<?php namespace Authority\Interfaces;


/**
 * Interface CategoryRepositoryInterface
 * @package Authority\Interfaces
 */
interface CategoryRepositoryInterface {
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll();

    /**
     * @param $id
     * @return mixed
     * @throws \Authority\Exceptions\NonExistantException
     */
    public function find($id);

    /**
     * @param $data
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public function createNew($data);

    /**
     * @param $data
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public function updateExisting($data, $id);

    /**
     * @param $id
     * @return bool
     * @throws \Authority\Exceptions\NonExistantException
     */
    public function delete($id);
} 