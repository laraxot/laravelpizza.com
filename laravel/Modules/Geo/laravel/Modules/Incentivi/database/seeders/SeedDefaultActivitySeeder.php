<?php

declare(strict_types=1);

namespace Modules\Incentivi\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use function Safe\date;

class SeedDefaultActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $attivita_lavori = [
            [
                'nome' => 'Responsabile Unico del Progetto',
                'tipo' => 'Lavori',
                'quota_percentuale' => 24,
                'importo' => null,
                'anno_competenza' => date('Y'),
                'appartiene_a_liquidazione_a_fasi' => true,
                'liquidazione_fasi' => 'Entrambe',
            ],
            [
                'nome' => 'Programmazione della spesa per investimenti',
                'tipo' => 'Lavori',
                'quota_percentuale' => 2,
                'importo' => null,
                'anno_competenza' => date('Y'),
                'appartiene_a_liquidazione_a_fasi' => false,
                'liquidazione_fasi' => null,
            ],
            [
                'nome' => 'Collaborazione all’attività del RUP, quali responsabili e addetti alla gestione tecnico-amministrativa dell’intervento e coordinamento dei flussi informativi',
                'tipo' => 'Lavori',
                'quota_percentuale' => 10,
                'importo' => null,
                'anno_competenza' => date('Y'),
                'appartiene_a_liquidazione_a_fasi' => true,
                'liquidazione_fasi' => 'Entrambe',
            ],
            [
                'nome' => 'Redazione del documento di fattibilità delle alternative progettuali',
                'tipo' => 'Lavori',
                'quota_percentuale' => 4,
                'importo' => null,
                'anno_competenza' => date('Y'),
                'appartiene_a_liquidazione_a_fasi' => false,
                'liquidazione_fasi' => null,
            ],
            [
                'nome' => 'Redazione del progetto di fattibilità tecnica ed economica',
                'tipo' => 'Lavori',
                'quota_percentuale' => 4,
                'importo' => null,
                'anno_competenza' => date('Y'),
                'appartiene_a_liquidazione_a_fasi' => false,
                'liquidazione_fasi' => null,
            ],
            [
                'nome' => 'Redazione del progetto esecutivo',
                'tipo' => 'Lavori',
                'quota_percentuale' => 4,
                'importo' => null,
                'anno_competenza' => date('Y'),
                'appartiene_a_liquidazione_a_fasi' => false,
                'liquidazione_fasi' => null,
            ],
            [
                'nome' => 'Coordinamento per la sicurezza in fase di progettazione',
                'tipo' => 'Lavori',
                'quota_percentuale' => 1,
                'importo' => null,
                'anno_competenza' => date('Y'),
                'appartiene_a_liquidazione_a_fasi' => false,
                'liquidazione_fasi' => null,
            ],
            [
                'nome' => 'Verifica del progetto ai fini della sua validazione',
                'tipo' => 'Lavori',
                'quota_percentuale' => 4,
                'importo' => null,
                'anno_competenza' => date('Y'),
                'appartiene_a_liquidazione_a_fasi' => false,
                'liquidazione_fasi' => null,
            ],
            [
                'nome' => 'Predisposizione dei documenti di gara',
                'tipo' => 'Lavori',
                'quota_percentuale' => 3,
                'importo' => null,
                'anno_competenza' => date('Y'),
                'appartiene_a_liquidazione_a_fasi' => false,
                'liquidazione_fasi' => null,
            ],
            [
                'nome' => 'Direzione dei lavori',
                'tipo' => 'Lavori',
                'quota_percentuale' => 22,
                'importo' => null,
                'anno_competenza' => date('Y'),
                'appartiene_a_liquidazione_a_fasi' => false,
                'liquidazione_fasi' => null,
            ],
            [
                'nome' => 'Ufficio di direzione dei lavori (direttore/i operativo/i, ispettore/i di cantiere)',
                'tipo' => 'Lavori',
                'quota_percentuale' => 14,
                'importo' => null,
                'anno_competenza' => date('Y'),
                'appartiene_a_liquidazione_a_fasi' => false,
                'liquidazione_fasi' => null,
            ],
            [
                'nome' => 'Coordinamento per la sicurezza in fase di esecuzione',
                'tipo' => 'Lavori',
                'quota_percentuale' => 1,
                'importo' => null,
                'anno_competenza' => date('Y'),
                'appartiene_a_liquidazione_a_fasi' => false,
                'liquidazione_fasi' => null,
            ],
            [
                'nome' => 'Collaudo tecnico-amministrativo/CRE e collaudo statico (calcolato in proporzione all’importo lavori strutture)',
                'tipo' => 'Lavori',
                'quota_percentuale' => 6,
                'importo' => null,
                'anno_competenza' => date('Y'),
                'appartiene_a_liquidazione_a_fasi' => false,
                'liquidazione_fasi' => null,
            ],
            [
                'nome' => 'Supporto tecnico al collaudatore',
                'tipo' => 'Lavori',
                'quota_percentuale' => 1,
                'importo' => null,
                'anno_competenza' => date('Y'),
                'appartiene_a_liquidazione_a_fasi' => false,
                'liquidazione_fasi' => null,
            ],
        ];

        $attivita_servizi = [
            [
                'nome' => 'Responsabile Unico del Progetto',
                'tipo' => 'Servizi',
                'quota_percentuale' => 21,
                'importo' => null,
                'anno_competenza' => date('Y'),
                'appartiene_a_liquidazione_a_fasi' => true,
                'liquidazione_fasi' => 'Entrambe',
            ],
            [
                'nome' => 'Programmazione della spesa per investimenti',
                'tipo' => 'Servizi',
                'quota_percentuale' => 2,
                'importo' => null,
                'anno_competenza' => date('Y'),
                'appartiene_a_liquidazione_a_fasi' => false,
                'liquidazione_fasi' => null,
            ],
            [
                'nome' => 'Collaborazione all’attività del RUP, quali responsabili e addetti alla gestione tecnico-amministrativa dell’intervento e coordinamento dei flussi informativi',
                'tipo' => 'Servizi',
                'quota_percentuale' => 14,
                'importo' => null,
                'anno_competenza' => date('Y'),
                'appartiene_a_liquidazione_a_fasi' => true,
                'liquidazione_fasi' => 'Entrambe',
            ],
            [
                'nome' => 'Redazione del progetto (livello unico) e predisposizione dei documenti di gara',
                'tipo' => 'Servizi',
                'quota_percentuale' => 24,
                'importo' => null,
                'anno_competenza' => date('Y'),
                'appartiene_a_liquidazione_a_fasi' => false,
                'liquidazione_fasi' => null,
            ],
            [
                'nome' => 'Coordinamento per la sicurezza in fase di progettazione',
                'tipo' => 'Servizi',
                'quota_percentuale' => 1,
                'importo' => null,
                'anno_competenza' => date('Y'),
                'appartiene_a_liquidazione_a_fasi' => false,
                'liquidazione_fasi' => null,
            ],
            [
                'nome' => 'Direzione dell’esecuzione',
                'tipo' => 'Servizi',
                'quota_percentuale' => 21,
                'importo' => null,
                'anno_competenza' => date('Y'),
                'appartiene_a_liquidazione_a_fasi' => false,
                'liquidazione_fasi' => null,
            ],
            [
                'nome' => 'Collaboratori del direttore dell’esecuzione',
                'tipo' => 'Servizi',
                'quota_percentuale' => 11,
                'importo' => null,
                'anno_competenza' => date('Y'),
                'appartiene_a_liquidazione_a_fasi' => false,
                'liquidazione_fasi' => null,
            ],
            [
                'nome' => 'Coordinamento per la sicurezza in fase di esecuzione',
                'tipo' => 'Servizi',
                'quota_percentuale' => 1,
                'importo' => null,
                'anno_competenza' => date('Y'),
                'appartiene_a_liquidazione_a_fasi' => false,
                'liquidazione_fasi' => null,
            ],
            [
                'nome' => 'Verifica di conformità/Regolare esecuzione',
                'tipo' => 'Servizi',
                'quota_percentuale' => 5,
                'importo' => null,
                'anno_competenza' => date('Y'),
                'appartiene_a_liquidazione_a_fasi' => false,
                'liquidazione_fasi' => null,
            ],
        ];

        $attivita_misti = [
            [
                'nome' => 'Responsabile Unico del Progetto',
                'tipo' => 'Misti',
                'quota_percentuale' => 14,
                'importo' => null,
                'anno_competenza' => date('Y'),
                'appartiene_a_liquidazione_a_fasi' => true,
                'liquidazione_fasi' => 'Entrambe',
            ],
            [
                'nome' => 'Programmazione della spesa per investimenti',
                'tipo' => 'Misti',
                'quota_percentuale' => 2,
                'importo' => null,
                'anno_competenza' => date('Y'),
                'appartiene_a_liquidazione_a_fasi' => false,
                'liquidazione_fasi' => null,
            ],
            [
                'nome' => 'Collaborazione all’attività del RUP, quali responsabili e addetti alla gestione tecnico-amministrativa dell’intervento e coordinamento dei flussi informativi',
                'tipo' => 'Misti',
                'quota_percentuale' => 18,
                'importo' => null,
                'anno_competenza' => date('Y'),
                'appartiene_a_liquidazione_a_fasi' => true,
                'liquidazione_fasi' => 'Entrambe',
            ],
            [
                'nome' => 'Redazione del progetto',
                'tipo' => 'Misti',
                'quota_percentuale' => 9,
                'importo' => null,
                'anno_competenza' => date('Y'),
                'appartiene_a_liquidazione_a_fasi' => false,
                'liquidazione_fasi' => null,
            ],
            [
                'nome' => 'Coordinamento per la sicurezza in fase di progettazione',
                'tipo' => 'Misti',
                'quota_percentuale' => 1,
                'importo' => null,
                'anno_competenza' => date('Y'),
                'appartiene_a_liquidazione_a_fasi' => false,
                'liquidazione_fasi' => null,
            ],
            [
                'nome' => 'Gestione delle procedure di gara e gestione amministrativa e contabile dell’appalto',
                'tipo' => 'Misti',
                'quota_percentuale' => 16,
                'importo' => null,
                'anno_competenza' => date('Y'),
                'appartiene_a_liquidazione_a_fasi' => false,
                'liquidazione_fasi' => null,
            ],
            [
                'nome' => 'Direzione dell’esecuzione',
                'tipo' => 'Misti',
                'quota_percentuale' => 15,
                'importo' => null,
                'anno_competenza' => date('Y'),
                'appartiene_a_liquidazione_a_fasi' => false,
                'liquidazione_fasi' => null,
            ],
            [
                'nome' => 'Collaboratori del direttore dell’esecuzione',
                'tipo' => 'Misti',
                'quota_percentuale' => 21,
                'importo' => null,
                'anno_competenza' => date('Y'),
                'appartiene_a_liquidazione_a_fasi' => false,
                'liquidazione_fasi' => null,
            ],
            [
                'nome' => 'Coordinamento per la sicurezza in fase di esecuzione',
                'tipo' => 'Misti',
                'quota_percentuale' => 1,
                'importo' => null,
                'anno_competenza' => date('Y'),
                'appartiene_a_liquidazione_a_fasi' => false,
                'liquidazione_fasi' => null,
            ],
            [
                'nome' => 'Verifica di conformità/Regolare esecuzione',
                'tipo' => 'Misti',
                'quota_percentuale' => 3,
                'importo' => null,
                'anno_competenza' => date('Y'),
                'appartiene_a_liquidazione_a_fasi' => false,
                'liquidazione_fasi' => null,
            ],
        ];

        foreach ($attivita_lavori as $attivita) {
            DB::connection('incentivi')->table('default_activities')->insert([
                'nome' => $attivita['nome'],
                'tipo' => $attivita['tipo'],
                'quota_percentuale' => $attivita['quota_percentuale'],
                'importo' => $attivita['importo'],
                'anno_competenza' => $attivita['anno_competenza'],
            ]);
        }

        foreach ($attivita_servizi as $attivita) {
            DB::connection('incentivi')->table('default_activities')->insert([
                'nome' => $attivita['nome'],
                'tipo' => $attivita['tipo'],
                'quota_percentuale' => $attivita['quota_percentuale'],
                'importo' => $attivita['importo'],
                'anno_competenza' => $attivita['anno_competenza'],
            ]);
        }

        foreach ($attivita_misti as $attivita) {
            DB::connection('incentivi')->table('default_activities')->insert([
                'nome' => $attivita['nome'],
                'tipo' => $attivita['tipo'],
                'quota_percentuale' => $attivita['quota_percentuale'],
                'importo' => $attivita['importo'],
                'anno_competenza' => $attivita['anno_competenza'],
            ]);
        }
    }
}
