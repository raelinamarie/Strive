<?php namespace Authority\Interfaces;


/**
 * Interface RatingRepositoryInterface
 * @package Authority\Interfaces
 */
interface RatingRepositoryInterface {
    /**
     * @param $user_id
     * @param $rating_id
     * @return mixed
     */
    public function find($user_id,$rating_id);

    /**
     * @param $rating_by
     * @param $rating_for
     * @return mixed
     */
    public static function ratingExists($rating_by,$rating_for);

    /**
     * @param $from_id
     * @param $for_id
     * @param $input
     * @return mixed
     */
    public function createNew($from_id,$for_id,$input);

    /**
     * @param $rating_id
     * @return mixed
     */
    public function delete($rating_id);


} 