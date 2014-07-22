<?php

use Authority\AuthToken\Exceptions\NotAuthorizedException;
use Authority\Exceptions\ValidationException;
use Authority\Exceptions\NonExistantException;
use Authority\Interfaces\RatingRepositoryInterface;
use Authority\Exceptions\DuplicateRatingException;
use Authority\Interfaces\UserRepositoryInterface;
use Carbon\Carbon;

/**
 * Class RatingsController
 */
class RatingsController extends BaseController  {


    /**
     * @param RatingRepositoryInterface $rating
     */
    public function __construct(RatingRepositoryInterface $rating,UserRepositoryInterface $user){
        $this->user = $user;
        $this->rating = $rating;

    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function index($user_id)
	{
        $user = User::with(array('ratings_for_user'))->whereId($user_id)->first();
        if($user){
            return Restable::listing($user['ratings_for_user'])->render();
        }
        else{
            return Restable::listing([])->render();
        }
	}

    /**
     * @param $rating_for
     * @return mixed
     */
    public function store($rating_for){
        $rating = $this->rating->createNew(Auth::user()->id,$rating_for,Input::all());
        Queue::push('\Authority\Service\Workers\Observer@ratings_change',$rating_for);
        return Restable::single($rating)->render();
	}

    /**
     * @param $user_id
     * @param $rating_id
     * @return mixed
     */
    public function show($user_id,$rating_id){
        $rating = $this->rating->find($user_id,$rating_id);
        return Restable::single($rating)->render();
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($user_id,$id){
		Queue::push('\Authority\Service\Workers\Observer@ratings_change',$user_id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($user_id,$id){
        $this->rating->delete($id);
        Queue::push('\Authority\Service\Workers\Observer@ratings_change',$user_id);
        return Restable::deleted([])->render();
	}

    public function testMath(){
        $ratings = DB::select("SELECT rating_for,SUM(rating)/COUNT(rating) as 'average',COUNT(rating) as 'total_ratings' FROM ratings GROUP BY rating_for");
        foreach($ratings as $row){
            User::find($row->rating_for)->update(['total_rating' => $row->total_ratings,'avg_rating'=>$row->average])."<BR>";
        }
        return Restable::listing(User::all())->render();
    }
}