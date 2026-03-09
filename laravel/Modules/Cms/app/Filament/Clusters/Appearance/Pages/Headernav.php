<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Clusters\Appearance\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Illuminate\Support\Arr;
use Modules\Cms\Actions\SaveHeadernavConfigAction;
use Modules\Cms\Datas\HeadernavData;
use Modules\Cms\Filament\Clusters\Appearance;
use Modules\Tenant\Services\TenantService;
use Modules\Xot\Actions\Filament\Block\GetViewBlocksOptionsByTypeAction;
use Modules\Xot\Filament\Pages\XotBasePage;

class Headernav extends XotBasePage
{
    public ?HeadernavData $headernavData = null;
    public array $data = [];

    protected string $view = 'cms::filament.clusters.appearance.pages.headernav';
    protected static ?string $cluster = Appearance::class;
    protected static ?int $navigationSort = 1;

    public function mount(): void
    {
        $this->fillForms();
    }

    public function schema(Schema $schema): Schema
    {
        $options = app(GetViewBlocksOptionsByTypeAction::class)->execute('headernav', false);

        return $schema
            ->components([
                ColorPicker::make('background_color'),
                FileUpload::make('background'),
                ColorPicker::make('overlay_color'),
                TextInput::make('overlay_opacity')->numeric(),
                TextInput::make('class'),
                TextInput::make('style'),
                Select::make('view')->options($options),
            ])
            ->columns(2)
            ->statePath('data');
    }

    public function updateData(): void
    {
        $data = HeadernavData::from($this->form->getState());
        app(SaveHeadernavConfigAction::class)->execute($data);
        Notification::make()->title('Saved successfully')->success()->send();
    }

    protected function fillForms(): void
    {
        $appearanceConfig = TenantService::getConfig('appearance');
        $headernavConfig = Arr::get($appearanceConfig, 'headernav', []);
        $this->headernavData = HeadernavData::from($headernavConfig);
        $this->form->fill($this->headernavData->toArray());
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('updateAction')->label('Salva')->submit('updateData'),
        ];
    }
}
