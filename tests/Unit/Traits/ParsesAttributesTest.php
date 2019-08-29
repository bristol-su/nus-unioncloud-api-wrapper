<?php


namespace Twigger\UnionCloud\Tests\Unit\Traits;

use Twigger\UnionCloud\API\Traits\ParsesAttributes;
use Twigger\UnionCloud\Tests\TestCase;

class ParsesAttributesTest extends TestCase
{

    use ParsesAttributes;

    /** @test */
    public function it_changes_camel_case_to_snake_case(){
        $this->assertEquals('camel_case', $this->fromCamelToSnake('camelCase'));
    }

    /** @test */
    public function it_replaces_a_space_with_an_underscore(){
        $this->assertEquals('camel_case_camel_case', $this->fromCamelToSnake('camelCase camelCase'));
    }

    /** @test */
    public function it_leaves_snake_case_unchanged(){
        $this->assertEquals('snake_case_in_disguise', $this->fromCamelToSnake('snake_case_in_disguise'));
    }

    /** @test */
    public function it_changes_snake_case_to_camel_case(){
        $this->assertEquals('snakeCase', $this->fromSnakeToCamel('snake_case'));
    }

    /** @test */
    public function it_preserves_spaces_in_snake_case(){
        $this->assertEquals('snakeCase snakeCase', $this->fromSnakeToCamel('snake_case snake_case'));
    }

}