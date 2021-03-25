<?php

declare(strict_types=1);

namespace Qjdata\RedisPackage\App;

use Qjdata\RedisPackage\Redis\AbstractApplication;
use Qjdata\RedisPackage\Traits\FixedSortSetTrait;

/**
 * Fixed Sort Set Application.
 */
class FixedSortSet extends AbstractApplication
{
    use FixedSortSetTrait;

    /**
     * Push to sort set.
     *
     * @param string $value
     * @return mixed
     */
    public function toList(string $value)
    {
        $time = CURRENT_TIMESTAMP;

        $lua = "
        return redis.call('zadd', '$this->key', $time, '%s')
        ";

        $sha = sprintf($lua, $value);
        return $this->redis->evalSha($this->redis->script('load', $sha));
    }

    /**
     * The length of sort set.
     *
     * @return bool|int
     */
    public function zLen()
    {
        return $this->redis->zCard($this->key);
    }

    /**
     * Get by index.
     *
     * @param integer $index
     * @return array
     */
    public function getByIndex(int $index)
    {
        // random delete (集合总数 > 期望的数目)
        if ((mt_rand(1, 15) === 10) && ($this->zLen() > $this->len)) {
            $this->delete();
        }

        return $this->redis->zRevRange($this->key, $index, $index) ?? [];
    }

    /**
     * Delete random.
     *
     * @return void
     */
    public function delete()
    {
        $keys = $this->redis->zRevRange($this->key, $this->len, -1);

        $this->redis->zRem($this->key, ...$keys);
    }
}
