<?php

declare(strict_types=1);

namespace App\Matrix\Application;


interface Shuffler
{
    /**
     * @template T
     * @param array<T> $input
     * @return array<T>
     */
    public function shuffle(array $input): array;
}
