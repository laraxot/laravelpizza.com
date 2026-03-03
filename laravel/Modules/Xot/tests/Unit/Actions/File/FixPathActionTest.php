<?php

declare(strict_types=1);

use Modules\Xot\Actions\File\FixPathAction;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

beforeEach(function (): void {
    $this->action = app(FixPathAction::class);
});

it('normalizes forward slashes to directory separator', function (): void {
    $path = 'path/to/file.txt';
    $result = $this->action->execute($path);
    expect($result)->toBe(str_replace('/', DIRECTORY_SEPARATOR, $path));
});

it('normalizes back slashes to directory separator', function (): void {
    $path = 'path\\to\\file.txt';
    $result = $this->action->execute($path);
    expect($result)->toBe(str_replace('\\', DIRECTORY_SEPARATOR, $path));
});

it('handles mixed slash types', function (): void {
    $path = 'path/to\\mixed/file.txt';
    $result = $this->action->execute($path);
    expect($result)->toBe('path' . DIRECTORY_SEPARATOR . 'to' . DIRECTORY_SEPARATOR . 'mixed' . DIRECTORY_SEPARATOR . 'file.txt');
});

it('returns empty string for empty input', function (): void {
    expect($this->action->execute(''))->toBe('');
});

it('handles already normalized paths', function (): void {
    $path = 'already' . DIRECTORY_SEPARATOR . 'normalized' . DIRECTORY_SEPARATOR . 'path.txt';
    expect($this->action->execute($path))->toBe($path);
});
