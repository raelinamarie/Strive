<?php namespace Authority\Indexers;


/**
 * Interface IndexerInterface
 * @package Authority\Indexers
 */
interface IndexerInterface {
    /**
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * @param $item
     * @return mixed
     */
    public function save($item);

    /**
     * @param $job
     * @return mixed
     */
    public function indexJob($job);

    /**
     * @param $user
     * @return mixed
     */
    public function indexUser($user);
} 