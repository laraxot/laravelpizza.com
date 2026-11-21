<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit;

use Illuminate\Translation\PotentiallyTranslatedString;
use Modules\UI\Actions\Datetime\GetDaysMappingAction;
use Modules\UI\Rules\OpeningHoursRule;
use Modules\UI\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/**
 * Applica la regola e restituisce i messaggi di errore raccolti.
 *
 * La closure rispetta la firma dichiarata da ValidationRule — `Closure(string, ?string=):
 * PotentiallyTranslatedString` — perché è quella che il contratto promette al chiamante:
 * una closure di comodo con firma diversa passerebbe a runtime e mentirebbe sul contratto.
 *
 * @param array<string, mixed>|string|int|null $value
 *
 * @return list<string>
 */
function uiOpeningHoursFailures(array|string|int|null $value): array
{
    /** @var list<string> $failures */
    $failures = [];

    $collect = static function (string $message, ?string $_attribute = null) use (&$failures): PotentiallyTranslatedString {
        $failures[] = $message;

        return new PotentiallyTranslatedString($message, app('translator'));
    };

    (new OpeningHoursRule())->validate('orari', $value, $collect);

    return $failures;
}

/**
 * Prima chiave del mapping dei giorni: la regola itera su quelle, non su nomi cablati.
 */
function uiFirstDayKey(): string
{
    $days = app(GetDaysMappingAction::class)->execute();
    $keys = array_keys($days);

    Assert::assertNotEmpty($keys, 'GetDaysMappingAction deve restituire almeno un giorno.');

    return (string) $keys[0];
}

it('ignora un valore che non è un array', function (): void {
    Assert::assertSame([], uiOpeningHoursFailures('non-un-array'));
    Assert::assertSame([], uiOpeningHoursFailures(null));
    Assert::assertSame([], uiOpeningHoursFailures(42));
});

it('non segnala nulla quando il giorno non ha orari', function (): void {
    Assert::assertSame([], uiOpeningHoursFailures([uiFirstDayKey() => []]));
});

it('segnala l orario di chiusura mancante', function (): void {
    $failures = uiOpeningHoursFailures([
        uiFirstDayKey() => ['morning_from' => '09:00'],
    ]);

    Assert::assertCount(1, $failures);
});

it('segnala l orario di apertura mancante', function (): void {
    $failures = uiOpeningHoursFailures([
        uiFirstDayKey() => ['afternoon_to' => '18:00'],
    ]);

    Assert::assertCount(1, $failures);
});

it('segnala una sessione che chiude prima di aprire', function (): void {
    $failures = uiOpeningHoursFailures([
        uiFirstDayKey() => ['morning_from' => '13:00', 'morning_to' => '09:00'],
    ]);

    Assert::assertCount(1, $failures);
});

it('segnala una sessione che apre e chiude allo stesso minuto', function (): void {
    $failures = uiOpeningHoursFailures([
        uiFirstDayKey() => ['morning_from' => '09:00', 'morning_to' => '09:00'],
    ]);

    Assert::assertCount(1, $failures);
});

it('segnala il pomeriggio che inizia prima della chiusura della mattina', function (): void {
    $failures = uiOpeningHoursFailures([
        uiFirstDayKey() => [
            'morning_from' => '09:00',
            'morning_to' => '14:00',
            'afternoon_from' => '13:00',
            'afternoon_to' => '18:00',
        ],
    ]);

    Assert::assertCount(1, $failures);
});

it('accetta una giornata con due sessioni coerenti', function (): void {
    $failures = uiOpeningHoursFailures([
        uiFirstDayKey() => [
            'morning_from' => '09:00',
            'morning_to' => '13:00',
            'afternoon_from' => '14:00',
            'afternoon_to' => '18:00',
        ],
    ]);

    Assert::assertSame([], $failures);
});

it('tratta stringa vuota, spazi e il segnaposto --:-- come orario assente', function (): void {
    // Se questi valori non fossero normalizzati a null, la coppia from/to risulterebbe
    // incompleta e la regola segnalerebbe un errore che l'utente non ha commesso.
    foreach (['', '   ', '--:--'] as $vuoto) {
        Assert::assertSame([], uiOpeningHoursFailures([
            uiFirstDayKey() => ['morning_from' => $vuoto, 'morning_to' => $vuoto],
        ]), sprintf('Il valore %s deve valere come orario assente.', var_export($vuoto, true)));
    }
});

it('ignora un giorno il cui valore non è un array', function (): void {
    Assert::assertSame([], uiOpeningHoursFailures([uiFirstDayKey() => 'chiuso']));
});
