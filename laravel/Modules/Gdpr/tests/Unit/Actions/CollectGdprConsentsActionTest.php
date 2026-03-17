<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Actions;

uses(\Modules\Gdpr\Tests\TestCase::class);

use Modules\Gdpr\Actions\Consent\CollectGdprConsentsAction;

test('CollectGdprConsentsAction returns correct array', function () {
    $action = new CollectGdprConsentsAction();
    $result = $action->execute(true, true, false);

    expect($result)->toBeArray()
        ->toHaveKeys(['privacy_accepted', 'terms_accepted', 'marketing_consent'])
        ->privacy_accepted->toBeTrue()
        ->terms_accepted->toBeTrue()
        ->marketing_consent->toBeFalse();
});

test('CollectGdprConsentsAction handles all false', function () {
    $action = new CollectGdprConsentsAction();
    $result = $action->execute(false, false, false);

    expect($result['privacy_accepted'])->toBeFalse()
        ->and($result['terms_accepted'])->toBeFalse()
        ->and($result['marketing_consent'])->toBeFalse();
});

test('CollectGdprConsentsAction handles all true', function () {
    $action = new CollectGdprConsentsAction();
    $result = $action->execute(true, true, true);

    expect($result['privacy_accepted'])->toBeTrue()
        ->and($result['terms_accepted'])->toBeTrue()
        ->and($result['marketing_consent'])->toBeTrue();
});
