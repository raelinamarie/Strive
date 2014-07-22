<?php namespace Authority\Repositories;

use Authority\Exceptions\ValidationException;
use Authority\Interfaces\RatingRepositoryInterface;
use Authority\Exceptions\NonExistantException;
use Authority\Exceptions\DuplicateRatingException;
use \Rating;
use Authority\Validation\RatingValidator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class RatingRepository
 * @package Authority\Repositories
 */
class RatingRepository implements RatingRepositoryInterface{
    protected $validator;

    /**
     * @param RatingValidator $validator
     * @param Rating $rating
     */
    public function __construct(RatingValidator $validator, Rating $rating){
        $this->validator = $validator;
        $this->rating = $rating;
    }

    /**
     * @param $user_id
     * @param $rating_id
     * @return mixed
     * @throws \Authority\Exceptions\NonExistantException
     */
    public function find($user_id,$rating_id){
        $rating = Rating::where('id','=',$rating_id)->where('rating_for','=',$user_id)->first();
        if(!$rating){
            throw new NonExistantException;
        }
        return $rating;
    }

    /**
     * @param $rating_by
     * @param $rating_for
     * @return bool
     */
    public static function ratingExists($rating_by,$rating_for){
        if(Rating::where('rating_by','=',$rating_by)->where('rating_for','=',$rating_for)->get()->isEmpty()){
            return false;
        }
        else{
            return true;
        }
    }

    /**
     * @param $from_id
     * @param $for_id
     * @param $input
     * @return Rating
     * @throws \Authority\Exceptions\DuplicateRatingException
     */
    public function createNew($from_id,$for_id,$input){

        if($this->ratingExists($from_id,$for_id)) {
            throw new DuplicateRatingException(array('Rating Exists'));
        }
        $input['rating_for'] = $for_id;
        $input['rating_by'] = $from_id;
        $this->validator->validateForCreate($input);
        return Rating::create($input);
    }

    /**
     * @param $rating_id
     * @return bool
     * @throws \Authority\Exceptions\NonExistantException
     */
    public function delete($rating_id){
        $rating = $this->rating->find($rating_id);
        if(!$rating){
            throw new NonExistantException;
        }
        else{
            $rating->delete($rating_id);
            return true;
        }
    }

}