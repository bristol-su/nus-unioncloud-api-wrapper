<?php

namespace Twigger\UnionCloud\Exception\Authentication;

use Twigger\UnionCloud\Exception\BaseUnionCloudException;
use Throwable;

class BaseUnionCloudAuthenticationException extends BaseUnionCloudException
{

    public function __construct($message = "", $code = 0, Throwable $previous = null, $unionCloudCode=0)
    {
        parent::__construct($message, $code, $previous, $unionCloudCode);
    }

}