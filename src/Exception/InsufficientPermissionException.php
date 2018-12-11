<?php
/**
 * InsufficientPermissionException
 */

namespace Twigger\UnionCloud\Exception;

use Throwable;

/**
 * Class InsufficientPermissionException
 *
 * @package Twigger\UnionCloud
 */
class InsufficientPermissionException extends BaseUnionCloudException
{

    /**
     * InsufficientPermissionException constructor.
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