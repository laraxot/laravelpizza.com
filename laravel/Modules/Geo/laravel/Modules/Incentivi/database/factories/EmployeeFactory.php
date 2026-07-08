<?php

declare(strict_types=1);

namespace Modules\Incentivi\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Incentivi\Models\Employee;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'matricola' => rand(1000, 99999),
            'cognome' => 'Cognome Test',
            'nome' => 'Nome Test',
            'sesso' => 'm',
            'codice_fiscale' => 'RSSMRA80A01H501U',
            'posizione_inail' => 'Posizione Test',
            'tipologia' => 'Tipologia Test',
        ];
    }
}
