<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Forms\Components;

use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\Xot\Filament\Forms\Components\XotBaseTextInput;

/**
 * Chiave primaria di un record in un form: si legge, si copia, non si scrive mai.
 *
 * Sostituisce `TextInput::make('id')->disabled()` ripetuto nei form. Rispetto a quello:
 * - non viene mai salvato (`dehydrated(false)`): un id non deve arrivare a fill() / update();
 * - non compare in creazione, dove l'id non c'e' ancora e il campo sarebbe un riquadro vuoto;
 * - si copia con un click (serve per segnalare un record, es. "criterio 108").
 *
 * Gemello in form di {@see IDColumn} (parita' Forms/Components <->
 * Tables/Columns): stesso nome con `ID` maiuscolo, per scelta utente 2026-11-04, anche se la regola
 * acronimi in PascalCase suggerirebbe `IdInput`. La coppia conta piu' della regola generica.
 *
 * Uso: `'id' => IDInput::make('id')`.
 */
class IDInput extends XotBaseTextInput
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->disabled()
            ->dehydrated(false)
            ->hiddenOn('create')
            ->prefixIcon('heroicon-o-hashtag')
            ->copyable();
    }
}
