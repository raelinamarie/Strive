<?php

use Authority\Exceptions\ValidationException;
use Authority\Exceptions\NonExistantException;
use Authority\Interfaces\CategoryRepositoryInterface;


/**
 * Class CategoriesController
 */
class CategoriesController extends BaseController  {


    /**
     * @param CategoryRepositoryInterface $category
     */
    public function __construct(CategoryRepositoryInterface $category){
        $this->category = $category;
	}

    public function index()
    {
        $categories = $this->category->getAll();
        return Restable::listing($categories)->render();
    }

	public function store()
	{
        $category = $this->category->createNew(Input::all());
        return Restable::created($category)->render();
	}

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
	{
        $category = $this->category->find($id);
        return Restable::single($category)->render();
	}

    /**
     * @param $id
     * @return mixed
     */
    public function update($id)
	{
        $category = $this->category->updateExisting(Input::all(),$id);
        return Restable::updated($category)->render();
	}

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
	{
        $this->category->delete($id);
        return Restable::deleted()->render();
	}

    public function showAllGrouped(){
        $return = Category::with(array('skills'))->get();
        return Restable::listing($return)->render();
    }

}