<?php

declare(strict_types=1);
use Filament\Facades\Filament;
use Modules\User\Models\Role;
use Modules\Xot\Database\Seeders\PanelRoleSeeder;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

/**
 * `BaseUser::canAccessPanel()` apre un pannello a chi ha il ruolo omonimo al suo
 * id. Finche' nessuno creava quei ruoli, ogni pannello verticale rispondeva 403
 * su un database appena migrato: 23 test lo dimostravano e nessuno leggeva il
 * perche'. Questo test tiene fermo il patto fra le due meta'.
 */
it('crea un ruolo per ogni pannello registrato', function (): void {
    $this->prepareSharedSqliteForTesting();

    $panelIds = array_keys(Filament::getPanels());

    expect($panelIds)->not->toBeEmpty();

    Role::query()->whereIn('name', $panelIds)->delete();

    (new PanelRoleSeeder)->run();

    foreach ($panelIds as $panelId) {
        expect(Role::query()->where('name', $panelId)->exists())
            ->toBeTrue("manca il ruolo del pannello [{$panelId}]");
    }
});

it('non duplica i ruoli se gira due volte', function (): void {
    $this->prepareSharedSqliteForTesting();

    $seeder = new PanelRoleSeeder;
    $seeder->run();
    $seeder->run();

    $panelId = array_key_first(Filament::getPanels());

    expect(Role::query()->where('name', $panelId)->count())->toBe(1);
});
