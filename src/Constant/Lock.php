<?php

declare(strict_types=1);

namespace Mitirrli\RedisPackage\Constant;

/**
 * 锁.
 */
abstract class Lock
{
    //默认加锁时间
    const DEFAULT_LOCK_TIME = 600;

    //锁的格式
    const LOCK_NAME = 'mi_app_lock:%s';
}