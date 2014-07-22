<?php
namespace Authority\Exceptions;

/**
 * Class DuplicateRatingException
 * @package Authority\Exceptions
 */
class DuplicateRatingException extends \Exception {
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

};