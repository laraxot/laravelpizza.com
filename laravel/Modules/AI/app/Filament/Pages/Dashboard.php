<?php

declare(strict_types=1);

namespace Modules\AI\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBaseDashboard;

/**
 * Dashboard del pannello AI (Filament `ai/admin`).
 *
 * Estende XotBaseDashboard così non passa da GetTransKey su classe `Dashboard`
 * (chiave vuota `ai::` → file lang `.php` e gruppo `.navigation`).
 *
 * @see Modules/Xot/docs/contracts/get-trans-key-action.md
 * @see Modules/AI/docs/manuals/manuale-utente.md
 */
class Dashboard extends XotBaseDashboard {}
