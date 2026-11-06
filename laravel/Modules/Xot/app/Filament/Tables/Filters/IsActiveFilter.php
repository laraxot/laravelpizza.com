<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Tables\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * Filtro ternario "attivo / inattivo" riusabile su qualunque tabella che espone
 * una colonna booleana `is_active`.
 *
 * Perche' una classe e non un `TernaryFilter::make('is_active')` ripetuto in ogni
 * tabella: (etichetta, stato vuoto, query) sono identici ovunque e ogni copia si
 * porta dietro un proprioavo di traduzione — e cosi che almeno una tabella resta
 * con "Si"/"No" o con un placeholder vuoto. Qui le stringhe vengono da
 * `xot::table-filters.is_active.*`, quindi la correzione di una lingua vale per
 * tutti i moduli che usano il filtro.
 *
 * Perche' ternario e non SelectFilter: con tre stati (tutti / attivo / inattivo)
 * l'utente vede lo stato corrente senza aprire un menu, e lo screen reader
 * annuncia un solo controll invece di una select con etichetta generica. Lo stato
 * vuoto ha una label propria invece di restare "-": senza, chi usa uno screen
 * reader non ha modo di sapere che il filtro e disattivato.
 *
 * Il nome del campo non e fisso: `make('is_active')`, `make('enabled')`,
 * `make('active')` funzionano tutti, perche' le query sono costruite sul nome
 * ricevuto e non su una stringa scritta a mano nella classe.
 */
class IsActiveFilter extends XotBaseTernaryFilter
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('xot::table-filters.is_active.label'));
        $this->placeholder(__('xot::table-filters.is_active.all'));
        $this->trueLabel(__('xot::table-filters.is_active.active'));
        $this->falseLabel(__('xot::table-filters.is_active.inactive'));

        // Posizionali, non named: `queries(true: ..., false: ...)` sembra
        // leggibile ma i nomi dei parametri sono keyword riservate e PHP li
        // tratta come posizionali (verificato: i valori finiscono scambiati
        // nell'ordine sbagliato). L'ordine qui e (per true, per false).
        $this->queries(
            fn (Builder $query): Builder => $query->where($this->getName(), true),
            fn (Builder $query): Builder => $query->where($this->getName(), false),
        );
    }
}
