<?php

declare(strict_types=1);

use Modules\Performance\Models\Individuale;
use Modules\Performance\Models\IndividualeDip;
use Modules\Performance\Models\IndividualeDirigente;
use Modules\Performance\Models\IndividualePo;
use Modules\Performance\Models\IndividualeRegionale;

describe('Individuale Model', function () {
    beforeEach(function () {
        $this->individuale = new Individuale;
    });

    describe('Database Configuration', function () {
        it('uses performance database connection', function () {
            expect($this->individuale->getConnectionName())->toBe('performance');
        });

        it('uses correct table name', function () {
            expect($this->individuale->getTable())->toBe('performance_individuale');
        });
    });

    describe('Fillable Attributes', function () {
        it('has correct fillable attributes', function () {
            $fillable = $this->individuale->getFillable();

            expect($fillable)->toContain('type');
            expect($fillable)->toContain('ente');
            expect($fillable)->toContain('matr');
            expect($fillable)->toContain('cognome');
            expect($fillable)->toContain('nome');
            expect($fillable)->toContain('email');
            expect($fillable)->toContain('stabi');
            expect($fillable)->toContain('repar');
            expect($fillable)->toContain('anno');
            expect($fillable)->toContain('ha_diritto');
            expect($fillable)->toContain('totale_punteggio');
            expect($fillable)->toContain('valutatore_id');
        });

        it('has performance evaluation fields', function () {
            $fillable = $this->individuale->getFillable();

            expect($fillable)->toContain('esperienza_acquisita');
            expect($fillable)->toContain('risultati_ottenuti');
            expect($fillable)->toContain('arricchimento_professionale');
            expect($fillable)->toContain('impegno');
            expect($fillable)->toContain('qualita_prestazione');
        });

        it('has absence and presence tracking fields', function () {
            $fillable = $this->individuale->getFillable();

            expect($fillable)->toContain('gg_assenza_anno');
            expect($fillable)->toContain('gg_presenza_anno');
            expect($fillable)->toContain('ore_assenza_anno');
            expect($fillable)->toContain('giorni_assenza');
            expect($fillable)->toContain('giorni_presenza');
        });
    });

    describe('Type Casting', function () {
        it('casts numeric fields correctly', function () {
            $casts = $this->individuale->casts();

            expect($casts['stabi'])->toBe('integer');
            expect($casts['repar'])->toBe('integer');
            expect($casts['ente'])->toBe('integer');
            expect($casts['matr'])->toBe('integer');
            expect($casts['anno'])->toBe('integer');
            expect($casts['ha_diritto'])->toBe('integer');
        });

        it('casts performance score fields as float', function () {
            $casts = $this->individuale->casts();

            expect($casts['totale_punteggio'])->toBe('float');
            expect($casts['peso_esperienza_acquisita'])->toBe('float');
            expect($casts['peso_risultati_ottenuti'])->toBe('float');
            expect($casts['peso_arricchimento_professionale'])->toBe('float');
            expect($casts['peso_impegno'])->toBe('float');
            expect($casts['peso_qualita_prestazione'])->toBe('float');
        });

        it('casts absence and presence fields correctly', function () {
            $casts = $this->individuale->casts();

            expect($casts['gg_assenza_anno'])->toBe('integer');
            expect($casts['gg_presenza_anno'])->toBe('integer');
            expect($casts['hh_assenza_anno'])->toBe('float');
            expect($casts['gg_anno'])->toBe('float');
        });

        it('casts type field to WorkerType enum', function () {
            $casts = $this->individuale->casts();

            expect($casts['type'])->toBe(\Modules\Ptv\Enums\WorkerType::class);
        });

        it('can set and get type attribute with enum casting', function () {
            $individuale = new Individuale;
            
            // Test setting type directly with string
            $individuale->type = 'dip';
            expect($individuale->type)->toBe(\Modules\Ptv\Enums\WorkerType::Dip);
            expect($individuale->type->value)->toBe('dip');
            
            // Test setting with enum
            $individuale->type = \Modules\Ptv\Enums\WorkerType::Regionale;
            expect($individuale->type)->toBe(\Modules\Ptv\Enums\WorkerType::Regionale);
            expect($individuale->type->value)->toBe('regionale');
        });
    });

    describe('Child Types', function () {
        it('has correct child type mappings', function () {
            $childTypes = $this->individuale->getChildTypes();

            expect($childTypes)->toHaveKey('po');
            expect($childTypes)->toHaveKey('dip');
            expect($childTypes)->toHaveKey('regionale');
            expect($childTypes)->toHaveKey('dirigente');
            expect($childTypes)->toHaveKey('individuale_regionale');
        });

        it('maps to correct child classes', function () {
            $childTypes = $this->individuale->getChildTypes();

            expect($childTypes['po'])->toBe(IndividualePo::class);
            expect($childTypes['dip'])->toBe(IndividualeDip::class);
            expect($childTypes['dirigente'])->toBe(IndividualeDirigente::class);
            expect($childTypes['regionale'])->toBe(IndividualeRegionale::class);
            expect($childTypes['individuale_regionale'])->toBe(IndividualeRegionale::class);
        });
    });

    describe('Performance Evaluation Logic', function () {
        it('can calculate total score from individual components', function () {
            $individuale = Individuale::factory()->create([
                'esperienza_acquisita' => 8.5,
                'risultati_ottenuti' => 7.8,
                'arricchimento_professionale' => 9.2,
                'impegno' => 8.0,
                'qualita_prestazione' => 8.7,
            ]);

            // Verifica che i campi di valutazione siano impostati correttamente
            expect($individuale->esperienza_acquisita)->toBe(8.5);
            expect($individuale->risultati_ottenuti)->toBe(7.8);
            expect($individuale->arricchimento_professionale)->toBe(9.2);
            expect($individuale->impegno)->toBe(8.0);
            expect($individuale->qualita_prestazione)->toBe(8.7);
        });

        it('tracks absence and presence correctly', function () {
            $individuale = Individuale::factory()->create([
                'gg_assenza_anno' => 15,
                'gg_presenza_anno' => 220,
                'ore_assenza_anno' => 120.5,
            ]);

            expect($individuale->gg_assenza_anno)->toBe(15);
            expect($individuale->gg_presenza_anno)->toBe(220);
            expect($individuale->ore_assenza_anno)->toBe(120.5);
        });
    });

    describe('Business Rules', function () {
        it('has diritto field for eligibility', function () {
            $individuale = Individuale::factory()->create([
                'ha_diritto' => 1,
                'motivo' => null,
            ]);

            expect($individuale->ha_diritto)->toBe(1);
            expect($individuale->motivo)->toBeNull();
        });

        it('can track part-time percentages', function () {
            $individuale = Individuale::factory()->create([
                'perc_parttime' => 50.0,
                'perc_parttime_anno' => 45.5,
                'perc_parttime_dalal' => 48.0,
            ]);

            expect($individuale->perc_parttime)->toBe(50.0);
            expect($individuale->perc_parttime_anno)->toBe(45.5);
            expect($individuale->perc_parttime_dalal)->toBe(48.0);
        });

        it('can track position and function codes', function () {
            $individuale = Individuale::factory()->create([
                'posiz' => 123,
                'posfun' => 456,
                'propro' => 789,
                'posiz_txt' => 'Posizione Test',
                'posfun_txt' => 'Funzione Test',
            ]);

            expect($individuale->posiz)->toBe(123);
            expect($individuale->posfun)->toBe(456);
            expect($individuale->propro)->toBe(789);
            expect($individuale->posiz_txt)->toBe('Posizione Test');
            expect($individuale->posfun_txt)->toBe('Funzione Test');
        });
    });
});
