<?php namespace Controllers\Frontend;
use Authority\AuthToken\Exceptions\NotAuthorizedException;
use Authority\Interfaces\UserRepositoryInterface;
use \Restable;
use \User;

class SubscriptionsController {
    public function __construct(UserRepositoryInterface $userRepo, User $user){
        $this->userRepo = $userRepo;
        $this->user = $user;
    }

    public function destroy($user_id){
        try{
            $this->userRepo->privatePage($user_id);
            $this->user->find($user_id)->subscription()->cancel();
        }
        catch(NotAuthorizedException $e){
            return Restable::unauthorized()->render();
        }
    }
} 