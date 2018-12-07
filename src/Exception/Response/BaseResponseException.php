<?php

namespace Twigger\UnionCloud\Exception\Response;

use Throwable;
use Twigger\UnionCloud\Exception\BaseUnionCloudException;

class BaseResponseException extends BaseUnionCloudException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null, $unionCloudCode = 0)
    {
        parent::__construct($message, $code, $previous, $unionCloudCode);
    }
}