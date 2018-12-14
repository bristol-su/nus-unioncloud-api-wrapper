<?php
/**
 * BaseResourceException
 */

namespace Twigger\UnionCloud\API\Exception\Resource;

use Throwable;
use Twigger\UnionCloud\API\Exception\BaseUnionCloudException;

/**
 * Class BaseResourceException
 *
 * @package Twigger\UnionCloud\API\Exceptions
 */
class BaseResourceException extends BaseUnionCloudException
{

    /**
     * BaseResourceException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param int $unionCloudCode
     * @param string $unionCloudMessage
     */
    public function __construct($message = 'A problem occured creating your resource', $code = 500, Throwable $previous = null, $unionCloudCode = 0, $unionCloudMessage = '')
    {
        parent::__construct($message, $code, $previous, $unionCloudCode, $unionCloudMessage);
    }

}