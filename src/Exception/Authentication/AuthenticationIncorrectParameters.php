<?php
/**
 * AuthenticationIncorrectParameters
 */

namespace Twigger\UnionCloud\Exception\Authentication;

use Throwable;

/**
 * Class AuthenticationIncorrectParameters
 * @package Twigger\UnionCloud\Exceptions
 */
class AuthenticationIncorrectParameters extends UnionCloudResponseAuthenticationException
{

    /**
     * AuthenticationIncorrectParameters constructor.
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