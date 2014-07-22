<?php
/*
 * User: tappleby
 * Date: 2013-05-12
 * Time: 12:17 AM
 */

namespace Authority\AuthToken\Exceptions;


/**
 * Class NotAuthorizedException
 * @package Authority\AuthToken\Exceptions
 */
class NotAuthorizedException extends \Exception {
    /**
     * @param string $message
     * @param int $code
     * @param Exception $previous
     */
    public function __construct($message = "Not Authorized", $code = 401, Exception $previous = null)
  {
    parent::__construct($message, $code, $previous);
  }
}