<?php

declare(strict_types=1);

namespace Modules\Xot\Datas\Concerns;

use Illuminate\Support\Str;
use Modules\Tenant\Actions\Config\GetTenantConfigArrayAction;
use Modules\Xot\Filament\Pages\BaseSettingPage;

/**
 * `{Modulo}ConfigData::make()`: legge `config/{tenant}/{modulo}.php`, il file che BaseSettingPage
 * scrive.
 *
 * Si legge il file e non `config()`: con `config:cache` attivo (produzione) un salvataggio non
 * sarebbe visibile fino al prossimo `config:cache`. Stesso schema di XotData e MetatagData.
 *
 * @see BaseSettingPage
 */
trait MakesFromTenantConfig
{
    public static function make(): static
    {
        return static::from(app(GetTenantConfigArrayAction::class)->execute(static::tenantConfigName()));
    }

    /**
     * `Modules\Ptv\Datas\PtvConfigData` => `ptv`.
     */
    public static function tenantConfigName(): string
    {
        // Str::between taglia all'ULTIMO separatore (`Progressioni\Datas`): serve il primo segmento.
        return Str::lower(Str::before(Str::after(static::class, 'Modules\\'), '\\'));
    }
}
