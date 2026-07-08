<?php

declare(strict_types=1);

use Modules\IndennitaCondizioniLavoro\Models\Policies\CondizioniLavoroAdmPolicy;
use Modules\IndennitaCondizioniLavoro\Models\Policies\CondizioniLavoroPolicy;
use Modules\IndennitaCondizioniLavoro\Models\Policies\IndennitaTipoPolicy;
use Modules\IndennitaCondizioniLavoro\Models\Policies\StabiDirigentePolicy;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

test('CondizioniLavoroPolicy returns expected static authorization decisions', function (): void {
    $policy = new CondizioniLavoroPolicy();
    $user = new User();

    Assert::assertTrue($policy->compila());
    Assert::assertTrue($policy->viewAny($user));
    Assert::assertFalse($policy->view());
    Assert::assertFalse($policy->create());
    Assert::assertFalse($policy->update());
    Assert::assertFalse($policy->delete());
    Assert::assertFalse($policy->restore());
    Assert::assertFalse($policy->forceDelete());
});

test('CondizioniLavoroAdmPolicy returns expected static authorization decisions', function (): void {
    $policy = new CondizioniLavoroAdmPolicy();
    $user = new User();

    Assert::assertTrue($policy->compila());
    Assert::assertFalse($policy->viewAny($user));
    Assert::assertFalse($policy->view());
    Assert::assertFalse($policy->create());
    Assert::assertFalse($policy->update());
    Assert::assertFalse($policy->delete());
    Assert::assertFalse($policy->restore());
    Assert::assertFalse($policy->forceDelete());
});

test('IndennitaTipoPolicy returns expected static authorization decisions', function (): void {
    $policy = new IndennitaTipoPolicy();
    $user = new User();

    Assert::assertTrue($policy->compila());
    Assert::assertFalse($policy->viewAny($user));
    Assert::assertFalse($policy->view());
    Assert::assertFalse($policy->create());
    Assert::assertTrue($policy->update());
    Assert::assertFalse($policy->delete());
    Assert::assertFalse($policy->restore());
    Assert::assertFalse($policy->forceDelete());
});

test('StabiDirigentePolicy returns expected static authorization decisions', function (): void {
    $policy = new StabiDirigentePolicy();
    $user = new User();

    Assert::assertTrue($policy->compila());
    Assert::assertFalse($policy->viewAny($user));
    Assert::assertFalse($policy->view());
    Assert::assertFalse($policy->create());
    Assert::assertTrue($policy->update());
    Assert::assertFalse($policy->delete());
    Assert::assertFalse($policy->restore());
    Assert::assertFalse($policy->forceDelete());
});
