<?php  namespace Authority\Service\Workers;
use \Action;
use \Charge;
use \Product;
use \Stripe;
use Authority\Interfaces\UserRepositoryInterface;
use \Stripe_Customer;
use \User;
use \Event;
use \DB;

class Observer {
    public function __construct(UserRepositoryInterface $user){
        $this->user = $user;
    }

    public function createUser($job,$message){
        Action::create($message);
    }

    public function newAction($job,$message){
        Action::create($message);
    }

    public function invoiceitem_created($payload){

        $customer = $payload->data->object->customer;
        $subscription = $payload->data->object->subscription;
        $amount = $payload->data->object->amount;
        $description = $payload->data->object->description;
        $sub = json_decode($this->stripe_customer->retrieve($customer)->subscriptions->retrieve($subscription));
        $monthly = ($sub->plan->interval == 'month')? 1 : 0;
        $product_id = Product::where('name','=',$sub->plan->name)->first()->id;
        $user = User::where('stripe_id','=',$customer)->first()->id;

        Charge::create(['user_id'=>$user,'amount'=>$amount,'monthly'=>$monthly,'product_id'=>$product_id,'description'=>$description]);
        if($product_id == 1){
            Event::fire('monthlyEmployerSubscription',$user);
        }

    }

    public function ratings_change($job,$message){
        $ratings =\DB::select("SELECT rating_for,SUM(rating)/COUNT(*) as 'average',COUNT(*) as 'total_ratings' FROM ratings WHERE rating_for = ".$message." GROUP BY rating_for")[0];
        $rating = $this->user->findAsObject($message);
        $rating->total_ratings = $ratings->total_ratings;
        $rating->avg_rating = $ratings->average;
        $rating->save();
    }
} 