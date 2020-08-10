<?php

declare(strict_types=1);

namespace Mitirrli\RedisPackage;

use Mitirrli\RedisPackage\{App\Lock, Exception\ApplicationException, Redis\RedisTrait};

/**
 * @method static Lock Lock(array $key)
 */
class App
{
    use RedisTrait;

    /**
     * Call Static.
     *
     * @param string $name
     * @param array $arguments
     * @return Lock
     * @throws ApplicationException
     * @throws Exception\KeyException
     */
    public static function __callStatic(string $name, array $arguments)
    {
        switch ($name) {
            case 'Lock':
                return new Lock($arguments);

            default:
                throw new ApplicationException('App Not Exists.', 1);
        }
    }
}