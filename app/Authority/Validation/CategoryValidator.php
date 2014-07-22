<?php namespace Authority\Validation;

/**
 * Class CategoryValidator
 * @package Authority\Validation
 */
class CategoryValidator extends Validator {

    static $createRules = [
        'name' => "required|min:5",
        'active' => 'between:0,1'
    ];

    static $updateRules = [
        'name' => "required|min:5",
        'active' => 'between:0,1'
    ];
}