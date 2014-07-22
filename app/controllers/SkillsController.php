<?php

use Authority\Exceptions\ValidationException;
use Authority\Exceptions\NonExistantException;
use Authority\Interfaces\SkillRepositoryInterface;

/**
 * Class SkillsController
 */
class SkillsController extends BaseController {

    /**
     * @param SkillRepositoryInterface $skill
     */
    public function __construct(SkillRepositoryInterface $skill){
        $this->skill = $skill;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function index($id)
    {
        $category = Category::with(array('skills'))->whereId($id)->first();
        if($category){
            return Restable::listing($category['skills'])->render();
        }
        else{
            return Restable::listing([])->render();
        }
    }

    /**
     * @param $category_id
     * @return mixed
     */
    public function store($category_id)
    {
        $input = Input::all();
        $input['category_id'] = $category_id;
        $skill = $this->skill->createNew($input);
        return Restable::created($skill)->render();
    }

    /**
     * @param $category
     * @param $skill
     * @return mixed
     */
    public function show($category,$skill)
    {
        $skill = Skill::where('category_id','=',$category)->where('id','=',$skill)->get();
        if(!$skill->isEmpty()){
            return Restable::single($skill)->render();
        }
        return Restable::missing()->render();
    }

    /**
     * @param $category
     * @param $skill
     */
    public function update($category,$skill)
    {
        $skill = Skill::find($skill);
        $skill->category_id = $category;

    }

    /**
     * @param $category_id
     * @param $skill_id
     * @return mixed
     */
    public function destroy($category_id,$skill_id)
    {
        $this->skill->delete($category_id,$skill_id);
        return Restable::deleted()->render();
    }
}