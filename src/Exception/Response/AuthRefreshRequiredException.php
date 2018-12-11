<?php
/**
 * AuthRefreshRequiredException
 */

namespace Twigger\UnionCloud\Exception\Response;

use Throwable;

/**
 * Class AuthRefreshRequiredException
 *
 * @package Twigger\UnionCloud
 */
class AuthRefreshRequiredException extends BaseResponseException
{

    /**
     * AuthRefreshRequiredException constructor.
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