<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures\Stubs;

final class HasCustomModelLabelProbeWithLabels extends HasCustomModelLabelProbeBase
{
    protected static ?string $modelLabel = 'Utente';

    protected static ?string $pluralModelLabel = 'Utenti';

    protected static ?string $navigationLabel = 'Gestione Utenti';
}
