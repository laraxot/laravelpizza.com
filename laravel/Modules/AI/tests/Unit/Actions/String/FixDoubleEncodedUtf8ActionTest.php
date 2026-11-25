<?php

declare(strict_types=1);

use Modules\Xot\Actions\String\FixDoubleEncodedUtf8Action;
use Modules\Xot\Tests\XotBaseTestCase;

// XotBaseTestCase e non TestCase: qui non serve il database, e TestCase apre
// una transazione sulla connessione sqlite, che in locale non ha il file
// (SQLiteDatabaseDoesNotExistException, anche sui test fratelli di questa cartella).
uses(XotBaseTestCase::class);

/*
 * I testi rovinati sono scritti con le sequenze \u{...} per avere esattamente i
 * byte trovati nei backup locali del 2026-10-23 (story
 * docs/stories/fix-double-encoded-utf8-action.story.md), senza dipendere da
 * come l'editor salva il file.
 */

it('ripara il testo codificato due volte', function (string $rovinato, string $atteso): void {
    expect(app(FixDoubleEncodedUtf8Action::class)->execute($rovinato))->toBe($atteso);
})->with([
    // «Sì» delle risposte Sì/No di LimeSurvey: C383 C2AC invece di C3AC.
    'sì' => ["S\u{00C3}\u{00AC}", "S\u{00EC}"],
    // «à» seguita da uno spazio non separabile: il secondo byte e' A0.
    'qualità' => ["Qualit\u{00C3}\u{00A0} dell'acqua", "Qualit\u{00E0} dell'acqua"],
    // Apostrofo tipografico: richiede Windows-1252 (€ e ™ non sono in ISO-8859-1).
    'apostrofo tipografico' => ["dell\u{00E2}\u{20AC}\u{2122}acqua", "dell\u{2019}acqua"],
]);

it('lascia com\'e\' il testo che non e\' codificato due volte', function (string $testo): void {
    expect(app(FixDoubleEncodedUtf8Action::class)->execute($testo))->toBe($testo);
})->with([
    'vuoto' => [''],
    'solo ascii' => ['Pagare le bollette'],
    'accento pulito' => ["Citt\u{00E0}"],
    'sì pulito' => ["S\u{00EC}"],
    'apostrofo pulito' => ["dell\u{2019}acqua"],
    // Non esiste in Windows-1252: il passaggio perderebbe il carattere.
    'emoji' => ["Ottimo \u{1F600}"],
    // Non e' UTF-8 valido: non e' compito di questa Action indovinare cosa sia.
    'non utf-8' => ["\xC3\x28"],
]);
