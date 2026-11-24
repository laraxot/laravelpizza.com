<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Actions;

use Illuminate\Support\Str;
use Modules\Gdpr\Actions\SaveGdprConsentsAction;
use Modules\Gdpr\Models\Consent;
use Modules\Gdpr\Models\Treatment;
use Modules\Gdpr\Tests\TestCase;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;
use ReflectionMethod;

use function Safe\json_decode;

uses(TestCase::class);

test('SaveGdprConsentsAction exposes execute for persisting registration consents', function (): void {
    $action = new SaveGdprConsentsAction;
    $method = new ReflectionMethod($action, 'execute');

    Assert::assertSame(SaveGdprConsentsAction::class, $action::class);
    Assert::assertTrue($method->isPublic());
    Assert::assertGreaterThanOrEqual(2, $method->getNumberOfParameters());
});

/**
 * Utente non salvato: l'Action legge solo id e classe, e la tabella `users` del DB di prova condiviso puo' essere indietro rispetto
 * alla factory (colonna `state`), che non e' cio' che questi test provano.
 */
function gdprSaveProofUser(): User
{
    $user = new User;
    $user->forceFill(['id' => (string) Str::uuid()]);

    return $user;
}

/**
 * Raccoglie le righe che l'Action scriverebbe in `consents` e ne blocca l'insert: la tabella del DB di prova condiviso non ha
 * ancora tutte le colonne delle migrazioni del modulo (`ip_address`, `metadata`). Ogni `creating` e' un INSERT: se l'Action
 * aggiornasse una riga esistente, qui non comparirebbe.
 *
 * @return \ArrayObject<int, array<string, mixed>>
 */
function gdprCaptureConsentInserts(): \ArrayObject
{
    /** @var \ArrayObject<int, array<string, mixed>> $rows */
    $rows = new \ArrayObject;
    Consent::creating(static function (Consent $consent) use ($rows): bool {
        $rows->append($consent->getAttributes());

        return false;
    });

    return $rows;
}

// Contratto: docs/contracts/save-gdpr-consents-action.md (GDPR art. 7 par. 1: il titolare deve poter dimostrare il consenso).
test('writes one proof row per treatment, accepted or refused, with document version, locale, ip and user agent', function (): void {
    $user = gdprSaveProofUser();
    $inserted = gdprCaptureConsentInserts();

    app(SaveGdprConsentsAction::class)->execute(
        $user,
        ['privacy_accepted' => true, 'terms_accepted' => true, 'marketing_consent' => false],
        '203.0.113.5',
        'Pest/GDPR-SAVE',
    );

    $rows = collect($inserted->getArrayCopy())->keyBy('type');
    Assert::assertSame(['marketing_consent', 'privacy_policy', 'terms_conditions'], $rows->keys()->sort()->values()->all());
    foreach ($rows as $type => $row) {
        $json = $row['metadata'] ?? null;
        Assert::assertIsString($json, "metadata mancante per {$type}");
        $metadata = json_decode($json, true);
        Assert::assertIsArray($metadata, "metadata mancante per {$type}");
        Assert::assertIsString($metadata['document_version'] ?? null);
        Assert::assertNotSame('', $metadata['document_version'], "versione mancante per {$type}");
        Assert::assertSame(app()->getLocale(), $metadata['locale'] ?? null);
        Assert::assertSame('203.0.113.5', $row['ip_address'] ?? null);
        Assert::assertSame('Pest/GDPR-SAVE', $row['user_agent'] ?? null);
        Assert::assertSame($user->id, $row['user_id'] ?? null);
    }
    Assert::assertNotNull($rows['privacy_policy']['accepted_at'] ?? null);
    Assert::assertNotNull($rows['terms_conditions']['accepted_at'] ?? null);
    Assert::assertNull($rows['marketing_consent']['accepted_at'] ?? null, 'consenso rifiutato registrato come accettato');
})->group('GDPR-SAVE-INV-1', 'GDPR-SAVE-INV-2', 'GDPR-SAVE-INV-3');

test('creates a missing treatment and gives a version to one without, instead of skipping the proof', function (): void {
    Treatment::query()->where('name', 'terms_conditions')->delete();
    Treatment::query()->updateOrCreate(['name' => 'privacy_policy'], ['description' => 'x', 'required' => true, 'active' => true, 'weight' => 1, 'documentVersion' => '']);
    $inserted = gdprCaptureConsentInserts();

    app(SaveGdprConsentsAction::class)->execute(gdprSaveProofUser(), ['privacy_accepted' => true, 'terms_accepted' => true], '203.0.113.5', 'Pest');

    Assert::assertNotNull(Treatment::query()->where('name', 'terms_conditions')->first(), 'trattamento mancante non creato');
    Assert::assertSame('1.0', Treatment::query()->where('name', 'privacy_policy')->value('documentVersion'));
    Assert::assertCount(3, $inserted, 'prova saltata per un trattamento');
})->group('GDPR-SAVE-INV-4');

test('never overwrites an earlier proof: a second call adds new rows', function (): void {
    $user = gdprSaveProofUser();
    $inserted = gdprCaptureConsentInserts();

    app(SaveGdprConsentsAction::class)->execute($user, ['privacy_accepted' => true, 'terms_accepted' => true], '203.0.113.5', 'Pest');
    app(SaveGdprConsentsAction::class)->execute($user, ['privacy_accepted' => true, 'terms_accepted' => true, 'marketing_consent' => true], '203.0.113.5', 'Pest');

    Assert::assertCount(6, $inserted);
})->group('GDPR-SAVE-INV-5');
