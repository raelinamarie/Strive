<?php namespace Authority\Validation;

/**
 * Class RatingValidator
 * @package Authority\Validation
 */
class RatingValidator extends Validator {

    static $createRules = [
        'rating_for' => "required|exists:users,id",
        'rating_by' => "required|exists:users,id",
        'rating' => 'required|between:0,5',
        'review' => 'max:250'
    ];

    static $updateRules = [
        'rating_for' => "required|exists:users,id",
        'rating_by' => "required|exists:users,id",
        'rating' => 'required|between:0,5',
        'review' => 'max:250'
    ];
}