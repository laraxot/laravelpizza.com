---
title: "Overflow history (ceiling 100)"
type: digest
status: active
qmd: "digest ceiling 100 overflow-history"
---

# Overflow history (ceiling 100)

Overflow force-cap: 3 file oltre target 100.

### `contracts/serve-index-now-key-action.md` — ServeIndexNowKeyAction


# ServeIndexNowKeyAction

Il file di verifica IndexNow: `GET /{chiave}.txt` risponde con la chiave, solo se è quella configurata. Rotta
`seo.indexnow.key` in `routes/web.php`, alla radice del sito (senza lingua), registrata **dopo** `/robots.txt`.
Sorgente: `app/Actions/IndexNow/ServeIndexNowKeyAction.php`.

Test: `cd laravel && vendor/bin/pest Modules/Seo/tests/Feature/IndexNow/IndexNowTest.php --group=SEO-INDEXNOW-KEY-INV-1`.

## Input

- `string $key`: la parte del percorso prima di `.txt` (la rotta ammette solo `[A-Za-z0-9-]{8,128}`).
- La chiave del tenant da `SeoConfigData::make()->indexNowKey()`.

## Output

- `Response` 200, `Content-Type: text/plain; charset=UTF-8`, corpo = la chiave configurata.
- Altrimenti `NotFoundHttpException` (404), come se la rotta non esistesse.

## Inva

### `stories/phpstan-cleanup-seo.dev.md` — [DEV] PHPStan cleanup — Seo


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

### `stories/phpstan-seo-fix.md` — Problema


## Problema
PHPStan errors in Modules/Seo (4, resurfaced after the 2026-09-06 22:05
phpstan.neon Larastan/Pest-extension regression — owner confirmed config
stays as-is).

## Solution
1. Analyze with phpstan -> 4 `method.nonObject` errors in `tests/TestCase.php`
   on `$this->app['config']->set(...)` (ArrayAccess on the container resolves
   to `mixed` without Larastan).
2. Fix: use the `config()` helper instead of `$this->app['config']` — Laravel's
   own conditional-return-type PHPDoc on the helper resolves to
   `Repository` without needing Larastan.
3. Verify: phpstan 0; phpmd (1 pre-existing non-actionable finding, see
   coverage.md); pest 35/47 passing — 12 pre-existing failures
   (`Target class [config] does not exist`), confirmed via `git stash`
   NOT caused by this fix, unrela
