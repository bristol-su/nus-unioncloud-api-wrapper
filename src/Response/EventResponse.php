<?php

namespace Twigger\UnionCloud\Response;

class EventResponse extends BaseResponse implements IResponse
{

    public function __construct($response, $request)
    {
        parent::__construct($response, $request);
    }

}