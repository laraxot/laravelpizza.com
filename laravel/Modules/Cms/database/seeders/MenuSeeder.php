<?php

declare(strict_types=1);

namespace Modules\Cms\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Cms\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        xotSeedModelOnce(Menu::class);
    }
}
