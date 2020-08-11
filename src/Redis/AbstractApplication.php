<?php

declare(strict_types=1);

namespace Mitirrli\RedisPackage\Redis;

use Mitirrli\RedisPackage\Exception\KeyException;

abstract class AbstractApplication extends RedisConnect
{
    /**
     * App constructor.
     *
     * @param array $params
     * @throws KeyException
     */
    public function __construct(array $params)
    {
        parent::__construct();

        foreach ($params = reset($params) as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{"set" . ucfirst($property)}($value);
            }
        }

        if (!isset($this->key)) {
            throw new KeyException('Key must be defined', 3);
        }
    }
}