<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Process\Process;

echo "=========================================\n";
echo "User Module Test Coverage Report (pcov)\n";
echo "=========================================\n\n";

// Run Unit tests with coverage
$cmd = [
    'php',
    '-d', 'pcov.enabled=1',
    '-d', 'pcov.directory=Modules/User/app',
    './vendor/bin/pest',
    '--coverage',
    '--coverage-text=php://stdout',
    'Modules/User/tests/Unit/',
];

$process = new Process($cmd);
$process->setTimeout(300);
$process->run(function ($type, $buffer) {
    echo $buffer;
});

echo "\n=========================================\n";
echo "Coverage report complete\n";
echo "=========================================\n";
