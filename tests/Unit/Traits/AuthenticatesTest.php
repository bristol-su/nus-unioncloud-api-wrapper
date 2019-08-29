<?php

namespace Twigger\UnionCloud\Tests\Unit\Traits;

use Twigger\UnionCloud\API\Traits\Authenticates;
use Twigger\UnionCloud\Tests\TestCase;

class AuthenticatesTest extends TestCase
{

    use Authenticates;

    /** @test */
    public function it_returns_true_when_all_keys_given(){
        $parameters = [
            'param1' => 'value1',
            'param2' => 'value2',
            'param3' => 'value3',
        ];

        $this->assertTrue($this->authArrayKeysExist(array_keys($parameters), $parameters));

    }

    /** @test */
    public function it_returns_false_when_not_all_keys_given(){
        $parameters = [
            'param1' => 'value1',
            'param2' => 'value2',
            'param3' => 'value3',
        ];

        $this->assertFalse($this->authArrayKeysExist([
            'param1', 'param2', 'param3', 'param4'
        ], $parameters));

    }

    /** @test */
    public function it_adds_a_header_to_an_empty_options_array(){
        $this->assertEquals(
            ['headers' => ['header_name' => 'header_value']],
            $this->addHeader([], 'header_name', 'header_value'));
    }

    /** @test */
    public function it_appends_a_header_to_a_populated_options_array(){
        $options = ['headers' => ['header1' => 'val1']];
        $this->assertEquals(
            ['headers' => ['header1' => 'val1', 'header_name' => 'header_value']],
            $this->addHeader($options, 'header_name', 'header_value'));
    }

    /** @test */
    public function it_replaces_a_header_if_already_present(){
        $options = ['headers' => ['header_name' => 'val1']];
        $this->assertEquals(
            ['headers' => ['header_name' => 'header_value']],
            $this->addHeader($options, 'header_name', 'header_value'));
    }
}