<?php
/**
 * UnionCloudResponseAuthenticationException
 */

namespace Twigger\UnionCloud\Exception\Authentication;

use Throwable;

/**
 * Class UnionCloudResponseAuthenticationException
 *
 * @package Twigger\UnionCloud
 */
class UnionCloudResponseAuthenticationException extends BaseUnionCloudAuthenticationException
{

    /**
     * UnionCloudResponseAuthenticationException constructor.
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