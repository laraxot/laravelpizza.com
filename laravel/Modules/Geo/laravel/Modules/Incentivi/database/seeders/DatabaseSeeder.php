<?php

declare(strict_types=1);

namespace Modules\Incentivi\Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            // SeedDefaultActivitySeeder::class,
            // SeedCapitalPercentagesSeeder::class,
            // SeedWorkgroupSeeder::class,
            // SeedEmployeeSeeder::class,
            // SeedDepartmentSeeder::class,
        ]);
    }
}
