<?php

declare(strict_types=1);

namespace App\Matrix\Infrastructure;


use App\Matrix\Application\Shuffler;

final class RandomShuffler implements Shuffler
{

    public function shuffle(array $input): array
    {
        shuffle($input);
        return $input;
    }
}
