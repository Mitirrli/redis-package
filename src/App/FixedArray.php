<?php

declare(strict_types=1);

namespace Mitirrli\RedisPackage\App;

use Mitirrli\RedisPackage\Exception\IndexException;
use Mitirrli\RedisPackage\Redis\AbstractApplication;
use Mitirrli\RedisPackage\Traits\FixedArrayTrait;

/**
 * Fixed Array Application.
 */
class FixedArray extends AbstractApplication
{
    use FixedArrayTrait;

    /**
     * Left in, Right Out.
     *
     * @param string $value
     * @return mixed
     */
    public function toList(string $value)
    {
        $lua = "if redis.call('llen', KEYS[1]) < tonumber({$this->len})
        then
            return redis.call('rpush', KEYS[1], ARGV[1])
        else
            redis.call('lpop', KEYS[1])
            return redis.call('rpush', KEYS[1], ARGV[1])
        end";

        return $this->redis->eval($lua, [$this->key, $value], 1);
    }

    /**
     * The length of queue.
     *
     * @return bool|int
     */
    public function lLen()
    {
        return $this->redis->lLen($this->key);
    }

    /**
     * Get data by index.
     *
     * @param int $index
     * @return bool|mixed|string
     * @throws IndexException
     */
    public function getItemByIndex(int $index)
    {
        if ($this->lLen() < $index + 1) {
            throw new IndexException('The data of the current index does not exist', 4);
        }

        return $this->redis->lIndex($this->key, $index) ?? '';
    }
}