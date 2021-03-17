<?php

declare(strict_types=1);

namespace Qjdata\RedisPackage\Constant;

/**
 * Fixed Sort Set.
 */
abstract class FixedSortSet
{
    //Default Array length.
    const ARRAY_LENGTH = 10;

    //Array Format.
    const ARRAY_NAME = 'mi_app_sort_set:%s';
}
