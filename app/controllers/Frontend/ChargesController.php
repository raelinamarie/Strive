<?php  namespace Controllers\Frontend;


use Authority\Interfaces\ChargeRepositoryInterface;
use \Auth;
use \View;

class ChargesController extends BaseController{

    public function __construct(ChargeRepositoryInterface $charge){
        $this->charge = $charge;
    }
    /*
        public function create(){
            dd(Auth::user()->subscription()->cancel());
        }
        public function store(){

        }

    */
        public function create(){
            $data['title'] = 'New Payment';
            return View::make('frontend.pages.charge.membership',$data);
        }
        public function store(){
            $token = Input::get('stripeToken');
            $response = $this->charge->newOrder(Auth::user()->getAuthIdentifier(), Input::all());
            return Restable::created($response)->render();
        }

} 