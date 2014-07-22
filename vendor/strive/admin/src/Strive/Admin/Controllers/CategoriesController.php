<?php namespace Strive\Admin\Controllers;

use Authority\Interfaces\CategoryRepositoryInterface;
use \Auth;
use \Redirect;
use \View;
use \Input;
use \API;
use \Queue;
use \Request;
use \Session;

class CategoriesController extends \BaseController {


    public function __construct(CategoryRepositoryInterface $category) {
        $this->category = $category;
    }

    public function index() {
        $view['categories'] = API::invoke('/admin/api/v1/categories', 'get');
        $view['title'] = 'Manage Skills';
        Queue::push('\Authority\Service\Workers\Observer@newAction', array('action' => 'Admin Page', 'uri' => Request::path(), 'method' => Request::method(), 'user_id' => Auth::user()->getAuthIdentifier(), 'session' => Session::GetId()));
        return View::make('admin.pages.manageSkills', $view);
    }

    public function store() {
        if (API::invoke('/admin/api/v1/categories', 'post', Input::all())) {
            Queue::push('\Authority\Service\Workers\Observer@newAction', array('action' => 'Admin Page', 'uri' => Request::path(), 'method' => Request::method(), 'user_id' => Auth::user()->getAuthIdentifier(), 'session' => Session::GetId()));
            return Redirect::back()->with('message', 'Category Added');
        }
    }
    /*
       public function show($id)
        {
            try{
                $category = $this->category->find($id);
            }
            catch(NonExistantException $e){
                return Restable::missing()->render();
            }
            return Restable::single($category)->render();
        }

        public function update($id)
        {
            try{
                $category = $this->category->updateExisting(Input::all(),$id);
            }
            catch(ValidationException $e){
                return Restable::unprocess($e->getErrors())->render();
            }
            return Restable::updated($category)->render();
        }

        public function destroy($id)
        {
            try {
                $this->category->delete($id);

            }
            catch(NonExistantException $e){
                return Restable::missing()->render();
            }
            return Restable::deleted()->render();

        }
    */
}