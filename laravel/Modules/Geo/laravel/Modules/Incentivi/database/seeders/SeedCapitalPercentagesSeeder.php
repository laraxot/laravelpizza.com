<?php

declare(strict_types=1);

namespace Modules\Incentivi\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeedCapitalPercentagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // LAVORI

        DB::connection('incentivi')->table('capital_percentages')->insert([
            'nome' => '2%',
            'descrizione' => '40.000 ≤ X < 1.000.000',
            'tipologia' => 'Lavori',
            'da' => 40000,
            'a' => 1000000,
            'valore' => 2,
        ]);

        DB::connection('incentivi')->table('capital_percentages')->insert([
            'nome' => '1,8%',
            'descrizione' => '1.000000 ≤ X < Soglia',
            'tipologia' => 'Lavori',
            'da' => 1000000,
            'a' => 5538000,
            'valore' => 1.8,
        ]);

        DB::connection('incentivi')->table('capital_percentages')->insert([
            'nome' => '1,4%',
            'descrizione' => 'Soglia ≤ X < 25.000.000',
            'tipologia' => 'Lavori',
            'da' => 5538000,
            'a' => 25000000,
            'valore' => 1.4,
        ]);

        DB::connection('incentivi')->table('capital_percentages')->insert([
            'nome' => '1%',
            'descrizione' => 'X >= 25.000.000',
            'tipologia' => 'Lavori',
            'da' => 25000000,
            'a' => 100000000,
            'valore' => 1,
        ]);

        // SERVIZI

        DB::connection('incentivi')->table('capital_percentages')->insert([
            'nome' => '2%',
            'descrizione' => '40.000 ≤ X < 1.000.000',
            'tipologia' => 'Servizi',
            'da' => 40000,
            'a' => 1000000,
            'valore' => 2,
        ]);

        DB::connection('incentivi')->table('capital_percentages')->insert([
            'nome' => '1,8%',
            'descrizione' => '1.000.000 ≤ X < 5.500.000',
            'tipologia' => 'Servizi',
            'da' => 1000000,
            'a' => 5500000,
            'valore' => 1.8,
        ]);

        DB::connection('incentivi')->table('capital_percentages')->insert([
            'nome' => '1,4%',
            'descrizione' => '5.500.000 ≤ X < 25.000.000',
            'tipologia' => 'Servizi',
            'da' => 5500000,
            'a' => 25000000,
            'valore' => 1.4,
        ]);

        DB::connection('incentivi')->table('capital_percentages')->insert([
            'nome' => '1%',
            'descrizione' => 'X >= 25.000.000',
            'tipologia' => 'Servizi',
            'da' => 25000000,
            'a' => 100000000,
            'valore' => 1,
        ]);

        // MISTI
        DB::connection('incentivi')->table('capital_percentages')->insert([
            'nome' => '2%',
            'descrizione' => '40.000 ≤ X < 1.000.000',
            'tipologia' => 'Misti',
            'da' => 40000,
            'a' => 1000000,
            'valore' => 2,
        ]);

        DB::connection('incentivi')->table('capital_percentages')->insert([
            'nome' => '1,8%',
            'descrizione' => '1.000.000 ≤ X < Soglia',
            'tipologia' => 'Misti',
            'da' => 1000000,
            'a' => 5538000,
            'valore' => 1.8,
        ]);

        DB::connection('incentivi')->table('capital_percentages')->insert([
            'nome' => '1,4%',
            'descrizione' => 'Soglia ≤ X < 25.000.000',
            'tipologia' => 'Misti',
            'da' => 5538000,
            'a' => 25000000,
            'valore' => 1.4,
        ]);

        DB::connection('incentivi')->table('capital_percentages')->insert([
            'nome' => '1%',
            'descrizione' => 'X >= 25.000.000',
            'tipologia' => 'Misti',
            'da' => 25000000,
            'a' => 100000000,
            'valore' => 1,
        ]);
    }
}
