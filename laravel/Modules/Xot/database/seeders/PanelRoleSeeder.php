<?php

declare(strict_types=1);

namespace Modules\Xot\Database\Seeders;

use Filament\Facades\Filament;
use Illuminate\Database\Seeder;
use Modules\User\Models\Role;

/**
 * Un ruolo per ogni pannello registrato.
 *
 * `BaseUser::canAccessPanel()` apre un pannello a chi ha il ruolo omonimo al suo
 * id. Finora nessuno creava quei ruoli: su un database appena migrato i pannelli
 * verticali (wts, thermo, dds, ...) rispondevano 403 a chiunque, e il difetto si
 * vedeva solo al primo deploy pulito.
 *
 * Scorre i pannelli invece di elencarli: un pannello nuovo si porta dietro il
 * proprio ruolo senza che nessuno debba ricordarsi di aggiungerlo qui.
 */
class PanelRoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach (array_keys(Filament::getPanels()) as $panelId) {
            Role::firstOrCreate([
                'name' => $panelId,
                'guard_name' => 'web',
            ]);
        }
    }
}
