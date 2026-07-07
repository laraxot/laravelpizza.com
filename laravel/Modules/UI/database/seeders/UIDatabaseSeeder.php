<?php

declare(strict_types=1);

namespace Modules\UI\Database\Seeders;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class UIDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
=======
use Illuminate\Database\Seeder;

/**
 * Orchestratore UI — N modelli owner = N {Model}Seeder (regola Laraxot).
 */
class UIDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (null !== $this->command) {
            $this->command->info('UIDatabaseSeeder: entity seeders…');
        }

        $this->call([
            CategorySeeder::class,
            CollectionSeeder::class,
            FieldOptionSeeder::class,
        ]);

        if (null !== $this->command) {
            $this->command->info('UIDatabaseSeeder: completato.');
        }
>>>>>>> 40b96bcd6 (.)
    }
}
