<?php
/**
 * AuthenticationExpiredException
 */

namespace Twigger\UnionCloud\API\Exception\Authentication;

use Throwable;

/**
 * Class AuthenticationExpiredException
 * @package Twigger\UnionCloud\API\Exceptions
 */
class AuthenticationExpiredException extends UnionCloudResponseAuthenticationException
{

    /**
     * AuthenticationExpiredException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param int $unionCloudCode
     * @param string $unionCloudMessage
     */
    public function __construct($message='Authentication Expired', $code=401, Throwable $previous = null, $unionCloudCode = 0, $unionCloudMessage='')
    {
        parent::__construct($message, $code, $previous, $unionCloudCode, $unionCloudMessage);
    }

}