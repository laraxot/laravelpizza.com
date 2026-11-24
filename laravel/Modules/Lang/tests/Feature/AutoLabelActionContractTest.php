<?php

declare(strict_types=1);

use Filament\Forms\Components\TextInput;
use Mockery\MockInterface;
use Modules\Lang\Actions\SaveTransAction;
use Modules\Lang\Tests\Fixtures\AutoLabelContractCaller;
use Modules\Lang\Tests\TestCase;
use Modules\Xot\Actions\GetTransKeyAction;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/*
 * Contratto: Modules/Lang/docs/contracts/auto-label-action.md. La chiave di traduzione e' fissata (GetTransKeyAction
 * finto) e SaveTransAction e' una spia: nessun file di lingua viene toccato. AutoLabelContractCaller fa da classe
 * chiamante (AutoLabelAction cerca nel backtrace la prima classe Modules\\ concreta che lo invoca).
 */

function autoLabelHelperTextIsSet(TextInput $field): bool
{
    return (fn (): bool => $this->helperTextSchema !== null)->call($field);
}

beforeEach(function (): void {
    $transKey = Mockery::mock(GetTransKeyAction::class);
    $transKey->allows('execute')->andReturn('lang::autolabelcontract');
    app()->instance(GetTransKeyAction::class, $transKey);

    $this->saveTrans = Mockery::spy(SaveTransAction::class);
    app()->instance(SaveTransAction::class, $this->saveTrans);
    app()->setLocale('it');
});

it('takes the label from the translation file of the calling class', function (): void {
    app('translator')->addLines(['autolabelcontract.fields.title.label' => 'Titolo'], 'it', 'lang');

    $field = (new AutoLabelContractCaller)->apply(TextInput::make('title'), 'label');

    Assert::assertSame('Titolo', $field->getLabel());
})->group('LANG-AUTOLABEL-INV-1');

it('asks to save only the missing label, never the auxiliary texts', function (): void {
    $field = TextInput::make('zz_missing');
    foreach (['label', 'placeholder', 'helperText', 'description'] as $type) {
        (new AutoLabelContractCaller)->apply($field, $type);
    }

    /** @var MockInterface $spy */
    $spy = $this->saveTrans;
    $spy->shouldHaveReceived('execute')->with('lang::autolabelcontract.fields.zz_missing.label', 'zz_missing');
    $spy->shouldNotHaveReceived('execute', ['lang::autolabelcontract.fields.zz_missing.placeholder', Mockery::any()]);
    $spy->shouldNotHaveReceived('execute', ['lang::autolabelcontract.fields.zz_missing.helper_text', Mockery::any()]);
    $spy->shouldNotHaveReceived('execute', ['lang::autolabelcontract.fields.zz_missing.description', Mockery::any()]);
    Assert::assertNull($field->getPlaceholder());
    Assert::assertFalse(autoLabelHelperTextIsSet($field));
})->group('LANG-AUTOLABEL-INV-2');

it('does not show an auxiliary text that only repeats the field name', function (): void {
    app('translator')->addLines([
        'autolabelcontract.fields.route.helper_text' => 'route',
        'autolabelcontract.fields.route.placeholder' => 'route',
    ], 'it', 'lang');

    $field = TextInput::make('route');
    (new AutoLabelContractCaller)->apply($field, 'helperText');
    (new AutoLabelContractCaller)->apply($field, 'placeholder');

    Assert::assertFalse(autoLabelHelperTextIsSet($field));
    Assert::assertNull($field->getPlaceholder());
})->group('LANG-AUTOLABEL-INV-3');
