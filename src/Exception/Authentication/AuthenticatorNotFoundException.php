<?php
/**
 * AuthenticatorNotFound
 */

namespace Twigger\UnionCloud\API\Exception\Authentication;

use Throwable;

/**
 * Class AuthenticatorNotFound
 *
 * @package Twigger\UnionCloud\API\Exceptions
 */
class AuthenticatorNotFound extends BaseUnionCloudAuthenticationException
{

    /**
     * AuthenticatorNotFound constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param int $unionCloudCode
     * @param string $unionCloudMessage
     */
    public function __construct($message = 'No authenticator supplied', $code = 401, Throwable $previous = null, $unionCloudCode = 0, $unionCloudMessage = '')
    {
        parent::__construct($message, $code, $previous, $unionCloudCode, $unionCloudMessage);
    }

}