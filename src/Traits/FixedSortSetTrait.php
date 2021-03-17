<?php

declare(strict_types=1);

namespace Qjdata\RedisPackage\Traits;

use Qjdata\RedisPackage\Constant\FixedSortSet;
use Qjdata\RedisPackage\Exception\KeyException;

trait FixedSortSetTrait
{
    /**
     * Array name.
     */
    protected $key;

    /**
     * Array length.
     */
    protected $len = FixedSortSet::ARRAY_LENGTH;

    /**
     * Set array len.
     *
     * @param int $len
     */
    public function setLen(int $len)
    {
        $this->len = $len;
    }

    /**
     * Set key.
     *
     * @param string $key
     * @throws KeyException
     */
    public function setKey(string $key)
    {
        if (empty($key)) {
            throw new KeyException('Key can not be empty string.', 2);
        }

        $this->key = sprintf(FixedSortSet::ARRAY_NAME, $key);
    }
}
