<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Ptv\Filament\Resources\UserResource;
use Modules\Xot\Datas\XotData;
use Tests\TestCase;

uses(TestCase::class, DatabaseTransactions::class);

it('uses the configured user model for the resource', function () {
    $modelClass = UserResource::getModel();
    $expectedClass = XotData::make()->getUserClass();

    expect($modelClass)->toBe($expectedClass);
    expect(is_subclass_of($modelClass, Model::class))->toBeTrue();
});
