<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Unit;

use Modules\Job\Actions\GetTaskFrequenciesAction;
use Modules\Job\Tests\TestCase;

uses(TestCase::class);

describe('GetTaskFrequenciesAction', function () {
    it('can be instantiated', function () {
        $action = app(GetTaskFrequenciesAction::class);
        expect($action)->toBeInstanceOf(GetTaskFrequenciesAction::class);
    });

    it('has queueable action trait', function () {
        $action = app(GetTaskFrequenciesAction::class);
        $traits = class_uses($action);

        expect($traits)->toContain('Spatie\QueueableAction\QueueableAction');
    });

    it('returns an array of frequencies', function () {
        $action = app(GetTaskFrequenciesAction::class);
        $result = $action->execute();

        expect($result)->toBeArray();
    });
});
