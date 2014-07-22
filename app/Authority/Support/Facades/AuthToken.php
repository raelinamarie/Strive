<?php
/*
 * User: tappleby
 * Date: 2013-05-11
 * Time: 9:33 PM
 */

namespace Authority\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class AuthToken
 * @package Authority\Support\Facades
 */
class AuthToken extends Facade {

    /**
     * @return string
     */
    protected static function getFacadeAccessor() { return 'authority.auth.token'; }
}