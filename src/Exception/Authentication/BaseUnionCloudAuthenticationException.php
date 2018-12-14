<?php
/**
 * BaseUnionCloudAuthenticationException
 */
namespace Twigger\UnionCloud\API\Exception\Authentication;

use Twigger\UnionCloud\API\Exception\BaseUnionCloudException;
use Throwable;

/**
 * Class BaseUnionCloudAuthenticationException
 *
 * @package Twigger\UnionCloud\API\Exceptions
 */
class BaseUnionCloudAuthenticationException extends BaseUnionCloudException
{

    /**
     * BaseUnionCloudAuthenticationException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param int $unionCloudCode
     * @param string $unionCloudMessage
     */
    public function __construct($message='Authentication Failed', $code=401, Throwable $previous = null, $unionCloudCode = 0, $unionCloudMessage='')
    {
        parent::__construct($message, $code, $previous, $unionCloudCode, $unionCloudMessage);
    }

}