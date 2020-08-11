<?php

declare(strict_types=1);

namespace Mitirrli\RedisPackage\App;

use Mitirrli\RedisPackage\Traits\LockTrait;
use Mitirrli\RedisPackage\Redis\AbstractApplication;

/**
 * Lock Application.
 */
class Lock extends AbstractApplication
{
    use LockTrait;

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