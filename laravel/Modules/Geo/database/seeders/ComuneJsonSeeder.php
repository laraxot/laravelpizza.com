<?php

declare(strict_types=1);

namespace Modules\Geo\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Geo\Models\ComuneJson;

/**
 * ComuneJson è readonly (GeoJsonModel + comuni.json) — il seeder scalda la cache.
 */
class ComuneJsonSeeder extends Seeder
{
    public function run(): void
    {
        ComuneJson::allRegions();
        ComuneJson::allProvinces();
        ComuneJson::searchByName('Milano', 1);

        if ($this->command !== null) {
            $this->command->info('ComuneJsonSeeder: cache geo scaldata da resources/json/comuni.json');
        }
    }
}
