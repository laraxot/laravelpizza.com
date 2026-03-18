<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\Filament\Clusters\Passport\Resources;

use Modules\User\Filament\Clusters\Passport\Resources\OauthAccessTokenResource;
use Modules\User\Models\OauthToken;
use Modules\User\Tests\TestCase;

use function Pest\Livewire\livewire;

uses(TestCase::class);

it('can render oauth access token resource page', function () {
    $this->actingAs(\Modules\User\Models\User::factory()->create());
    $this->get(OauthAccessTokenResource::getUrl('index'))->assertSuccessful();
});

it('can list oauth access tokens', function () {
    $token = OauthToken::factory()->create();
    $this->actingAs(\Modules\User\Models\User::factory()->create());

    livewire(OauthAccessTokenResource\Pages\ListOauthAccessTokens::class)
        ->assertCanSeeTableRecords([$token]);
});
