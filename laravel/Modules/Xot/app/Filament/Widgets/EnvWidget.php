<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Widgets;

use Filament\Schemas\Schema;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Component;
use Filament\Widgets\Widget;
use Illuminate\Support\Arr;
use Modules\Xot\Datas\EnvData;

/**
 * @property Schema $form
 */
class EnvWidget extends Widget implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    /** @var array<string, mixed>|null */
    public ?array $data = [];

    public array $only = [];

    protected string $view = 'xot::filament.widgets.env';

    public function mount(): void
    {
        /** @var array<string, mixed> */
        $data = EnvData::make()->toArray();
        $this->data = $data;

        $this->form->fill($this->data);
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components($this->getFormSchema())->columns(1)->statePath('data');
    }

    public function submit(): void
    {
        if (! is_array($this->data)) {
            return;
        }
        EnvData::make()->update($this->data);
        Notification::make()
            ->title('Saved successfully')
            ->success()
            ->send();

        /*
         * dddx([
         * 'data' => $this->data,
         * // 'data1' => $this->form->getState(),
         * ]);
         */
    }

    /**
     * @return array<Component>
     */
    public function getFormSchema(): array
    {
        $all = [
            'app_url' => TextInput::make('app_url')
                ->placeholder('http://localhost')
                ->helperText('Required for file uploads and other internal configs')
                ->required(),
            'debugbar_enabled' => Toggle::make('debugbar_enabled')->helperText(
                'Enable/Disable debug mode to help debug errors',
            ),
            'google_maps_api_key' => TextInput::make('google_maps_api_key')
                ->placeholder('AIzaSyAuB_...')
                ->helperText('google maps api key'),
            'telegram_bot_token' => TextInput::make('telegram_bot_token')
                ->placeholder('AIzaSyAuB_...')
                ->helperText('telegram_bot_token'),
        ];

        /**
         * @var array<Component>
         */
        return Arr::only($all, $this->only);
    }
}
