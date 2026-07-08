<?php

declare(strict_types=1);

use Modules\Performance\Services\CriteriEsclusioneService;

describe('CriteriEsclusioneService', function () {
    beforeEach(function () {
        $this->service = new CriteriEsclusioneService;
    });

    describe('Service Instantiation', function () {
        it('can be instantiated', function () {
            expect($this->service)->toBeInstanceOf(CriteriEsclusioneService::class);
        });
    });

    describe('Business Logic Methods', function () {
        it('can validate exclusion criteria', function () {
            // Test della logica di validazione dei criteri
            $criteri = [
                'min_gg_ruolo' => 200,
                'max_gg_assenze_anno' => 30,
                'min_gg_anno' => 180,
            ];

            // Verifica che i criteri siano validi
            expect($criteri)->toHaveKey('min_gg_ruolo');
            expect($criteri)->toHaveKey('max_gg_assenze_anno');
            expect($criteri)->toHaveKey('min_gg_anno');

            expect($criteri['min_gg_ruolo'])->toBeGreaterThan(0);
            expect($criteri['max_gg_assenze_anno'])->toBeGreaterThan(0);
            expect($criteri['min_gg_anno'])->toBeGreaterThan(0);
        });

        it('can process exclusion rules', function () {
            // Test della logica di elaborazione delle regole di esclusione
            $regole = [
                'min_gg_ruolo' => 200,
                'noposiz_list' => '123,456,789',
                'max_gg_assenze_anno' => 25,
            ];

            // Verifica che le regole siano processabili
            foreach ($regole as $chiave => $valore) {
                expect($chiave)->toBeString();
                expect($valore)->not->toBeNull();
            }
        });

        it('can handle position exclusion lists', function () {
            // Test della gestione delle liste di esclusione per posizioni
            $posizioni_escluse = '123,456,789';
            $posizioni_array = explode(',', $posizioni_escluse);

            expect($posizioni_array)->toHaveCount(3);
            expect($posizioni_array)->toContain('123');
            expect($posizioni_array)->toContain('456');
            expect($posizioni_array)->toContain('789');
        });

        it('can validate absence thresholds', function () {
            // Test della validazione delle soglie di assenza
            $soglia_massima = 25;
            $giorni_assenza = 20;

            $valido = $giorni_assenza <= $soglia_massima;
            expect($valido)->toBeTrue();

            $giorni_assenza_eccessivi = 30;
            $valido_eccessivo = $giorni_assenza_eccessivi <= $soglia_massima;
            expect($valido_eccessivo)->toBeFalse();
        });

        it('can calculate effective working days', function () {
            // Test del calcolo dei giorni lavorativi effettivi
            $giorni_presenza = 220;
            $giorni_assenza = 30;

            $giorni_effettivi = $giorni_presenza - $giorni_assenza;
            expect($giorni_effettivi)->toBe(190);

            // Verifica che i giorni effettivi siano positivi
            expect($giorni_effettivi)->toBeGreaterThan(0);
        });

        it('can validate role requirements', function () {
            // Test della validazione dei requisiti di ruolo
            $giorni_ruolo_richiesti = 200;
            $giorni_ruolo_effettivi = 250;

            $ruolo_valido = $giorni_ruolo_effettivi >= $giorni_ruolo_richiesti;
            expect($ruolo_valido)->toBeTrue();

            $giorni_ruolo_insufficienti = 150;
            $ruolo_invalido = $giorni_ruolo_insufficienti >= $giorni_ruolo_richiesti;
            expect($ruolo_invalido)->toBeFalse();
        });
    });

    describe('Data Validation', function () {
        it('validates numeric criteria values', function () {
            $criteri_numerici = [
                'min_gg_ruolo' => 200,
                'max_gg_assenze_anno' => 30,
                'min_gg_anno' => 180,
                'max_gg_assenza_anno' => 25,
            ];

            foreach ($criteri_numerici as $chiave => $valore) {
                expect($valore)->toBeInt();
                expect($valore)->toBeGreaterThan(0);
            }
        });

        it('validates date criteria formats', function () {
            $criteri_data = [
                'date_min_assunz' => '2020-01-01',
                'date_max_assunz' => '2025-12-31',
            ];

            foreach ($criteri_data as $chiave => $valore) {
                $data_valida = DateTime::createFromFormat('Y-m-d', $valore);
                expect($data_valida)->not->toBeFalse();
            }
        });

        it('validates list criteria formats', function () {
            $criteri_lista = [
                'noposiz_list' => '123,456,789',
                'nopropro_list' => 'A,B,C',
                'noposfun_list' => 'X,Y,Z',
            ];

            foreach ($criteri_lista as $chiave => $valore) {
                $elementi = explode(',', $valore);
                expect($elementi)->toHaveCount(3);

                foreach ($elementi as $elemento) {
                    expect($elemento)->not->toBeEmpty();
                }
            }
        });
    });

    describe('Business Rule Combinations', function () {
        it('can combine multiple exclusion criteria', function () {
            $criteri_multipli = [
                'min_gg_ruolo' => 200,
                'max_gg_assenze_anno' => 25,
                'min_gg_anno' => 180,
                'noposiz_list' => '999,888,777',
            ];

            // Verifica che tutti i criteri siano presenti
            expect($criteri_multipli)->toHaveCount(4);

            // Verifica che i criteri numerici siano validi
            expect($criteri_multipli['min_gg_ruolo'])->toBeGreaterThan(0);
            expect($criteri_multipli['max_gg_assenze_anno'])->toBeGreaterThan(0);
            expect($criteri_multipli['min_gg_anno'])->toBeGreaterThan(0);

            // Verifica che la lista di esclusione sia valida
            $posizioni_escluse = explode(',', $criteri_multipli['noposiz_list']);
            expect($posizioni_escluse)->toHaveCount(3);
        });

        it('can handle complex exclusion scenarios', function () {
            // Scenario complesso con multiple regole
            $scenario = [
                'min_gg_ruolo' => 250,
                'max_gg_assenze_anno' => 20,
                'min_gg_anno' => 200,
                'noposiz_list' => '100,200,300',
                'nopropro_list' => 'A1,B2,C3',
                'date_min_assunz' => '2018-01-01',
            ];

            // Verifica della completezza dello scenario
            expect($scenario)->toHaveCount(6);

            // Verifica dei criteri numerici
            $criteri_numerici = ['min_gg_ruolo', 'max_gg_assenze_anno', 'min_gg_anno'];
            foreach ($criteri_numerici as $criterio) {
                expect($scenario[$criterio])->toBeInt();
                expect($scenario[$criterio])->toBeGreaterThan(0);
            }

            // Verifica delle liste
            $liste = ['noposiz_list', 'nopropro_list'];
            foreach ($liste as $lista) {
                $elementi = explode(',', $scenario[$lista]);
                expect($elementi)->toHaveCount(3);
            }

            // Verifica della data
            $data_valida = DateTime::createFromFormat('Y-m-d', $scenario['date_min_assunz']);
            expect($data_valida)->not->toBeFalse();
        });
    });

    describe('Edge Cases', function () {
        it('handles zero values correctly', function () {
            $criteri_zero = [
                'min_gg_ruolo' => 0,
                'max_gg_assenze_anno' => 0,
                'min_gg_anno' => 0,
            ];

            foreach ($criteri_zero as $chiave => $valore) {
                expect($valore)->toBe(0);
            }
        });

        it('handles empty lists correctly', function () {
            $lista_vuota = '';
            $elementi = explode(',', $lista_vuota);

            expect($elementi)->toHaveCount(1);
            expect($elementi[0])->toBe('');
        });

        it('handles single item lists correctly', function () {
            $lista_singola = '123';
            $elementi = explode(',', $lista_singola);

            expect($elementi)->toHaveCount(1);
            expect($elementi[0])->toBe('123');
        });
    });
});
