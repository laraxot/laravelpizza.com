<?php

declare(strict_types=1);
use Modules\Xot\Tests\TestCase;
use Modules\Xot\Tests\Unit\Support\DummyTestModel;
use Modules\Xot\Tests\Unit\Support\OptionLabelProbeForm;

uses(TestCase::class)->group('no-xot-db');

/**
 * Regressione: una colonna titolo nulla faceva arrivare `null` a
 * `Filament\Forms\Components\Select::isOptionDisabled(string|Htmlable $label)`
 * e mandava in TypeError l'intera pagina di edit.
 */
describe('etichetta opzione da record', function (): void {
    it('usa la colonna titolo quando e\' valorizzata', function (): void {
        $record = new DummyTestModel;
        $record->setAttribute('name', 'Viva Servizi');

        expect(OptionLabelProbeForm::labelFor($record))->toBe('Viva Servizi');
    });

    it('ripiega sulla chiave primaria quando la colonna titolo e\' nulla', function (): void {
        $record = new DummyTestModel;
        $record->setAttribute('name', null);
        $record->setAttribute('id', 24);

        expect(OptionLabelProbeForm::labelFor($record))->toBe('#24');
    });

    it('ripiega sulla chiave primaria quando la colonna titolo e\' vuota', function (): void {
        $record = new DummyTestModel;
        $record->setAttribute('name', '');
        $record->setAttribute('id', 7);

        expect(OptionLabelProbeForm::labelFor($record))->toBe('#7');
    });

    it('rispetta una colonna titolo diversa da name', function (): void {
        $record = new DummyTestModel;
        $record->setAttribute('title', 'Contratto 2026');

        expect(OptionLabelProbeForm::labelFor($record, 'title'))->toBe('Contratto 2026');
    });
});
