<?php

declare(strict_types=1);

namespace Modules\UI\Data;

use Spatie\LaravelData\Data;

/**
 * SUPERSEDED — duplicato di {@see \Modules\UI\Datas\UserData}: zero caller, e `GetUserDataAction` restituisce
 * la versione in `Datas/`. La cartella `app/Data` e' vietata da `DatasFolderConventionTest` (i data object vivono
 * in `app/Datas`); il file e' rientrato dal merge di `laraxot/dev` dopo essere stato rimosso da una story di audit.
 * Resta on-disk finche' non si autorizza la cancellazione (no-delete senza autorizzazione).
 *
 * @deprecated Use Modules\UI\Datas\UserData instead.
 * @see Modules/UI/docs/merge-conflict-markers-committed.md
 */
final class UserData extends Data
{
    /**
     * @param  array<int, string>  $permissions
     * @param  array<string, mixed>  $settings
     */
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public ?string $avatar,
        public ?string $role,
        public array $permissions,
        public array $settings,
    ) {}
}
