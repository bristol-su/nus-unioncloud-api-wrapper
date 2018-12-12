<?php
/**
 * RequestHistoryNotFound
 */

namespace Twigger\UnionCloud\Exception\Request;

use Throwable;
use Twigger\UnionCloud\Exception\Request\BaseRequestException;

/**
 * Class RequestHistoryNotFound
 *
 * @package Twigger\UnionCloud\Exceptions
 */
class RequestHistoryNotFound extends BaseRequestException
{

    /**
     * RequestHistoryNotFound constructor.
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