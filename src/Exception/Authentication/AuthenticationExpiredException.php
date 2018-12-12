<?php
/**
 * AuthenticationExpiredException
 */

namespace Twigger\UnionCloud\Exception\Authentication;

use Throwable;

/**
 * Class AuthenticationExpiredException
 * @package Twigger\UnionCloud\Exceptions
 */
class AuthenticationExpiredException extends UnionCloudResponseAuthenticationException
{

    /**
     * AuthenticationExpiredException constructor.
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