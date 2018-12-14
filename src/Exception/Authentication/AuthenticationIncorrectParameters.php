<?php
/**
 * AuthenticationIncorrectParameters
 */

namespace Twigger\UnionCloud\API\Exception\Authentication;

use Throwable;

/**
 * Class AuthenticationIncorrectParameters
 * @package Twigger\UnionCloud\API\Exceptions
 */
class AuthenticationIncorrectParameters extends UnionCloudResponseAuthenticationException
{

    /**
     * AuthenticationIncorrectParameters constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param int $unionCloudCode
     * @param string $unionCloudMessage
     */
    public function __construct($message='Authentication details incorrect', $code=401, Throwable $previous = null, $unionCloudCode = 0, $unionCloudMessage='')
    {
        parent::__construct($message, $code, $previous, $unionCloudCode, $unionCloudMessage);
    }

}