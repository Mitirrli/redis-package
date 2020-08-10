<?php

declare(strict_types=1);

namespace Mitirrli\RedisPackage\App;

use Mitirrli\RedisPackage\Redis\RedisConnect;
use Mitirrli\RedisPackage\Exception\KeyException;
use Mitirrli\RedisPackage\Constant\Lock as LockConstant;

/**
 * Lock Application.
 */
class Lock extends RedisConnect
{
    /**
     * Lock Time.
     */
    protected $time = LockConstant::DEFAULT_LOCK_TIME;

    /**
     * Lock Key.
     */
    protected $key;

    /**
     * Lock Value.
     */
    protected $val;

    /**
     * Lock constructor.
     *
     * @param $key
     * @throws KeyException
     */
    public function __construct($key)
    {
        parent::__construct();

        $this->key = $this->setKey(reset($key));
        $this->val = $this->setValue();
    }

    /**
     * Set Value.
     *
     * @return string
     */
    public function setValue()
    {
        return time() . uniqid() . md5($_SERVER['REQUEST_TIME'] . $_SERVER['REMOTE_ADDR']) . mt_rand(1, 999);
    }

    /**
     * Set Key.
     *
     * @param $key
     * @return string
     * @throws KeyException
     */
    public function setKey($key)
    {
        if (empty($key)) {
            throw new KeyException('Key can not be empty string.', 2);
        }

        return sprintf(LockConstant::LOCK_NAME, $key);
    }


    /**
     * 加锁 .
     * @return bool
     */
    public function lock()
    {
        return $this->redis->set($this->key, $this->val, ['nx', 'ex' => $this->time]);
    }

    /**
     * 解锁 .
     * @return mixed
     */
    public function unlock()
    {
        $lua = "if redis.call('get', KEYS[1]) == ARGV[1]
        then
            return redis.call('del', KEYS[1]) 
        else 
            return 0 
        end";

        return $this->redis->eval($lua, [$this->key, $this->val], 1);
    }
}