<?php

namespace TypistTech\Sunny\Vendor\League\Container\Exception;

use TypistTech\Sunny\Vendor\Interop\Container\Exception\NotFoundException as NotFoundExceptionInterface;
use InvalidArgumentException;

class NotFoundException extends InvalidArgumentException implements NotFoundExceptionInterface
{
}
