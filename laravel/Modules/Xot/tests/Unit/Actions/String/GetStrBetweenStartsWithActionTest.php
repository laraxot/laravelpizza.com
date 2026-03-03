<?php

declare(strict_types=1);

use Modules\Xot\Actions\String\GetStrBetweenStartsWithAction;

beforeEach(function (): void {
    $this->action = app(GetStrBetweenStartsWithAction::class);
});

it('extracts substring between start and balanced close', function (): void {
    $body = 'pre START (inner) close post';
    $result = $this->action->execute($body, 'START', '(', ')');

    expect($result)->toContain('START')->toContain('inner');
});

it('throws when start not found', function (): void {
    $this->action->execute('no start here', 'MISSING', '(', ')');
})->throws(Exception::class, 'Cannot find');
