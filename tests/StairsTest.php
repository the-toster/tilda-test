<?php

declare(strict_types=1);

namespace Tests;

use App\Stairs;
use PHPUnit\Framework\TestCase;

final class StairsTest extends TestCase
{
    /** @test */
    public function it_can_produce_given_example(): void
    {
        $example = [[1], [2, 3], [4, 5, 6]];
        $this->assertEquals($example, Stairs::buildTo(6)->rows);
    }

    /** @test */
    public function in_can_give_correct_string(): void
    {
        $this->assertEquals(
            implode(PHP_EOL, ['1', '2 3', '4 5 6']),
            Stairs::buildTo(6)->asString()
        );
    }
}
