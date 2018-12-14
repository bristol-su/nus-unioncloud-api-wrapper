<?php
/**
 * Base exception thrown by this package
 */

namespace Twigger\UnionCloud\API\Exception;

use Throwable;

/**
 * Class BaseUnionCloudException
 *
 * @package Twigger\UnionCloud\API\Exceptions
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
     * @var int $unionCloudCode
     */
    public $unionCloudCode = 0;

    /**
     * The unioncloud message
     *
     * This is the message from UnionCloud
     *
     * @var string$unionCloudCode
     */
    public $unionCloudMessage = '';

    /**
     * BaseUnionCloudException constructor.
     *
     * Pass the error to \Exception
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param int $unionCloudCode
     * @param string $unionCloudMessage
     */
    public function __construct($message = "Something went wrong with the UnionCloud API", $code = 500, Throwable $previous = null, $unionCloudCode = 0, $unionCloudMessage = '')
    {
        $this->unionCloudCode = $unionCloudCode;
        $this->unionCloudMessage = $unionCloudMessage;
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