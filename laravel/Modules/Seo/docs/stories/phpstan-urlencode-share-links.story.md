---
title: "[STORY] PHPStan — GenerateSocialShareLinksAction urlencode stub (ambientale) + tipizzazione"
type: story
module: Seo
status: ready-for-dev
priority: medium
created: 2026-10-15
updated: 2026-10-15
tags: [phpstan, cleanup, bmad, seo, swarm]
---

# [STORY] PHPStan — GenerateSocialShareLinksAction urlencode stub + tipizzazione

## Richiesta

Agente swarm PHPStan, scope solo `laravel/Modules/Seo/`. Ground truth
`laravel/phpstan_modules_initial.json`: internal error sullo stub `urlencode`
su `app/Actions/GenerateSocialShareLinksAction.php` (ambientale: verifica +
tipizza, nessun workaround). Cercare errori Seo in
`laravel/phpstan_output.txt/json`. Tipizzare urlencode, array shape, const.
Docs + BMAD story in `Modules/Seo/docs/stories/`. No QMD. Report.

Vincoli: MAI `phpstan.neon`/baseline/ignore, MAI `git checkout/restore/reset`,
forward-only.

## Ground truth verificata

`laravel/phpstan_modules_initial.json` (27 errori totali: 3 `file_errors` +
24 internal):

- Zero `file_errors` nel modulo Seo.
- Unico finding Seo, di tipo **internal** (non codice):

```text
Internal error: Function urlencode stub not found in
phar:///.../phpstan.phar/src/Reflection/SignatureMap/../../../vendor/phpstan/php-8-stubs/stubs/ext/standard/urlencode.stub.
while analysing file
.../laravel/Modules/Seo/app/Actions/GenerateSocialShareLinksAction.php
```

Stessa famiglia di altri 23 internal (strtolower, ltrim, basename,
random_int, mb_*, … su Lang/Media/Notify/User/Tenant/UI): stub
`php-8-stubs` mancanti dentro il phar di PHPStan. Causa ambiente, non codice.
Nessun workaround nel sorgente (niente `Safe\`, niente `rawurlencode`,
niente ignore/baseline).

`laravel/phpstan_output.txt` (human-readable, `[ERROR] Found 169 errors`):
sezioni ispezionate head/tail (Fixcity, UI, User, Xot), nessun blocco Seo
osservato — coerente con 0 file-error Seo nel json. Scansione esaustiva del
corpo non eseguibile in questa sessione (nessuna shell/grep disponibile):
comando riproducibile sotto.

## Scopo ricostruito

`GenerateSocialShareLinksAction::execute(SocialShareData $data)` costruisce le
URL di condivisione social (facebook, twitter, linkedin, whatsapp, telegram,
copy) usate per la SEO sociale.

- Chiamante produzione: `app/Filament/Widgets/SocialShareWidget.php`
  (`getViewData()` → `app(GenerateSocialShareLinksAction::class)->execute()`),
  passa solo `url` + `title`; `via`/`hashtags` restano `null` → omessi.
- Test: `tests/Unit/Actions/GenerateSocialShareLinksActionTest.php`
  (chiavi presenti, `copy` invariato, `via`/`hashtags` in twitter),
  `tests/Unit/Datas/SocialShareDataTest.php` (default piattaforme).
- Input già tipizzato alla sorgente: `Datas/SocialShareData.php`
  (`string $url`, `?string` opzionali, `array<int, string> $platforms`).

## Causa radice

1. L'internal error e' del phar PHPStan (stub mancante), non del codice:
   `urlencode(string): string` non ritorna mai `false`, quindi non esiste
   nemmeno un `Safe\urlencode` da usare.
2. Debolezze tipizzazione nel codice (reali, corrette in avanti):
   `array<string, string>` generico, 5 magic string per le base URL senza
   tipo, `via`/`hashtags` passati a `urlencode()` come `?string` con narrowing
   implicito sul ternary.

## Modifiche

File: `laravel/Modules/Seo/app/Actions/GenerateSocialShareLinksAction.php`
(solo writer, nessun altro file toccato).

- 5 costanti tipizzate `public const string` (PHP 8.3+, repo su PHP ^8.4)
  per le base URL di condivisione; costanti riusate via `self::`.
- `@return` array shape esatta
  `array{facebook: string, twitter: string, linkedin: string, whatsapp: string,
  telegram: string, copy: string}` (contratto usato da widget e test).
- Locali `string $via` / `string $hashtags` (`?? ''`, truthy check invariato →
  semantica identica, incluso `'0'` falsy come prima); `urlencode()` ora
  riceve solo `string` evidenti.
- Volutamente NON fatto: passaggio a `rawurlencode` (cambia `+` in `%20`,
  semantica query-string diversa), `use function Safe\urlencode` (non esiste:
  Safe wrappa solo funzioni che ritornano `false`), ignore/baseline/neon.

## Verifica

NON eseguita in questa sessione: nessuna shell disponibile (integrazione
Daytona senza `DAYTONA_API_KEY`), quindi niente `php -l`, PHPStan mirato o
Pest. Comandi riproducibili per il verificatore / coordinatore:

```bash
cd laravel && php -l Modules/Seo/app/Actions/GenerateSocialShareLinksAction.php
cd laravel && ./vendor/bin/phpstan analyse Modules/Seo --no-progress
cd laravel && ./vendor/bin/pest Modules/Seo/tests/Unit/Actions/GenerateSocialShareLinksActionTest.php
rg -n "Seo" phpstan_output.txt | head
```

Atteso: 0 errori Seo (l'internal `urlencode stub` puo' riapparire solo nel
run completo ed e' ambientale, da rivalutare dopo fix/upgrade PHPStan,
fuori scope di questo task). `typeCoverage.*` verificabile solo con
`analyse Modules` intero (coordinatore).

## Decisioni

- D1: `urlencode` nativo mantenuto — semantica query-string corretta e firma
  totale `string → string`; internal stub = problema ambiente.
- D2: costanti `public const string` invece di enum — le base URL non sono un
  insieme chiuso di casi da matchare ma frammenti riusabili; enum non
  aggiungerebbe type-safety qui.
- D3: shape fissa a 6 chiavi — l'action restituisce sempre tutte le
  piattaforme (`platforms` del Data non filtra l'output: comportamento
  esistente preservato, non cambiato).

## Aperto

- Duplicato `app/Data/SocialShareData.php` vs `app/Datas/SocialShareData.php`
  (il secondo con docblock `@param` duplicato): ridondanza nota, fuori scope
  action — candidato per story dedicata.
- Rivalidazione con gate canonico (`analyse Modules` intero) al coordinatore.
- Lock `bashscripts/lock/*.sh` non eseguibili qui; `.locks/` osservata vuota,
  scope monofile senza conflitti noti.
