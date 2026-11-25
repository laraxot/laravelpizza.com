---
title: "Modulo Seo"
type: documentation
status: active
tags: [seo, sitemap, robots, metatag, indexnow, documentation]
qmd: "seo modulo presentazione sitemap robots metatag canonical alias indexnow social share"
issues: [64]
discussions: []
---

# Modulo Seo

Rende il sito trovabile: sitemap e `robots.txt` dinamici, redirect canonici, metatag della pagina, link di
condivisione social e notifica IndexNow. Senza modelli ne' migrazioni: lo stato vive per richiesta (metatag) o nel
file `seo` del tenant. La mappa completa della documentazione e' in **[00-index.md](./00-index.md)**.

Principio: *i metadati sono SEO gratis, si automatizzano*. L'autore di una pagina non deve conoscere SEO: titolo,
descrizione e tipo bastano, il resto lo producono le Action del modulo.

## Cosa fa

| Funzione | Dove | Note |
|----------|------|------|
| `/sitemap.xml` | `app/Actions/Sitemap/BuildSitemapAction.php` | Pagine pubbliche in tutte le lingue, con `<lastmod>`; altri moduli aggiungono percorsi registrandosi sotto `SitemapPathsContract::TAG` |
| `/robots.txt` | `app/Actions/Robots/BuildRobotsTxtAction.php` | Chiude le aree private in ogni lingua e dichiara la sitemap con URL assoluto |
| `php artisan seo:robots` | `app/Console/Commands/WriteRobotsTxtCommand.php` | Scrive nella document root lo stesso `robots.txt` servito dalla rotta (`--dry-run` lo stampa soltanto) |
| IndexNow | `app/Actions/IndexNow/`, `app/Console/Commands/SubmitIndexNowCommand.php` | File di verifica della chiave e invio delle URL nuove con `php artisan seo:indexnow`; spento se manca la chiave |
| Redirect canonico 301 | `app/Http/Middleware/RedirectToCanonicalPath.php` | Lingua minuscola, niente doppio slash o slash finale, alias di pagina (`SeoConfigData::pathAliases()`); solo GET/HEAD |
| Metatag della pagina | facade `Metatag` -> `app/Adapters/MetatagFacadeAdapter.php` | Stato per richiesta in `MetatagState`, letto e scritto dalle Action in `app/Actions/Metatag/` |
| Condivisione social | `app/Actions/GenerateSocialShareLinksAction.php`, `SocialShareWidget` | Dati in `app/Datas/SocialShareData.php` |
| Impostazioni | `app/Filament/Pages/SettingPage.php`, `app/Datas/SeoConfigData.php` | File `seo` del tenant: alias di pagina e chiave IndexNow |

Le lingue gestite sono quelle di `config('laravellocalization.supportedLocales')`.

## Dove leggere

- Struttura e regole di costruzione: [architecture.md](./architecture.md)
- Metatag e contratto dei dati: [metatag.md](./metatag.md)
- Condivisione social: [social-share.md](./social-share.md)
- Impostazioni, rotte, comandi: [configuration.md](./configuration.md)
- Decisioni e contratti verificabili: [adr/README.md](./adr/README.md), [contracts/README.md](./contracts/README.md)
- Cosa c'e' e cosa manca: [roadmap.md](./roadmap.md)

## Qualita'

```bash
cd laravel
./vendor/bin/phpstan analyse Modules/Seo --memory-limit=-1   # livello max, 0 errori
./vendor/bin/pest Modules/Seo/tests
```

Dettaglio dei gate e delle cause radice chiuse: [testing-and-quality.md](./testing-and-quality.md). Audit e lavoro in
corso: [stories/audit-qualita.story.md](./stories/audit-qualita.story.md).
