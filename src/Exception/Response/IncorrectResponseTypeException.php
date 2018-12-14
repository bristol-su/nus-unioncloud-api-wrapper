<?php
/**
 * IncorrectResponseTypeException
 */

namespace Twigger\UnionCloud\API\Exception\Response;

use Throwable;

/**
 * Class IncorrectResponseTypeException
 *
 * @package Twigger\UnionCloud\API\Exceptions
 */
class IncorrectResponseTypeException extends BaseResponseException
{

    /**
     * IncorrectResponseTypeException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param int $unionCloudCode
     * @param string $unionCloudMessage
     */
    public function __construct($message='The response from Guzzle was of an incorrect type.', $code=500, Throwable $previous = null, $unionCloudCode = 0, $unionCloudMessage='')
    {
        parent::__construct($message, $code, $previous, $unionCloudCode, $unionCloudMessage);
    }

}