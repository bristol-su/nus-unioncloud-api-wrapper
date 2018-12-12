<?php
/**
 * BaseUnionCloudAuthenticationException
 */
namespace Twigger\UnionCloud\Exception\Authentication;

use Twigger\UnionCloud\Exception\BaseUnionCloudException;
use Throwable;

/**
 * Class BaseUnionCloudAuthenticationException
 *
 * @package Twigger\UnionCloud\Exceptions
 */
class BaseUnionCloudAuthenticationException extends BaseUnionCloudException
{

    /**
     * BaseUnionCloudAuthenticationException constructor.
     *
     * Pass the error to \Exception
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param int $unionCloudCode
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null, $unionCloudCode=0)
    {
        parent::__construct($message, $code, $previous, $unionCloudCode);
    }

}