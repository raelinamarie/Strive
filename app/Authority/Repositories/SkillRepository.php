<?php namespace Authority\Repositories;

use Authority\Interfaces\SkillRepositoryInterface;
use Authority\Exceptions\NonExistantException;
use \Skill;
use Authority\Validation\SkillValidator;

/**
 * Class SkillRepository
 * @package Authority\Repositories
 */
class SkillRepository implements SkillRepositoryInterface{
    protected $validator;

    /**
     * @param SkillValidator $validator
     * @param Skill $skill
     */
    public function __construct(SkillValidator $validator, Skill $skill){
        $this->validator = $validator;
        $this->skill = $skill;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll(){
        return $this->skill->all();
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|static
     * @throws \Authority\Exceptions\NonExistantException
     */
    public function find($id){
        $skill = $this->skill->find($id);
        if(!$skill) {
            throw new NonExistantException;
        }
        else{
            return $skill;
        }
    }

    /**
     * @param $data
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public function createNew($data){
        if($this->validator->validateForCreate($data)){
            return $this->skill->create($data);
        }
    }

    /**
     * @param $data
     * @param $category
     * @param $id
     * @return bool
     */
    public function updateExisting($data,$category,$id){
        if($this->validator->validateForUpdate($data)){
            $skill = $this->skill->find($id);
            $skill->name = $data['name'];
            $skill->category_id = $id;
            $skill->active = $data['active'];
            return $skill->save();

        }
    }

    /**
     * @param $category_id
     * @param $skill_id
     * @return bool
     * @throws \Authority\Exceptions\NonExistantException
     */
    public function delete($category_id,$skill_id){
        $skill = $this->skill->find($skill_id);
        if(!$skill){
            throw new NonExistantException;
        }
        else{
            $skill->delete();
            return true;
        }
    }

    public function list_ids(){
        return Skill::all()->lists('id');
    }

    public function skillIdFormat($skills,$categories){
        if($skills == NULL && $categories == NULL){
            return Skill::all()->lists('id');
        }
        elseif($skills == NULL && $categories != NULL){
            return Skill::whereIn('category_id',$categories)->lists('id');
        }
        elseif($skills != NULL && $categories == NULL){
            return Skill::whereIn('id',$skills)->lists('id');
        }
        elseif($skills != NULL && $categories != NULL){
            $skillsFromSkills = Skill::whereIn('id',$skills)->lists('id');
            $skillsFromCategories = Skill::whereIn('category_id',$categories)->lists('id');
            return array_merge($skillsFromSkills,$skillsFromCategories);
        }
    }
} 