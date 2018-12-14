<?php
/**
 * PageNotFoundException
 */
namespace Twigger\UnionCloud\API\Exception\Pagination;

use Throwable;

/**
 * Class PageNotFoundException
 *
 * @package Twigger\UnionCloud\API\Exceptions
 */
class PageNotFoundException extends BasePaginationException
{

    /**
     * PageNotFoundException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param int $unionCloudCode
     * @param string $unionCloudMessage
     */
    public function __construct($message = 'Page of results not found', $code = 404, Throwable $previous = null, $unionCloudCode = 0, $unionCloudMessage = '')
    {
        parent::__construct($message, $code, $previous, $unionCloudCode, $unionCloudMessage);
    }

}