<?php

declare(strict_types=1);

namespace Mitirrli\RedisPackage\App;

use Mitirrli\RedisPackage\Exception\KeyException;
use Mitirrli\RedisPackage\Redis\RedisConnect;
use Mitirrli\RedisPackage\Traits\LockTrait;

/**
 * Lock Application.
 */
class Lock extends RedisConnect
{
    use LockTrait;

    /**
     * Lock constructor.
     *
     * @param array $params
     * @throws KeyException
     */
    public function __construct(array $params)
    {
        parent::__construct();

        foreach ($params = reset($params) as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{"set" . ucfirst($property)}($value);
            }
        }
        
        if (!isset($this->key)) {
            throw new KeyException('Key must be defined', 3);
        }
    }

    /**
     * Lock.
     * @return bool
     */
    public function lock()
    {
        return $this->redis->set($this->key, $this->val, ['nx', 'ex' => $this->time]);
    }

    /**
     * unLock.
     * @return bool
     */
    public function unLock()
    {
        $lua = "if redis.call('get', KEYS[1]) == ARGV[1]
        then
            return redis.call('del', KEYS[1]) 
        else 
            return 0 
        end";

        return (bool)$this->redis->eval($lua, [$this->key, $this->val], 1);
    }
}