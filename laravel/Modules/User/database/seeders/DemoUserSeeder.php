<?php

declare(strict_types=1);

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\User\Models\Role;
use Modules\User\Models\User;
use Modules\Xot\Datas\XotData;

/**
 * Utenti demo deterministici per il front-office del progetto ospite (login + owner).
 *
 * Idempotente: updateOrCreate su email.
 */
class DemoUserSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Utenti demo con password note (tra cui un super-admin): mai fuori da sviluppo e test.
        if (! app()->environment(['local', 'testing'])) {
            $this->command?->warn('DemoUserSeeder: saltato fuori da local/testing.');

            return;
        }

        $userClass = XotData::make()->getUserClass();
        \assert(is_subclass_of($userClass, User::class));

        $userTable = (new $userClass)->getTable();
        $userConnection = (new $userClass)->getConnectionName() ?? 'user';

        DB::connection($userConnection)
            ->table($userTable)
            ->where('type', 'admin_user')
            ->update(['type' => 'master_admin']);

        $demoUsers = [
            [
                'email' => 'marco.sottana@gmail.com',
                'name' => 'Marco Sottana',
                'password' => 'marco',
                'type' => 'master_admin',
                'role' => 'super-admin',
            ],
            [
                'email' => 'cittadino@example.test',
                'name' => 'Cittadino Demo',
                'password' => 'password123',
                'type' => 'customer_user',
                'role' => 'user',
            ],
            [
                'email' => 'waiter1@example.test',
                'name' => 'Mario Cameriere',
                'password' => 'waiter123',
                'type' => 'waiter_user',
                'role' => 'waiter',
            ],
            [
                'email' => 'waiter2@example.test',
                'name' => 'Luisa Cameriera',
                'password' => 'waiter123',
                'type' => 'waiter_user',
                'role' => 'waiter',
            ],
        ];

        foreach ($demoUsers as $demo) {
            $roleName = $demo['role'];
            unset($demo['role']);

            /** @var User $user */
            $user = $userClass::query()->updateOrCreate(
                ['email' => $demo['email']],
                [
                    'name' => $demo['name'],
                    'password' => Hash::make($demo['password']),
                    'email_verified_at' => now(),
                    'is_active' => true,
                    'lang' => 'it',
                    'type' => $demo['type'],
                    'state' => 'active',
                ],
            );

            $role = Role::query()->where('name', $roleName)->where('guard_name', 'web')->first();
            if ($role !== null && ! $user->hasRole($roleName)) {
                $user->assignRole($role);
            }
        }

        if ($this->command !== null) {
            $this->command->info('DemoUserSeeder: '.count($demoUsers).' utenti demo pronti.');
        }
    }
}
