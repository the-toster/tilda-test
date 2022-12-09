<?php

declare(strict_types=1);

use App\Matrix\Application\RandomMatrixGenerator;
use App\Matrix\Domain\Matrix;
use App\Matrix\Infrastructure\RandomShuffler;
use MathieuViossat\Util\ArrayToTextTable;

require __DIR__ . "/vendor/autoload.php";


$matrix = (new RandomMatrixGenerator(new RandomShuffler()))
    ->buildOfDistinctOfRange(
        rows: 5,
        cols: 7,
        from: 1,
        to:   1000
    );

echo (new ArrayToTextTable())
    ->setValuesAlignment(ArrayToTextTable::AlignRight)
    ->getTable(presentationOfMatrix($matrix));

function presentationOfMatrix(Matrix $matrix): array
{
    $sigma = "Σ";
    $rowsSum = $matrix->rowsSum();
    foreach ($matrix->rows as $i => $row) {
        $table[] = [ ...$row, $sigma . ' ' . $rowsSum[$i]];
    }
    $table[] = [ ...array_map(fn($s) => $sigma . ' ' . $s, $matrix->colsSum())];
    return $table;
}

