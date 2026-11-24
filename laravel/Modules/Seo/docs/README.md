---
title: "Modulo Seo"
type: documentation
status: active
tags: [seo, sitemap, robots, metatag, documentation]
created: 2026-09-26
updated: 2026-11-19
qmd: "seo modulo presentazione sitemap robots metatag canonical alias"
issues: [64]
discussions: []
---

# Modulo Seo

Presentazione del modulo. L'indice completo della documentazione e' **[index.md](./index.md)** (unico indice di `docs/`).

## Cosa fa

| Funzione | Dove | Note |
|----------|------|------|
| `/sitemap.xml` | `app/Actions/Sitemap/BuildSitemapAction.php` | Pagine pubbliche in tutte le lingue, con `<lastmod>`; altri moduli aggiungono percorsi registrandosi sotto `SitemapPathsContract::TAG` |
| `/robots.txt` | `app/Actions/Robots/BuildRobotsTxtAction.php` | Chiude le aree private in ogni lingua e dichiara la sitemap con URL assoluto |
| `php artisan seo:robots` | `app/Console/Commands/WriteRobotsTxtCommand.php` | Scrive nella document root lo stesso `robots.txt` servito dalla rotta (`--dry-run` lo stampa soltanto) |
| Redirect canonico 301 | `app/Http/Middleware/RedirectToCanonicalPath.php` | Lingua minuscola, niente doppio slash o slash finale, alias di pagina (`SeoConfigData::pathAliases()`); solo GET/HEAD |
| Metatag della pagina | facade `Metatag` -> `app/Adapters/MetatagFacadeAdapter.php` | Stato per richiesta in `MetatagState`, letto e scritto dalle Action in `app/Actions/Metatag/` |
| Condivisione social | `app/Actions/GenerateSocialShareLinksAction.php`, `SocialShareWidget` | Dati in `app/Datas/SocialShareData.php` |
| Impostazioni | `app/Filament/Pages/SettingPage.php`, `app/Datas/SeoConfigData.php` | File `seo` del tenant |

Le lingue gestite sono quelle di `config('laravellocalization.supportedLocales')`.

## Qualita'

```bash
cd laravel
./vendor/bin/phpstan analyse Modules/Seo --memory-limit=-1   # livello max, 0 errori
./vendor/bin/pest Modules/Seo/tests
```

Audit e lavoro in corso: [stories/audit-qualita.story.md](./stories/audit-qualita.story.md).
