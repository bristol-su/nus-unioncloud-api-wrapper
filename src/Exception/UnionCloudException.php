<?php

namespace Twigger\UnionCloud\Exception;

use Throwable;

class UnionCloudException extends \Exception {

    /**
     * The unioncloud response code
     *
     * @var int|null $unionCloudCode
     */
    protected $unionCloudCode=null;

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