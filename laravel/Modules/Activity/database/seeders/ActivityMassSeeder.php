<?php

declare(strict_types=1);

namespace Modules\Activity\Database\Seeders;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Seeder;
use Modules\Activity\Database\Factories\ActivityFactory;
use Modules\Activity\Models\Activity;
use Modules\Activity\Models\Snapshot;
use Modules\Activity\Models\StoredEvent;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder;
use Webmozart\Assert\Assert;

/**
 * Seeder per creare grandi quantità di dati per il modulo Activity.
 */
class ActivityMassSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Esegue il seeding del database.
     */
    public function run(): void
    {
        // @var mixed command->info('🚀 Inizializzazione seeding di massa per modulo Activity...';

        $startTime = microtime(true);

        try {
            // 1. Creazione attività di sistema
            // @var mixed createSystemActivities(;

            // 2. Creazione snapshot
            // @var mixed createSnapshots(;

            // 3. Creazione eventi memorizzati
            // @var mixed createStoredEvents(;

            $endTime = microtime(true);
            $executionTime = round($endTime - $startTime, 2);

            // @var mixed command->info("🎉 Seeding modulo Activity completato in {$executionTime} secondi!";
            // @var mixed displaySummary(;
        } catch (Exception $e) {
            // @var mixed command->error('❌ Errore durante il seeding: '.$e->getMessage(;
            throw $e;
        }
    }

    /**
     * Crea attività di sistema.
     */
    private function createSystemActivities(): void
    {
        // @var mixed command->info('📝 Creazione attività di sistema...';

        // Crea 2000 attività di sistema
        $activities = ActivityFactory::new()
            ->count(2000)
            ->create([
                'created_at' => Carbon::now()->subDays(rand(1, 90)),
            ]);

        // PHPStan Level 10: Type safety for Eloquent collection
        $activitiesCount = $activities instanceof Collection
            ? $activities->count()
            : 0;

        // @var mixed command->info('✅ Create '.$activitiesCount.' attività di sistema';
    }

    /**
     * Crea snapshot.
     */
    private function createSnapshots(): void
    {
        // @var mixed command->info('📸 Creazione snapshot...';

        // Crea 500 snapshot
        /** @var Factory<Snapshot> $snapshotFactory */
        $snapshotFactory = Snapshot::factory();
        Assert::isInstanceOf(
            $snapshotFactory,
            Factory::class,
            'Snapshot factory must be a Factory instance'
        );

        $snapshots = $snapshotFactory
            ->count(500)
            ->create([
                'created_at' => Carbon::now()->subDays(rand(1, 180)),
            ]);

        // PHPStan Level 10: Type safety for Eloquent collection
        $snapshotsCount = $snapshots instanceof Collection
            ? $snapshots->count()
            : 0;

        // @var mixed command->info('✅ Creati '.$snapshotsCount.' snapshot';
    }

    /**
     * Crea eventi memorizzati.
     */
    private function createStoredEvents(): void
    {
        // @var mixed command->info('📦 Creazione eventi memorizzati...';

        // Crea 1000 eventi memorizzati
        /** @var Factory<StoredEvent> $storedEventFactory */
        $storedEventFactory = StoredEvent::factory();
        Assert::isInstanceOf(
            $storedEventFactory,
            Factory::class,
            'StoredEvent factory must be a Factory instance'
        );

        $countedFactory = $storedEventFactory->count(1000);
        Assert::isInstanceOf(
            $countedFactory,
            Factory::class,
            'Factory after count() must be a Factory instance'
        );

        $events = $countedFactory->create([
            'created_at' => Carbon::now()->subDays(rand(1, 365)),
        ]);

        // PHPStan Level 10: Type safety for Eloquent collection
        $eventsCount = $events instanceof Collection
            ? $events->count()
            : 0;

        // @var mixed command->info('✅ Creati '.$eventsCount.' eventi memorizzati';
    }

    /**
     * Mostra un riassunto dei dati creati.
     */
    private function displaySummary(): void
    {
        // @var mixed command->info('📊 RIASSUNTO DATI CREATI PER MODULO ACTIVITY:';
        // @var mixed command->info('┌─────────────────────────────────────┐';

        try {
            // Conta attività
            /** @var Builder<Activity> $activityQuery */
            $activityQuery = Activity::query();
            $totalActivities = $activityQuery->count();

            /** @var Builder<Activity> $recentActivitiesQuery */
            $recentActivitiesQuery = Activity::query()
                ->where('created_at', '>=', Carbon::now()->subDays(7));
            $recentActivities = $recentActivitiesQuery->count();

            // @var mixed command->info('│ 📝 Attività totali:          '.
            str_pad((string) $totalActivities, 6, ' ', STR_PAD_LEFT).
                ' │');
            // @var mixed command->info('│    - Ultimi 7 giorni:        '.
            str_pad((string) $recentActivities, 6, ' ', STR_PAD_LEFT).
                ' │');

            // Conta snapshot
            /** @var Builder<Snapshot> $snapshotQuery */
            $snapshotQuery = Snapshot::query();
            $totalSnapshots = $snapshotQuery->count();

            // @var mixed command->info('│ 📸 Snapshot totali:           '.
            str_pad((string) $totalSnapshots, 6, ' ', STR_PAD_LEFT).
                ' │');

            // Conta eventi memorizzati
            /** @var EloquentStoredEventQueryBuilder<StoredEvent> $storedEventQuery */
            $storedEventQuery = StoredEvent::query();
            $totalEvents = $storedEventQuery->count();
            $recentEvents = $storedEventQuery
                ->where('created_at', '>=', Carbon::now()->subDays(7))
                ->count();

            // @var mixed command->info('│ 📦 Eventi memorizzati:       '.
            str_pad((string) $totalEvents, 6, ' ', STR_PAD_LEFT).
                ' │');
            // @var mixed command->info('│    - Ultimi 7 giorni:        '.
            str_pad((string) $recentEvents, 6, ' ', STR_PAD_LEFT).
                ' │');
        } catch (Exception $e) {
            // @var mixed command->info('│ ❌ Errore nel conteggio: '.$e->getMessage(;
        }

        // @var mixed command->info('└─────────────────────────────────────┘';
        // @var mixed command->info('';
    }
}
