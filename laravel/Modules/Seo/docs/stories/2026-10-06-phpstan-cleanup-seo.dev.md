---
title: "[DEV] PHPStan cleanup — Seo"
type: dev
module: Seo
story: "./2026-10-06-phpstan-cleanup-seo.story.md"
status: done
created: 2026-10-06
updated: 2026-10-06
tags: [phpstan, cleanup, bmad, seo]
---

# [DEV] PHPStan cleanup — Seo

## Technical Plan

- Fixture con nome al posto della classe anonima, stessa semantica

## Files to Modify

- `tests/Unit/Filament/Widgets/SocialShareWidgetTest.php`
- `tests/Fixtures/ExposedSocialShareWidget.php` (nuovo)
- `docs/README.md` (write-back)

## Implementation Steps

- [x] Verificato che l'errore non compare su singolo file (sintomo da cache) ma nel run completo
- [x] Creata la fixture, sostituita l'anonima, aggiunto l'import
- [x] PHPStan + `php -l`

## Testing

Test eseguiti: nessuno (Pest non lanciato). Il test mantiene le stesse asserzioni su `links`, `platforms` e `data`.

## Verification

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/Tenant Modules/Activity Modules/Media Modules/AI Modules/UI Modules/Job Modules/Gdpr Modules/TechPlanner Modules/Seo --memory-limit=-1 --no-progress
php -l <file toccati>

```

Esito: 0 errori sui 9 moduli del gruppo (anche con run completo `./vendor/bin/phpstan analyse` senza argomenti).

## Lessons Learned

- PHPStan non risolve i docblock delle classi anonime in modo stabile: il cache dei name-scope e' indicizzato per file ma il nome della classe anonima contiene un percorso relativo alla radice dell'esecuzione (file singolo, sottoinsieme di moduli, run completo). Esecuzioni con radici diverse lasciano voci inconsistenti e compaiono falsi `missingType.iterableValue`/`missingType.generics` anche con docblock corretti. Fix deterministico: classi **con nome** in `tests/Fixtures/` (convenzione gia' usata nei moduli).
- I due `@var` inline gia' presenti nel test (`$links`, `$platforms`) restano: non segnalati, ma sono asserzioni di tipo non verificate; da sostituire con `Assert::isArray()` in una passata di qualita' dei test.
- Segnalazione NON mia: la cartella `Seo/docs/wiki/README.md` risulta cancellata nel working tree (`git status`), non toccata.
