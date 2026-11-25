<?php

declare(strict_types=1);

namespace Modules\Rating\Filament\Tables\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Filament\Tables\Filters\XotBaseTernaryFilter;

/**
 * «La scheda è stata valutata davvero?».
 *
 * Una riga in `rating_morph` non vuol dire valutazione inserita: le righe si creano
 * quando la scheda viene preparata, con `value` a NULL, e restano così finché il
 * valutatore non compila. Sui dati attuali di un'installazione: 180 righe pivot,
 * **171 con `value` NULL**, e solo 2 schede su 7.955 hanno almeno un valore.
 * Filtrare sull'esistenza della riga risponderebbe sempre di sì.
 *
 * Quindi «valutata» = esiste almeno una riga con `value` **non NULL e diverso da
 * zero**. Lo zero conta come non valutato quanto il NULL: è il valore che resta
 * quando si salva senza toccare niente.
 *
 * Componente riutilizzabile: sa da sé su quali tabelle ha senso mostrarsi e da
 * quale tabella pivot leggere. Chi lo compone scrive una riga.
 *
 * @see docs/wiki/rules/filament-reusable-component-owns-visibility.md
 */
class HasRatingValuesFilter extends XotBaseTernaryFilter
{
    public static function getDefaultName(): ?string
    {
        return 'has_rating_values';
    }

    protected function setUp(): void
    {
        parent::setUp();

        // Su un model senza la relazione `ratings()` il filtro non ha nulla da
        // chiedere: si nasconde invece di far esplodere la query.
        $this->hidden(fn (): bool => ! $this->modelHasRatings());

        $this->queries(
            true: fn (Builder $query): Builder => $query->whereHas(
                'ratingMorphs',
                fn (Builder $rows) => $this->constrainToValued($rows),
            ),
            false: fn (Builder $query): Builder => $query->whereDoesntHave(
                'ratingMorphs',
                fn (Builder $rows) => $this->constrainToValued($rows),
            ),
            blank: static fn (Builder $query): Builder => $query,
        );
    }

    /**
     * Si interroga `ratingMorphs()` — le righe pivot — e non `ratings()`: `value` sta
     * sul pivot, e `ratings()` vede una sola delle due forme di `model_type` presenti
     * in tabella. Con la relazione sbagliata il filtro risponderebbe 1 invece di 147.
     *
     * @param  Builder<Model>  $rows
     */
    protected function constrainToValued(Builder $rows): void
    {
        $rows->whereNotNull('value')->where('value', '!=', 0);
    }

    protected function modelHasRatings(): bool
    {
        $model = $this->getTable()->getModel();

        return is_string($model) && method_exists($model, 'ratingMorphs');
    }
}
