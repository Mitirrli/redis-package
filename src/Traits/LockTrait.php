<?php

declare(strict_types=1);

namespace Mitirrli\RedisPackage\Traits;

use Mitirrli\RedisPackage\Exception\KeyException;
use Mitirrli\RedisPackage\Constant\Lock;

trait LockTrait
{
    /**
     * Lock key.
     */
    protected $key;

    /**
     * Lock value.
     */
    protected $val;

    /**
     * Lock time.
     */
    protected $time = Lock::DEFAULT_LOCK_TIME;

    /**
     * Set key.
     *
     * @param string $key
     * @throws KeyException
     */
    public function setKey(string $key)
    {
        if (empty($key)) {
            throw new KeyException('Key can not be empty string.', 2);
        }

        $this->key = sprintf(Lock::LOCK_NAME, $key);
    }

    /**
     * Set random value.
     */
    public function setValue()
    {
        $this->val = microtime(true) . uniqid() . ip2long($_SERVER['REMOTE_ADDR']) . mt_rand(1, 9999);
    }

    /**
     * Set lock time.
     *
     * @param $time
     */
    public function setTime(int $time)
    {
        $this->time = $time;
    }
}