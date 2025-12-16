<?php

declare(strict_types=1);

namespace Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\User\Models\Team;
use Modules\User\Models\User;
use Modules\Xot\Actions\Cast\SafeStringCastAction;

/**
 * Factory per il modello Team del modulo User.
 *
 * @extends Factory<Team>
 */
class TeamFactory extends Factory
{
    /**
     * Il nome del modello corrispondente alla factory.
     *
     * @var class-string<Team>
     */
    protected $model = Team::class;

    /**
     * Definisce lo stato di default del modello.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $teamTypes = [
            'Amministrazione',
            'Sviluppo',
            'Marketing',
            'Vendite',
            'Supporto Clienti',
            'Risorse Umane',
            'Contabilità',
            'Produzione',
            'Qualità',
            'Logistica',
        ];

        return [
            'name' => app(SafeStringCastAction::class)->execute($this->faker->randomElement($teamTypes)).' Team',
            'user_id' => User::factory(),
            'personal_team' => false,
        ];
    }

    /**
     * Indica che il team è un team personale.
     */
    public function personal(): static
    {
        return $this->state(fn (array $_attributes) => [
            'personal_team' => true,
            'name' => $this->faker->firstName()."'s Team",
        ]);
    }

    /**
     * Crea un team con un owner specifico.
     */
    public function ownedBy(int $userId): static
    {
        return $this->state(fn (array $_attributes) => [
            'user_id' => $userId,
        ]);
    }

    /**
     * Crea un team con un nome specifico.
     */
    public function withName(string $name): static
    {
        return $this->state(fn (array $_attributes) => [
            'name' => $name.' Team',
        ]);
    }
}
