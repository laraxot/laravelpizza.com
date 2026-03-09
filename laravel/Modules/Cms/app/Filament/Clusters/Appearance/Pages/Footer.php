<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Clusters\Appearance\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Illuminate\Support\Arr;
use Modules\Cms\Actions\SaveFooterConfigAction;
use Modules\Cms\Datas\FooterData;
use Modules\Cms\Filament\Clusters\Appearance;
use Modules\Tenant\Services\TenantService;
use Modules\Xot\Actions\Filament\Block\GetViewBlocksOptionsByTypeAction;
use Modules\Xot\Filament\Pages\XotBasePage;

class Footer extends XotBasePage
{
    public ?FooterData $footerData = null;
    public array $data = [];

    protected string $view = 'cms::filament.clusters.appearance.pages.headernav';
    protected static ?string $cluster = Appearance::class;
    protected static ?int $navigationSort = 2;

    public function mount(): void
    {
        $this->fillForms();
    }

    public function schema(Schema $schema): Schema
    {
        $options = app(GetViewBlocksOptionsByTypeAction::class)->execute('footer', false);

        return $schema
            ->components([
                ColorPicker::make('background_color'),
                FileUpload::make('background'),
                ColorPicker::make('overlay_color'),
                Select::make('view')->options($options),
            ])
            ->columns(2)
            ->statePath('data');
    }

    public function updateData(): void
    {
        $data = FooterData::from($this->form->getState());
        app(SaveFooterConfigAction::class)->execute($data);
        Notification::make()->title('Saved successfully')->success()->send();
    }

    protected function fillForms(): void
    {
        $appearanceConfig = TenantService::getConfig('appearance');
        $footerConfig = Arr::get($appearanceConfig, 'footer', []);
        $this->footerData = FooterData::from($footerConfig);
        $this->form->fill($this->footerData->toArray());
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('updateAction')->label('Salva')->submit('updateData'),
        ];
    }
}
