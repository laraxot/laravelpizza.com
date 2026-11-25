---
title: "Seo: test e qualita'"
type: reference
status: active
module: Seo
tags: [seo, test, pest, phpstan, qualita]
qmd: "seo test pest phpstan level max assert expect internal arch sitemap ownership quality gate"
related:
  - ./architecture.md
  - ./stories/audit-qualita.story.md
---

# Test e qualita'

## Gate

Dalla cartella `laravel/`:

```bash
./vendor/bin/phpstan analyse Modules/Seo --memory-limit=-1   # livello max, 0 errori, nessuna baseline
./vendor/bin/pest Modules/Seo/tests
```

Si usa solo Pest (mai PHPUnit diretto). Mai `RefreshDatabase` ne' `migrate:fresh`: i dati sono sacri e Seo non ha
tabelle proprie. I test del modulo stanno in `Modules/Seo/tests/`, non in `laravel/tests/`.

## Mappa dei test

| Cartella | Cosa copre |
|----------|-----------|
| `tests/Unit/Actions/` | `GenerateSocialShareLinksAction`, `Metatag/ReplaceMetatagDataAction`, `Robots/BuildRobotsTxtAction`, `Robots/RobotsSegmentsMatchHeadPolicyTest` (ogni segmento chiuso in `robots.txt` e' `noindex` nel `<head>` di Cms), `Url/NormalizeLocalizedPathAction`, `Url/ResolvePathAliasAction` |
| `tests/Unit/Adapters/`, `Facades/` | `MetatagFacadeAdapter` e facade `Metatag` |
| `tests/Unit/Datas/` | `MetatagData`, `SeoConfigData`, `SocialShareData` |
| `tests/Unit/Http/Middleware/` | `RedirectToCanonicalPath`, `RedirectToPageAlias` |
| `tests/Unit/Filament/Widgets/` | `SocialShareWidget` (fixture `tests/Fixtures/ExposedSocialShareWidget.php`) |
| `tests/Unit/Providers/` | `SeoProvidersTest` |
| `tests/Unit/Architecture/SitemapOwnershipTest.php` | solo Seo costruisce la sitemap; `Modules/Seo/app` importa solo Seo, Xot, Cms |
| `tests/Feature/` | `CanonicalPathRedirectTest`, `MetatagFacadeAdapterTest`, `SitemapDetailTemplatesTest`, `WriteRobotsTxtCommandTest`, `IndexNow/IndexNowTest` |
| `tests/Arch/debt.php` | debito dichiarato dei test di architettura |

`tests/TestCase.php` imposta la configurazione con `config()->set()` (non con `$this->app['config']`, che e' `mixed`
senza Larastan); `tests/Support/FakeTenantSeoConfig.php` sostituisce la configurazione del tenant.

## PHPStan livello max: le regole che hanno portato a 0 errori

Il livello max (bleedingEdge) analizza anche i test, senza `ignoreErrors` ne' baseline. Cause radice chiuse:

1. **Pest `method.internalClass`**: `expect()`, `->with()`, `uses()->group()` toccano API `@internal` di Pest
   (`Pest\Mixins\Expectation`). Fix: asserzioni con `PHPUnit\Framework\Assert`, `foreach` al posto dei dataset,
   `tests/Pest.php` senza `uses()` ne' `group()`. Pest resta Pest: cambia solo il modo di asserire.
2. **Sitemap delle pagine CMS**: `Page::query()` tipizzato come union senza `get()`; ristretto a `Builder<Page>`.
3. **`Safe\preg_replace` e `__()`** restituiscono `array|string`: cast con `SafeStringCastAction`.
4. **`view-string` sui widget**: assegnazione con `@phpstan-var view-string` nel costruttore.
5. **Tag PHPMD nel PHPDoc**: `@SuppressWarnings(PHPMD.StaticAccess)` dava `phpDoc.parseError`; PHPStan non lo
   interpreta, quindi non va scritto come PHPDoc strutturato.

Un exit code 1 sul modulo puo' venire da un `ignoreErrors` obsoleto in `phpstan.neon` (file dell'utente), non dal
codice di Seo.

## Quando si tocca il codice

- `declare(strict_types=1);` in ogni file PHP; ogni classe o metodo toccato porta nel docblock un `@see` verso la pagina di
  `docs/` che spiega cosa fa (qui: `adr/search-engine-presence.md`, `contracts/*.md` e le pagine di questa cartella).
- Il comportamento verificabile delle Action esterne (IndexNow) e' fissato in [contracts/](./contracts/README.md); le
  invarianti con `group` si lanciano con `vendor/bin/pest Modules/Seo/tests --group=<ID>`.
- Gate di una modifica solo `.md`: PHPStan e Pest non si applicano; si verificano link e marcatori di conflitto.
