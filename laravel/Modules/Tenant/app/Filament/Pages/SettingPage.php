<?php

declare(strict_types=1);

namespace Modules\Tenant\Filament\Pages;

use Filament\Forms\Components\TextInput;
use Modules\Tenant\Datas\TenantConfigData;
use Modules\Xot\Filament\Pages\BaseSettingPage;

/**
 * Impostazioni di Tenant, solo super-admin: l'identita' del tenant nel file `metatag` (`config/{tenant}/metatag.php`),
 * lo stesso che legge `MetatagData` di Xot. Non scrive in un `tenant.php`: nessuno lo leggerebbe.
 *
 * @see TenantConfigData
 */
class SettingPage extends BaseSettingPage
{
    /** Lunghezza CSS semplice (`2em`, `32px`, `1.5rem`): finisce in uno `style` dei pannelli, niente `calc()` ne' altro. */
    public const string LOGO_HEIGHT_PATTERN = '/^\d{1,3}(\.\d{1,2})?(px|em|rem)\z/';

    public static function getConfigName(): string
    {
        return TenantConfigData::tenantConfigName();
    }

    /**
     * @return array<string, TextInput>
     */
    protected function getFormSchema(): array
    {
        return [
            'title' => TextInput::make('title')
                ->required()
                ->maxLength(120),
            'logo_height' => TextInput::make('logo_height')
                ->required()
                ->regex(self::LOGO_HEIGHT_PATTERN)
                ->maxLength(16),
        ];
    }
}
