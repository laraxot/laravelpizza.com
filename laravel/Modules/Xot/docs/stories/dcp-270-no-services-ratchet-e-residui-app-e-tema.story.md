---
title: "DCP-270: No Services: guardia vera e ultimi residui (app/, tema Sixteen)"
type: story
module: Xot
status: done
updated: 2026-10-20
tags: [bmad, services, queueable-action, ratchet, architecture, no-services, filament-blueprint]
qmd: "dcp 270 no services ratchet NoServicesTest app/Services Themes Sixteen src Services orfani use TenantService archAllowedServicesDirs"
related:
  - ./services-to-actions-global-wave.story.md
  - ../decisions/action-conversion.md
  - ../bmad/brainstorming-services-to-actions-wave.md
  - ../../../User/docs/bmad/stories/dcp-269-login-google-localizzato-e-rientro-nella-lingua.story.md
---

# DCP-270: No Services: guardia vera e ultimi residui

**Numero:** 270, preso con controllo che blocca (massimo trovato 269) e controllo del nome file con lo strumento della regola.

## Regola e senso

Nessuna cartella `Services` nel codice di produzione: un caso d'uso = una Action Spatie Queueable con `execute()`, tipizzata, accodabile e
testabile da sola. Un `Service` accumula metodi statici e stato senza confini e invita a duplicare. Il piano e le decisioni
stanno nella [wave globale](./services-to-actions-global-wave.story.md); questa story chiude quello che la wave dichiarava fatto ma non lo era.

## Cosa risultava e cosa era vero (misurato il 2026-10-20 ~18:00)

| Dichiarato nei documenti | Realtà |
|---|---|
| «Ratchet anti-riesumazione (`ModulesArchitectureTest`, allowlist `[]`)» ✔ | **Il test non esisteva** (cercati `ModulesArchitectureTest` e `archAllowedServicesDirs` fuori dai docs: 0 risultati). Nulla impediva una riesumazione da merge, già avvenuta per Geo, Notify, Xot e Fixcity. |
| «Zero file residui sotto `app/Services`» ✔ | `laravel/app/Services` aveva `LogSanitizer`, `QueryOptimizer`, `SecurityService`: **0 chiamanti, 0 test** (grep su codice, config, Blade, JSON). |
| «Zero directory `Modules/*/app/Services`» ✔ | Vero per i moduli (le cartelle sono sparite nel commit di sync `63a67a3054`; le Actions dichiarano «Replaces …Service::metodo()»). Non copriva `Themes/`. |
| (non dichiarato) | `Themes/Sixteen/src/Services/{CieAuthService,SpidAuthService,MenuBuilder}`: **non autoloadati** (il `composer.json` del tema mappa `Themes\Sixteen\` su `app/`) e già sostituiti da `CieAuthAction`, `SpidAuthAction`, `MenuBuilderAction`. Runtime: `Themes\Sixteen\Services\MenuBuilder` non è caricabile. |
| (non dichiarato) | 4 gemelli morti in `Themes/Sixteen/src` importavano quei servizi (`BuildingSixteenMenu`, `CieAuthController`, `SpidAuthController`, `SixteenComposer`); 2 viste del tema avevano `use Modules\Tenant\Services\TenantService` verso una classe inesistente. |
| (non dichiarato) | `Modules/Xot/tests/Unit/Services/{ThemeServiceTest,UrlServiceTest}` testavano già le Actions ma stavano in una cartella `Services`. |

## Fatto

1. **Guardia vera:** `Modules/Xot/tests/Unit/Architecture/NoServicesTest.php` (3 test, nessuna allowlist). Roots: `Modules/*/app`, `Themes/*/app`, `Themes/*/src`, `app/`.
   Controlla: (a) nessuna directory `Services`, (b) nessuna classe in un namespace `...\Services\...`, (c) nessuna `use Modules|Themes|App\...\Services\...`.
   `tests/` e viste (`views/services`, minuscolo) restano fuori. **Prova inversa:** ricreata una cartella `Services` in tre punti (`Modules/Tenant/app`, `Themes/Sixteen/app`, `app/`)
   con una classe di prova → 2 test rossi con l'elenco dei percorsi; ripulito. Prima della pulizia dei residui, il test (c) segnalava i 4 gemelli morti del tema.
2. Rimosse (nessun chiamante, quindi niente da convertire; ripristino da git: radice `32990ef1f6`, tema `c0ea4b70`):
   `laravel/app/Services/*` (3), `Themes/Sixteen/src/Services/*` (3), i 4 gemelli morti in `Themes/Sixteen/src` che li importavano.
3. Tolta la `use` morta verso `Modules\Tenant\Services\TenantService` in `Themes/Sixteen/resources/views/pages/counter.blade.php` e in `pages_old1/pages/[slug].blade.php`.
4. Test spostati dove vive il codice che provano: `Xot/tests/Unit/Services/ThemeServiceTest.php` → `Unit/Actions/Theme/ThemeActionsTest.php`;
   `UrlServiceTest.php` → `Unit/Actions/Url/IsValidUrlActionTest.php`. Rimossa la cartella vuota `Geo/tests/Unit/Services`.

## Verifica

- Pest `NoServicesTest` + i due test spostati: 8 su 8 (DB usa-e-getta, mai quello di sviluppo).
- `SixteenComposer` si carica da `Themes/Sixteen/app`; `php artisan about` parte.
- PHPStan `analyse Modules` (18:01–18:05): **0 segnalazioni nel codice di produzione**, 289 tutte in `tests/` (vedi la lane di coordinamento `phpstan-test-wave-regression.story.md`).

## Aperto (serve una decisione o non è mio)

1. `Themes/Sixteen/src` (20 file rimasti): copia vecchia di `app/` (i Models differiscono di centinaia di righe), non autoloadata, mai referenziata. Proposta: rimuovere l'intero albero. Non fatto: è più ampio del tema Services.
2. `Modules/Seo/tests/Unit/Services/MetatagServiceExtendedTest.php.old` e `tests/Unit/Modules/Chart/**` (modulo `Chart` assente da questo repo): test orfani; le regole di progetto vietano di cancellare test senza approvazione.
3. In corso da un'altra sessione, non committato: cancellazione di `Modules/Fixcity/app/Services/{NotificationService,TicketService,WorkflowService}.php` e `Themes/Sixteen/app/Services/ThemeService.php`
   (0 riferimenti vivi: `use …\Services\` = 0 nel codice di produzione).
4. Molti documenti storici nominano ancora `app/Services/` come stato passato: non riscritti, sono cronologia.
