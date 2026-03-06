<?php

declare(strict_types=1);

namespace Modules\Geo\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Geo\Models\State;

/**
 * State Factory.
 *
 * @extends Factory<State>
 */
class StateFactory extends Factory
{
    protected $model = State::class;

    public function definition(): array
    {
        $italianRegions = [
            'Lazio' => 'LAZ',
            'Lombardia' => 'LOM',
            'Campania' => 'CAM',
            'Sicilia' => 'SIC',
            'Veneto' => 'VEN',
            'Piemonte' => 'PIE',
            'Emilia-Romagna' => 'EMR',
            'Toscana' => 'TOS',
            'Puglia' => 'PUG',
            'Calabria' => 'CAL',
        ];

        $states = array_keys($italianRegions);
        $state = $states[array_rand($states)];

        return [
            'state' => $state,
            'state_code' => is_string($state) && isset($italianRegions[$state]) ? $italianRegions[$state] : 'XX',
        ];
    }

    public function lombardia(): static
    {
        return $this->state(fn (array $_attributes): array => [
            'state' => 'Lombardia',
            'state_code' => 'LOM',
        ]);
    }

    public function lazio(): static
    {
        return $this->state(fn (array $_attributes): array => [
            'state' => 'Lazio',
            'state_code' => 'LAZ',
        ]);
    }
}
