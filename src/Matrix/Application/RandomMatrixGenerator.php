<?php

declare(strict_types=1);

namespace App\Matrix\Application;


use App\Matrix\Domain\Matrix;

final class RandomMatrixGenerator
{
    public function __construct(private readonly Shuffler $shuffler)
    {
    }

    public function buildOfDistinctOfRange(int $rows, int $cols, int $from, int $to): Matrix
    {
        $this->assertDimensions($rows, $cols);
        $elements = range($from, $to);

        $matrixSize = $rows * $cols;
        if (count($elements) < $matrixSize) {
            throw new \UnderflowException('Range too small for given dimensions');
        }

        $shuffled = $this->shuffler->shuffle($elements);

        $firstElements = array_slice($shuffled, 0, $matrixSize);

        return Matrix::fromVector($firstElements, $rows, $cols);
    }

    private function assertDimensions(int $rows, int $cols): void
    {
        if ($rows < 1 || $cols < 1) {
            throw new \UnderflowException('Matrix dimensions should be greater than zero');
        }
    }
}
