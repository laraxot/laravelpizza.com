<?php

declare(strict_types=1);

namespace Modules\Notify\Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            MailTemplateSeeder::class,
        ]);
    }
}
