<?php
/*
 * User: tappleby
 * Date: 2013-05-11
 * Time: 7:34 PM
 */

namespace Authority\AuthToken;

use Illuminate\Hashing;

/**
 * Class HashProvider
 * @package Authority\AuthToken
 */
class HashProvider {
  private $algo = 'sha256';
  private $hashKey;

    /**
     * @return string
     */
    public function getAlgo()
  {
    return $this->algo;
  }

  public function getHashKey()
  {
    return $this->hashKey;
  }

    /**
     * @param $hashKey
     */
    function __construct($hashKey)
  {
    $this->hashKey = $hashKey;
  }

    /**
     * @param null $entropy
     * @return string
     */
    public function make($entropy=null)
  {
    if(empty($entropy)) {
      $entropy = $this->generateEntropy();
    }

    return \Hash::make(hash($this->algo, $entropy));
  }

    /**
     * @param $publicKey
     * @return string
     */
    public function makePrivate($publicKey)
  {
    return hash_hmac($this->algo, $publicKey, $this->hashKey);
  }

    /**
     * @param $publicKey
     * @param $privateKey
     * @return bool
     */
    public function check($publicKey, $privateKey) {
    $genPublic = $this->makePrivate($publicKey);
    return $genPublic == $privateKey;
  }

    /**
     * @return string
     */
    public function generateEntropy() {
    $entropy = mcrypt_create_iv(32, $this->getRandomizer());
    $entropy .= uniqid(mt_rand(), true);

    return $entropy;
  }

    /**
     * @return int
     */
    protected function getRandomizer()
  {
    if (defined('MCRYPT_DEV_URANDOM')) return MCRYPT_DEV_URANDOM;

    if (defined('MCRYPT_DEV_RANDOM')) return MCRYPT_DEV_RANDOM;

    mt_srand();

    return MCRYPT_RAND;
  }
}