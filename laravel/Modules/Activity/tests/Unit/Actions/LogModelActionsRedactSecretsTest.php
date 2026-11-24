<?php

declare(strict_types=1);

use Modules\Activity\Actions\LogModelCreatedAction;
use Modules\Activity\Actions\LogModelDeletedAction;
use Modules\Activity\Actions\LogModelUpdatedAction;
use Modules\Activity\Tests\Fixtures\LogModelCreatedActionTestModel;
use Modules\Activity\Tests\Fixtures\LogModelDeletedActionTestModel;
use Modules\Activity\Tests\Fixtures\LogModelUpdatedActionTestModel;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/*
 * Il log attività non contiene mai password, remember_token né segreti 2FA del modello (RedactModelAttributesAction):
 * contratto docs/contracts/log-model-updated-action.md, invariante ACTIVITY-MODEL-LOG-INV-1.
 */

test('created, updated and deleted logs never carry passwords or tokens', function (string $action, string $fixture): void {
    /** @var \Illuminate\Database\Eloquent\Model $model */
    $model = new $fixture;
    $model->forceFill([
        'id' => 'redact-'.$action,
        'name' => 'Visibile',
        'password' => 'hash-segreto',
        'remember_token' => 'token-segreto',
        'two_factor_secret' => 'segreto-2fa',
    ]);
    $model->exists = true;
    $model->syncOriginal();

    /** @var LogModelCreatedAction|LogModelUpdatedAction|LogModelDeletedAction $logger */
    $logger = new $action;
    $properties = json_encode($logger->execute($model)->properties, JSON_THROW_ON_ERROR);

    Assert::assertStringContainsString('Visibile', $properties);
    Assert::assertStringNotContainsString('hash-segreto', $properties);
    Assert::assertStringNotContainsString('token-segreto', $properties);
    Assert::assertStringNotContainsString('segreto-2fa', $properties);
})->with([
    'created' => [LogModelCreatedAction::class, LogModelCreatedActionTestModel::class],
    'updated' => [LogModelUpdatedAction::class, LogModelUpdatedActionTestModel::class],
    'deleted' => [LogModelDeletedAction::class, LogModelDeletedActionTestModel::class],
])->group('ACTIVITY-MODEL-LOG-INV-1');
