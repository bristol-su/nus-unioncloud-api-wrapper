<?php
/**
 * IncorrectRequestParameterException
 */
namespace Twigger\UnionCloud\API\Exception\Request;

use Throwable;
use Twigger\UnionCloud\API\Exception\Request\BaseRequestException;

/**
 * Class IncorrectRequestParameterException
 * @package Twigger\UnionCloud\API\Exceptions
 */
class IncorrectRequestParameterException extends BaseRequestException
{

    /**
     * IncorrectRequestParameterException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param int $unionCloudCode
     * @param string $unionCloudMessage
     */
    public function __construct($message = 'An incorrect parameter was passed to UnionCloud', $code = 400, Throwable $previous = null, $unionCloudCode = 0, $unionCloudMessage = '')
    {
        parent::__construct($message, $code, $previous, $unionCloudCode, $unionCloudMessage);
    }

}