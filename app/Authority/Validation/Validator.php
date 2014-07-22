<?php namespace Authority\Validation;

use Validator as V;
use Authority\Exceptions\ValidationException;

/**
 * Class Validator
 * @package Authority\Validation
 */
abstract class Validator {

    /**
     * @var \Illuminate\Validation\Factory
     */
    protected $validator;



    /**
     * Trigger validation
     *
     * @param array $data
     *
     * @return bool
     * @throws ValidationException
     */
    public function validateForCreate($data)
    {
        $validation = V::make($data, static::$createRules);

        if ( $validation->fails()) throw new ValidationException($validation->messages());

        return true;
    }

    /**
     * @param $data
     * @return bool
     * @throws \Authority\Exceptions\ValidationException
     */
    public function validateForUpdate($data)
    {
        $validation = V::make($data, static::$updateRules);

        if ( $validation->fails()) throw new ValidationException($validation->messages());

        return true;
    }

    /**
     * @param $data
     * @return bool
     * @throws \Authority\Exceptions\ValidationException
     */
    public function validateForNewUser($data){
        $validation = V::make($data, static::$newUserRules);

        if ( $validation->fails()) throw new ValidationException($validation->messages());

        return true;
    }

    public function validChargeData($data){
        $validation = V::make($data, static::$cardData);

        if ( $validation->fails()) throw new ValidationException($validation->messages());

        return true;
    }

    public function validCardData($data){
        $validation = V::make($data, static::$validCard);

        if ( $validation->fails()) throw new ValidationException($validation->messages());

        return true;
    }

    public function validPostDataForCharge($data){
        $validation = V::make($data, static::$postCharge);

        if ( $validation->fails()) throw new ValidationException($validation->messages());

        return true;
    }

}