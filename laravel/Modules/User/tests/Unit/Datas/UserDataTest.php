<?php

declare(strict_types=1);

use Modules\User\Datas\UserData;
use Tests\TestCase;

uses(TestCase::class);

test('lo schema users espone creazione e aggiornamento colonne', function (): void {
    $createColumns = new ReflectionMethod(UserData::class, 'createColumns');
    $updateColumns = new ReflectionMethod(UserData::class, 'updateColumns');

    expect($createColumns->isPublic())->toBeTrue()
        ->and($createColumns->isStatic())->toBeTrue()
        ->and($updateColumns->isPublic())->toBeTrue()
        ->and($updateColumns->isStatic())->toBeTrue();
});
