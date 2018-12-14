<?php
/**
 * Thrown when a response doesn't inherit the IResponse interface
 */

namespace Twigger\UnionCloud\API\Exception\Response;

use Throwable;
/**
 * Class ResponseMustInheritIResponse
 *
 * @package Twigger\UnionCloud\API\Exceptions
 */
class ResponseMustInheritIResponse extends BaseResponseException
{

    /**
     * ResponseMustInheritIResponse constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param int $unionCloudCode
     * @param string $unionCloudMessage
     */
    public function __construct($message='Your response handler must inherit IResponse', $code=500, Throwable $previous = null, $unionCloudCode = 0, $unionCloudMessage='')
    {
        parent::__construct($message, $code, $previous, $unionCloudCode, $unionCloudMessage);
    }

}