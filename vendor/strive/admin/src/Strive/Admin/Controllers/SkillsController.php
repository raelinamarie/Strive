<?php  namespace Strive\Admin\Controllers;

use \Auth;
use \Restable;
use \View;
use \API;
use \Input;
use \Redirect;
use \Queue;
use \Request;
use \Session;
use \Category;

class SkillsController extends \BaseController {

    public function index() {
        $categories = Category::with('skills')->withTrashed()->get()->toArray();
        $view['categories'] = $categories;
        #$view['categories'] = API::invoke('/admin/api/v1/categories', 'get');

        $view['title'] = 'Manage Skills';
        #echo"<pre>";
        #print_r($view);
        #echo "</pre>";
        return View::make('admin.pages.manageSkills', $view);
    }

    public function store() {
        $data['name'] = Input::get('name');
        $category_id = Input::get('category_id');
        if (API::invoke("/admin/api/v1/categories/$category_id/skills", 'post', $data)) {
            return Redirect::back()->with('message', 'Skill Added');
        }
    }

    public function destroy($cat_id, $skill_id){
        $skill = \Skill::find($skill_id);
        if($skill){
            $skill->delete();
        }


        $categories = Category::with(array('skills' => function($q){$q->withTrashed();}))->withTrashed()->get()->toArray();
        $view['categories'] = $categories;
        #$view['categories'] = API::invoke('/admin/api/v1/categories', 'get');

        $view['title'] = 'Manage Skills';
        #echo"<pre>";
        #print_r($view);
        #echo "</pre>";
        return View::make('admin.pages.manageSkills', $view);
    }
} 