<?php
/**
 * AuthRefreshRequiredException
 */

namespace Twigger\UnionCloud\API\Exception\Response;

use Throwable;

/**
 * Class AuthRefreshRequiredException
 *
 * @package Twigger\UnionCloud\API\Exceptions
 */
class AuthRefreshRequiredException extends BaseResponseException
{

    /**
     * AuthRefreshRequiredException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param int $unionCloudCode
     * @param string $unionCloudMessage
     */
    public function __construct($message = 'Your authentication needs a refresh', $code = 401, Throwable $previous = null, $unionCloudCode = 0, $unionCloudMessage = '')
    {
        parent::__construct($message, $code, $previous, $unionCloudCode, $unionCloudMessage);
    }

}