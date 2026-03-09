<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Clusters\Appearance\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Filament\Support\Exceptions\Halt;
use Illuminate\Support\Arr;
use Modules\Cms\Actions\SaveFooterConfigAction;
use Modules\Cms\Datas\FooterData;
use Modules\Cms\Filament\Clusters\Appearance;
use Modules\Tenant\Services\TenantService;
use Modules\Xot\Actions\Filament\Block\GetViewBlocksOptionsByTypeAction;
use Modules\Xot\Filament\Pages\XotBasePage;
use Webmozart\Assert\Assert;

/**
 * Page class for managing footer appearance settings.
 *
 * @property Schema $form
 */
class Footer extends XotBasePage
{
    /**
     * @var FooterData|null the form data
     */
    public ?FooterData $footerData = null;

    public array $data = [];

    protected string $view = 'cms::filament.clusters.appearance.pages.headernav';

    protected static ?string $cluster = Appearance::class;

    protected static ?int $navigationSort = 2;

    /**
     * Initialize the page and fill the form state.
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
        $options = app(GetViewBlocksOptionsByTypeAction::class)->execute('footer', false);

        return $schema
            ->components([
                ColorPicker::make('background_color')->label(trans_string('Background Color')),
                FileUpload::make('background')->label(trans_string('Background Image')),
                ColorPicker::make('overlay_color')->label(trans_string('Overlay Color')),
                Select::make('view')->options($options)->label(trans_string('View Template')),
                /*
                 * RadioImage::make('_tpl')
                 * ->options($options)
                 * ->columnSpanFull()
                 * ->label(trans_string('Template Selection')),
                 */
            ])
            ->columns(2)
            ->statePath('data');
    }

    /**
     * Update footer data and save it to the configuration.
     */
    public function updateData(): void
    {
        try {
            $data = FooterData::from($this->form->getState());

            app(SaveFooterConfigAction::class)->execute($data);

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

        $footerConfig = Arr::get($appearanceConfig, 'footer', []);
        Assert::isArray($footerConfig);

        $this->footerData = FooterData::from($footerConfig);
        /** @var array<string, mixed> */
        $form_fill = $this->footerData->toArray();
        $this->form->fill($form_fill);
    }

    /**
     * Get form actions for updating the footer settings.
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
