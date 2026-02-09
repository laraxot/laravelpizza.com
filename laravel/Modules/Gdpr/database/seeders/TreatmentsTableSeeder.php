<?php

declare(strict_types=1);

namespace Modules\Gdpr\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Gdpr\Models\Treatment;

class TreatmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $treatments = [
            [
                'name' => 'privacy_policy',
                'description' => 'user::auth.consents.privacy_policy',
                'required' => true,
                'weight' => 1,
            ],
            [
                'name' => 'terms_of_service',
                'description' => 'user::auth.consents.terms_of_service',
                'required' => true,
                'weight' => 2,
            ],
            [
                'name' => 'marketing',
                'description' => 'user::auth.consents.marketing',
                'required' => false,
                'weight' => 3,
            ],
            [
                'name' => 'profiling',
                'description' => 'user::auth.consents.profiling',
                'required' => false,
                'weight' => 4,
            ],
        ];

        foreach ($treatments as $treatment) {
            Treatment::firstOrCreate(
                ['name' => $treatment['name']],
                [
                    'description' => $treatment['description'],
                    'required' => $treatment['required'],
                    'active' => true,
                    'weight' => $treatment['weight'],
                ]
            );
        }
    }
}
