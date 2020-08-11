<?php

declare(strict_types=1);

namespace Mitirrli\RedisPackage\Traits;

use Mitirrli\RedisPackage\Constant\FixedArray;
use Mitirrli\RedisPackage\Exception\KeyException;

trait FixedArrayTrait
{
    /**
     * Array name.
     */
    protected $key;

    /**
     * Array length.
     */
    protected $len = FixedArray::ARRAY_LENGTH;

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

        $this->key = sprintf(FixedArray::ARRAY_NAME, $key);
    }
}