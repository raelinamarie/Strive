<?php namespace Authority\Exceptions;

use Exception;

/**
 * Class ValidationException
 * @package Authority\Exceptions
 */
class NoSearchResultsException extends Exception {

    /**
     * @var string
     */
    protected $errors;

    /**
     * @param string $errors
     */
    public function __construct($errors)
    {
        $this->errors = $errors;
    }

    /**
     * Fetch validation errors
     *
     * @return string
     */
    public function getErrors()
    {
        return $this->errors;
    }

}