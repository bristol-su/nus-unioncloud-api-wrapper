<?php
/**
 * Thrown when a response doesn't inherit the IResponse interface
 */

namespace Twigger\UnionCloud\Exception\Response;

use Throwable;
/**
 * Class ResponseMustInheritIResponse
 *
 * @package Twigger\UnionCloud
 */
class ResponseMustInheritIResponse extends BaseResponseException
{

    /**
     * ResponseMustInheritIResponse constructor.
     *
     * Pass the error to \Exception
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param int $unionCloudCode
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null, $unionCloudCode = 0)
    {
        parent::__construct($message, $code, $previous, $unionCloudCode);
    }

}