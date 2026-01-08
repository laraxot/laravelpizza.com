<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Passport\Resources\OauthPersonalAccessClientResource\Pages;

use Modules\User\Filament\Clusters\Passport\Resources\OauthPersonalAccessClientResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditOauthPersonalAccessClient extends XotBaseEditRecord
{
    protected static string $resource = OauthPersonalAccessClientResource::class;
}
