<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Appearance\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Schemas\Schema;
use Filament\Support\Exceptions\Halt;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Filament\Clusters\Appearance;
use Modules\Xot\Filament\Pages\XotBasePage;

/**
 * Pagina Colors nel Cluster Appearance.
 *
 * ⚠️ IMPORTANTE: Estende XotBasePage (Standalone), MAI Filament\Pages\Page!
 *
 * @property Schema $form
 *
 * @see XotBasePage
 * @see \Modules\User\docs\errori\class-page-not-found.md
 */
class Colors extends XotBasePage
{
    // $data è già definita in XotBasePage, non ridichiarare!

    protected string $view = 'user::filament.clusters.appearance.pages.colors';

    protected static ?string $cluster = Appearance::class;

    protected static ?int $navigationSort = 3;

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
                ColorPicker::make('text_color'),
                ColorPicker::make('button_color'),
                ColorPicker::make('button_text_color'),
                ColorPicker::make('input_text_color'),
                ColorPicker::make('input_border_color'),
                // ])->columns(2),
            ])
            ->columns(3)
            // ->model($this->getUser())
            ->statePath('data');
    }

    public function updateData(): void
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

    protected function getUpdateFormActions(): array
    {
        return [
            Action::make('updateAction')->submit('editForm'),
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);

        return $record;
    }
}
