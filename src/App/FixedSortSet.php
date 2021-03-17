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
     * Get data.
     *
     * @param int $num
     * @return bool|mixed|string
     */
    public function getTop(int $num)
    {
        $rand = mt_rand(1, 15);
        //随机删除(集合总数 > 希望的数目)
        if (($rand === 10) && ($this->zLen() > $this->len)) {
            $this->delete();
        }

        return $this->redis->zRange($this->key, 0, $num - 1) ?? [];
    }


    /**
     * Delete random.
     *
     * @return void
     */
    public function delete()
    {
        $keys = $this->redis->zRange($this->key, $this->len, -1);

        $this->redis->zRem($this->key, ...$keys);
    }
}
