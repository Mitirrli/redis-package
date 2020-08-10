<?php

declare(strict_types=1);

namespace Mitirrli\RedisPackage;

use Mitirrli\RedisPackage\{App\Lock, Exception\ApplicationException, Redis\RedisTrait};

/**
 * @method static Lock Lock(string $key)
 */
class Application
{
    use RedisTrait;

    /**
     * Call Static.
     *
     * @param $name
     * @param $arguments
     * @return Lock
     * @throws ApplicationException
     */
    public static function __callStatic($name, $arguments)
    {
        switch ($name) {
            case 'Lock':
                return new Lock($arguments);

            default:
                throw new ApplicationException('App Not Exists.', 1);
        }
    }
}