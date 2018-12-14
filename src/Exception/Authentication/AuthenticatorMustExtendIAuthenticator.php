<?php
/**
 * AuthenticatorMustExtendIAuthenticator
 */
namespace Twigger\UnionCloud\API\Exception\Authentication;

use Throwable;
use Twigger\UnionCloud\API\Auth\IAuthenticator;

/**
 * Class AuthenticatorMustExtendIAuthenticator
 *
 * @package Twigger\UnionCloud\API\Exceptions
 */
class AuthenticatorMustExtendIAuthenticator extends BaseUnionCloudAuthenticationException
{

    /**
     * AuthenticatorMustExtendIAuthenticator constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param int $unionCloudCode
     * @param string $unionCloudMessage
     */
    public function __construct($message = 'Your authenticator must extend IAuthenticator at '.IAuthenticator::class, $code = 500, Throwable $previous = null, $unionCloudCode = 0, $unionCloudMessage = '')
    {
        parent::__construct($message, $code, $previous, $unionCloudCode, $unionCloudMessage);
    }

}