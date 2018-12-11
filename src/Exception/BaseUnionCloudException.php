<?php
/**
 * Base exception thrown by this package
 */

namespace Twigger\UnionCloud\Exception;

use Throwable;

/**
 * Class BaseUnionCloudException
 *
 * @package Twigger\UnionCloud
 */
class BaseUnionCloudException extends \Exception {

    /**
     * The unioncloud response code
     *
     * If UnionCloud contains a response code, it'll
     * be here. This should correspond to an error
     * message in the API documentation, allowing
     * for easier debugging.
     *
     * @var int|null $unionCloudCode
     */
    protected $unionCloudCode=null;

    /**
     * BaseUnionCloudException constructor.
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
        $this->unionCloudCode = $unionCloudCode;
        parent::__construct($message, $code, $previous);
    }

    /**
     * Retrieve the UnionCloud response code
     *
     * @return int|null
     */
    public function getUnionCloudCode()
    {
        return $this->unionCloudCode;
    }
}