<?php
/**
 * InsufficientPermissionException
 */

namespace Twigger\UnionCloud\API\Exception;

use Throwable;

/**
 * Class InsufficientPermissionException
 *
 * @package Twigger\UnionCloud\API\Exceptions
 */
class InsufficientPermissionException extends BaseUnionCloudException
{

    /**
     * InsufficientPermissionException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param int $unionCloudCode
     * @param string $unionCloudMessage
     */
    public function __construct($message = 'You don\'t have the permission to do that', $code = 403, Throwable $previous = null, $unionCloudCode = 0, $unionCloudMessage = '')
    {
        parent::__construct($message, $code, $previous, $unionCloudCode, $unionCloudMessage);
    }

}