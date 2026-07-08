<?php

declare(strict_types=1);

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Orchestratore User — N modelli owner = N {Model}Seeder (regola Laraxot).
 */
class UserDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (null !== $this->command) {
            $this->command->info('UserDatabaseSeeder: entity seeders…');
        }

        $this->call([
            AuthenticationSeeder::class,
            AuthenticationLogSeeder::class,
            DeviceSeeder::class,
            DeviceProfileSeeder::class,
            DeviceUserSeeder::class,
            ExtraSeeder::class,
            FeatureSeeder::class,
            MembershipSeeder::class,
            ModelHasPermissionSeeder::class,
            ModelHasRoleSeeder::class,
            ModelRoleSeeder::class,
            NotificationSeeder::class,
            OauthAccessTokenSeeder::class,
            OauthAuthCodeSeeder::class,
            OauthClientSeeder::class,
            OauthDeviceCodeSeeder::class,
            OauthPersonalAccessClientSeeder::class,
            OauthRefreshTokenSeeder::class,
            OauthTokenSeeder::class,
            PasswordResetSeeder::class,
            PermissionSeeder::class,
            PermissionRoleSeeder::class,
            PermissionUserSeeder::class,
            PersonalAccessTokenSeeder::class,
            ProfileSeeder::class,
            ProfileTeamSeeder::class,
            RoleSeeder::class,
            RoleHasPermissionSeeder::class,
            SocialiteUserSeeder::class,
            SocialProviderSeeder::class,
            SsoProviderSeeder::class,
            TeamSeeder::class,
            TeamInvitationSeeder::class,
            TeamPermissionSeeder::class,
            TeamUserSeeder::class,
            TenantSeeder::class,
            TenantUserSeeder::class,
        ]);

        if (null !== $this->command) {
            $this->command->info('UserDatabaseSeeder: completato.');
        }
    }
}
