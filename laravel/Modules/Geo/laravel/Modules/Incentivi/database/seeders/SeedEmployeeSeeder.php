<?php

declare(strict_types=1);

namespace Modules\Incentivi\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeedEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::connection('incentivi')->table('employees')->insert([
            'matricola' => '11111',
            'cognome' => 'Storgato',
            'nome' => 'Nicola',
            'sesso' => 'm',
            'codice_fiscale' => 'STRNCL96E14L407V',
            'posizione_inail' => 'test',
        ]);

        DB::connection('incentivi')->table('employees')->insert([
            'matricola' => '11112',
            'cognome' => 'Buzziol',
            'nome' => 'Toni',
            'sesso' => 'm',
            'codice_fiscale' => 'STRNCL96E14L407F',
            'posizione_inail' => 'test',
        ]);

        DB::connection('incentivi')->table('employees')->insert([
            'matricola' => '11113',
            'cognome' => 'Cianfrone',
            'nome' => 'Antonio',
            'sesso' => 'm',
            'codice_fiscale' => 'STRNCL96E14L407T',
            'posizione_inail' => 'test',
        ]);
    }
}
