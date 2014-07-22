<?php
/*
 * User: tappleby
 * Date: 2013-05-11
 * Time: 10:11 PM
 */

namespace Authority\AuthToken;


use Illuminate\Events\Dispatcher;
use Authority\AuthToken\Exceptions\NotAuthorizedException;
use \Config;
use \Route;

/**
 * Class AuthTokenFilter
 * @package Authority\AuthToken
 */
class AuthTokenFilter {

    /**
     * The event dispatcher instance.
     *
     * @var \Illuminate\Events\Dispatcher
     */
    protected $events;

    /**
     * @var \Authority\AuthToken\AuthTokenDriver
     */
    protected $driver;

    /**
     * @param AuthTokenDriver $driver
     * @param Dispatcher $events
     */
    function __construct(AuthTokenDriver $driver, Dispatcher $events)
    {
        $this->driver = $driver;
        $this->events = $events;
    }

    /**
     * @param $route
     * @param $request
     * @throws Exceptions\NotAuthorizedException
     */
    function filter($route, $request) {
        $payload = $request->header('X-Auth-Token');
        // REMOVE THIS IF STATEMENT FOR PRODUCTION. IT IS DANGEROUS!!
        //TODO: remove this
        if($payload == 'employer' || $payload == 'contractor' || $payload == 'user' || $payload == 'admin'){
            $customUser = \User::where('email','=',$payload."@strive.com")->first();
            $this->events->fire('auth.token.valid', $customUser);
        }
        else {
            if (empty($payload)) {
                $payload = $request->input('auth_token');
            }

            $user = $this->driver->validate($payload);

            if (!$user) {
                $publicUrls = Config::get('publicUrls');
                if (in_array(Route::current()->uri(), $publicUrls)) {

                } else {
                    throw new NotAuthorizedException();
                }
            } else {
                $this->events->fire('auth.token.valid', $user);
            }
        }
    }
}