<?php

declare(strict_types=1);

namespace Modules\Incentivi\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeedWorkgroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::connection('incentivi')->table('workgroups')->insert([
            'denominazione' => 'Gruppo 1 test',
        ]);

        DB::connection('incentivi')->table('workgroups')->insert([
            'denominazione' => 'Gruppo 2 test',
        ]);
    }
}
