<?php

declare(strict_types=1);

namespace Modules\Incentivi\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeedDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::connection('incentivi')->table('departments')->insert([
            'nome' => 'Ambiente e Pianificazione Territoriale',
            'dirigente' => 'Simone Busoni',
        ]);

        DB::connection('incentivi')->table('departments')->insert([
            'nome' => 'Direzione Generale',
            'dirigente' => 'Carlo Rapicavoli',
        ]);

        DB::connection('incentivi')->table('departments')->insert([
            'nome' => 'Finanza e Contabilità',
            'dirigente' => 'Betta Genziana De Gioia',
        ]);

        DB::connection('incentivi')->table('departments')->insert([
            'nome' => 'Innovazione Digitale e Servizi di Supporto',
            'dirigente' => 'Antonio Cianfrone',
        ]);

        DB::connection('incentivi')->table('departments')->insert([
            'nome' => 'Organizzazione e Risorse Umane',
            'dirigente' => 'Maristella Pesce',
        ]);

        DB::connection('incentivi')->table('departments')->insert([
            'nome' => 'Stazione Unica Appaltante, Contratti e Trasporti',
            'dirigente' => 'Massimiliano Lorenzon',
        ]);

        DB::connection('incentivi')->table('departments')->insert([
            'nome' => 'Viabilità',
            'dirigente' => 'Antonio Pavan',
        ]);

        DB::connection('incentivi')->table('departments')->insert([
            'nome' => 'Edilizia e Patrimonio',
            'dirigente' => 'Marina Coghetto',
        ]);
    }
}
