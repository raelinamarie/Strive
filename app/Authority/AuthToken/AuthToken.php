<?php
/*
 * User: tappleby
 * Date: 2013-05-11
 * Time: 3:44 PM
 */

namespace Authority\AuthToken;


use Illuminate\Support\Contracts\ArrayableInterface;

/**
 * Class AuthToken
 * @package Authority\AuthToken
 */
class AuthToken implements ArrayableInterface {


  protected $authIdentifier;
  protected $publicKey;
  protected $privateKey;

    /**
     * @param $authIdentifier
     * @param $publicKey
     * @param $privateKey
     */
    function __construct($authIdentifier, $publicKey, $privateKey)
  {
    $this->authIdentifier = $authIdentifier;
    $this->publicKey = $publicKey;
    $this->privateKey = $privateKey;
  }

    /**
     * @return mixed
     */
    public function getAuthIdentifier()
  {
    return $this->authIdentifier;
  }

    /**
     * @param $authIdentifier
     */
    public function setAuthIdentifier($authIdentifier)
  {
    $this->authIdentifier = $authIdentifier;
  }

    /**
     * @return mixed
     */
    public function getPrivateKey()
  {
    return $this->privateKey;
  }

    /**
     * @return mixed
     */
    public function getPublicKey()
  {
    return $this->publicKey;
  }

    /**
     * @param $privateKey
     */
    public function setPrivateKey($privateKey)
  {
    $this->privateKey = $privateKey;
  }

    /**
     * @param $publicKey
     */
    public function setPublicKey($publicKey)
  {
    $this->publicKey = $publicKey;
  }

  /**
   * Get the instance as an array.
   *
   * @return array
   */
  public function toArray()
  {
    return array(
      'auth_identifier' => $this->authIdentifier,
      'public_key' => $this->publicKey,
      'private_key' => $this->privateKey
    );
  }


}