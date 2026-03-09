<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\Pages;

use Filament\Actions\DeleteAction;
use Illuminate\Support\Facades\Hash;
use Modules\User\Filament\Actions\Header\ChangePasswordHeaderAction;
use Modules\User\Filament\Resources\UserResource;
use Modules\User\Models\User;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord as EditRecord;
use Webmozart\Assert\Assert;

abstract class BaseEditUser extends EditRecord
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
            'change-password' => ChangePasswordHeaderAction::make('change-password'),
        ];
    }
}
