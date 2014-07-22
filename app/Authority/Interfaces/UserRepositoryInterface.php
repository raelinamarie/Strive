<?php
namespace Authority\Interfaces;

/**
 * Interface UserRepositoryInterface
 * @package Authority\Interfaces
 */
interface UserRepositoryInterface {
    #public function byId($id);
    #public function isValidForCreation($input);
    /**
     * @param $data
     * @return mixed
     */
    public function createNew($data);

    /**
     * @param $id
     * @return mixed
     */
    public function userJobs($id);

    /**
     * @param $id
     * @return mixed
     */
    public function userSkills($id);
    public function updateExisting($id,$data);
    #public function delete($id);
    public function findWithGroups($id = null);
    public function find($id);
    public function userRatings($user_id, $for, $by);
    public function userFavorites($id);
    public function addSkills($id,$skills);
    public function updateSkills($id,$skills);
    public function userSearch($input);
    public function userGroups($id);
    public function userDelete($id);
    public function adminSearch($email);
    public function recentUsers();
    public function privatePage($user_id);
    public function hasJobPostAvailable();
    public function executeJobPost($job);
    public function monthlyEmployerSubscription($user_id);
    public function userFavoritesIds($id);
    public function findAsObject($id,$user_id = null);
    public function profile_type($user_id);
    public function createNewFrontend($data);
} 