<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Modules\User\Models\Profile;

class ProfileResource extends BaseProfileResource
{
    protected static ?string $model = Profile::class;
}
