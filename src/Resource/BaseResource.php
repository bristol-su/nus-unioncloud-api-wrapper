<?php

namespace Twigger\UnionCloud\Resource;

class BaseResource
{

    private $modelParameters;

    public function __call($name, $arguments)
    {
        var_dump($name);
        var_dump($arguments);
        // TODO: Implement __call() method.
    }

    // TODO populateModel function to populate model if ID is set

}