<?php

declare(strict_types=1);

namespace Modules\Rating\Tests\Unit;

use Modules\Rating\Enums\RuleEnum;
use Modules\Rating\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('RuleEnum espone le regole di validazione attese', function (): void {
    Assert::assertSame('', RuleEnum::Null->value);
    Assert::assertSame('numeric|min:0|max:4', RuleEnum::ZeroFour->value);
    Assert::assertSame('numeric|min:0|max:5', RuleEnum::ZeroFive->value);
    Assert::assertSame('numeric|min:0|max:6', RuleEnum::ZeroSix->value);
    Assert::assertSame('min:0|max:25|not_in:1,2,3', RuleEnum::ZeroOrMin4Max25->value);
    Assert::assertSame('nullable|numeric|min:0|max:25', RuleEnum::NullableNumericMin0Max25->value);
});

/*
 * Le due guardie che seguono reggono anche il caso che verra' aggiunto al prossimo rinnovo
 * contrattuale, mentre il test sopra va esteso a mano ogni volta. Se una sola delle tre puo'
 * sopravvivere a un refactoring, tenere queste.
 */

test('ogni caso di RuleEnum ha la sua etichetta tradotta', function (): void {
    foreach (RuleEnum::cases() as $case) {
        $label = $case->getLabel();

        // `transClass()` restituisce la chiave grezza quando la voce manca: il sintomo e'
        // un'etichetta che comincia col namespace di traduzione del modulo. Nessuna
        // eccezione, nessun log — si vede solo a schermo, nel Radio di BaseRatingForm.
        Assert::assertStringStartsNotWith(
            'rating::',
            $label,
            sprintf(
                'RuleEnum::%s (valore "%s") non ha la voce values."%s".label in lang/it/rule_enum.php',
                $case->name,
                $case->value,
                $case->value,
            ),
        );
        Assert::assertNotSame('', $label);
    }
});

test('i tetti dei criteri dell art. 17 c. 6 sono tutti esprimibili', function (): void {
    // CCI 2026-2028, art. 17 comma 6: cinque criteri con tetti 5, 6, 4, 4, 6 — somma 25,
    // pavimento 4. Il totale e' coperto da ZeroOrMin4Max25 (`not_in:1,2,3` = minimo 4).
    // Se un domani la griglia cambia, questo test dice subito quale tetto manca.
    $tettiRichiesti = [5, 6, 4, 4, 6];
    $valoriDisponibili = array_map(
        static fn (RuleEnum $case): string => $case->value,
        RuleEnum::cases(),
    );

    foreach (array_unique($tettiRichiesti) as $tetto) {
        Assert::assertContains(
            sprintf('numeric|min:0|max:%d', $tetto),
            $valoriDisponibili,
            sprintf('Nessun caso di RuleEnum esprime il tetto %d richiesto dall art. 17 c. 6', $tetto),
        );
    }

    Assert::assertSame(25, array_sum($tettiRichiesti), 'La somma dei tetti dell art. 17 c. 6 deve essere 25');
});
