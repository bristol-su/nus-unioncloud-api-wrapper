<?php
/**
 * IncorrectRequestParameterException
 */
namespace Twigger\UnionCloud\Exception\Request;

use Throwable;
use Twigger\UnionCloud\Exception\Request\BaseRequestException;

/**
 * Class IncorrectRequestParameterException
 * @package Twigger\UnionCloud\Exceptions
 */
class IncorrectRequestParameterException extends BaseRequestException
{

    /**
     * IncorrectRequestParameterException constructor.
     *
     * Pass the error to \Exception
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param int $unionCloudCode
     */
    public function __construct($message, $code, Throwable $previous = null, $unionCloudCode=0)
    {
        parent::__construct($message, $code, $previous, $unionCloudCode);
    }
}