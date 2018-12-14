<?php
/**
 * BaseResponseException
 */

namespace Twigger\UnionCloud\API\Exception\Response;

use Throwable;
use Twigger\UnionCloud\API\Exception\BaseUnionCloudException;

/**
 * Class BaseResponseException
 *
 * @package Twigger\UnionCloud\API\Exceptions
 */
class BaseResponseException extends BaseUnionCloudException
{
    /**
     * BaseResponseException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param int $unionCloudCode
     * @param string $unionCloudMessage
     */
    public function __construct($message='A problem occured processing the response', $code=500, Throwable $previous = null, $unionCloudCode = 0, $unionCloudMessage='')
    {
        parent::__construct($message, $code, $previous, $unionCloudCode, $unionCloudMessage);
    }

}