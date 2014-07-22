<?php
use Authority\AuthToken\Exceptions\NotAuthorizedException;
use Authority\Exceptions\ChargeException;
use Authority\Exceptions\DuplicateMembershipException;
use Authority\Interfaces\ChargeRepositoryInterface;
use Authority\Exceptions\ValidationException;
use Authority\Interfaces\UserRepositoryInterface;
use Carbon\Carbon;
use \Restable;
use \Stripe_Customer;
use \Stripe;
use \Config;
use \Product;


/**
 * Class TransactionsController
 */
class ChargesController extends BaseController{
    /**
     * @param TransactionRepositoryInterface $transaction
     */
    public function __construct(ChargeRepositoryInterface $charge, Restable $rest, UserRepositoryInterface $user){
        $this->charge = $charge;
        $this->response = $rest;
        $this->user = $user;

    }
    public function create($user_id){
        return $this->charge->hasMembership(User::find($user_id)->stripe_id);
    }

    public function store($user_id){
        $this->user->privatePage($user_id);
        return Restable::created($this->charge->newOrder($user_id, Input::all()))->render();
    }
}