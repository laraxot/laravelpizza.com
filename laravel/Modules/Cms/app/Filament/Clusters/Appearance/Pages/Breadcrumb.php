<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Clusters\Appearance\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Filament\Support\Exceptions\Halt;
use Illuminate\Support\Arr;
use Modules\Cms\Filament\Clusters\Appearance;
use Modules\Tenant\Services\TenantService;
use Modules\Xot\Filament\Pages\XotBasePage;
use Webmozart\Assert\Assert;

/**
 * Class Breadcrumb.
 *
 * @property Schema $form
 */
class Breadcrumb extends XotBasePage
{
    /**
     * Data for the form state.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    protected string $view = 'cms::filament.clusters.appearance.pages.headernav';

    protected static ?string $cluster = Appearance::class;

    protected static ?int $navigationSort = 2;

    /**
     * Mount the page and initialize the form state.
     */
    public function mount(): void
    {
        $this->fillForms();
    }

    /**
     * Define the form schema.
     */
    public function schema(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('class')->label(trans_string('Class'))->placeholder(trans_string('Enter breadcrumb class')),
                TextInput::make('style')->label(trans_string('Style'))->placeholder(trans_string('Enter breadcrumb style')),
            ])
            ->columns(2)
            ->statePath('data');
    }

    /**
     * Update the breadcrumb data.
     */
    public function updateData(): void
    {
        try {
            $data = $this->form->getState();

            // Save the data using TenantService
            $up = [
                'breadcrumb' => $data,
            ];
            TenantService::saveConfig('appearance', $up);

            Notification::make()
                ->title(trans_string('Saved successfully'))
                ->success()
                ->send();
        } catch (Halt $exception) {
            Notification::make()
                ->title(trans_string('Error!'))
                ->danger()
                ->body($exception->getMessage())
                ->persistent()
                ->send();
        }
    }

    /**
     * Fill the form with initial data.
     */
    protected function fillForms(): void
    {
        $appearanceConfig = TenantService::config('appearance');
        Assert::isArray($appearanceConfig);

        /** @var array<string, mixed> */
        $breadcrumbData = Arr::get($appearanceConfig, 'breadcrumb', []);
        Assert::isArray($breadcrumbData);

        $this->form->fill($breadcrumbData);
    }

    /**
     * Get the actions for updating the form.
     *
     * @return array<Action>
     */
    protected function getUpdateFormActions(): array
    {
        return [
            Action::make('updateAction')->label(trans_string('Save Changes'))->submit('updateData'),
        ];
    }
}
