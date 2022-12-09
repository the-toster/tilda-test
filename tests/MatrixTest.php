<?php

declare(strict_types=1);

namespace Tests;


use App\Matrix\Domain\Matrix;
use PHPUnit\Framework\TestCase;

final class MatrixTest extends TestCase
{
    /** @test */
    public function it_respects_rows_size_equality(): void
    {
        $this->expectExceptionMessage('All rows should be equal size');
        Matrix::fromRows([[1], [1, 2]]);
    }

    /** @test */
    public function empty_matrix_not_allowed(): void
    {
        $this->expectExceptionMessage('Zero-row matrix is not allowed');
        Matrix::fromRows([]);
    }

    /** @test */
    public function it_can_transpose(): void
    {
        $rows = [
            [1, 2, 3],
            [4, 5, 6],
            [7, 8, 9],
        ];

        $transposed = [
            [1, 4, 7],
            [2, 5, 8],
            [3, 6, 9]
        ];

        $this->assertEquals($transposed, Matrix::fromRows($rows)->transpose()->rows);
    }

    /** @test */
    public function it_can_calculate_rows_sum(): void
    {
        $rows = [
            [1, 1, 1], // 3
            [2, 2, 2], // 6
            [3, 3, 3], // 9
        ];

        $this->assertEquals([3, 6, 9], Matrix::fromRows($rows)->rowsSum());
    }

    /** @test */
    public function it_can_calculate_cols_sum(): void
    {
        $rows = [
            [1, 2, 3],
            [4, 5, 6]
        ];

        $this->assertEquals([5, 7, 9], Matrix::fromRows($rows)->colsSum());
    }

    /** @test */
    public function it_can_be_built_from_vector(): void
    {
        $vector = [1, 2, 3, 4, 5, 6];
        $expected = [
            [1, 2, 3],
            [4, 5, 6]
        ];

        $this->assertEquals($expected, Matrix::fromVector($vector, 2, 3)->rows);
    }

    /** @test */
    public function it_can_control_dimensions_when_build_from_vector(): void
    {
        $this->expectExceptionMessage('Invalid vector length for given dimensions');
        Matrix::fromVector([1, 2, 3], 2, 3);
    }

    /** @test */
    public function it_can_transpose_one_row_matrix(): void
    {
        $singleColumn = Matrix::fromRows([[1, 2]]);
        $this->assertEquals([[1], [2]], $singleColumn->transpose()->rows);
    }
}
