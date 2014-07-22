<?php namespace Authority\Validation;

/**
 * Class UserValidator
 * @package Authority\Validation
 */
class UserValidator extends Validator {

    static $newUserRules = [
        'email' => 'required|unique:users,email|email',
        'password' => 'required|confirmed|between:4,20',
    ];
    static $createRules = [];
    static $rules = [
        'email' => 'required|email:unique',
        'password' => 'required|confirmed|between:4,20',
        'first_name' => 'max:50',
        'last_name' => 'max:50',
        'display_name' => 'max:50',
        'phone_number' => 'required',
        'profile_image' => 'image'
    ];

    /**
     * Rules for updating a user
     *
     * @var array
     */
    static $updateRules = [
        'email' => 'email',
        'password' => 'between:4,20',
        'first_name' => 'max:50',
        'last_name' => 'max:50',
        'display_name' => 'max:50',
        'profile_image' => 'image'
    ];
}