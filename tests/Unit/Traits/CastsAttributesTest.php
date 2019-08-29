<?php


namespace Twigger\UnionCloud\Tests\Unit\Traits;


use Carbon\Carbon;
use Twigger\UnionCloud\API\Traits\CastsAttributes;
use Twigger\UnionCloud\Tests\TestCase;

class CastsAttributesTest extends TestCase
{

    use CastsAttributes;

    /** @test */
    public function it_casts_a_date_string(){
        $date = '01/01/2019';

        $this->assertInstanceOf(Carbon::class, $this->parseDate($date));
        $this->assertEquals($date, $this->parseDate($date)->format('d/m/Y'));
    }

    /** @test */
    public function it_casts_a_datetime_instance(){
        $date = Carbon::now();

        $this->assertInstanceOf(Carbon::class, $this->parseDate($date));
        $this->assertEquals($date->toDateString(), $this->parseDate($date)->toDateString());
    }

    /** @test */
    public function it_converts_upper_case_to_proper_case(){
        $upper = 'TOBY TWIGGER';

        $this->assertEquals('Toby Twigger', $this->parseProperCase($upper));
    }

    /** @test */
    public function it_converts_upper_case_to_proper_case_but_leaves_de_untouched(){
        $upper = 'TOBY de TWIGGER';

        $this->assertEquals('Toby de Twigger', $this->parseProperCase($upper));
    }

    /** @test */
    public function it_converts_upper_case_to_proper_case_with_Mc(){
        $upper = 'TOBY MCTWIGGER';

        $this->assertEquals('Toby McTwigger', $this->parseProperCase($upper));
    }

    /** @test */
    public function it_converts_a_double_barelled_surname_correctly(){
        $upper = 'TOBY TWIGGER-SMITH';

         $this->assertEquals('Toby Twigger-Smith', $this->parseProperCase($upper));
    }

    /** @test */
    public function it_converts_a_lower_case_name_to_proper_case(){
        $lower = 'toby twigger';

        $this->assertEquals('Toby Twigger', $this->parseProperCase($lower));
    }

    /** @test */
    public function it_converts_roman_numerals_to_caps(){
        $lower = 'toby twigger iii';

        $this->assertEquals('Toby Twigger III', $this->parseProperCase($lower));
    }
}