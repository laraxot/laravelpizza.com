<?php

declare(strict_types=1);

use Mockery\MockInterface;
use Modules\Xot\Tests\TestCase;
use Modules\Xot\Tests\XotBaseTestCase;

uses(TestCase::class);

afterEach(function (): void {
    Mockery::close();
});

it('returns an Expectation that can be configured and chained', function (): void {
    /** @var MockInterface&Countable $mock */
    $mock = Mockery::mock(Countable::class);

    XotBaseTestCase::singleExpectation($mock, 'count')->once()->andReturn(3);

    expect(count($mock))->toBe(3);
});

it('returns the expectation of the method asked for, not the one registered before', function (): void {
    /** @var MockInterface&Iterator<int, string> $mock */
    $mock = Mockery::mock(Iterator::class);

    $current = XotBaseTestCase::singleExpectation($mock, 'current');
    $current->andReturn('x');
    $key = XotBaseTestCase::singleExpectation($mock, 'key');
    $key->andReturn(4);

    expect($key)->not->toBe($current);
    expect($mock->current())->toBe('x');
    expect($mock->key())->toBe(4);
});
