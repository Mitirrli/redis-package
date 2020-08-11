<?php

declare(strict_types=1);

namespace Mitirrli\RedisPackage\Constant;

/**
 * Fixed Array.
 */
abstract class FixedArray
{
    //Default Array length.
    const ARRAY_LENGTH = 10;

    //Array Format.
    const ARRAY_NAME = 'mi_app_array:%s';
}