<?php

declare(strict_types=1);

namespace Tests;


use App\Matrix\Application\RandomMatrixGenerator;
use App\Matrix\Infrastructure\ReverseShuffler;
use PHPUnit\Framework\TestCase;

final class RandomMatrixGeneratorTest extends TestCase
{
    /** @test */
    public function it_can_generate_using_shuffler(): void
    {
        $generator = new RandomMatrixGenerator(new ReverseShuffler());

        $this->assertEquals(
            [
                [8, 7, 6, 5],
                [4, 3, 2, 1]
            ],
            $generator->buildOfDistinctOfRange(2, 4, 1, 8)->rows
        );
    }
}
