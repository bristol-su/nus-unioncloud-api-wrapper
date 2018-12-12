<?php
/**
 * AuthenticatorMustExtendIAuthenticator
 */
namespace Twigger\UnionCloud\Exception\Authentication;

use Throwable;

/**
 * Class AuthenticatorMustExtendIAuthenticator
 *
 * @package Twigger\UnionCloud\Exceptions
 */
class AuthenticatorMustExtendIAuthenticator extends BaseUnionCloudAuthenticationException
{

    /**
     * AuthenticatorMustExtendIAuthenticator constructor.
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