<?php

namespace Twigger\UnionCloud\Exception\Authentication;

use Throwable;

class AuthenticatorNotFound extends BaseUnionCloudAuthenticationException
{

    public function __construct($message = "", $code = 0, Throwable $previous = null, $unionCloudCode=0)
    {
        parent::__construct($message, $code, $previous, $unionCloudCode);
    }

}