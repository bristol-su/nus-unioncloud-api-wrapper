<?php
/**
 * RequestHistoryNotFound
 */

namespace Twigger\UnionCloud\API\Exception\Request;

use Throwable;
use Twigger\UnionCloud\API\Exception\Request\BaseRequestException;

/**
 * Class RequestHistoryNotFound
 *
 * @package Twigger\UnionCloud\API\Exceptions
 */
class RequestHistoryNotFound extends BaseRequestException
{

    /**
     * RequestHistoryNotFound constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param int $unionCloudCode
     * @param string $unionCloudMessage
     */
    public function __construct($message = 'Request history wasn\'t being recorded', $code = 500, Throwable $previous = null, $unionCloudCode = 0, $unionCloudMessage = '')
    {
        parent::__construct($message, $code, $previous, $unionCloudCode, $unionCloudMessage);
    }

}