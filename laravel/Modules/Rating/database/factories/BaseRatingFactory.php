<?php

declare(strict_types=1);

namespace Modules\Rating\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Rating\Enums\RuleEnum;
use Modules\Rating\Models\BaseRating;

/**
 * Factory condivisa dei `Rating`.
 *
 * ## Perche' sta in `Modules/Rating` e non in Ptv
 *
 * La base sta **nel modulo che possiede il concetto**, non in un contenitore comune.
 * `Rating` possiede `BaseRating`, `BaseRatingMorph`, `BaseRatingResource`,
 * `BaseRatingsTable`: e' li' che vive il significato di "dare un punteggio", quindi e'
 * li' che vive anche la forma del dato.
 *
 * Metterla in Ptv sarebbe stato comodo e sbagliato: Ptv e' la piattaforma del dominio
 * scheda, non il magazzino di tutto cio' che e' condiviso. Una base nel posto sbagliato
 * costringe chi non c'entra a dipendere da chi non gli serve.
 *
 * ## Cosa ha sostituito
 *
 * Misura del 2026-09-02: **sei** `RatingFactory` — in `Rating`, `Ptv`, `Performance`,
 * `Progressioni`, `IndennitaResponsabilita`, `IndennitaCondizioniLavoro` — e **tutte e
 * sei con `definition()` vuota**. Sei file che esistono e non fanno nulla.
 *
 * Una definition vuota non e' neutra: `Rating::factory()->create()` scriveva una riga
 * con `title`, `color`, `rule` a `null`. Un rating senza titolo non e' mostrabile, e uno
 * senza `rule` non valida nulla — ma il test passa lo stesso.
 *
 * ## Perche' `$model` non e' dichiarato qui
 *
 * Ogni leaf vive su una connection diversa (`rating`, `ptv`, `performance`,
 * `progressioni`, `indennita_responsabilita`, `indennita_condizioni_lavoro`). Un modello
 * concreto nella base farebbe scrivere tutte le factory sullo stesso database, in
 * silenzio. La classe e' `abstract` per rendere l'omissione impossibile.
 *
 * @template TModel of \Modules\Rating\Models\BaseRating
 *
 * @extends Factory<TModel>
 */
abstract class BaseRatingFactory extends Factory
{
    /**
     * Stato di default **utile**: un rating mostrabile e validabile.
     *
     * `slug` non compare: lo genera Spatie Sluggable da `title`
     * ({@see BaseRating::getSlugOptions()}). Valorizzarlo a mano
     * significherebbe testare un valore che in produzione nessuno scrive.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        /** @var non-empty-list<string> $rules */
        $rules = array_map(
            static fn (RuleEnum $case): string => $case->value,
            RuleEnum::cases()
        );

        return [
            'title' => $this->faker->words(2, true),
            'color' => $this->faker->hexColor(),
            'icon' => null,
            'txt' => $this->faker->optional()->sentence(),
            'rule' => $rules[array_rand($rules)],
            'is_disabled' => false,
            'is_readonly' => false,
            'order_column' => $this->faker->numberBetween(1, 50),
        ];
    }
}
