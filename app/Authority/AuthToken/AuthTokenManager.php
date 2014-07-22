<?php
/*
 * User: tappleby
 * Date: 2013-05-11
 * Time: 9:14 PM
 */

namespace Authority\AuthToken;


use Illuminate\Support\Manager;

/**
 * Class AuthTokenManager
 * @package Authority\AuthToken
 */
class AuthTokenManager extends Manager {

    /**
     * @return AuthTokenDriver
     */
    protected function createDatabaseDriver() {
    $provider = $this->createDatabaseProvider();
    $users = $this->app['auth']->driver()->getProvider();

    return new AuthTokenDriver($provider, $users);
  }

    /**
     * @return DatabaseAuthTokenProvider
     */
    protected function createDatabaseProvider() {
    $connection = $this->app['db']->connection();
    $encrypter = $this->app['encrypter'];
    $hasher = new HashProvider($this->app['config']['app.key']);

    return new DatabaseAuthTokenProvider($connection, 'ta_auth_tokens', $encrypter, $hasher);
  }

    /**
     * @return string
     */
    protected function getDefaultDriver() {
    return 'database';
  }
}