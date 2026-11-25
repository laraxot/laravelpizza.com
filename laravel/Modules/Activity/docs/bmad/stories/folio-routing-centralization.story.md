---
title: "Centralizzare il routing Folio dei moduli: Activity non monta Folio"
status: done
module: Activity
epic: architecture
qmd: "BMAD Folio routing Activity provider CMS FolioVoltServiceProvider confine modulo no mount Cms assente"
related:
  - ../../../../../../docs/wiki/memories/filament5-layout-contract-shared-modules.md
  - ../../../../User/docs/wiki/concepts/folio-pages-owner-pattern.md
---

# Story: centralizzare il routing Folio dei moduli

## Problema

`ActivityServiceProvider` registrava direttamente una directory Folio. Questo
faceva dipendere il router globale dal provider di un singolo modulo e rendeva
necessario replicare lo stesso blocco in ogni modulo con pagine `resources/views/pages`.

## Perché `Folio::path` in `ActivityServiceProvider` è sbagliato

Un modulo di dominio **non** è il router Folio, con o senza il modulo Cms.

| Ruolo | Owner |
|-------|--------|
| File `resources/views/pages/**` | modulo di dominio (Activity) |
| `Folio::path` nei progetti con Cms | `Cms/FolioVoltServiceProvider` |
| `Folio::path` nei progetti senza Cms | **non** Activity; `App\Providers\FolioServiceProvider` non è un sostituto di Cms per le pagine dei moduli |

Motivi:

1. Confine ECC — Activity = activitylog/LogViewer; il routing del front office è trasversale.
2. DRY — altrimenti ogni modulo copia un mount incompleto.
3. Ordine delle catch-all — la prima registrazione Folio vince e può interferire con le fallback Filament (rischio maggiore nei progetti con molti pannelli).
4. Modulo condiviso — Activity non deve assumere la presenza di Cms né inventare un mini-FolioVolt.

## Decisione

**Progetti con il modulo Cms** — owner del montaggio Folio:
**Progetti con il modulo Cms** — owner del montaggio Folio:
**Progetti con il modulo Cms** — owner del montaggio Folio:
Owner del montaggio Folio in questo progetto:
**Progetti con il modulo Cms** — owner del montaggio Folio:
`Modules\Cms\Providers\FolioVoltServiceProvider`.

- monta tema + `resources/views/pages` di ogni modulo abilitato (`uri($locale)`);
- monta `pages/api` con `uri('/api')` + middleware `web`
  → `log-download.blade.php` = GET `/api/log-download`;
- mount in `booted()` (non prima delle fallback Filament).

`ActivityServiceProvider` = config/comportamento Activity, **non** router.
Niente `Folio::path()` lì (rimozione applicata; istruzione utente: aggiungere Folio nel provider «è sbagliato»).
In questo checkout il modulo `Cms` non è presente e non va introdotto. Di
conseguenza `ActivityServiceProvider` non deve montare Folio e
`App\Providers\FolioServiceProvider` non va usato come sostituto: il provider
applicativo monta soltanto `resources/views/pages`, non le pagine dei moduli.

Nei progetti che includono il modulo comune CMS, il solo owner delle pagine
Folio dei moduli e dei temi è `Cms/app/Providers/FolioVoltServiceProvider`.
Activity resta proprietario della configurazione e del comportamento Activity,
non dell'infrastruttura di routing.
**Progetti senza il modulo Cms** — Cms non va introdotto solo per questo, e
`App\Providers\FolioServiceProvider` non va usato come surrogato: il provider
applicativo monta soltanto `resources/views/pages`, non le pagine dei moduli. Il
pattern si impara dai progetti che hanno Cms, non si importa il modulo.

In entrambi i casi `ActivityServiceProvider` = configurazione/comportamento Activity,
**non** router. Niente `Folio::path()` / `use Laravel\Folio\Folio` lì (rimozione
applicata; istruzione utente: aggiungere Folio nel provider «è sbagliato»).

## Verifica

- `php -l` sui provider: verde;
- `bootstrap/providers.php` non registra `App\Providers\FolioServiceProvider`;
- `Folio::path()` assente da `ActivityServiceProvider`
  (guardia: `tests/Unit/Providers/ActivityServiceProviderNoFolioMountTest.php`);
- con Cms presente: `php artisan folio:list --path=api/log-download` mostra GET `/api/log-download`;
- `phpstan analyse Modules`: gate da rieseguire dopo il rilascio del lock;
- Pest feature `tests/Feature/Filament/LogDownloadPageTest.php`: da eseguire solo in ambiente di test raggiungibile.

## Acceptance criteria

- [ ] Nessuna registrazione `Folio::path()` nel provider Activity (file ancora sotto lock concorrente).
- [x] Nessun provider Folio applicativo aggiunto o registrato.
- [x] Il routing Folio resta responsabilità del CMS nei progetti che lo includono.
- [ ] Pest feature verde in ambiente di test stabile.
title: "Activity non monta Folio (PTVX senza Cms)"
status: done
module: Activity
epic: architecture
qmd: "BMAD Folio Activity no mount Cms assente PTVX confine modulo"
related:
  - ../../../../../../docs/wiki/memories/filament5-layout-contract-shared-modules.md
  - ../../../../User/docs/wiki/concepts/folio-pages-owner-pattern.md
---

# Activity non monta Folio

## Perché `Folio::path` in ActivityServiceProvider è sbagliato

Anche senza Cms in PTVX, un modulo di dominio **non** è il router Folio.

| Ruolo | Owner |
|-------|--------|
| File `resources/views/pages/**` | modulo dominio (Activity) |
| `Folio::path` nei progetti FO con Cms | `Cms/FolioVoltServiceProvider` |
| `Folio::path` in PTVX | **non** Activity; App Folio non è un sostituto di Cms per le pagine moduli |

Motivi:

1. Confine ECC — Activity = activitylog/LogViewer; routing FO cross-cutting.
2. DRY — altrimenti ogni modulo copia un mount incompleto.
3. Race fallback Folio vs Filament (PTVX è panel-heavy).
4. Portfolio — Activity è modulo *condiviso*: non deve assumere Cms né inventare un mini-FolioVolt.

In PTVX Cms non c’è e non deve stare: si **impara** il pattern dai sibling FO, non si importa il modulo.

## Decisione PTVX

- [x] Nessun `Folio::path` / `use Laravel\Folio\Folio` in `ActivityServiceProvider`.
- [x] Nessun `Modules/Cms` introdotto.
- [x] `App\Providers\FolioServiceProvider` non registrato e **non scomodato**: nei sibling FO basta FolioVolt; qui non è un surrogato.
- [x] Pest `ActivityServiceProviderNoFolioMountTest`.
- [x] Nessuna registrazione `Folio::path()` nel provider Activity.
- [x] Owner unico con Cms: `Cms\FolioVoltServiceProvider` (nessun `App\Providers\FolioServiceProvider`).
- [x] Senza Cms: nessun provider Folio applicativo aggiunto o registrato, nessun `Modules/Cms` introdotto.
- [x] Pagina Activity visibile nell'inventario Folio (progetti con Cms).
- [x] Pest `ActivityServiceProviderNoFolioMountTest`.
- [ ] Pest feature `LogDownloadPageTest` verde in ambiente di test stabile.
