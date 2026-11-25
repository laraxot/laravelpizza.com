<?php

declare(strict_types=1);

namespace Modules\Rating\Contracts;

use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Collection;
use Modules\Rating\Models\Contracts\RatingContract;
use Modules\Rating\Models\Traits\HasRatingsTrait;

/**
 * Il canale con cui una pagina chiede a {@see HasRatingsTrait}
 * di costruire i campi dei rating, e le restituisce il comportamento che è suo.
 *
 * Il trait sa **cosa** ogni riga di `ratings` è — modificabile o calcolata, con quale regola
 * di validazione, con quale nome di campo. Non sa **come** quel campo si comporta nel dominio
 * di chi lo ospita: se è denaro, quale funzione lo ricalcola, quante colonne occupa, quale
 * etichetta porta.
 *
 * Questo contratto è quel confine, e il motivo per cui è un'interfaccia e non un
 * `method_exists` su un nome dedotto: dedurre il comportamento da una stringa — dal titolo
 * del rating o dal nome di un metodo — è il difetto che l'estrazione non deve promuovere a
 * piattaforma. `Rating` è consumato da sei moduli.
 *
 * Un host che non implementa questo contratto riceve comunque uno schema valido: il generale
 * basta a compilare, manca solo il particolare.
 *
 * @see HasRatingsTrait::getRatingsFormSchema()
 * @see ../../docs/wiki/concepts/schema-form-dai-rating.md
 * @see ../../docs/stories/5.92.get-ratings-form-schema-nel-trait.story.md
 */
interface RatingsFormCallerContract
{
    /**
     * Applica al componente costruito dal trait ciò che è specifico dell'host.
     *
     * Qui vanno l'etichetta, il formato (denaro, percentuale), il numero di colonne, il
     * valore di default — tutto ciò che il trait non può sapere. Il componente va
     * restituito: i metodi di Filament sono fluenti ma il contratto non lo assume.
     */
    public function decorateRatingField(RatingContract $rating, Component $component): Component;

    /**
     * Ricalcola i campi in sola lettura dopo che un campo modificabile è cambiato.
     *
     * Il trait aggancia questo metodo a `afterStateUpdated()` e gli passa i rating con
     * `is_readonly = true`. **Il calcolo resta dell'host**: è dominio, non piattaforma.
     *
     * @param  Collection<int, RatingContract>  $readonlyRatings
     */
    public function recalculateRatingFields(Set $set, Get $get, Collection $readonlyRatings): void;
}
