<?php namespace Authority\Repositories;

use Authority\Interfaces\CategoryRepositoryInterface;
use Authority\Exceptions\NonExistantException;
use \Category;
use Authority\Validation\CategoryValidator;

/**
 * Class CategoryRepository
 * @package Authority\Repositories
 */
class CategoryRepository implements CategoryRepositoryInterface {
    protected $validator;

    /**
     * @param CategoryValidator $validator
     * @param Category $category
     */
    public function __construct(CategoryValidator $validator, Category $category){
        $this->validator = $validator;
        $this->category = $category;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll(){
        return $this->category->all();
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Authority\Exceptions\NonExistantException
     */
    public function find($id){
        $category = $this->category->whereId($id)->first();
        if(!$category) {
            throw new NonExistantException;
        }
        else{
            return $category;
        }
    }

    /**
     * @param $data
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public function createNew($data){
        if($this->validator->validateForCreate($data)){
            return $this->category->create($data);
        }
    }

    /**
     * @param $data
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public function updateExisting($data, $id){
        if($this->validator->validateForUpdate($data)){
            $category = Category::find($id)->fill($data);
            $category->update();
            return $category;

        }
    }

    /**
     * @param $id
     * @return bool
     * @throws \Authority\Exceptions\NonExistantException
     */
    public function delete($id){
        $category = $this->category->find($id);
        if(!$category){
            throw new NonExistantException;
        }
        else{
            $category->delete($id);
            return true;
        }
    }
} 