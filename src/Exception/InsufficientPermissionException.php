<?php

namespace Twigger\UnionCloud\Exception;

use Throwable;

class InsufficientPermissionException extends UnionCloudException
{

    public function __construct($message = "", $code = 0, Throwable $previous = null, $unionCloudCode=0)
    {
        parent::__construct($message, $code, $previous, $unionCloudCode);
    }

}