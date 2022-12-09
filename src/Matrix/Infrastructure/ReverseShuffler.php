<?php

declare(strict_types=1);

namespace App\Matrix\Infrastructure;


use App\Matrix\Application\Shuffler;

final class ReverseShuffler implements Shuffler
{
    public function shuffle(array $input): array
    {
        return array_reverse($input);
    }
}
