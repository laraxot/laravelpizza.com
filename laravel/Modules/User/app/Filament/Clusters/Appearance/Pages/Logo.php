<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Appearance\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\Exceptions\Halt;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Filament\Clusters\Appearance;
use Modules\Xot\Filament\Pages\XotBasePage;

/**
 * @property Schema $form
 */
class Logo extends XotBasePage
{
    public ?array $logoData = [];

    protected string $view = 'user::filament.clusters.appearance.pages.logo';

    protected static ?string $cluster = Appearance::class;

    protected static ?int $navigationSort = 1;

    public function mount(): void
    {
        $this->fillForms();
    }

    // protected function getForms(): array
    // {
    //    return [
    //        'editLogoForm',
    //    ];
    // }

    public function schema(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Forms\Components\Section::make('Profile Information')
                // ->description('Update your account\'s profile information and email address.')
                // ->schema([
                FileUpload::make('logo'),
                FileUpload::make('logo_dark'),
                TextInput::make('logo_height')->numeric()->default(32),
                // ])->columns(2),
            ])
            ->columns(2)
            // ->model($this->getUser())
            ->statePath('logoData');
    }

    public function updateLogo(): void
    {
        try {
            $data = $this->form->getState();
            dddx($data);

            // $this->handleRecordUpdate($this->getUser(), $data);
        } catch (Halt $exception) {
            dddx($exception->getMessage());

            return;
        }
    }

    protected function fillForms(): void
    {
        // $data = $this->getUser()->attributesToArray();
        $data = [];

        $this->form->fill($data);
    }

    protected function getUpdateLogoFormActions(): array
    {
        return [
            Action::make('updateLogoAction')->submit('editLogoForm'),
        ];
    }

    /**
     * @param array<string, mixed> $data
     */
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);

        return $record;
    }
}
