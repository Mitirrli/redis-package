<?php

declare(strict_types=1);

namespace Mitirrli\RedisPackage\Constant;

/**
 * Lock.
 */
abstract class Lock
{
    //Default Lock Time.
    const DEFAULT_LOCK_TIME = 600;

    //Lock Format.
    const LOCK_NAME = 'mi_app_lock:%s';
}