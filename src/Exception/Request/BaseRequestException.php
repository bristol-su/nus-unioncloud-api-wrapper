<?php
/**
 * BaseRequestException
 */

namespace Twigger\UnionCloud\API\Exception\Request;

use Throwable;
use Twigger\UnionCloud\API\Exception\BaseUnionCloudException;

/**
 * Class BaseRequestException
 *
 * @package Twigger\UnionCloud\API\Exceptions
 */
class BaseRequestException extends BaseUnionCloudException
{

    /**
     * BaseRequestException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param int $unionCloudCode
     * @param string $unionCloudMessage
     */
    public function __construct($message = 'Error creating a request to UnionCloud', $code = 500, Throwable $previous = null, $unionCloudCode = 0, $unionCloudMessage = '')
    {
        parent::__construct($message, $code, $previous, $unionCloudCode, $unionCloudMessage);
    }

}