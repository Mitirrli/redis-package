<?php

declare(strict_types=1);

namespace Mitirrli\RedisPackage\Redis;

use Redis;
use Mitirrli\RedisPackage\Application;

trait RedisTrait
{
    /**
     * @var Redis
     */
    public static $redis;

    /**
     * Inject redis.
     *
     * @param Redis $redis
     *
     * @return Application
     */
    public static function setRedis(Redis $redis)
    {
        self::$redis = $redis;

        return new Application();
    }
}