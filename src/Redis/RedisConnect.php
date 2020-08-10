<?php

declare(strict_types=1);

namespace Mitirrli\RedisPackage\Redis;

use Mitirrli\RedisPackage\Application;

/**
 * Redis Connect.
 */
abstract class RedisConnect
{
    protected $redis;

    /**
     * Php Redis.
     */
    public function __construct()
    {
        $this->redis = Application::$redis ?? new \Redis();
    }
}