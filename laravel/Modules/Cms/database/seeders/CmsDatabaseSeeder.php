<?php

declare(strict_types=1);

namespace Modules\Cms\Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Orchestratore Cms — N modelli owner = N {Model}Seeder (regola Laraxot).
 */
class CmsDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (null !== $this->command) {
            $this->command->info('CmsDatabaseSeeder: entity seeders…');
        }

        $this->call([
            AttachmentSeeder::class,
            ConfSeeder::class,
            MenuSeeder::class,
            ModuleSeeder::class,
            PageSeeder::class,
            PageContentSeeder::class,
            SectionSeeder::class,
        ]);

        if (null !== $this->command) {
            $this->command->info('CmsDatabaseSeeder: completato.');
        }
    }
}
