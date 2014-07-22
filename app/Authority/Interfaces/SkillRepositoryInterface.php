<?php namespace Authority\Interfaces;


/**
 * Interface SkillRepositoryInterface
 * @package Authority\Interfaces
 */
interface SkillRepositoryInterface {
    /**
     * @param $id
     * @return mixed
     */
    public function find($id);
    #public function isValidForCreation($input);
    /**
     * @param $data
     * @return mixed
     */
    public function createNew($data);

    /**
     * @param $data
     * @param $category
     * @param $id
     * @return mixed
     */
    public function updateExisting($data,$category,$id);

    /**
     * @param $category_id
     * @param $skill_id
     * @return mixed
     */
    public function delete($category_id,$skill_id);
    public function list_ids();
    public function skillIdFormat($skills,$categories);
    public function getAll();
} 