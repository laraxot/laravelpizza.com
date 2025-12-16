<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;
use Modules\Tenant\Services\TenantService;
use Modules\Xot\Datas\MetatagData;
use Modules\Xot\Filament\Pages\XotBasePage;
use Modules\Xot\Filament\Traits\NavigationLabelTrait;
use Webmozart\Assert\Assert;

/**
 * @property Schema $form
 */
class MetatagPage extends XotBasePage
{
    use NavigationLabelTrait;

    public array $data = [];

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-document-text';

    protected string $view = 'xot::filament.pages.metatag';

    public function mount(): void
    {
        Assert::isArray($data = config('metatag'));

        // @phpstan-ignore argument.type
        $this->form->fill($data);
    }

    public function form(Schema $schema): Schema
    {
        $metatag = MetatagData::make();

        return $schema
            ->components([
                TextInput::make('title')->required(),
                TextInput::make('sitename'),
                TextInput::make('subtitle'),
                TextInput::make('generator'),
                TextInput::make('charset'),
                TextInput::make('author'),
                TextInput::make('description'),
                TextInput::make('keywords'),
                TextInput::make('logo_header'),
                TextInput::make('logo_header_dark')->helperText('logo for dark css'),
                TextInput::make('logo_height'),
                Repeater::make('colors')
                    ->schema([
                        Select::make('key')
                            ->required()
                            ->options($metatag->getFilamentColors()),
                        Select::make('color')
                            ->options(array_combine(array_keys(Color::all()), array_keys(Color::all())))
                            ->reactive(),
                        ColorPicker::make('hex')
                            ->required(),
                    ])
                    ->columns(3),
            ])
            ->columns(2)
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        TenantService::saveConfig('metatag', $data);

        Notification::make()
            ->success()
            ->title(__('filament-panels::resources/pages/edit-record.notifications.saved.title'))
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')->submit('save'),
        ];
    }
}
