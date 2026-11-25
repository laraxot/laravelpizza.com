<?php

declare(strict_types=1);

namespace Modules\Xot\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory condivisa di `Extra`.
 *
 * Sostituisce 2 factory (Xot e User), **entrambe** con `definition()` vuota.
 *
 * ## Perche' `$model` non e' dichiarato qui
 *
 * Ogni leaf vive su una connection diversa. Un modello concreto nella base farebbe
 * scrivere tutte le factory sullo stesso database, in silenzio. La classe e' `abstract`
 * per rendere l'omissione impossibile: il leaf deve dichiarare il suo `$model`.
 *
 * @template TModel of \Modules\Xot\Models\BaseExtra
 *
 * @extends Factory<TModel>
 */
abstract class BaseExtraFactory extends Factory
{
    /**
     * `model_type` e `model_id` sono la relazione morph: senza, l'extra non appartiene a
     * nulla e nessuna query lo trova.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'model_id' => $this->faker->numberBetween(1, 9999),
            'model_type' => 'Modules\\Xot\\Models\\Extra',
            'extra_attributes' => [],
        ];
    }
}
