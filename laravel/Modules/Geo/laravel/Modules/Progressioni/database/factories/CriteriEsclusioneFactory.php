<?php

declare(strict_types=1);

namespace Modules\Progressioni\Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Progressioni\Models\CriteriEsclusione;

/**
 * @extends Factory<CriteriEsclusione>
 */
class CriteriEsclusioneFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<CriteriEsclusione>
     */
    protected $model = CriteriEsclusione::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $anno = $this->faker->numberBetween(2020, 2025);
        $criterio = $this->faker->randomElement([
            'min_gg_ruolo',
            'min_gg_anno',
            'min_valutazioni',
            'min_punteggio',
            'max_progressioni',
            'min_giorni_posfun',
        ]);

        return [
            'post_type' => 'criteri_esclusione',
            'criterio' => $criterio,
            'valore' => $this->getValueForCriterio((string) $criterio),
            'anno' => $anno,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'created_by' => 'test',
            'updated_by' => 'test',
        ];
    }

    /**
     * Generate a reasonable value based on criterio type.
     *
     * @return mixed
     */
    protected function getValueForCriterio(string $criterio)
    {
        return match ($criterio) {
            'min_gg_ruolo' => (string) $this->faker->numberBetween(180, 365),
            'min_gg_anno' => (string) $this->faker->numberBetween(150, 300),
            'min_valutazioni' => (string) $this->faker->numberBetween(1, 3),
            'min_punteggio' => (string) $this->faker->numberBetween(70, 90),
            'max_progressioni' => (string) $this->faker->numberBetween(1, 5),
            'min_giorni_posfun' => (string) $this->faker->numberBetween(90, 180),
            default => (string) $this->faker->numberBetween(1, 100),
        };
    }

    /**
     * Define a state for minimum days in role criteria.
     */
    public function minGgRuolo(int $value = 180): static
    {
        return $this->state(fn (array $attributes) => [
            'criterio' => 'min_gg_ruolo',
            'valore' => (string) $value,
        ]);
    }

    /**
     * Define a state for minimum days in year criteria.
     */
    public function minGgAnno(int $value = 150): static
    {
        return $this->state(fn (array $attributes) => [
            'criterio' => 'min_gg_anno',
            'valore' => (string) $value,
        ]);
    }

    /**
     * Define a state for minimum evaluations criteria.
     */
    public function minValutazioni(int $value = 2): static
    {
        return $this->state(fn (array $attributes) => [
            'criterio' => 'min_valutazioni',
            'valore' => (string) $value,
        ]);
    }

    /**
     * Define a state for specific year.
     */
    public function forYear(int $year = 2025): static
    {
        return $this->state(fn (array $attributes) => [
            'anno' => $year,
        ]);
    }
}
