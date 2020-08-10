<?php

declare(strict_types=1);

namespace Mitirrli\RedisPackage\Redis;

use Redis;
use Mitirrli\RedisPackage\App;

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
     * @return App
     */
    public static function setRedis(Redis $redis)
    {
        self::$redis = $redis;

        return new App();
    }
}