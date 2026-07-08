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
 * Utenti demo deterministici per FO Fixcity (login + owner ticket).
 *
 * Idempotente: updateOrCreate su email.
 */
class DemoUserSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $userClass = XotData::make()->getUserClass();
        \assert(is_subclass_of($userClass, User::class));

        $userTable = (new $userClass())->getTable();
        $userConnection = (new $userClass())->getConnectionName() ?? 'user';

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
                'email' => 'cittadino@fixcity.demo',
                'name' => 'Cittadino Demo',
                'password' => 'password123',
                'type' => 'customer_user',
                'role' => 'user',
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
            if (null !== $role && ! $user->hasRole($roleName)) {
                $user->assignRole($role);
            }
        }

        if (null !== $this->command) {
            $this->command->info('DemoUserSeeder: '.count($demoUsers).' utenti demo pronti.');
        }
    }
}
