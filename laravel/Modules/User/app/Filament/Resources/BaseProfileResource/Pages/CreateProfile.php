<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\BaseProfileResource\Pages;

use Illuminate\Support\Arr;
use Modules\User\Filament\Resources\BaseProfileResource;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateProfile extends XotBaseCreateRecord
{
    protected static string $resource = BaseProfileResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $user_data = Arr::except($data, ['user']);
        $extra = $data['user'] ?? [];
        if (! is_array($extra)) {
            $extra = [];
        }
        $user_data = array_merge($user_data, $extra);
        $user_class = XotData::make()->getUserClass();
        /** @var array<string, mixed> $user_data */
        $user = $user_class::create($user_data);
        $data['user_id'] = $user->getKey();

        return $data;
    }
}
