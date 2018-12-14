<?php
/**
 * AuthenticationParameterMissing
 */
namespace Twigger\UnionCloud\API\Exception\Authentication;

use Throwable;

/**
 * Class AuthenticationParameterMissing
 * @package Twigger\UnionCloud\API\Exceptions
 */
class AuthenticationParameterMissing extends BaseUnionCloudAuthenticationException
{

    /**
     * AuthenticationParameterMissing constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param int $unionCloudCode
     * @param string $unionCloudMessage
     */
    public function __construct($message='Missing an authentication detail', $code=401, Throwable $previous = null, $unionCloudCode = 0, $unionCloudMessage='')
    {
        parent::__construct($message, $code, $previous, $unionCloudCode, $unionCloudMessage);
    }

}