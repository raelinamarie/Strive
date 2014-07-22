<?php namespace Authority\Validation;

/**
 * Class SkillValidator
 * @package Authority\Validation
 */
class SkillValidator extends Validator {

    /**
     * Default rules
     *
     * @var array
     */
    static $createRules = array(
        'name' => 'required|min:4',
        'category_id' => 'required|exists:categories,id'
    );

    /**
     * Rules for updating a user
     *
     * @var array
     */
    static $updateRules = [
        'name' => 'required|min:4',
        'category_id' => 'required|exists:categories,id'
    ];
}