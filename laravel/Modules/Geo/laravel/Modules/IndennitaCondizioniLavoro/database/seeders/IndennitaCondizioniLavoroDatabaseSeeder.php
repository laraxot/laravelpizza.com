<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

/**
 * Database seeder for IndennitaCondizioniLavoro.
 *
 * @SuppressWarnings("PMD.StaticAccess")
 */
class IndennitaCondizioniLavoroDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
    }
}
