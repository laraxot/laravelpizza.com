<?php

declare(strict_types=1);

namespace Modules\User\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\User\Models\AuthenticationLog;
use Modules\User\Models\Device;
use Modules\User\Models\Permission;
use Modules\User\Models\Profile;
use Modules\User\Models\Role;
use Modules\User\Models\SocialProvider;
use Modules\User\Models\Team;
use Modules\User\Models\User;

/**
 * Seeder per creare grandi quantità di dati per il modulo User.
 */
class UserMassSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Esegue il seeding del database.
     */
    public function run(): void
    {
        $this->info('Inizializzazione seeding di massa per modulo User...');

        $startTime = microtime(true);

        try {
            // 1. Creazione ruoli e permessi avanzati
            $this->createAdvancedRolesAndPermissions();

            // 2. Creazione team specializzati
            $this->createSpecializedTeams();

            // 3. Creazione utenti con profili completi
            $this->createUsersWithProfiles();

            // 4. Creazione log di autenticazione
            $this->createAuthenticationLogs();

            // 5. Creazione dispositivi utente
            $this->createUserDevices();

            // 6. Creazione provider social
            $this->createSocialProviders();

            $endTime = microtime(true);
            $executionTime = round($endTime - $startTime, 2);

            $this->info("Seeding modulo User completato in {$executionTime} secondi.");
            $this->displaySummary();
        } catch (\Exception $e) {
            $this->error('Errore durante il seeding: '.$e->getMessage());
            throw $e;
        }
    }

    /**
     * Crea ruoli e permessi avanzati.
     */
    private function createAdvancedRolesAndPermissions(): void
    {
        $this->info('Creazione ruoli e permessi avanzati...');

        // Permessi avanzati
        $advancedPermissions = [
            'manage-system-settings',
            'view-system-logs',
            'manage-backups',
            'manage-api-keys',
            'view-analytics',
            'manage-notifications',
            'manage-webhooks',
            'manage-integrations',
            'view-financial-data',
            'manage-billing',
            'manage-subscriptions',
            'view-audit-trail',
            'manage-data-export',
            'manage-data-import',
        ];

        foreach ($advancedPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Ruoli avanzati
        $advancedRoles = [
            'system-architect' => [
                'manage-system-settings',
                'view-system-logs',
                'manage-backups',
                'manage-api-keys',
                'view-analytics',
                'manage-integrations',
                'view-audit-trail',
            ],
            'data-analyst' => [
                'view-analytics',
                'view-financial-data',
                'view-audit-trail',
                'manage-data-export',
                'manage-data-import',
            ],
            'billing-manager' => [
                'view-financial-data',
                'manage-billing',
                'manage-subscriptions',
                'view-audit-trail',
            ],
            'integration-specialist' => [
                'manage-integrations',
                'manage-webhooks',
                'manage-api-keys',
                'view-system-logs',
            ],
        ];

        foreach ($advancedRoles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($rolePermissions);
        }

        $this->info(
            'Creati '.
            count($advancedPermissions).
                ' permessi avanzati e '.
                count($advancedRoles).
                ' ruoli specializzati.',
        );
    }

    /**
     * Crea team specializzati.
     */
    private function createSpecializedTeams(): void
    {
        $this->info('Creazione team specializzati...');

        $specializedTeams = [
            [
                'name' => 'Sviluppo',
                'display_name' => 'Team di Sviluppo',
                'description' => 'Team per lo sviluppo software',
            ],
            [
                'name' => 'DevOps',
                'display_name' => 'Team DevOps',
                'description' => 'Team per infrastruttura e deployment',
            ],
            ['name' => 'QA', 'display_name' => 'Team Quality Assurance', 'description' => 'Team per test e qualità'],
            ['name' => 'Design', 'display_name' => 'Team Design', 'description' => 'Team per design e UX/UI'],
            [
                'name' => 'Marketing',
                'display_name' => 'Team Marketing',
                'description' => 'Team per marketing e comunicazione',
            ],
            [
                'name' => 'Vendite',
                'display_name' => 'Team Vendite',
                'description' => 'Team per vendite e business development',
            ],
            [
                'name' => 'Supporto',
                'display_name' => 'Team Supporto',
                'description' => 'Team per supporto tecnico e clienti',
            ],
            ['name' => 'Finanza', 'display_name' => 'Team Finanza', 'description' => 'Team per gestione finanziaria'],
            [
                'name' => 'Risorse Umane',
                'display_name' => 'Team HR',
                'description' => 'Team per gestione risorse umane',
            ],
            [
                'name' => 'Legale',
                'display_name' => 'Team Legale',
                'description' => 'Team per questioni legali e compliance',
            ],
        ];

        foreach ($specializedTeams as $teamData) {
            Team::firstOrCreate(['name' => $teamData['name']], $teamData);
        }

        $this->info('Creati '.count($specializedTeams).' team specializzati.');
    }

    /**
     * Crea utenti con profili completi.
     */
    private function createUsersWithProfiles(): void
    {
        $this->info('Creazione utenti con profili completi...');

        // Crea 200 utenti generici
        $userFactory = \Modules\User\Database\Factories\UserFactory::new();
        /** @var \Illuminate\Database\Eloquent\Collection<int, User> $users */
        $users = $userFactory->count(200)->create([
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now()->subDays(rand(1, 365)),
        ]);

        // Crea profili per tutti gli utenti
        $profileFactory = \Modules\User\Database\Factories\ProfileFactory::new();
        foreach ($users as $user) {
            // @phpstan-ignore-next-line
            $profileFactory->create([
                'user_id' => $user->id,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ]);
        }

        // Assegna ruoli casuali
        /** @var \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles */
        $roles = Role::all();
        foreach ($users as $user) {
            $randomRole = $roles->random();
            $user->assignRole($randomRole);
        }

        $this->info('Creati '.$users->count().' utenti con profilo.');
    }

    /**
     * Crea log di autenticazione.
     */
    private function createAuthenticationLogs(): void
    {
        $this->info('Creazione log di autenticazione...');

        // Crea 1000 log di autenticazione
        $logFactory = \Modules\User\Database\Factories\AuthenticationLogFactory::new();
        /** @var \Illuminate\Database\Eloquent\Collection<int, AuthenticationLog> $logs */
        $logs = $logFactory->count(1000)->create([
            'created_at' => Carbon::now()->subDays(rand(1, 30)),
        ]);

        $this->info('Creati '.$logs->count().' log di autenticazione.');
    }

    /**
     * Crea dispositivi utente.
     */
    private function createUserDevices(): void
    {
        $this->info('Creazione dispositivi utente...');

        // Crea 500 dispositivi
        $deviceFactory = \Modules\User\Database\Factories\DeviceFactory::new();
        /** @var \Illuminate\Database\Eloquent\Collection<int, Device> $devices */
        $devices = $deviceFactory->count(500)
            ->create([
                'created_at' => Carbon::now()->subDays(rand(1, 90)),
            ]);

        $this->info('Creati '.$devices->count().' dispositivi.');
    }

    /**
     * Crea provider social.
     */
    private function createSocialProviders(): void
    {
        $this->info('Creazione provider social...');

        // Crea 100 provider social
        $providerFactory = \Modules\User\Database\Factories\SocialProviderFactory::new();
        /** @var \Illuminate\Database\Eloquent\Collection<int, SocialProvider> $providers */
        $providers = $providerFactory->count(100)->create([
            'created_at' => Carbon::now()->subDays(rand(1, 180)),
        ]);

        $this->info('Creati '.$providers->count().' provider social.');
    }

    /**
     * Mostra un riassunto dei dati creati.
     */
    private function displaySummary(): void
    {
        $this->info('RIASSUNTO DATI CREATI PER MODULO USER:');
        $this->info('-------------------------------------');

        try {
            // Conta utenti
            $totalUsers = User::count();
            $verifiedUsers = User::whereNotNull('email_verified_at')->count();

            $this->info('Utenti totali: '.str_pad((string) $totalUsers, 6, ' ', STR_PAD_LEFT));
            $this->info('Utenti verificati: '.str_pad((string) $verifiedUsers, 6, ' ', STR_PAD_LEFT));

            // Conta profili
            $totalProfiles = Profile::count();

            $this->info('Profili totali: '.str_pad((string) $totalProfiles, 6, ' ', STR_PAD_LEFT));

            // Conta ruoli e permessi
            $totalRoles = Role::count();
            $totalPermissions = Permission::count();
            $totalTeams = Team::count();

            $this->info('Ruoli totali: '.str_pad((string) $totalRoles, 6, ' ', STR_PAD_LEFT));
            $this->info('Permessi totali: '.str_pad((string) $totalPermissions, 6, ' ', STR_PAD_LEFT));
            $this->info('Team totali: '.str_pad((string) $totalTeams, 6, ' ', STR_PAD_LEFT));

            // Conta log e dispositivi
            $totalLogs = AuthenticationLog::count();
            $totalDevices = Device::count();
            $totalProviders = SocialProvider::count();

            $this->info('Log autenticazione: '.str_pad((string) $totalLogs, 6, ' ', STR_PAD_LEFT));
            $this->info('Dispositivi: '.str_pad((string) $totalDevices, 6, ' ', STR_PAD_LEFT));
            $this->info('Provider social: '.str_pad((string) $totalProviders, 6, ' ', STR_PAD_LEFT));
        } catch (\Exception $e) {
            $this->info('Errore nel conteggio: '.$e->getMessage());
        }

        $this->info('-------------------------------------');
        $this->info('');
    }

    private function info(string $message): void
    {
        $command = $this->getConsoleCommand();
        $command->info($message);
    }

    private function error(string $message): void
    {
        $command = $this->getConsoleCommand();
        $command->error($message);
    }

    private function getConsoleCommand(): Command
    {
        return $this->command;
    }
}
