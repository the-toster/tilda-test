<?php

declare(strict_types=1);

namespace App;

/** @template T of int|float */
final class Matrix
{
    /** @param array<T[]> $rows */
    private function __construct(public readonly array $rows)
    {
        if (count($this->rows) < 1) {
            throw new \LengthException('Zero-row matrix is not allowed');
        }

        $rowSize = count($this->rows[0]);

        foreach ($this->rows as $row) {
            if (count($row) !== $rowSize) {
                throw new \LengthException('All rows should be equal size');
            }
        }
    }

    /** @param array<T[]> $rows */
    public static function fromRows(array $rows): self
    {
        return new self($rows);
    }

    /** @param array<T> $vector */
    public static function fromVector(array $vector, int $rowsNumber, int $colsNumber): self
    {
        $rows = array_chunk($vector, $colsNumber);
        if (count($rows) !== $rowsNumber) {
            throw new \LengthException('Invalid vector length for given dimensions');
        }

        return new self($rows);
    }

    /** @return array<T> */
    public function rowsSum(): array
    {
        return array_map(array_sum(...), $this->rows);
    }

    /** @return array<T> */
    public function colsSum(): array
    {
        return $this->transpose()->rowsSum();
    }

    public function transpose(): self
    {
        // array_map zip arrays if callback is null
        return new self(array_map(null, ...$this->rows));
    }
}
