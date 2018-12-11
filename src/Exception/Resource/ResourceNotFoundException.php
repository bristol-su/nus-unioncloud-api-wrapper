<?php
/**
 * ResourceNotFoundException
 */

namespace Twigger\UnionCloud\Exception\Resource;

use Throwable;

/**
 * Class ResourceNotFoundException
 *
 * @package Twigger\UnionCloud
 */
class ResourceNotFoundException extends BaseResourceException
{

    /**
     * ResourceNotFoundException constructor.
     *
     * Pass the error to \Exception
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param int $unionCloudCode
     */
    public function __construct($message, $code, Throwable $previous = null, $unionCloudCode = 0)
    {
        parent::__construct($message, $code, $previous, $unionCloudCode);
    }
}