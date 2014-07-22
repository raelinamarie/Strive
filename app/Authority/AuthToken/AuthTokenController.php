<?php
/*
* User: tappleby
* Date: 2013-05-11
* Time: 11:26 PM
*/

namespace Authority\AuthToken;

use Authority\Interfaces\SessionsAuthTokenInterface;
use Illuminate\Routing\Controller;
use Authority\AuthToken\Exceptions\NotAuthorizedException;

/**
 * Class AuthTokenController
 * @package Authority\AuthToken
 */
class AuthTokenController extends Controller implements SessionsAuthTokenInterface
{

    /**
     * @var \Authority\AuthToken\AuthTokenDriver
     */
    protected $driver;

    /**
     * @var callable format username and password into hash for Auth::attempt
     */
    protected $credentialsFormatter;

    /**
     * @param AuthTokenDriver $driver
     * @param callable $credentialsFormatter
     */
    function __construct(AuthTokenDriver $driver, \Closure $credentialsFormatter)
    {
        $this->driver = $driver;
        $this->credentialsFormatter = $credentialsFormatter;
    }

    /**
     * @return mixed|string
     */
    protected function getAuthToken()
    {

        $token = \Request::header('X-Auth-Token');

        if (empty($token)) {
            $token = \Input::get('auth_token');
        }

        return $token;
    }

    /**
     * @return bool|\Illuminate\Auth\UserInterface
     */
    public function index()
    {
        $payload = $this->getAuthToken();
        return $this->driver->validate($payload);
    }

    /**
     * @param $data
     * @return mixed
     * @throws Exceptions\NotAuthorizedException
     */
    public function store($data)
    {
        $validator = \Validator::make(
            $data,
            array('username' => array('required'), 'password' => array('required'))
        );

        if ($validator->fails()) {
                throw new NotAuthorizedException();

        }


        $creds = call_user_func($this->credentialsFormatter, $data['username'], $data['password']);
        $token = $this->driver->attempt($creds);

        if (!$token) {
            throw new NotAuthorizedException();
        }

        $serializedToken = $this->driver->getProvider()->serializeToken($token);

        $user = $this->driver->user($token);
        $response['id'] = $user->toArray()['id'];
        $response['token'] = $serializedToken;

        return $response;
    }

    public function destroy()
    {
        $payload = $this->getAuthToken();
        $user = $this->driver->validate($payload);

        if (!$user) {
            throw new NotAuthorizedException();
        }
        $this->driver->getProvider()->purge($user);
    }
}