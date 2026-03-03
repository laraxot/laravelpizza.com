<?php

declare(strict_types=1);

use Modules\Xot\Actions\ParsePrintPageStringAction;

it('parses single pages and ranges', function (): void {
    $result = ParsePrintPageStringAction::execute('1-3,5,8-9');

    expect($result)->toBe([1, 2, 3, 5, 8, 9]);
});

it('throws when no valid page number exists', function (): void {
    ParsePrintPageStringAction::execute('abc,def');
})->throws(InvalidArgumentException::class, 'No valid page numbers found');

it('builds inclusive ranges from fromTo helper', function (): void {
    expect(ParsePrintPageStringAction::fromTo(4, 6))->toBe([4, 5, 6]);
});

it('throws when fromTo end is lower than start', function (): void {
    ParsePrintPageStringAction::fromTo(6, 4);
})->throws(InvalidArgumentException::class);
