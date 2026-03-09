<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\Pages;

use Filament\Actions\DeleteAction;
use Illuminate\Support\Facades\Hash;
use Modules\User\Filament\Resources\UserResource;
use Modules\User\Models\User;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;
use Webmozart\Assert\Assert;

class EditUser extends XotBaseEditRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (! array_key_exists('new_password', $data) || ! filled($data['new_password'])) {
            return $data;
        }

        $record = $this->getRecord();
        Assert::isInstanceOf($record, User::class);

        $newPassword = (string) $data['new_password'];
        $record->update(['password' => Hash::make($newPassword)]);

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
