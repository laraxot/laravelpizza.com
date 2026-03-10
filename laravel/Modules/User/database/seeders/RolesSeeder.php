<?php

declare(strict_types=1);

namespace Modules\User\Database\Seeders;

use Illuminate\Console\Command;
use Illuminate\Database\Seeder;
use Modules\User\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Table headers for output display.
     *
     * @var array<int, string>
     */
    private static array $OUTPUT_TABLE_HEADERS = [
        '#',
        'Name',
        'Guard',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [];

        // Display results in a table format
        $this->displayResults($roles);
    }

    /**
     * Display the seeding results in a table format.
     *
     * @param array<int, Role> $roles
     */
    private function displayResults(array $roles): void
    {
        $command = $this->getConsoleCommand();
        $command->info('Roles seeded successfully:');
        $command->table(
            self::$OUTPUT_TABLE_HEADERS,
            collect($roles)
                ->map(fn (Role $role, int $index) => [
                    $index + 1,
                    $role->name,
                    $role->guard_name,
                ])
                ->toArray(),
        );
    }

    private function getConsoleCommand(): Command
    {
        return $this->command;
    }
}
