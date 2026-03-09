<?php

declare(strict_types=1);

namespace Modules\User\Filament\Pages;

use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Filament\Pages\XotBasePage;

class MyProfilePage extends XotBasePage implements HasSchemas
{
    use InteractsWithSchemas;

    public ?array $profileData = [];
    public ?array $passwordData = [];

    protected string $view = 'user::filament.pages.my-profile';
    protected static bool $shouldRegisterNavigation = false;

    public function mount(): void
    {
        $user = $this->getUser();
        $this->editProfileForm->fill($user->toArray());
        $this->editPasswordForm->fill();
    }

    public function editProfileForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Profile Information')
                    ->schema([
                        TextInput::make('name')->required(),
                        TextInput::make('email')->email()->required(),
                    ]),
            ])
            ->model($this->getUser())
            ->statePath('profileData');
    }

    public function editPasswordForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Update Password')
                    ->schema([
                        TextInput::make('current_password')->password()->required()->currentPassword(),
                        TextInput::make('new_password')->password()->required(),
                        TextInput::make('new_password_confirmation')->password()->required()->same('new_password'),
                    ]),
            ])
            ->model($this->getUser())
            ->statePath('passwordData');
    }

    public function getUser(): Authenticatable&Model
    {
        $user = Filament::auth()->user();
        if (! $user instanceof Model) {
            throw new \Exception('User must be Eloquent model');
        }

        return $user;
    }

    protected function getForms(): array
    {
        return ['editProfileForm', 'editPasswordForm'];
    }

    public function getFormSchema(): array
    {
        return [
            TextInput::make('name')->required(),
            TextInput::make('email')->required(),
        ];
    }
}
