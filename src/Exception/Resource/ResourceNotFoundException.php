<?php
/**
 * ResourceNotFoundException
 */

namespace Twigger\UnionCloud\API\Exception\Resource;

use Throwable;

/**
 * Class ResourceNotFoundException
 *
 * @package Twigger\UnionCloud\API\Exceptions
 */
class ResourceNotFoundException extends BaseResourceException
{

    /**
     * ResourceNotFoundException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param int $unionCloudCode
     * @param string $unionCloudMessage
     */
    public function __construct($message='Your resource wasn\'t found', $code=400, Throwable $previous = null, $unionCloudCode = 0, $unionCloudMessage='')
    {
        parent::__construct($message, $code, $previous, $unionCloudCode, $unionCloudMessage);
    }

}