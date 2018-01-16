<?php
/**
 * @license http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace TypistTech\Sunny\Vendor\Interop\Container\Exception;

use TypistTech\Sunny\Vendor\Psr\Container\NotFoundExceptionInterface as PsrNotFoundException;

/**
 * No entry was found in the container.
 */
interface NotFoundException extends ContainerException, PsrNotFoundException
{
}
