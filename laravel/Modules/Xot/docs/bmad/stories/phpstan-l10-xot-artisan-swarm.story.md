---
qmd: "xot bmad stories phpstan l10 xot artisan swarm story md"
title: "PHPStan L10 Xot Artisan actions (swarm-lang-tenant)"
type: story
module: Xot
status: done
created: 2026-10-06
track: quality/phpstan
related:
  - ../../../../Xot/docs/bmad/stories/2026-10-06-phpstan-modules-level10.story.md
---

# PHPStan L10 Xot Artisan actions

Claim: agente swarm-lang-tenant. Errori in elenco: 2 (`ShowArtisanErrorLogAction`, `ShowArtisanRouteListAction`), risolti 2.

## Scopo funzionale
Pagine di debug amministrativo: `ShowArtisanRouteListAction` mostra l'elenco rotte, `ShowArtisanErrorLogAction` elenca i file di `storage/logs`, mostra il contenuto di quello scelto (`?log=`) e gli URL trovati.

## Cosa e' cambiato
- `ShowArtisanRouteListAction`: tolto `@var string` che allargava il letterale; la view `xot::acts.artisan.show_route_list` esiste, PHPStan ora la verifica da solo.
- `ShowArtisanErrorLogAction`: il `@var view-string` (messo dall'orchestratore dopo la risoluzione dei merge marker) mentiva. Tolto, PHPStan ha segnalato il bug vero: la view `xot::acts.artisan.error-show` NON ESISTEVA (mai esistita nella storia git, anche nel vecchio `ArtisanService::errorShow()`), quindi `?act=error` lanciava `View not found`. Creata `resources/views/acts/artisan/error-show.blade.php` (stesso layout `pub_theme::layouts.app` della route list; elenco file, URL, contenuto, tutto escapato).
- Stessa action: `log` arriva dalla query string e finiva in `storage_path('logs/'.$log)`: `../` leggeva file fuori da `storage/logs`. Ora `basename()` + `File::isFile()`.

## Verifica
`phpstan analyse Modules/Xot/app/Actions/Artisan`: `[OK] No errors`. `view()->exists('xot::acts.artisan.error-show')` true; la view compila in PHP valido. Nessun test copre la view: renderla davvero richiede il layout del tema (non verificato).

## Lezione
Un `@var view-string` su un letterale di view e' lecito solo se la view esiste: verificarlo con `view()->exists()`, altrimenti nasconde un fatal a runtime.
