<?php
/**
 * UnionCloudResponseAuthenticationException
 */

namespace Twigger\UnionCloud\API\Exception\Authentication;

use Throwable;

/**
 * Class UnionCloudResponseAuthenticationException
 *
 * @package Twigger\UnionCloud\API\Exceptions
 */
class UnionCloudResponseAuthenticationException extends BaseUnionCloudAuthenticationException
{

    /**
     * UnionCloudResponseAuthenticationException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param int $unionCloudCode
     * @param string $unionCloudMessage
     */
    public function __construct($message = 'Error authenticating with UnionCloud', $code = 401, Throwable $previous = null, $unionCloudCode = 0, $unionCloudMessage = '')
    {
        parent::__construct($message, $code, $previous, $unionCloudCode, $unionCloudMessage);
    }

}