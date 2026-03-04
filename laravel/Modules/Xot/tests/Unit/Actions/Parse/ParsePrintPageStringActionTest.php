<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Parse;

use Modules\Xot\Actions\ParsePrintPageStringAction;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

it('parses single pages and ranges', function (): void {
    $str = '1-4,6,7,8,11-14';
    $expected = [1, 2, 3, 4, 6, 7, 8, 11, 12, 13, 14];
    
    expect(ParsePrintPageStringAction::execute($str))->toBe($expected);
    expect(ParsePrintPageStringAction::execute('5'))->toBe([5]);
    expect(ParsePrintPageStringAction::execute('1-3'))->toBe([1, 2, 3]);
});

it('throws when no valid page number exists', function (): void {
    expect(fn() => ParsePrintPageStringAction::execute('invalid'))->toThrow(\InvalidArgumentException::class);
});

it('builds inclusive ranges from fromTo helper', function (): void {
    expect(ParsePrintPageStringAction::fromTo(1, 3))->toBe([1, 2, 3]);
    expect(ParsePrintPageStringAction::fromTo(5, 5))->toBe([5]);
});

it('throws when fromTo end is lower than start', function (): void {
    expect(fn() => ParsePrintPageStringAction::fromTo(10, 5))->toThrow(\InvalidArgumentException::class);
});
