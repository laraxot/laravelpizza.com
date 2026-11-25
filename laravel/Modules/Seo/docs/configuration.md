---
title: "Seo: configurazione, rotte e comandi"
type: reference
status: active
module: Seo
tags: [seo, configurazione, tenant, rotte, comandi, indexnow, robots, sitemap]
qmd: "seo configurazione SeoConfigData path_aliases indexnow_key SettingPage seo:robots seo:indexnow rotte sitemap.xml robots.txt config.php tenant"
related:
  - ./architecture.md
  - ./adr/search-engine-presence.md
  - ./contracts/README.md
---

# Configurazione, rotte e comandi

## Configurazione

| Dove | Cosa |
|------|------|
| `config/config.php` del modulo | solo `name` (`Seo`), `icon` (`fas-superscript`), `navigation_sort` (`1`) |
| `config/{tenant}/seo.php` | impostazioni del tenant, lette con `SeoConfigData::make()` (non con `config('seo.config...')`: il config del modulo sostituirebbe quel ramo e un valore del tenant non arriverebbe) |
| `Modules\Seo\Filament\Pages\SettingPage` | form per modificare `seo.php`, solo super-admin |

`SeoConfigData` (`app/Datas/SeoConfigData.php`) ha due impostazioni:

- **`path_aliases`**: lista di righe `{alias, target}` con percorsi senza lingua (`''` = home). Default: `about` ->
  `chi-siamo`, `contatti` -> `contacts`, `cookie` -> `cookies`, `faqs` -> `faq`, `home` -> `''`. Il middleware
  `RedirectToCanonicalPath` risponde 301 nella stessa lingua e `BuildSitemapAction` non elenca l'alias. Una lista e non una
  mappa, perche' `SaveTenantConfigAction` fonde le mappe per chiave e un alias tolto dal form tornerebbe nel file.
  `pathAliases()` scarta cicli, catene e righe con alias uguale al bersaglio; la `SettingPage` segnala queste righe
  invece di salvarle in silenzio. Per ritirare un alias basta togliere la riga: la pagina torna a rispondere 200.
- **`indexnow_key`**: chiave IndexNow del sito, 8-128 caratteri `[A-Za-z0-9-]`. Non e' un segreto (il protocollo la
  pubblica in `/{chiave}.txt`). Vuota = IndexNow spento: nessun file servito, nessun invio. `indexNowKey()` restituisce
  la chiave solo se ha il formato valido.

Titolo e descrizione del sito stanno nel file `metatag` del tenant; l'indicizzazione del `<head>` e' di Cms. Non si
duplicano in Seo.

## Rotte (`routes/web.php`, alla radice, senza prefisso di lingua)

| Rotta | Nome | Action |
|-------|------|--------|
| `GET /sitemap.xml` | `seo.sitemap` | `BuildSitemapAction` (`application/xml`) |
| `GET /robots.txt` | `seo.robots` | `BuildRobotsTxtAction` (`text/plain`) |
| `GET /{key}.txt` (`[A-Za-z0-9-]{8,128}`) | `seo.indexnow.key` | `ServeIndexNowKeyAction`: 404 per ogni chiave diversa da quella configurata |

Le Action sono invocabili: `route:cache` non ammette closure. La rotta della chiave e' dopo `robots.txt` perche' le
rotte si confrontano in ordine di registrazione.

## Comandi artisan

| Comando | Cosa fa |
|---------|---------|
| `php artisan seo:robots [--path=] [--dry-run]` | scrive in `public/robots.txt` lo stesso contenuto della rotta; da lanciare a ogni deploy |
| `php artisan seo:indexnow [--all] [--url=*] [--dry-run]` | invia a IndexNow le URL della sitemap nuove o con `<lastmod>` piu' recente dell'ultimo invio; stato in `storage/app/seo/indexnow-submitted.json`; senza chiave non fa nulla |

Perche' `robots.txt` va scritto anche come file: se il web server cerca prima il file statico e ricade su Laravel con
`error_page 404`, la rotta arriva con stato 404 e Google ignora il contenuto, sitemap compresa. Il widget Filament
`GenerateSitemapWidget` (pulsante "Genera/rigenera sitemap" nella Dashboard del modulo) scrive in modo analogo
`public/sitemap.xml` con lo stesso XML della rotta.

## Interfaccia di amministrazione

- `Filament\Pages\Dashboard` (estende `XotBaseDashboard`): widget `sitemap` (`GenerateSitemapWidget`).
- `Filament\Pages\SettingPage`: alias di pagina e chiave IndexNow.
- Traduzioni: `lang/{it,en,de,es}/social_share.php` e `generate_sitemap_widget.php`; `lang/{it,en}/setting.php`;
  `lang/it/redirect_to_canonical_path.php`.
