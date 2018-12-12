<?php
/**
 * PageNotFoundException
 */
namespace Twigger\UnionCloud\Exception\Pagination;

use Throwable;

/**
 * Class PageNotFoundException
 *
 * @package Twigger\UnionCloud\Exceptions
 */
class PageNotFoundException extends BasePaginationException
{

    /**
     * PageNotFoundException constructor.
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