<?php

declare(strict_types=1);

namespace Modules\Tenant\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Tenant\Database\Factories\TestSushiModelFactory;
use Modules\Tenant\Models\TestSushiModel;

class TestSushiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Only seed in testing or local environments
        if (! app()->environment(['local', 'testing', 'development'])) {
            return;
        }

        $testData = [
            [
                'name' => 'Test Patient Management',
                'description' => 'Sistema di gestione pazienti per test',
                'status' => 'active',
                'metadata' => [
                    'priority' => 'high',
                    'category' => 'healthcare',
                    'tags' => ['patients', 'management', 'healthcare'],
                ],
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'name' => 'Test Appointment Booking',
                'description' => 'Sistema di prenotazione appuntamenti per test',
                'status' => 'pending',
                'metadata' => [
                    'priority' => 'medium',
                    'category' => 'booking',
                    'tags' => ['appointments', 'scheduling', 'booking'],
                ],
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'name' => 'Test Reporting System',
                'description' => 'Sistema di reporting per test',
                'status' => 'completed',
                'metadata' => [
                    'priority' => 'low',
                    'category' => 'reporting',
                    'tags' => ['reports', 'analytics', 'data'],
                ],
                'created_by' => 2,
                'updated_by' => 2,
            ],
        ];

        foreach ($testData as $data) {
            /** @var TestSushiModelFactory $factory */
            $factory = TestSushiModel::factory();
            $factory->create($data);
        }

        // Create additional random test models for development
        if (app()->environment(['local', 'development'])) {
            /** @var TestSushiModelFactory $factory */
            $factory = TestSushiModel::factory();
            $factory->count(10)->create();
        }
    }
}
