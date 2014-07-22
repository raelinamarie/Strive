<?php namespace Authority\Validation;

/**
 * Class JobValidator
 * @package Authority\Validation
 */
class JobValidator extends Validator {


    static $createRules = array(
        'title' => 'required|between:5,100',
        'description' => 'required|between:15,1000',
        'address1' => 'required',
        'city' => 'required',
        'state' => 'required|max:2|alpha',
        'max_payrate' => 'numeric',
        'contact_email' => 'email',
        'posted_by' => 'required|exists:users,id',
        'contact_phone' => 'required',
        'hourly' => 'required',
        'single_day' => 'required',
        'duration_start' => 'integer|between:0,23',
        'duration_end' => 'integer|between:0,23'
    );

    static $updateRules = array(
        'title' => 'between:5,100',
        'description' => 'between:15,400',
        'state' => 'max:2|alpha',
        'max_payrate' => 'numeric',
        'contact_email' => 'email',
        'posted_by' => 'exists:users,id'
    );
}
