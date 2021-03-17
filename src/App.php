<?php

declare(strict_types=1);

namespace Qjdata\RedisPackage;

use Qjdata\RedisPackage\{App\FixedArray, App\Lock, Exception\ApplicationException, Redis\RedisTrait};
use Qjdata\RedisPackage\App\FixedSortSet;

/**
 * @method static Lock Lock(array $params) 分布式锁
 * @method static FixedArray FixedArray(array $params) 固定大小的数组
 * @method static FixedSortSet FixedSortSet(array $params) 固定大小的有序集合
 */
class App
{
    use RedisTrait;

    /**
     * Call Static.
     *
     * @param string $name
     * @param array $arguments
     * @return Lock|FixedArray
     * @throws ApplicationException
     * @throws Exception\KeyException
     */
    public static function __callStatic(string $name, array $arguments)
    {
        switch ($name) {
            case 'Lock':
                return new Lock($arguments);

            case 'FixedArray':
                return new FixedArray($arguments);

            case 'FixedSortSet':
                return new FixedSortSet($arguments);

            default:
                throw new ApplicationException('App Not Exists.', 1);
        }
    }
}
