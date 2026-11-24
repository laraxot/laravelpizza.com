<?php

declare(strict_types=1);

/*
 * Debito di architettura di Modules\Xot: classi che oggi violano una regola di Modules/Xot/tests/Arch/ArchitectureTest.php.
 * Misurato il 2026-11-18. Solo in discesa: chi corregge una classe la toglie, chi aggiunge una voce lo spiega nella PR.
 * Ogni voce deve stare nel namespace di questo pacchetto (lo verifica ArchitectureTest).

 * ADR: Modules/Xot/docs/adr/architecture-tests-pest-arch.md
 */

return [
    // funzioni di debug o deprecate (dd, dump, print_r, var_export, debug_backtrace…)
    'php' => [
        'Modules\Xot\Actions\Arr\SavePhpArrayAction',
        'Modules\Xot\Actions\Filament\AutoLabelAction',
        'Modules\Xot\Actions\GetTransKeyAction',
        'Modules\Xot\Actions\GetViewAction',
        'Modules\Xot\Actions\Query\StartQueryLogAction',
        'Modules\Xot\Filament\Actions\Form\FieldRefreshAction',
        'Modules\Xot\Models\XotBaseModel',
    ],
    // md5/sha1/uniqid/rand/extract nel codice di produzione: quasi sempre usi non crittografici (chiavi di cache, id), da rivedere uno per uno; factory e seeder sono esclusi a parte
    'security' => [
        'Modules\Xot\Actions\Filament\GetModulesNavigationItems',
        'Modules\Xot\Actions\Filament\GetNavigationItemByModulename',
        'Modules\Xot\Actions\File\DownloadZipByPathsDiskAction',
        'Modules\Xot\Filament\Traits\NavigationLabelTrait',
<<<<<<< HEAD
        'Modules\Xot\Services\RouteService',
    ],
    // classi in un namespace Services (regola No Services, DCP-270); NoServicesTest le vede come cartelle
    'services' => [
        'Modules\Xot\Services\Artisan\Handlers\ModuleCommandHandler',
        'Modules\Xot\Services\RouteService',
    ],
=======
    ],
    // classi in un namespace Services (regola No Services, DCP-270); NoServicesTest le vede come cartelle
    //
    // Vuota dal 2026-11-20 (base_quaeris_fila5#247). `RouteService` era una copia
    // morta: tutti e otto i metodi pubblici vivono in `Actions/Route/`, con test.
    // Via anche dalla chiave `security`, dove stava per i tre `extract($params)`.
    // `Services/.../ModuleCommandHandler` era un alias di 13 righe che estendeva
    // l'Action omonima: cancellato l'alias, anche quella restava a zero
    // riferimenti, quindi sono andate via entrambe. Il comportamento
    // `module:list/disable/enable` vive in `Actions/Artisan/HandleArtisanActRequestAction`
    // con `ArtisanActEnum`.
    'services' => [],
>>>>>>> laraxot/dev
    // classi che estendono Filament direttamente invece della base Xot (e una seconda XotBaseRelationManager duplicata)
    'xotbase' => [
        'Modules\Xot\Filament\Resources\XotBaseResource\RelationManager\XotBaseRelationManager',
    ],
];
