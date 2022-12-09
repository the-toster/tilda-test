<?php

declare(strict_types=1);

require __DIR__ . "/vendor/autoload.php";

echo \App\Stairs::buildTo(100)->asString();
