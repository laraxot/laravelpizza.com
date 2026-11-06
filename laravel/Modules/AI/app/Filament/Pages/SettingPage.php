<?php

declare(strict_types=1);

namespace Modules\AI\Filament\Pages;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Modules\AI\Datas\AIConfigData;
use Modules\Xot\Filament\Pages\BaseSettingPage;

/**
 * Impostazioni di AI: modelli OpenAI, parametri di generazione, endpoint API.
 *
 * La chiave API OpenAI resta in `.env` (services.openai.api_key): non è un'impostazione
 * del form, è un segreto di infrastruttura.
 *
 * @see AIConfigData
 */
class SettingPage extends BaseSettingPage
{
    /**
     * @return array<string, Select|TextInput>
     */
    protected function getFormSchema(): array
    {
        $completionModels = [
            'gpt-3.5-turbo-instruct' => 'GPT-3.5 Turbo Instruct',
            'gpt-4o' => 'GPT-4o',
            'gpt-4o-mini' => 'GPT-4o Mini',
            'gpt-4-turbo' => 'GPT-4 Turbo',
            'gpt-4' => 'GPT-4',
        ];

        $chatModels = [
            'gpt-4o-mini' => 'GPT-4o Mini',
            'gpt-4o' => 'GPT-4o',
            'gpt-4-turbo' => 'GPT-4 Turbo',
            'gpt-4' => 'GPT-4',
            'gpt-3.5-turbo' => 'GPT-3.5 Turbo',
        ];

        return [
            'model' => Select::make('model')
                ->options($completionModels)
                ->searchable()
                ->required(),

            'chat_model' => Select::make('chat_model')
                ->options($chatModels)
                ->searchable()
                ->required(),

            'temperature' => TextInput::make('temperature')
                ->numeric()
                ->minValue(0.0)
                ->maxValue(2.0)
                ->step(0.1)
                ->required(),

            'chat_temperature' => TextInput::make('chat_temperature')
                ->numeric()
                ->minValue(0.0)
                ->maxValue(2.0)
                ->step(0.1)
                ->required(),

            'max_tokens' => TextInput::make('max_tokens')
                ->numeric()
                ->integer()
                ->minValue(1)
                ->maxValue(32000)
                ->required(),

            'timeout' => TextInput::make('timeout')
                ->numeric()
                ->integer()
                ->minValue(5)
                ->maxValue(300)
                ->required(),

            'retry_attempts' => TextInput::make('retry_attempts')
                ->numeric()
                ->integer()
                ->minValue(1)
                ->maxValue(10)
                ->required(),

            'openai_base_url' => TextInput::make('openai_base_url')
                ->url()
                ->required(),
        ];
    }
}
