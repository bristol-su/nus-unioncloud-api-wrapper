<?php
/**
 * BaseRequestException
 */

namespace Twigger\UnionCloud\Exception\Request;

use Throwable;
use Twigger\UnionCloud\Exception\BaseUnionCloudException;

/**
 * Class BaseRequestException
 *
 * @package Twigger\UnionCloud\Exceptions
 */
class BaseRequestException extends BaseUnionCloudException
{

    /**
     * BaseRequestException constructor.
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