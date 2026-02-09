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
            // Consensi obbligatori per registrazione (Base giuridica: Contratto - Art. 6(1)(b) GDPR)
            [
                'name' => 'privacy_policy',
                'description' => 'Consenso all\'informativa privacy ai sensi degli Art. 13 e 14 del GDPR',
                'required' => true,
                'active' => true,
                'weight' => 1,
                'documentVersion' => '1.0',
            ],
            [
                'name' => 'terms_conditions',
                'description' => 'Accettazione dei termini e condizioni di servizio',
                'required' => true,
                'active' => true,
                'weight' => 2,
                'documentVersion' => '1.0',
            ],
            [
                'name' => 'data_processing',
                'description' => 'Consenso al trattamento dei dati personali per la gestione dell\'account',
                'required' => true,
                'active' => true,
                'weight' => 3,
                'documentVersion' => '1.0',
            ],
            // Consensi opzionali (Base giuridica: Consenso - Art. 6(1)(a) GDPR)
            [
                'name' => 'marketing_consent',
                'description' => 'Consenso al ricevimento di comunicazioni promozionali e newsletter',
                'required' => false,
                'active' => true,
                'weight' => 10,
                'documentVersion' => '1.0',
            ],
            [
                'name' => 'profiling_consent',
                'description' => 'Consenso all\'analisi del comportamento per personalizzazione dell\'esperienza',
                'required' => false,
                'active' => true,
                'weight' => 11,
                'documentVersion' => '1.0',
            ],
            [
                'name' => 'analytics_consent',
                'description' => 'Consenso all\'utilizzo di analytics per il monitoraggio delle prestazioni',
                'required' => false,
                'active' => true,
                'weight' => 12,
                'documentVersion' => '1.0',
            ],
            [
                'name' => 'third_party_consent',
                'description' => 'Consenso alla condivisione dei dati con partner terzi selezionati',
                'required' => false,
                'active' => true,
                'weight' => 13,
                'documentVersion' => '1.0',
            ],
        ];

        foreach ($treatments as $treatment) {
            Treatment::updateOrCreate(
                ['name' => $treatment['name']],
                [
                    'description' => $treatment['description'],
                    'required' => $treatment['required'],
                    'active' => $treatment['active'],
                    'weight' => $treatment['weight'],
                    'documentVersion' => $treatment['documentVersion'] ?? '1.0',
                ]
            );
        }
    }
}
