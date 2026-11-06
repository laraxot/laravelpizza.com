<?php

declare(strict_types=1);

namespace Modules\Activity\Actions\Config;

use Illuminate\Support\Arr;
use Modules\Activity\Datas\ActivityConfigData;
use Modules\Tenant\Actions\Config\GetTenantConfigArrayAction;
use Spatie\QueueableAction\QueueableAction;

/**
 * Porta le impostazioni salvate dal tenant dentro `config('activitylog')`, dove le legge il pacchetto.
 *
 * Si legge il file del tenant (come ogni `ConfigData`), non `config()`: con `config:cache` un
 * salvataggio non sarebbe visibile fino al prossimo `config:cache`. Si copiano solo le chiavi che il
 * file contiene davvero, cosi' finche' nessuno salva restano valide le variabili d'ambiente di oggi
 * (`ACTIVITY_LOGGER_ENABLED`).
 */
class ApplyActivityConfigAction
{
    use QueueableAction;

    public function execute(): void
    {
        $saved = app(GetTenantConfigArrayAction::class)->execute(ActivityConfigData::tenantConfigName());
        if ($saved === []) {
            return;
        }

        $values = Arr::only(ActivityConfigData::make()->toArray(), array_keys($saved));

        foreach ($values as $key => $value) {
            config(['activitylog.'.$key => $value]);
        }
    }
}
