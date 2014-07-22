<?php namespace Authority\Interfaces;


/**
 * Interface JobRepositoryInterface
 * @package Authority\Interfaces
 */
interface JobRepositoryInterface {
    /**
     * @param null $user_id
     * @param null $active
     * @return mixed
     */
    public function getAll($user_id = NULL, $active = NULL);

    /**
     * @param $input
     * @return mixed
     */
    public function saveJob($input);

    /**
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * @param $input
     * @return mixed
     */
    public function isValidForCreation($input);

    /**
     * @param $data
     * @return mixed
     */
    public function createNew($input,$skillsIds,$days);

    /**
     * @param $data
     * @param $job_id
     * @return mixed
     */
    public function updateExisting($job_id,$data);

    public function delete($job_id);

    public function jobSearch($input);

    public function addSkills($job_id,$data);
    public function addDays($id,$days);
    public function recentJobs();
    public function adminSearch($title);
    public function jobSearchFilterExpired($input);
    public function jobSearchFilterNonExpired($input);

} 