<?php namespace Authority\Billing\Gateways;
use Authority\Exceptions\DuplicateMembershipException;
use Authority\Exceptions\MissingParametersException;
use Authority\Interfaces\ChargeRepositoryInterface;
use Authority\Validation\ChargeDataValidator;
use Carbon\Carbon;
use \Stripe;
use \Config;
use \Stripe_Charge;
use \Stripe_Customer;
use \User;
use \Stripe_Token;
use Authority\Interfaces\ProductInterface;
use \Exception;
use Product;

class StripeGateway implements ChargeRepositoryInterface{
    public function __construct(ProductInterface $product, User $user, ChargeDataValidator $validator){
        $this->product = $product;
        $this->user = $user;
        $this->validator = $validator;
    }

    public function newCust($email){
        Stripe::setApiKey(Config::get('stripe.secret'));
        return Stripe_Customer::create(array('email'=>$email))->id;
    }

    public function newOrder($user_id, $dataForCharge){
        $this->validator->validPostDataForCharge($dataForCharge);
        $product = Product::find($dataForCharge['product']);

        switch($product->billing_interval){
            case 'single':
                return $this->singleCharge($user_id,$dataForCharge,$product);
                break;
            case 'month':
                return $this->subscriptionCharge($user_id,$dataForCharge,$product);
                break;
        }
    }

    private function subscriptionCharge($user_id,$dataForCharge,$product){
        $user = $this->user->find($user_id);
        $this->executeBasedOnCurrentSubscriptionStatus($dataForCharge, $product, $user);
        switch ($product->name) {
            case 'monthlyEmployer': $user->groups()->sync([1,4]); $user->monthlyJobPosts = 5; $user->employer_role = Carbon::tomorrow()->addMonth();$user->save(); break;
            case 'monthlyContractor': $user->groups()->sync([1,3]); $user->monthlyJobPosts = 0; $user->save();break;
        }
        return true;
    }

    private function singleCharge($user_id,$dataForCharge,$product){
        $user = $this->user->find($user_id);
        if($user->subscribed()){
            $user->subscription()->cancel();
            $user->groups()->sync([1]);
        }
        $this->executeStripeCharge($dataForCharge, $product, $user);
        return true;

    }

    public function getNewToken($data){
        return Stripe_Token::create(['card'=>['number' => $data['number'],'exp_month'=>$data['exp_month'],'exp_year'=>$data['exp_year'],'cvc'=>$data['cvc']]])->id;
    }

    /**
     * @param $dataForCharge
     * @param $product
     * @param $user
     */
    private function executeStripeCharge($dataForCharge, $product, $user) {
        $cust = Stripe_Customer::retrieve($user->stripe_id);
        $token = (isset($dataForCharge['token'])) ? $dataForCharge['token'] : $this->getNewToken($dataForCharge);
        $charge = ['customer' => $cust, 'amount' => $product->name, 'currency' => 'usd', 'card' => $token, 'description' => 'Strive: Job Post'];
        Stripe_Charge::create($charge);
        $user->update(['monthlyJobPosts' => 1]);
    }

    /**
     * @param $dataForCharge
     * @param $product
     * @param $user
     * @throws \Exception
     */
    private function executeBasedOnCurrentSubscriptionStatus($dataForCharge, $product, $user) {
        if ($user->subscribed()) {
            if ($user->stripe_plan == $product->name) {
                throw new DuplicateMembershipException('Can not have duplicate exception');
            }
            $user->subscription($product->name)->swap();
        } else {
            $token = (isset($dataForCharge['token'])) ? $dataForCharge['token'] : $this->getNewToken($dataForCharge);
            $user->subscription($product->name)->create($token);
        }
    }
}