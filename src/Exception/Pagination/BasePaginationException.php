<?php
/**
 * BasePaginationException
 */

namespace Twigger\UnionCloud\API\Exception\Pagination;

use Throwable;
use Twigger\UnionCloud\API\Exception\BaseUnionCloudException;

/**
 * Class BasePaginationException
 *
 * @package Twigger\UnionCloud\API\Exceptions
 */
class BasePaginationException extends BaseUnionCloudException
{

    /**
     * BasePaginationException constructor.
     *
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param int $unionCloudCode
     * @param string $unionCloudMessage
     */
    public function __construct($message='Pagination Failed', $code=500, Throwable $previous = null, $unionCloudCode = 0, $unionCloudMessage='')
    {
        parent::__construct($message, $code, $previous, $unionCloudCode, $unionCloudMessage);
    }

}