<?php

declare(strict_types=1);

namespace App;


final class Stairs
{
    /** @param array<int[]> $rows */
    private function __construct(public readonly array $rows)
    {
    }

    public static function buildTo(int $to): self
    {
        $rows = [];
        $stairSize = 1;

        $currentStair = 1;
        for ($i = 1; $i <= $to; $i++) {
            $rows[$currentStair][] = $i;

            if (count($rows[$currentStair]) === ($stairSize * $currentStair)) {
                $currentStair++;
            }
        }

        return new self(array_values($rows)); // array_values to fix index offset
    }

    public function asString(): string
    {
        $lines = [];
        foreach ($this->rows as $row) {
            $lines[] = implode(' ', $row);
        }

        return implode(PHP_EOL, $lines);
    }
}
