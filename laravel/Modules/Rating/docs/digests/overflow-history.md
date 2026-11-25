---
title: "Overflow history (ceiling 100)"
type: digest
status: active
qmd: "digest ceiling 100 overflow-history"
---

# Overflow history (ceiling 100)

<<<<<<< HEAD
Overflow force-cap: 2 file oltre target 100.

### `confidence-guidelines.md` — Massimizzare il livello di confidenza

# Massimizzare il livello di confidenza

1. **Test automatizzati**: copertura >90%, includi test unitari, integrazione, e fine‑to‑end.
2. **CI/CD**: esegui tutti i test su ogni commit, blocca merge se falliscono.
3. **Analisi statica**: PHPStan, Psalm e Laravel Pint al livello massimo.
4. **Revisione del codice**: code‑review obbligatoria con checklist di qualità.
5. **Monitoraggio in produzione**: New Relic / Sentry per errori e performance.
6. **Documentazione**: mantieni aggiornati doc e changelog.
7. **Rollback rapido**: feature flags e versioni per tornare indietro.

### `product-launch-plan-2.md` — Rating Module - Product Launch Plan

# Rating Module - Product Launch Plan

**Module:** Rating  
**Version:** 1.0.0  
**Last Updated:** March 12, 2026  
**Owner:** Product Team

---

## Launch Objectives

1. **Product:** Deploy rating and review system
2. **Participation:** 5% review rate
3. **Quality:** 4.0+ average rating
4. **Trust:** <5% fraud rate

---

## Pre-Launch Checklist
=======
Overflow force-cap: 247 file oltre target 100.

### `agent-confidence-discipline.md` — Disciplina agenti per massimizzare la confidenza


# Disciplina agenti per massimizzare la confidenza

Regola canonica: [../../Xot/docs/wiki/concepts/agent-confidence-discipline.md](../../Xot/docs/wiki/concepts/agent-confidence-discipline.md).

Sintesi: verificare prima di affermare; riprodurre prima di correggere; documentare prove, dubbi e rischio residuo; rispondere in italiano sintetico.

### `agent-confidence-protocol.md` — Massima confidenza agente


# Massima confidenza agente

Stub DRY. Regola canonica: [../../../../docs/wiki/rules/agent-confidence-protocol.md](../../../../docs/wiki/rules/agent-confidence-protocol.md).

Checklist locale: issue GitHub, wiki owner, file letti a chunk, gate eseguiti, log aggiornato, limiti dichiarati.

### `agent-edit-discipline.md` — agent-edit-discipline


See canonical documentation: ../../../Themes/docs/shared-components/agent-edit-discipline-Modules.md

### `architecture-rules.md` — Architectural Rules & Guidelines


# Architectural Rules & Guidelines

This module adheres to the **Laraxot Architecture** and **Super Cow Methodology**.

For strict coding standards, Filament extension rules, and PHPStan guidelines, please refer to the central documentation in the **Xot Module**:

-   [Super Cow Methodology](../../Xot/docs/super_cow_methodology.md)
-   [PHP Quality Guide](../../Xot/docs/php_quality_guide.md)
-   [Filament Extension Rules](../../Xot/docs/filament_extension_rules.md)

**Key Principles:**
1.  **DRY & KISS**: Don't repeat yourself, keep it simple.
2.  **Zero Errors**: PHPStan Level 10 compliance is mandatory.
3.  **XotBase**: Always extend `XotBase` classes, never Filament classes directly.
4.  **Translations**: Use `LangServiceProvider` for automatic label resolution.

### `architecture.md` — Rating Architecture


# Rating Architecture

Lightweight reference to architecture. See consolidated documentation:

- [README](./README.md) — Overview and module description
- [FAQ](./faq.md) — Quick answers (implementation, database, Filament, testing, performance, security, troubleshooting, upgrade)
- [Index](./index.md) — Navigation to wiki analysis

## Core Design

**Polymorphic ratings system** for any Eloquent model.

- One rating per user per entity (unique constraint)
- 1-5 score scale, optional comments
- HasRatingsTrait for model integration
- QueueableAction pattern for business logic
- Event-driven cache invalidation
- Multi-language translation support


### `bad-practices.md` — Bad Practices – Rating


# Bad Practices – Rating

## ❌ Calcolare la media in query N+1
Usa `withAvg()` Eloquent per aggregazioni efficienti.

## ❌ Usare float per star_rating
Genera problemi di UI e formattazione; usa interi 1-5.

## ❌ Consentire rating duplicati senza validazione
Implementa `unique:ratings,user_id,rateable_id`.

### `best-practices.md` — Best Practices – Rating

# Best Practices – Rating

## Principi DRY/KISS
- **DRY**: Centralizza logica di scoring in `RatingService`. Usa attributi calcolati per azioni utente.
- **KISS**: Usa `star_rating` come integer 1-5, non float o stringhe.
- **Clean Code**: Segui il pattern `Builder` per recensioni complesse.

## Componenti
- Usa `RatingStar` per visualizzare icone vuote/piene.
- Usa `AverageRating` come campo calcolato (non memorizzato).

## Test
- Implementa test unitari per `RatingService::calculate()`.
- Copri casi limite come rating inversi.

## Documentazione
- Aggiorna `docs/INDEX.md` con nuovi endpoint.
- Collega a moduli correlati come `Review` e `Auth`.

## Contenuto fuso da `best-practices.md`

### `binary-assets.md` — Asset binari


# Asset binari

Gli asset binari sono file normali del repository.

Regole:
- non aggiungere filtri o backend di storage esterno in `.gitattributes`;
- non committare file pointer al posto del contenuto reale;
- se un asset manca, recuperare il binario originale e committarlo direttamente;
- prima del push verificare che immagini, font, archivi e PDF siano contenuti reali.

### `bmad/architecture/form-field-label-and-xls-path-home.md` — Verdetto: dove vivono label, path e catalogo XLS (storico, vedi nota sopra)


> **AMENDED 2026-09-23**: il verdetto sotto (~78%, "restano nel trait") è stato
> **ribaltato** da correzione esplicita dell'utente in `04.md` righe 66-79:
> chiamare `TraitName::staticMethod()` va evitato "come la peste" a prescindere dal
> dominio del metodo: i due helper sono spostati in `RatingData` con type hint
> `RatingContract` (non `BaseRating`). Vedi
> [story 5.232](../stories/0031-ratingdata-ratingclass-required-revert-backtrace.story.md)
> per il verdetto finale e la contro-analisi dei punti 1-3 sotto. Documento
> mantenuto come storico del dibattito, non più normativo.

# Verdetto: dove vivono label, path e catalogo XLS (storico, vedi nota sopra)

Prompt utente (`04.md` 35–64): spostare `formFieldLabel` + `ratingXlsValuePath`
in `RatingData`; Resource con `...RatingData::getX

### `bmad/architecture/module-boundary.md` — Rating: architettura

# Rating: architettura

## Scopo osservato

Valutazioni e criteri di rating. Scheda derivata da `module.json`, struttura `app/` e conteggi del repository; non sostituisce decisioni architetturali non ancora approvate.

## Inventario verificato

- PHP in `app/`: 71 file.
- Test PHP in `tests/`: 39 file.
- Aree applicative: `Enums`, `Http`, `Filament`, `Contracts`, `Models`, `Console`, `Actions`, `Providers`, `Aggregates`, `View`, `DataObjects`, `Datas`.
- Persistenza: `database/factories`, `database/migrations`, `database/seeders` presenti.

## Confini

Il modulo espone risorse, azioni e contratti verso i consumatori; la logica di dominio deve restare nelle Action e nei modelli del modulo. Le dipendenze verso Xot, User, Tenant e UI vanno verificate tramite namespace/import reali prima di og

### `bmad/architecture/rating-data-export-methods.md` — Architecture: spostamento formFieldLabel e ratingXlsValuePath in RatingData


# Architecture: spostamento formFieldLabel e ratingXlsValuePath in RatingData

## Scopo
Spostare i metodi statici `formFieldLabel` e `ratingXlsValuePath` da `HasRatingsTrait.php` a `RatingData.php`, perché sono utility di rating e non di relazioni.

## Design
`RatingData` diventa il punto unico per:
- Utility di rating: `formFieldLabel(BaseRating $rating): string`
- Utility di export rating: `ratingXlsValuePath(BaseRating $rating): string`
- Catalogo colonne export XLS/XLSX dai criteri rating (`getXlsFields`, `criteriaToXlsFields`)

## Flusso
1. `HasRatingsTrait` mantiene le relazioni (`ratings()`, `ratingMorphs()`, `myRatings()`, ecc.) ma perde `formFieldLabel` e `ratingXlsValuePath`.
2. `RatingData` guadagna i due metodi e li usa internamente (in `getXlsFields`, `criteriaToXlsFields`).


### `bmad/architecture/rating-entity-helpers-home-in-ratingdata.md` — Sede helper (post-swarm 2026-09-23)


# Sede helper (post-swarm 2026-09-23)

| Helper | Sede SSoT | Note |
|--------|-----------|------|
| `formFieldLabel` | `RatingData` | presentazione entità |
| `ratingFieldName` | `RatingData` | schema form `ratings.{id}.pivot.*` |
| `ratingValuePath` / `ratingXlsValuePath` | `RatingData` | export `ratings_by_id.*` |
| `getXlsFields` / `criteriaToXlsFields` | `RatingData` | catalogo export |
| relazioni / sync / form schema build | `HasRatingsTrait` | host |

**Trappola:** due path diversi (`ratings.*` form vs `ratings_by_id.*` export) sono
volontari: non unificarli senza story. Dopo ogni move: sweep caller (5.231).

### `bmad/architecture/rating-table-component.md` — Componente Blade riutilizzabile per tabella rating


# Componente Blade riutilizzabile per tabella rating

## Scopo
Fornire un componente Blade `<x-rating-table>` riutilizzabile nel modulo Rating per visualizzare le righe di rating associate a un modello host (tramite relazione `ratings`), con supporto per:
- Visualizzazione del testo formattato (`getTxtHtml()`)
- Valore in grassetto (`getValueHtml()`)
- Nota aggregata con `rowspan` sull'ultima riga (`getNoteHtml()`)

## Architettura
Il componente risiede in `resources/views/components/rating-table.blade.php` e segue le convenzioni Laravel Blade components.

### Input (props)
| Prop | Tipo | Default | Descrizione |
|------|------|---------|-------------|
| `$row` | `Illuminate\Database\Eloquent\Model` (deve avere relazione `ratings`) | **obbligatorio** | Istanza del modello host (es. `Sched

### `bmad/architecture.md` — Rating: architettura


# Rating: architettura

Scopo e rischi: [purpose.md](./purpose.md). Finding: [audits/rating-audit.md](./audits/rating-audit.md).

## Struttura misurata (2026-11-16)

| Cartella `app/` | Contenuto |
|---|---|
| `Models/` | `BaseRating`, `BaseRatingMorph`, `BaseMorphPivot`, `Like`, `AbstractRatingsHost`; connessione `rating` ([BaseModel.php:14](../../app/Models/BaseModel.php)) |
| `Models/Traits/` | `HasRatingsTrait` (770 righe, il contratto reale), `HasLikes`; `RatingTrait` e `HasRating` sono senza consumer |
| `Models/Contracts/` | `HasRatingContract` (`ratings(): MorphToMany`), `RatingContract` |
| `Models/Policies/` | `Base*` + concrete per `Rating` e `RatingMorph` |
| `Actions/HasRating/` | 3 Action di conteggio/somma/opzioni per modello |
| `Filament/` | 4 Resource (`BaseRatingResourc

### `bmad/audit.md` — Audit BMAD — Rating


# Audit BMAD — Rating

SSoT dettagliata: [audits/rating-audit.md](./audits/rating-audit.md). Questo file è solo la sintesi.

## Sintesi (2026-11-16)

| Metrica | Valore |
|---|---:|
| PHP `app/` | 76 |
| Test (file PHP / `*Test.php`) | 42 / 30 |
| Resource / Actions / Services / Policy | 4 / 3 / 0 / 4 |
| Migration (radice) | 8 |
| Marker conflitto | 0 |
| P0 / P1 / P2 | 0 / 2 / 7 |

## Top finding

1. **RAT-P1-01** — `rating_morph` senza FK, senza unique, con `rating_id` e morph nullable: punteggi orfani o doppi.
2. **RAT-P1-02** — lo schema `ratings` e `rating_morph` è creato da 3 migration ciascuno; il risultato dipende dall'ordine.

### `bmad/audits/rating-audit.md` — Audit approfondito — Rating


# Audit approfondito — Rating

SSoT dei finding del modulo. Sintesi: [audit.md](../audit.md) · ECC: [rating-ecc-audit.md](../../ecc/rating-ecc-audit.md) · Story: [0066-module-bmad-audit.story.md](../stories/0066-module-bmad-audit.story.md) · Piano: [piano-miglioramento.md](../piano-miglioramento.md).

## Perché esiste (business)

Rating dà a ogni scheda (Performance, Progressioni, Indennità) lo **stesso modo** di raccogliere punteggi e note, via relazione polimorfica (`rating_morph`) e `HasRatingsTrait` ([HasRatingsTrait.php](../../../app/Models/Traits/HasRatingsTrait.php), 770 righe). È self-contained: non importa nessun altro modulo di dominio (solo Xot 63, Media 1). Il rischio è nel dato: un morph senza vincoli lascia punteggi orfani o duplicati che falsano il riparto.

## Metodo

Sour

### `bmad/best-practices.md` — Best practices: Rating


# Best practices: Rating

## Nota 2026-09-02

Questo file e `BEST_PRACTICES.md` (gemello con collisione di case, cancellato)
contenevano contenuti opposti e inconciliabili: uno rimandava a un canonical
`Themes/docs/shared-components/.gitkeep-Modules` che è un file placeholder
vuoto, l'altro descriveva classi (`RatingService`, `RatingStar`,
`AverageRating`) che **non esistono** in questo modulo (verificato con
`grep -rln "class RatingService\|class RatingStar\|class AverageRating" app`
- zero risultati). Nessuno dei due era utilizzabile: il primo puntava al
nulla, il secondo era inventato.

## Modelli reali del dominio (verificato)

`app/Models/`: `Rating`, `BaseRating`, `RatingMorph`, `BaseRatingMorph`,
`Like`, `AbstractRatingsHost`. Azioni sotto `app/Actions/HasRating/`.

Una guida best-

### `bmad/bmad-dossier.md` — Rating: BMAD dossier

# Rating: BMAD dossier
## Product brief / PRD
Collect trustworthy polymorphic feedback after an eligible civic outcome.
## Architecture / UX / security
Rating supplies reusable contracts/aggregates; Fixcity decides eligibility and owner policy.
## Epics and stories
Eligibility; idempotent submission; aggregation/moderation.
## Gaps / release
Abuse limits, duplicate policy, privacy and resolved-ticket browser proof need closure.

### `bmad/bmad-planning.md` — Obiettivo


# Obiettivo

Raccogliere feedback polimorfico affidabile dopo un esito civico eleggibile.

## Perché questo owner

- **Utenti:** cittadino post-chiusura, analyst PA
- **Track BMAD:** `quick-flow`
- **Religione:** Actions + Folio/Volt/Filament `XotBase*`; mai Controllers; docs solo in questo `docs/` (mai `bmad-output/`).

## Scope

### In
- contratti rating morph
- aggregate
- resource BO

### Out
- decidere eleggibilita (owner Fixcity)

### `bmad/brainstorming/module-opportunities.md` — Rating: brainstorming

# Rating: brainstorming

## Punto di partenza

Valutazioni e criteri di rating. L'inventario corrente misura 71 file applicativi e 39 file di test.

## Domande ad alto valore

- Quale problema utente risolve il modulo e quale comportamento è vincolante?
- Quali dati sono autorevoli e quali sono proiezioni o cache?
- Quali ruoli possono leggere, creare, modificare o approvare?
- Quale errore deve essere osservabile senza esporre dati sensibili?
- Quale parte è riusabile e quale è specifica del dominio PTVX?

## Ipotesi da validare

- Le Action sono il punto di orchestrazione del caso d'uso.
- Le Resource Filament sono adattatori, non il luogo della regola di business.
- I test esistenti sono evidenza parziale e vanno confrontati con i flussi esposti.


### `bmad/brainstorming/rating-data-export-methods.md` — Brainstorming: spostamento formFieldLabel e ratingXlsValuePath in RatingData


# Brainstorming: spostamento formFieldLabel e ratingXlsValuePath in RatingData

## Contesto
Due metodi statici di `HasRatingsTrait` (`formFieldLabel` e `ratingXlsValuePath`) sono utilizzati in diversi punti (RatingData, CompilaIndennitaResponsabilita, DecoratesRatingFormFields, test). Sono utility su rating, non su relazioni. L'utente suggerisce di spostarli in `RatingData.php`.

## Analisi pro/contro (con percentuali)

### Pro spostamento (85%)
- **Coerenza semantica** (90%): i metodi operano su rating, non su relazioni. `RatingData` è il DTO di rating, quindi ha senso che contenga utility su rating.
- **Riduzione coupling** (80%): il trait `HasRatingsTrait` sarebbe meno pesante e più focalizzato sulle relazioni.
- **Centralizzazione** (75%): tutte le utility rating vivono in `RatingData

### `bmad/brainstorming/rating-table-component.md` — Brainstorming: componente Blade riutilizzabile per tabella rating


# Brainstorming: componente Blade riutilizzabile per tabella rating

## Contesto
Il blocco Blade per la visualizzazione delle righe di `ratings` (testo, valore, nota con rowspan) è duplicato in più punti (viste schede, esportazioni XLS, viste PDF). Si vuole estrarlo in un componente Blade riutilizzabile.

## Domande chiave
1. **Quale nome per il componente?** `rating-table` (coerente con il naming esistente del modulo Rating, usa `x-rating-table`).
2. **Quali props?** `row`, `showNote`, `rowspan`, `alignValue`. Le props sono sufficienti per coprire tutti i casi d'uso attuali?
3. **Dove collocarlo?** `resources/views/components/rating-table.blade.php` (standard Laravel Blade component, nessun namespace custom richiesto).
4. **Dipendenze?** Solo il modello `BaseRating` (metodi `getTxtHtml`,

### `bmad/brainstorming/rating-xls-fields-home.md` — Brainstorm: dove vive il pezzo riusabile


# Brainstorm: dove vive il pezzo riusabile

## Domanda

Spostare il blocco “foreach rating → path/label (+ note se children)” fuori da
`IndennitaResponsabilitaResource::getXlsFields`. Dove?

## Voti interni (peso decisione)

| Casa | Peso | Motivo in una riga |
|------|------|--------------------|
| HasRatingsTrait | 62% | già path/label/sync + schemaless |
| Action Spatie | 48% | religione Action; forse dopo |
| BaseRating static | 40% | modello giusto, grasso |
| RatingData | 28% | preferenza utente ma DTO già bifronte |
| Solo Resource | 12% | status quo anti-DRY |

## Obiezione utente su RatingData


### `bmad/brainstorming.md` — Rating: Brainstorming


# Rating: Brainstorming

> **SUMMARY**: Decisioni prese, questioni aperte e opzioni scartate del modulo `Rating`,
> ancorate a file e simboli reali. Il brainstorming di dettaglio per area e' negli shard.

## Shard

| Shard | Path |
|-------|------|
| Nota obbligatoria «altro» | [brainstorming/rating-select-altro-note-obbligatoria.md](brainstorming/rating-select-altro-note-obbligatoria.md) |
| Metodi export | [brainstorming/rating-data-export-methods.md](brainstorming/rating-data-export-methods.md) |
| Campi export riusabili | [brainstorming/rating-export-fields-reusable.md](brainstorming/rating-export-fields-reusable.md) |
| Componente tabella | [brainstorming/rating-table-component.md](brainstorming/rating-table-component.md) |
| Home campi XLS | [brainstorming/rating-xls-fields-home.md]

### `bmad/completion.md` — BMAD completion pack: Rating

# BMAD completion pack: Rating

This is the owner-local BMAD entry point. Cross-owner contracts are in plans/fixcity-completion-architecture.md; the backlog is in docs/completion-backlog.md.

## Architecture

Boundary: eligibility, anti-abuse and aggregation.
- Inputs, outputs, authorization, persistence owner, failure behavior and localization must be recorded before implementation.
- Reuse XotBase, Queueable Actions, Folio/Volt, Filament schemas and shared theme components where applicable.
- No new Controller, Service, Bootstrap component, duplicate migration or mixed shortcut without an explicit decision.
- Shared files are serialized; owned files are declared in the story before parallel work.

## Brainstorming

- 5 Whys: identify why the current behavior exists before changing it.
- 

### `bmad/concepts/xotbase-never-extend-filament.md` — Mai `Filament\*`: sempre `Modules\Xot\Filament\...\XotBase*`


# Mai `Filament\*`: sempre `Modules\Xot\Filament\...\XotBase*`

Bridge on-demand. Contenuto canonico: [docs/wiki/rules/xotbase-critical-rules.md](../../../../../../docs/wiki/rules/xotbase-critical-rules.md).

## Zen (riassunto)

Nessuna classe in `Modules/Rating` estende una classe `Filament\...` direttamente.
Si estende sempre lo "specchio" in `Modules\Xot\Filament\...` allo stesso
percorso relativo (es. `Filament\Tables\Columns\ViewColumn` ->
`Modules\Xot\Filament\Tables\Columns\XotBaseViewColumn`). Se manca il
mirror, va creato in Xot prima di usarlo qui, mai come scorciatoia nel modulo.

Non pre-caricare questo file: leggi la fonte canonica solo quando il task lo richiede.

### `bmad/decision-log.md` — Decision log — Rating


# Decision log — Rating

Formato: **data · decisione · stato · motivo · conseguenza**. Evidenza completa in [audits/rating-audit.md](./audits/rating-audit.md).

| Data | Decisione | Stato | Motivo | Conseguenza |
|---|---|---|---|---|
| 2026-11-16 | Integrità `rating_morph` = P1 (RAT-P1-01) | approvata | morph senza FK/unique/morphMap; rischio già scritto in [purpose.md](./purpose.md) e mai mitigato | Epic A in [epics.md](./epics.md) |
| 2026-11-16 | Correggere lo schema con una migration nuova, non editando le 6 esistenti | approvata | dati sacri: solo migrate additivo; le vecchie sono già eseguite altrove | vedi RAT-P1-02 |
| 2026-11-16 | `_archive_redundant/` e `_bak/` restano dove sono | approvata | `loadMigrationsFrom` non è ricorsivo ([XotBaseServiceProvider.php:42](../../../Xot/app

### `bmad/epics/module-roadmap.md` — Rating: epic roadmap

# Rating: epic roadmap

## Epic A: Contratto e architettura

Documentare API pubbliche, dipendenze, confini e invarianti del modulo.

## Epic B: Qualità verificabile

Ridurre finding PHPStan, mantenere test Pest eseguibili e registrare evidence ripetibile.

## Epic C: UX e integrazione

Verificare parità Form/Table, traduzioni, autorizzazioni, error handling e integrazioni dichiarate.

## Epic D: Documentazione viva

Collegare ogni decisione a story BMAD, mantenere il second brain e chiudere i duplicati senza cancellare storia.

## Definition of Done


### `bmad/epics.md` — Epics — Rating


# Epics — Rating

Roadmap storica: [epics/module-roadmap.md](./epics/module-roadmap.md), [epics/rating-export-ssot.md](./epics/rating-export-ssot.md), [epics/rating-select-altro.md](./epics/rating-select-altro.md). Qui solo gli epic dell'[audit 2026-11-16](./audits/rating-audit.md).

## Epic A — Integrità di `rating_morph` (RAT-P1-01, RAT-P1-02)

**Perché:** il dato valutativo alimenta il riparto; orfani e doppi lo falsano e il DB non li ferma.
**Fatto quando:** una migration **nuova e additiva** (mai modificare le vecchie, mai `--force`) porta unique su (`model_type`, `model_id`, `rating_id`, `user_id`) e l'indice mancante; i dati esistenti sono prima contati con una query di sola lettura (duplicati/orfani); `morphMap` registrato dal provider; test di regressione su doppio inserimento.
*

### `bmad/filament-blueprint.md` — Scopo


# Scopo

Contratto Filament del modulo **Rating**: chrome BO e/o widget FO senza violare
i confini di dominio.

## Regole non negoziabili

1. Estendere solo `XotBaseResource` / `XotBaseWidget` / basi Xot: mai classi Filament dirette.
2. Nessun `->label()` hardcoded: chiavi in `lang/<locale>/` del modulo.
3. Business logic nelle Actions del modulo, non nei form hooks grassi.
4. FO: widget montati esplicitamente; non abusare `discoverWidgets` per chrome.

## Resource / widget

- `RatingResource`
- `RatingMorphResource`

## Form / Table / Infolist


### `bmad/piano-miglioramento.md` — Piano di miglioramento — Rating


# Piano di miglioramento — Rating

Derivato dall'[audit](./audits/rating-audit.md).

## P0

1. Bonificare marker/conflict se presenti (ora: 0).
2. Chiudere policy troppo permissive (`return true` ≈ 4) con matrice ruolo×ability.
3. Blocchi sicurezza runtime (auth panel, mass assignment, export) con test negativi.

## P1

1. Portare Services (0) ad Actions Queueable dove applicabile.
2. Alzare copertura test (attuale 42 test / 76 app PHP).
3. Allineare Filament (resources=4) a XotBase* e traduzioni Lang.
4. Spezzare dipendenze inverse verso verticali peer se rilevate con `rg`.

## P2


### `bmad/project-context.md` — Costituzione: Rating


# Costituzione: Rating

Raccogliere feedback polimorfico affidabile dopo un esito civico eleggibile.

## Utenti

cittadino post-chiusura, analyst PA

## Vincoli

1. Docs solo in questo owner (`docs/`), mai `bmad-output/`.
2. Actions + XotBase Filament; mai Controllers.
3. Non assorbire scope degli owner collegati (vedi Out nel planning).

## Artefatti

- [bmad-planning.md](../bmad-planning.md)
- [bmad-brainstorming.md](../bmad-brainstorming.md)
- [filament-blueprint.md](./filament-blueprint.md)

### `bmad/purpose.md` — Rating: perche' esiste


# Rating: perche' esiste

## Lo scopo in una frase

**Rating fornisce un sistema polimorfico di criteri di valutazione condiviso fra moduli diversi (schede, indennitá, progressioni) tramite `HasRatingsTrait`: ogni scheda raccoglie punteggi e note secondo un criterio diverso, senza duplicare il codice.**

## L'evidenza

- `HasRatingsTrait` + `HasRatingContract`: relazione polimorfica su `ratings` e `rating_morph` (`RatingMorphTrait` non esiste nel codice, verificato con `rg`)
- 3 Action, 2 Widget, 4 Resource, 76 PHP in `app/`, 602 file di documentazione (misure 2026-11-16)
- Ogni modulo che valuta (Performance, Progressioni, IndennitaResponsabilita) usa Rating tramite trait

## Confini: cosa **non** appartiene a Rating

- Il **calcolo della performance**: dominio di Performance
- La **valu

### `bmad/quick-reference.md` — Rating: Quick Reference


# Rating: Quick Reference

> **SUMMARY**: Riferimento rapido del modulo `Rating`: dove sta cosa, quali simboli usare,
> quali test leggere prima di toccare il codice. Paths relativi a `laravel/Modules/Rating`.

## SSoT e contratti

| Simbolo | Path |
|---------|------|
| `RatingData` (SSoT export/path/label) | `app/Datas/RatingData.php` |
| `RatingContract` | `app/Models/Contracts/RatingContract.php` |
| `HasRatingContract` | `app/Models/Contracts/HasRatingContract.php` |
| `RatingsFormCallerContract` | `app/Contracts/RatingsFormCallerContract.php` |
| `HasLikeContract` | `app/Contracts/HasLikeContract.php` |
| `RuleEnum` | `app/Enums/RuleEnum.php` |
| `SupportedLocale` | `app/Enums/SupportedLocale.php` |

Metodi chiave di `RatingData`: `ratingValuePath()`, `ratingXlsValuePath()`, `rating

### `bmad/setup-guide.md` — Rating: Setup Guide


# Rating: Setup Guide

> **SUMMARY**: Come si porta il modulo `Rating` in un ambiente funzionante: provider da
> registrare, config, migrazioni, seeders e test. Comandi da eseguire dalla root di `laravel/`.

## 1. Registrazione provider

Dichiarati in `module.json` e in `composer.json` (`extra.laravel.providers`):

- `Modules\Rating\Providers\RatingServiceProvider`
- `Modules\Rating\Providers\Filament\AdminPanelProvider`

`app/Providers/RatingServiceProvider.php` e' una classe di 20 righe che estende
`XotBaseServiceProvider` e non sovrascrive `boot()`/`register()`: il boot del modulo e' tutto
in `Filament/AdminPanelProvider.php` e nella scoperta automatica delle risorse.

## 2. Config

`config/config.php` contiene solo:

### `bmad/stories/0001-ratings-by-id-accessor.story.md` — 18.56: Accessor `ratings_by_id` per esportazione ratings con titolo

# 18.56: Accessor `ratings_by_id` per esportazione ratings con titolo

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0002-xls-export-value-selected-child.story.md` — 18.58: Valore export XLS riusabile sul rating

# 18.58: Valore export XLS riusabile sul rating

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0003-ratings-hoststub-getclassname-harness.story.md` — 18.59: Harness `getClassName` nei test ratings_by_id

# 18.59: Harness `getClassName` nei test ratings_by_id

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0004-rating-xls-fields-catalog.story.md` — 18.60: `HasRatingsTrait::ratingXlsFields`

# 18.60: `HasRatingsTrait::ratingXlsFields`

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0005-has-rating-values-filter-note.story.md` — Story Rating/5.141: D-8 filtro «valutata» + note

# Story Rating/5.141: D-8 filtro «valutata» + note

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0006-review-gate-select-altro-impl.story.md` — Story Rating/5.142: Review gate (mentre un altro agente implementa)

# Story Rating/5.142: Review gate (mentre un altro agente implementa)

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0007-lang-fields-altro.story.md` — Story Rating/5.143: Chiavi lang «altro» / placeholder

# Story Rating/5.143: Chiavi lang «altro» / placeholder

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0008-rename-select-is-other.story.md` — Story Rating/5.144: English identifiers

# Story Rating/5.144: English identifiers

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0010-select-obbligatorio-textarea-req.story.md` — Story Rating/5.146: Select obbligatorio + Textarea obbligatoria se seleziona altro

# Story Rating/5.146: Select obbligatorio + Textarea obbligatoria se seleziona altro

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0011-select-textarea-section-ui.story.md` — Story Rating/5.146: Section UI per Select+note

# Story Rating/5.146: Section UI per Select+note

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0012-hydrate-sync-ratings-form-data.story.md` — Story Rating/5.147: pass-through pivot generico nel trait

# Story Rating/5.147: pass-through pivot generico nel trait

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0013-fieldset-always-visible-two-columns.story.md` — Story Rating/5.148: Fieldset, sempre affiancati, 2 colonne

# Story Rating/5.148: Fieldset, sempre affiancati, 2 colonne

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0014-compila-vs-trait-reusable-boundary.story.md` — Story Rating/5.149: pezzi riutilizzabili, non tutto

# Story Rating/5.149: pezzi riutilizzabili, non tutto

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0015-human-validation-attribute.story.md` — Story Rating/5.151: validation attribute umano

# Story Rating/5.151: validation attribute umano

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0016-note-required-when-other.story.md` — Story Rating/5.152: note required on «altro» (bug reale)

# Story Rating/5.152: note required on «altro» (bug reale)

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0017-select-required.story.md` — Story Rating/5.152: Select required

# Story Rating/5.152: Select required

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0018-select-required-note-get-component.story.md` — Story Rating/5.156: Select required + note on «altro» (Get path fix)

# Story Rating/5.156: Select required + note on «altro» (Get path fix)

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0019-phpstan-rating-pivot-get-test.story.md` — Story Rating/5.157: PHPStan pivot e test Get

# Story Rating/5.157: PHPStan pivot e test Get

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0020-pest-gate-mandatory-standing-order.story.md` — Rating/5.158: puntatore

# Rating/5.158: puntatore

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0021-clear-ratings-scoped-to-model-id.story.md` — Story Rating/5.162: Svuota/sync scoped a un solo record

# Story Rating/5.162: Svuota/sync scoped a un solo record

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0022-ratings-table-pdf-component.story.md` — 5.226: Ratings table PDF: estrarre in componente Blade riutilizzabile nel modulo Rating

# 5.226: Ratings table PDF: estrarre in componente Blade riutilizzabile nel modulo Rating

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0024-stale-callers-after-ratingdata-move.story.md` — 5.231: Bug: caller lasciati sul trait dopo mossa a RatingData

# 5.231: Bug: caller lasciati sul trait dopo mossa a RatingData

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0027-formfieldlabel-ratingcontract-typehint.story.md` — 5.233: `formFieldLabel(RatingContract $rating)`: type-hint sul contratto

# 5.233: `formFieldLabel(RatingContract $rating)`: type-hint sul contratto

## Context and Problem Statement

> "piuttosto di `public static function formFieldLabel(BaseRating $rating)`
> avrei fatto `public static function formFieldLabel(RatingContract $rating)`"

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.

### `bmad/stories/0028-rating-wiki-agents-merge-markers.story.md` — 5.233: Rating `docs/wiki/AGENTS.md` (merge markers)

# 5.233: Rating `docs/wiki/AGENTS.md` (merge markers)

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0029-bmad-stories-dimenticate-process-fix.story.md` — 5.234: Perche' sono mancate le BMAD stories durante il refactor? (introsp.)

# 5.234: Perche' sono mancate le BMAD stories durante il refactor? (introsp.)

## Context and Problem Statement

1. **Confusione di ownership della story**: in swarm si assume che "chi fa i
   commit scrive la story". Ma l'orchestratore ha comunque `dev` NON WIP sulla
   MIA checklist: deve aprire la story PRIMA di ogni lavoro e chiuderla con
   l'esito. Il lavoro di orchestrazione/verifica e' lavoro.
2. **Verifica ≠ delega**: l'orchestratore ha fatto più volte `git status`, lock,
   letture, pest, phpstan: tutte attivita' BMAD-trackable, mai tracciate.
3. **Assenza di story-track per lo step corrente**: quando `qmd`/lock dicono che
   esiste gia' una story del worker (5.229/5.230), l'orchestratore assume
   "story già fatta" e smette di aggiornarla col proprio esito: violando
   "CONFRONT

### `bmad/stories/0030-rating-docs-merge-markers.story.md` — 5.234: Marker `<<<<<<<` residui in docs Rating

# 5.234: Marker `<<<<<<<` residui in docs Rating

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0031-ratingdata-ratingclass-required-revert-backtrace.story.md` — 5.234: revert backtrace-resolve: `$ratingClass` torna required

# 5.234: revert backtrace-resolve: `$ratingClass` torna required

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0032-ratingdata-export-ssot-architecture-reconcile.story.md` — 5.237: Docs/sprint obsoleti vs codice RatingData

# 5.237: Docs/sprint obsoleti vs codice RatingData

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0033-rating-export-early-stories-supersede.story.md` — 5.238: Bonifica story zombie (ready-for-dev ma codice già fatto)

# 5.238: Bonifica story zombie (ready-for-dev ma codice già fatto)

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0034-orchestrator-forgot-bmad-stories-root-cause.story.md` — 5.239: Perché ho dimenticato le BMAD stories (e come non ripetere)

# 5.239: Perché ho dimenticato le BMAD stories (e come non ripetere)

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0035-ratingcontract-closures-not-baserating.story.md` — 5.240: `fn (RatingContract $rating)` ovunque (04.md 97–101)

# 5.240: `fn (RatingContract $rating)` ovunque (04.md 97–101)

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0036-ratingdata-wiki-memory-sweep.story.md` — 5.240: Memory wiki che contraddicevano lo stato finale del codice

# 5.240: Memory wiki che contraddicevano lo stato finale del codice

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0037-prefer-contracts-over-abstract-classes-second-brain.story.md` — 5.241: Propagare «contratti, non astratte» nel second brain

# 5.241: Propagare «contratti, non astratte» nel second brain

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0038-close-ratingcontract-closures-and-align-index.story.md` — 5.242: Chiusura formale 5.240 (domani, 10–15 min)

# 5.242: Chiusura formale 5.240 (domani, 10–15 min)

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0039-handoff-ratingcontract-swarm-verification.story.md` — 5.242: Handoff sessione: verifica reale + chiusura gap residui

# 5.242: Handoff sessione: verifica reale + chiusura gap residui

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0040-sprint-architecture-post-ratingdata-residual.story.md` — 5.243: Second brain ancora «trait» dopo mossa a RatingData

# 5.243: Second brain ancora «trait» dopo mossa a RatingData

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0041-continuazione-domani-post-prompt-04-pack.story.md` — 5.244: Pack «continua domani» (post-04)

# 5.244: Pack «continua domani» (post-04)

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0042-ratings-by-id-hoststub-harness-verify.story.md` — 5.245: 18.59 harness: verify o chiudi

# 5.245: 18.59 harness: verify o chiudi

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0043-rating-contract-on-demand-specific-propagate.story.md` — 5.248: Propagazione "RatingContract non BaseRating" (layer specifico Rating)

# 5.248: Propagazione "RatingContract non BaseRating" (layer specifico Rating)

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0044-close-5240-ratingcontract-children-baserating-not-ratingcontract.story.md` — 5.249: swarm phpstan-D (Incentivi/IndennitaResponsabilita/Rating), chiusura residuo 5.240

# 5.249: swarm phpstan-D (Incentivi/IndennitaResponsabilita/Rating), chiusura residuo 5.240

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0045-select-altro-note-obbligatoria.story.md` — Story Rating/5.99

# Story Rating/5.99

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0050-auditcoverage-reinjection-legacy.story.md` — auditcoverage-reinjection-2026-09-24

# auditcoverage-reinjection-2026-09-24

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0052-auditcoverage-reinjection.story.md` — auditcoverage-reinjection-2026-09-24

# auditcoverage-reinjection-2026-09-24

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0054-cleanup-rating-legacy.story.md` — Story: Cleanup Rating Module

# Story: Cleanup Rating Module

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0056-cleanup-rating.story.md` — Story: Cleanup Rating Module

# Story: Cleanup Rating Module

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0058-cluster-3-rating-xot-phpstan-l10.story.md` — Cluster 3: PHPStan L10 Rating + Xot

# Cluster 3: PHPStan L10 Rating + Xot

## Context and Problem Statement

This cluster is part of the PHPStan L10 fleet remediation swarm. Cluster 3 focuses on two important modules:
- **Rating**: 13 errors, all false positives (alreadyNarrowedType from PHPDoc)
- **Xot**: Large module (338 files), full-tree scan timeout, requires scoped strategy

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome


### `bmad/stories/0059-conflict-marker-resolution-phpstan-bootstrap.story.md` — Conflict marker resolution: PHPStan bootstrap unblock (story 8.23)

# Conflict marker resolution: PHPStan bootstrap unblock (story 8.23)

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0060-continuazione-domani.story.md` — Continuazione domani

# Continuazione domani

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0061-devin-session-bmad-gaps-root-cause.story.md` — Story: Perché Devin ha mancato story BMAD in questa sessione (root cause propria)

# Story: Perché Devin ha mancato story BMAD in questa sessione (root cause propria)

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0062-docs-filename-no-date-bonifica-rating.story.md` — Rating: .md senza data/timestamp nel nome (batch trovato 2026-09-22)

# Rating: .md senza data/timestamp nel nome (batch trovato 2026-09-22)

## Context and Problem Statement

Direttiva utente questa sessione: nessun filename `.md` con data o timestamp.
Stesso batch di lavoro di [[docs-filename-no-date-bonifica-xot]] (Xot),
perimetro Rating.

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome


### `bmad/stories/0063-docs-reorg-domain.story.md` — Story: Indice docs canonico Rating

# Story: Indice docs canonico Rating

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0064-docs-zen-conventions.story.md` — Rating: bonifica docs `.md`

# Rating: bonifica docs `.md`

## Context and Problem Statement

Il rumore in `docs/` (copie esatte, varianti `_`/MAIUSCOLO/`-2`, stub generati, template di prodotto
generici) degrada QMD e confonde gli agenti. Obiettivo: una copia canonica per contenuto, nomi kebab,
frontmatter con `title` + `qmd` ovunque, link aggiornati.

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome


### `bmad/stories/0065-git-status-fleet-merge-markers-rating.story.md` — git-status-fleet-merge-markers-rating

# git-status-fleet-merge-markers-rating

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0068-phpstan-baserating-getvaluehtml.story.md` — Story — PHPStan parse `getValueHtml`

# Story — PHPStan parse `getValueHtml`

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0069-phpstan-fix-rating.story.md` — Story Rating/phpstan-fix-rating

# Story Rating/phpstan-fix-rating

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0071-phpstan-fleet-fix.story.md` — phpstan-fleet-fix-2026-09-23 — unico finding reale su tutto Modules/

# phpstan-fleet-fix-2026-09-23 — unico finding reale su tutto Modules/

## Context and Problem Statement

Chiudere ogni segnalazione phpstan residua sull'intero albero `Modules/`.
"Ponytail" non e' un tool da installare: e' gia' una metodologia documentata
nel repo (`docs/modules/ponytail.md`, Lazy Senior Developer Philosophy,
scala YAGNI). Applicarla qui vuol dire: non installare nulla (la filosofia
c'e' gia'), e non forzare uno swarm multi-agente per un solo finding banale —
proporzionare lo sforzo al lavoro reale trovato.

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

### `bmad/stories/0072-phpstan-modules-zero.story.md` — Story: PHPStan zero — Rating

# Story: PHPStan zero — Rating

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0074-phpstan-post-sync-restore.story.md` — phpstan-post-sync-restore-2026-09-24

# phpstan-post-sync-restore-2026-09-24

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0077-quality-gates-phpstan-swarm-legacy.story.md` — Story Rating/quality-gates-phpstan-swarm-2026-09-23

# Story Rating/quality-gates-phpstan-swarm-2026-09-23

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0078-quality-gates-phpstan-swarm.story.md` — Story Rating/quality-gates-phpstan-swarm-2026-09-23

# Story Rating/quality-gates-phpstan-swarm-2026-09-23

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0079-rating-assert-subclassof-to-ratingcontract.story.md` — Story: `Assert::subclassOf(BaseRating)` → `Assert::implementsInterface(RatingContract)`

# Story: `Assert::subclassOf(BaseRating)` → `Assert::implementsInterface(RatingContract)`

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0080-rating-contract-assert-subclass.story.md` — BMAD: ratingdata-ratingcontract-assert-subclass

# BMAD: ratingdata-ratingcontract-assert-subclass

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/5.229-ratingdata-getxlsfields-move.md` — 5.229: `HasRatingsTrait::ratingXlsFields` → `RatingData::getXlsFields`

# 5.229: `HasRatingsTrait::ratingXlsFields` → `RatingData::getXlsFields`

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/continuazione-domani.md` — Rating: Continuazione Domani

# Rating: Continuazione Domani

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/rating-5.99-review-improvements-bmad-story.md` — Review Rating/5.99 'altro' feature implementation: BMAD story

# Review Rating/5.99 'altro' feature implementation: BMAD story

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad-brainstorming.md` — Domanda guida


# Domanda guida

Quando un rating e prova di qualita del servizio e quando e solo rumore post-chiusura?

## 5 Whys (sintesi)

1. L'utente sente frizione o opacita sul valore di **Rating**.
2. La frizione nasce da confini poco chiari tra owner e consumer.
3. I confini si offuscano quando UI, persistenza e policy vivono nello stesso file "comodo".
4. Senza contratto, ogni fix locale crea una seconda verita.
5. Serve planning BMAD + blueprint Filament + docs owner come unica memoria operativa.

## Starbursting

- **Chi:** cittadino post-chiusura, analyst PA
- **Cosa:** Raccogliere feedback polimorfico affidabile dopo un esito civico eleggibile.
- **Quando:** a ogni incremento che tocca questo owner; decisioni in decision-log.
- **Dove:** `laravel/Modules/Rating/docs/` (+ `docs/bmad/`).
- **P

### `bmad-remaining-work.md` — Rating Module: BMAD Stories & Remaining Work


# Rating Module: BMAD Stories & Remaining Work

## Module Overview
The Rating module provides user and content rating functionality.

## Remaining Work
1. PHPStan Zero Verification ✅
2. Rating Mechanisms: Verify rating models and actions
3. Module Documentation 📋
4. Test Coverage 📋
5. BMAD Stories 📋

## Next Actions
- Create module-specific story files
- Verify contracts pass PHPStan level 10
- Add gate files

### `bugfix-supported-locale-translation-and-morph-table-name.md` — Rating: 3 fix in questa sessione


# Rating: 3 fix in questa sessione

## 1. `HasRating`: trait.unused (PHPStan)

`Modules/Rating/app/Models/Traits/HasRating.php` è un trait libreria pensato
per essere composto in modelli di **altri** moduli (`use HasRating;`), ma
nessun modello nello scope analizzato lo consuma attualmente. Pattern vietato:
creare un modello/probe finto solo per "usarlo" (vedi
`Modules/Xot/docs/wiki/concepts/phpstan-trait-probes.md`: questa esatta
combinazione, "Probe Rating legacy", è già citata come incidente storico da
non ripetere).

Fix: `/** @phpstan-ignore trait.unused */` sopra `trait HasRating`.

## 2. `SupportedLocale::getLabel()`: traduzione mancante

`Modules/Rating/app/Enums/SupportedLocale.php` usa `EnumTrait` →
`TransTrait::transClass()`, che ritorna deliberatamente `'fix:'.$key` quando
la 

### `case-sensitivity-rules.md` — Case Sensitivity Rules - Rating Module


# Case Sensitivity Rules - Rating Module

## Problema / Problem

**NON possono esistere file con lo stesso nome che differiscono solo per maiuscole/minuscole nella stessa directory.**

Riferimento completo: [Xot Module Case Sensitivity Rules](../../Xot/docs/case-sensitivity-rules.md)

## File/Directory Rimossi da Rating Module

I seguenti file/directory sono stati eliminati perché violavano le regole:

```
✗ Removed: database/Seeders/ (entire directory)
✓ Kept:    database/seeders/
```

## Convenzioni


### `chat/children-relationmanager-parent-id-hidden.md` — ChildrenRelationManager: `parent_id` nascosto e valorizzato: esito e collisione


# ChildrenRelationManager: `parent_id` nascosto e valorizzato: esito e collisione

**Da**: sessione `27de9782` · **A**: `base-ptvx-fila5-92`
**File**: `Modules/Rating/.../RelationManagers/BaseChildrenRelationManager.php`

## Cosa ha chiesto l'utente

Dalla pagina `ratings/52/edit`, premendo «nuovo» nella tabella dei figli, il form deve
arrivare **gia' valorizzato su `parent_id = 52`**: «anzi potrebbe anche essere nascosto
nella creazione del figlio».

## Esito: `Hidden::make('parent_id')` con default dal record aperto

```php
$schema['parent_id'] = Hidden::make('parent_id')
    ->default(function (): int|string|null { … $this->getOwnerRecord()->getKey() … });
```

Nascosto **e** valorizzato: copre entrambe le forme che l'utente ha indicato.

### `code-redundancy-audit.md` — Code redundancy audit — Rating


# Code redundancy audit — Rating

## Scopo

Ridurre rumore, duplicazione e ambiguita' nel codice di questo module, senza perdere conoscenza storica.

## Metriche

| Voce | Valore |
|---|---:|
| File PHP analizzati | 73 |
| Rischio ridondanza | medium |
| Basename duplicati locali | 5 |
| Hash normalizzati duplicati cross-owner | 1 |
| Class/trait/interface name ripetuti nel monorepo | 12 |
| File grandi >=350 righe | 0 |
| File PHP con marker Git | 0 |

## Evidenze

### `codex-error-fix.md` — codex-error-fix


See canonical documentation: ../../../Themes/docs/shared-components/codex-error-fix.md

### `completion-backlog.md` — Rating: completion backlog

# Rating: completion backlog

Status: partial and evidence-driven. This file is the canonical owner-local list for future work.

## Scope

This owner covers rating eligibility, anti-abuse, aggregation, authorization and ticket lifecycle coupling.

## Remaining work

- [ ] Inventory public, admin, queued and integration entry points; link each to a caller and test.
- [ ] Verify source purpose and domain invariant before editing any diagnostic or duplication.
- [ ] Audit authorization, privacy, nullable relations, localization and failure paths.
- [ ] Run focused syntax/PHPStan/tests from the documented Laravel root; mark bootstrap failures UNVERIFIED.
- [ ] Review Filament resources against XotBase and shared components against the data-driven reuse rule.
- [ ] Consolidate contradictory sta

### `completion-status.md` — Rating: cosa manca per completare


# Rating: cosa manca per completare

Fotografia misurata il 2026-10-28 (sola lettura). Si rigenera con gli stessi controlli: story nel frontmatter,
PHPStan livello 10, blade troncate, traduzioni, test. Riepilogo di progetto: `Modules/Xot/docs/project-completion-status.md`.

## Indicatori

| Indicatore | Valore |
|---|---|
| File PHP in `app/` | 73 |
| Errori PHPStan livello 10 | 0 |
| Blade (troncate in testa) | 16 (0) |
| File di test (`*Test.php`) | 29 |
| TODO/FIXME nel codice | 0 |
| Traduzioni it / en (solo in it) | 23 / 0 (23) |
| Story/epic BMAD (aperte) | 149 (89) |

## Problemi noti e prossimi passi


### `concepts/xotbase-never-extend-filament.md` — Mai `Filament\*`: sempre `Modules\Xot\Filament\...\XotBase*`


# Mai `Filament\*`: sempre `Modules\Xot\Filament\...\XotBase*`

Bridge on-demand. Contenuto canonico: [docs/wiki/rules/xotbase-critical-rules.md](../../../../../docs/wiki/rules/xotbase-critical-rules.md).

## Zen (riassunto)

Nessuna classe in `Modules/Rating` estende una classe `Filament\...` direttamente.
Si estende sempre lo "specchio" in `Modules\Xot\Filament\...` allo stesso
percorso relativo (es. `Filament\Tables\Columns\ViewColumn` ->
`Modules\Xot\Filament\Tables\Columns\XotBaseViewColumn`). Se manca il
mirror, va creato in Xot prima di usarlo qui, mai come scorciatoia nel modulo.

Non pre-caricare questo file: leggi la fonte canonica solo quando il task lo richiede.

### `configuration.md` — Rating Module Configuration


# Rating Module Configuration

## `composer.json` Dependencies

The `composer.json` file for the Rating module (`laravel/Modules/Rating/composer.json`) defines its core dependencies and development tools.

### `require` Section

This section lists the essential packages required for the module to function correctly. Adherence to semantic versioning is crucial, typically using caret (`^`) or tilde (`~`) operators to allow for patch and minor updates while preventing breaking changes.

```json
"require": {
    "spatie/laravel-schemaless-attributes": "^3.0",
    "laravel/framework": "^12.0",
    "filament/filament": "^5.0"
}
```

*   `spatie/laravel-schemaless-attributes`: Essential for handling flexible, schemaless data structures within the module's Eloquent models.

### `conflict-resolution.md` — Conflict Resolution: Module Rating


# Conflict Resolution: Module Rating

## Summary
- **Files resolved**: 1
- **Strategy**: Keep HEAD/local (ours) side
- **Root cause**: Nested stash-on-merge conflicts

## Config Files
- composer.json

## Backlinks
- [Root conflict resolution report](../../../../docs/conflict-resolution-report.md)

### `contracts/get-count-by-model-rating-id-action.md` — GetCountByModelRatingIdAction


# GetCountByModelRatingIdAction

Conta i voti ricevuti da un modello valutabile. Codice: `app/Actions/HasRating/GetCountByModelRatingIdAction.php:21-30`.

## Input

- `HasRatingContract $model`: modello con relazione `ratings()` (MorphToMany).
- `?string $rating_id`: se valorizzato, limita il conteggio a quel criterio.

## Output

- `float` dichiarato: il valore reale è il `int` restituito da `count('rating_morph.value')` (riga 29), convertito dal tipo di ritorno.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `RATING-COUNT-INV-1` | Sono contati solo i voti del pivot con `user_id` non nullo. | righe 24, 29 | `tests/Unit/HasRatingActionsTest.php:31` |
| `RATING-COUNT-INV-2` | Con `$rating_id` il conteggio è ristretto al pivot di quel `rating_id`. | righe 25-2

### `contracts/get-rating-opts-by-model-action.md` — GetRatingOptsByModelAction


# GetRatingOptsByModelAction

Elenca i criteri (opzioni di voto) associati a un modello, cioè le righe pivot senza votante. Codice: `app/Actions/HasRating/GetRatingOptsByModelAction.php:21-34`.

## Input

- `HasRatingContract $model`: modello con relazione `ratings()` (MorphToMany).

## Output

- `array<int, string|null>`: mappa `ratings.id` => titolo; il titolo è `null` se non è una stringa (righe 25-33).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `RATING-OPTS-INV-1` | Sono elencate solo le righe pivot con `user_id` nullo (opzioni, non voti). | riga 27 | `tests/Unit/HasRatingActionsTest.php:75` |
| `RATING-OPTS-INV-2` | Le chiavi sono `int` (cast da `ratings.id`). | riga 31 | Test: nessuno |
| `RATING-OPTS-INV-3` | Un titolo non stringa diventa `null` i

### `contracts/get-sum-by-model-rating-id-action.md` — GetSumByModelRatingIdAction


# GetSumByModelRatingIdAction

Somma i voti ricevuti da un modello valutabile. Codice: `app/Actions/HasRating/GetSumByModelRatingIdAction.php:21-31`.

## Input

- `HasRatingContract $model`: modello con relazione `ratings()` (MorphToMany).
- `?string $rating_id`: se valorizzato, limita la somma a quel criterio.

## Output

- `float`: somma di `rating_morph.value`; `0.0` se il risultato non è numerico (riga 30).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `RATING-SUM-INV-1` | Sono sommati solo i voti del pivot con `user_id` non nullo (voti senza votante esclusi). | righe 24, 28 | `tests/Unit/HasRatingActionsTest.php:43` (somma; esclusione `user_id` nullo non esplicita nel nome del test) |
| `RATING-SUM-INV-2` | Con `$rating_id` la somma è ristretta al pivo

### `contracts/rating-morph-policy.md` — RatingMorphPolicy


# RatingMorphPolicy

Decide chi può vedere, creare, modificare e cancellare una valutazione (`RatingMorph`), cioè dati personali di valutazione. Contratto non-Action (policy), quindi senza le sei sezioni obbligatorie delle Action: descrive la superficie di autorizzazione. Codice: `app/Models/Policies/RatingMorphPolicy.php:11-102`.

## Invarianti

| ID | Regola | Prova nel codice | Test esistente (senza group) |
|---|---|---|---|
| `RATING-POLICY-INV-1` | `viewAny` e `create` ammettono `super-admin`, `admin`, `hr-manager`, `evaluator`. | righe 16-19, 34-37 | `tests/Unit/RatingPolicyRolesTest.php:91,106,117` |
| `RATING-POLICY-INV-2` | `view` e `update`: sempre `super-admin`, `admin`, `hr-manager`; `evaluator` solo se `user->id === model->user_id`; inoltre chi ha un profilo ed è proprietari

### `contracts-naming.md` — Contracts Naming & Placement in Rating


# Contracts Naming & Placement in Rating

> A contract is an **agreement**, not a PHP keyword. We name it `*Contract` and place it under `app/Contracts/`.

## Rule

- ✅ `app/Contracts/ExampleContract.php`
- ❌ `app/Interfaces/ExampleInterface.php`

## Why

- `Contract` describes the domain concept (a pact between components).
- `interface` describes a PHP implementation detail.
- One folder (`app/Contracts/`) keeps the module language consistent and reduces cognitive noise.
- Aligned with Laravel `Illuminate\Contracts\*` convention.

## Verification

```bash

### `copilot-redundancy-audit.md` — copilot-redundancy-audit

Copilot Redundancy Audit — 2026-05-25

Sintesi
- Documentazione di rating e componenti correlati presente in più posizioni.

Raccomandazioni
- Consolidare pattern di rating e API in un documento riutilizzabile e linkarlo nei moduli che ne fanno uso.

Autore: Copilot CLI

### `cosa-migliorare.md` — Cosa migliorare: modulo Rating


# Cosa migliorare: modulo Rating

Ogni affermazione qui sotto viene da un comando eseguito il 1 settembre 2026, dopo il
ripristino di `vendor/` a 330 pacchetti. Le misure precedenti a quella data giravano su
un autoloader dimezzato e non valgono.

## I numeri

| | |
|---|---:|
| Errori PHPStan (modulo isolato) | 0 |
| Rilievi PHPMD su `app/` | 38 (sottostima: parse error) |
| PHPInsights: Code | 97.6 % |
| PHPInsights: Architecture | 78.6 % |
| PHPInsights: Style | 93.8 % |
| File PHP | 132 |
| Casi di test | 125 |
| Casi di test per file | 0.95 |
| Coverage di riga | 80.8 |

### `coverage-pest.md` — RATING — Coverage Target\n- Pest test directory: tests/\n- Coverage minimo: 80%\n- Fixture: app/Fixt


# RATING — Coverage Target\n- Pest test directory: tests/\n- Coverage minimo: 80%\n- Fixture: app/Fixtures/ quando necessario per PHPStan\n- Regola: git solo avanti, .md senza date

### `coverage.md` — Coverage del modulo Rating


# Coverage del modulo Rating

## PHPStan: 22 settembre 2026 (gate post `stuck-rebase-real-divergence-recovery`, commit `d80dc62`)

Baseline dichiarata dal recovery: **9 errori pre-esistenti** su
`RatingsHostStub::ratingValuePath()` non definito. Verificato con `git log -S"ratingValuePath"`
nel repo del modulo: introdotto dal recovery `d80dc62`/dal WIP della story
`18.56.ratings-by-id-accessor` (già `status: done` nella sua story), non da questa sessione.

Fix chiusi (dettaglio in `docs/stories/18.56.ratings-by-id-accessor.story.md#Dev-Agent-Record`):

- `HasRatingsTrait::ratingValuePath()`: `$rating->getKey()` (mixed, `Model::getKey()` non
  tipizzato nel vendor Eloquent) → `$rating->id` (tipizzato `int` da `@property int $id` su
  `BaseRating`). Risolveva `binaryOp.invalid` fra `'ratings

### `criteri-a-scelta-multipla.md` — Criteri a scelta: opzioni in JSON, figli del criterio, o altro


# Criteri a scelta: opzioni in JSON, figli del criterio, o altro

## Risposta breve

Fra le due strade proposte, i **figli** reggono meglio delle **opzioni in JSON**, ma nessuna
delle due va decisa per prima: prima il criterio deve dichiarare **di che tipo e'**, perche'
oggi lo si deduce confrontando il titolo con una lista di stringhe italiane dentro
un'Action. Senza quel dato, un criterio a scelta entra nel totale senza che nessuno lo abbia
deciso.

## Le sei strade a colpo d'occhio

| | dove stanno le opzioni | l'opzione e' | sopravvive a un rename | costo | quando e' la scelta giusta |
|---|---|---|---|---|---|
| **A** | `extra_attributes.options` (JSON) | un valore | no | nullo | poche voci, nessuno che debba puntarle |
| **B1** | figli del criterio, voto sul figlio | un'entita' | si

### `cyclomatic-complexity-report.md` — Cyclomatic Complexity Report - Module: Rating


# Cyclomatic Complexity Report - Module: Rating

**Generated:** 2025-10-01 19:44:11  
**Analyzer:** Super Mucca 🐮

---

## 📊 Summary Statistics

| Metric | Value |
|--------|-------|
| Total PHP Files | 71 |
| Total Lines of Code | 2914 |
| Total Classes/Traits/Interfaces | 51 |
| Total Methods | 99 |
| High Complexity Methods (>10) | 0 |

---


### `dataobjects-archived-duplicate.md` — DataObjects/RatingData rimossa definitivamente


# DataObjects/RatingData rimossa definitivamente

La cartella `app/DataObjects/` e il file `RatingData.php.old` sono stati
**rimossi definitivamente** dal modulo Rating. Conteneva un duplicato morto
(final readonly class RatingData, non estende `Spatie\LaravelData\Data`)
senza nessun utilizzatore nel repo.

## Azione

- Eliminata `Modules/Rating/app/DataObjects/`
- Eliminato `Modules/Rating/app/DataObjects/RatingData.php.old`

## Regola

- Solo `Modules\<M>\Datas\<Nome>Data extends Spatie\LaravelData\Data`.
- Vedi `Modules/UI/docs/datas-not-dtos-convention.md`.

### `decision-log.md` — Decision Log: Rating

# Decision Log: Rating

## Decisions
## Open Questions


### `dove-vive-un-contratto.md` — Dove vive un contratto


# Dove vive un contratto

## La regola, in una riga

**Un contratto che solo un model puo' implementare sta in `app/Models/Contracts/`.
Tutti gli altri in `app/Contracts/`.**

## Il perche': e non e' l'estetica della cartella

Il contratto **dichiara da se'** dove va. Se porta

```php
@phpstan-require-extends Model
```

allora nessuna classe che non sia un model puo' implementarlo: la domanda «dove lo metto»
e' gia' chiusa dal contratto, e metterlo altrove significa scrivere una cosa e archiviarla
come un'altra. Non serve una convenzione da ricordare: serve leggere il file.


### `dry-kiss-analysis.md` — 🐄 DRY & KISS Analysis - Rating


# 🐄 DRY & KISS Analysis - Rating

**Data:** 2025-10-15 | **Status:** ✅

## 📊 Struttura
Models: 8 | Resources: 2 | Actions: 3 | Docs: 15

## 🎯 Score: 9/10 🟢 **ECCELLENTE**

## ✅ PERFETTO
- BaseModel: GIÀ ottimizzato ⭐
- Minimal & focused ⭐
- Docs minime (15) ⭐

## ⚠️ MIGLIORAMENTI MINIMI
Resources (2): Helpers (~40 LOC)

**Status:** 🟢 **ECCELLENTE**


### `false-friends.md` — False Friends – Rating


# False Friends – Rating

| Falso Amico | Perché è fuorviante | Soluzione |
|-------------|---------------------|-----------|
| `rating_count` = `reviews_count` | Conta anche rating senza testo | Usa `review_count()` distinto |
| `avg(rating)` = `popularity` | Ignora il numero di voti | Normalizza per numero voti |
| 4.5 ⭐ è "ottimo" | Dipende da scala e contesto | Definisci soglie chiare |
| Rating sempre crescente | Non considera il tempo | Usa weighted average |

### `faq.md` — Rating Module - FAQ


# Rating Module - FAQ

Frequently asked questions and quick answers.

## General Questions

### What is the Rating module for?
Provides a reusable, generic rating system for any entity (products, services, users, etc.) in your Laraxot application. Supports 1-5 star ratings, comments, and flexible scoring criteria.

### Can I rate anything?
Yes. Any model can be rated via polymorphic relations. Add `HasRatingsTrait` to your model, and it automatically supports ratings.

### Does Rating depend on User module?
No. Rating is standalone. It stores `user_id` as a foreign key but doesn't import User classes. Any user-like entity works.

### Can multiple modules use Rating?
Yes. That's the design. User, Product, Service, Employee modules can all consume Rating independently via the trait.

### Is

### `filament-table-architecture.md` — La tabella si configura nella Table class, non nella pagina


# La tabella si configura nella Table class, non nella pagina

Vale per ogni Resource di questo modulo.

## La regola

Colonne, filtri e azioni di una Resource stanno in
`app/Filament/Resources/<Nome>Resource/Tables/<Plurale>Table.php`, che estende
`Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable`.

**Non** nella pagina `Pages/List<Plurale>.php`. Quello che scrivi li' dentro non viene
letto da nessuno.

```php
namespace Modules\Rating\Filament\Resources\FooResource\Tables;

use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class FoosTable extends XotBaseResourceTable

### `filament-version.md` — Filament Version Declaration: Rating


# Filament Version Declaration: Rating

**Current Version**: Filament v5 (Livewire v4 + Schemas)

This module/theme is developed against **Filament v5**.

All resources, forms, tables, infolists, widgets and actions must follow the v5 + XotBase patterns documented in:

- `docs/wiki/rules/filament-rules-summary.md`
- `docs/wiki/memories/filament-version-policy.md`
- `laravel/Modules/Xot/docs/filament-5-laraxot-rules.md`

**Legacy v4 documents** in this folder (if any) are historical only and must not be used as current reference.

**Last verified**: 2026-05-21

**Firmato:** Cursor Agent (Composer): template propagato ai package `docs/`

### `file-naming-rules.md` — file-naming-rules


See canonical documentation: ../../../Themes/docs/shared-components/file-naming-rules.md

### `fixtures-purpose.md` — fixtures-purpose

Scopo fixtures: forniscono host concreti per i trait (HasRating) così PHPStan analizza il corpo del trait (senza consumatori reali il corpo è ignorato). Spostati in app/Fixtures/ per mantenere utilità senza violare la regola 'no Tests dirs' nei moduli.

### `git-multi-org-sync-handoff.md` — Handoff: multi-org sync (STORY-003)


# Handoff: multi-org sync (STORY-003)

## Scopo

Allineare questo owner ai remote raggiungibili (**0 0**, working tree clean) e documentare decisioni di sessione 2026-07-21.

## Perché

Un tree dirty o un remote dietro/avanti **non** è sincronizzato, anche se l’altro org è a posto. Su PTVX i path vivono in `gitmodules.ini` con org `provtv` (+ `laraxot` se esiste).

## Link

| Tipo | URL |
|------|-----|
| Issue owner | https://github.com/provtv/module_rating_fila5/issues/14 |
| Discussion | https://github.com/provtv/<nome repository>/discussions/204 |
| Hub base issue | https://github.com/provtv/<nome repository>/issues/203 |
| Hub base discussion | https://github.com/provtv/<nome repository>/discussions/204 |
| Story monorepo | `docs/stories/STORY-003-multi-org-sync-geo-boundary-bashscri

### `glossary.md` — Glossario di dominio Rating


# Glossario di dominio Rating

Se glossario e codice divergono vale il codice. Percorsi relativi a `laravel/Modules/Rating/`.

| Termine | Significato | Nel codice |
|---|---|---|
| Rating (criterio) | Voce del catalogo condiviso su cui si vota; può avere attributi extra schemaless. | `app/Models/Rating.php`, `app/Models/BaseRating.php` (`extra_attributes`) |
| Voto (rating morph) | Il voto effettivo di un criterio su un modello, sul pivot `rating_morph`, con campo `value`. | `app/Models/RatingMorph.php`, `app/Models/BaseRatingMorph.php:97`, `app/Datas/RatingMorphData.php` |
| Host valutabile | Modello che può ricevere voti; espone la relazione `ratings()` (`MorphToMany`). | `app/Models/Contracts/HasRatingContract.php`, `app/Models/Traits/HasRatingsTrait.php` |
| Host astratto | Ancora pe

### `graphify-map.md` — Rating Module: Mappa Graphify


# Rating Module: Mappa Graphify

**Versione:** 1.1.0 | **Modulo:** Rating | **Data:** 2026-08-02

---
## 📌 Cosa fa il modulo Rating

Il modulo **Rating** gestisce:
- **Valutazioni polimorfiche**: Rating riusabile su qualsiasi modello (users, media, content, scede)
- **Aggregazioni in tempo reale**: sum, count, average delle valutazioni per entity
- **Like system**: Support per like/dislike tramite RatingMorph pivot
- **Schemaless attributes**: Campi custom con validazione rule-based
- **Media integration**: Attachment di immagini/icone via Spatie MediaLibrary

---

## 🏗️ Architettura Essenziale

### Entry Points

### `index-generated.md` — Rating Module Documentation Index


# Rating Module Documentation Index

**Stats**: 151 files | 18 categories | Last update: 2026-07-28 11:34

## Quick Navigation

- [Architecture](rating-architecture.md) | [Analysis](code-quality-analysis.md) | [Wiki](wiki/) | [Raw](raw/) | [Roadmap](roadmap/)
- [Configuration](configuration.md) | Models | [Concepts](wiki/concepts/)

## Documentation by Category

### Root (89 files)

The root level contains strategic documents, analyses, and consolidated guides:

- [00-INDEX.md](00-index.md)
- [00-index.md](00-index.md)
- [INDEX.md](index.md)
- [index.md](index.md)

### `investigation/investigation.md` — Investigation: Aggregation Model

# Investigation: Aggregation Model

## Problem Statement
Analisi delle feature mancanti nel modulo Rating.

## Current State
- Documentazione esistente: 67 stories
- Architettura: Actions,Aggregates,Console,Contracts,DataObjects,Datas,Enums,Filament,Http,Models,Providers,View,

## Feature Missing
1. Feature A - descrizione
2. Feature B - descrizione
3. Feature C - descrizione

## Proposed Solution
- Implementare le feature A/B/C usando le regole BMAD
- Seguire: no controller, no services layer, module providers manifest

## Acceptance Criteria
- [ ] APCA contrast ≥75 body, ≥45 large-bold

### `laravel-13-upgrade.md` — Upgrade Laravel 13 - Rating 🐄✨


# Upgrade Laravel 13 - Rating 🐄✨

## 🎯 Visione Architetturale
L'upgrade a Laravel 13 per il modulo **Rating** non è un mero aggiornamento tecnico, ma un atto di purificazione zen. Seguendo i dettami della **Super Mucca**, ogni riga di codice è stata meditata per raggiungere la massima indipendenza.

## 🧘 Principi Applicati
1.  **Isolamento (SOLID)**: Il modulo dichiara ora esplicitamente le proprie dipendenze, riducendo l'accoppiamento con il core.
2.  **Semplicità (KISS)**: Rimossi i wrapper obsoleti e le dipendenze ridondanti.
3.  **Memoria (Documentation)**: Questo documento funge da memoria persistente dell'evoluzione del modulo.

## 🛠️ Modifiche Eseguite
- [x] **PHP ^8.4**: Allineamento ai requisiti di Laravel 13.
- [x] **composer.json**: Aggiornato con `laravel/framework: ^13.0` e `

### `merge-conflict-files-list.md` — merge-conflict-files-list


See canonical documentation: ../../../Themes/docs/shared-components/merge-conflict-files-list.md

### `merge-conflicts-list.md` — merge-conflicts-list


See canonical documentation: ../../../Themes/docs/shared-components/merge-conflicts-list.md

### `metodi-duplicati-analisi.md` — 🐄⚡ ANALISI METODI DUPLICATI - SUPER MUCCA EDITION


# 🐄⚡ ANALISI METODI DUPLICATI - SUPER MUCCA EDITION

**Powered by**: Super Mucca AI 🐄✨  
**Data**: 15 Ottobre 2025  
**Versione**: 2.0 ULTIMATE  
**Confidenza**: 99.9% (Dati Reali dal Codice)

---
## 🎯 Executive Summary

Analisi **REALE e APPROFONDITA** di **18 moduli** + **2 temi** del framework Laraxot/Filament.

### Dati Chiave (VERIFICATI)

| Metrica | Valore | Fonte |
|---------|--------|-------|
| **Moduli Analizzati** | 18 | Directory scan |
| **Temi Analizzati** | 2 (Sixteen, TwentyOne) | Directory scan |
| **BaseModel Totali** | 10 | File count |

### `model-factory-coverage.md` — Rating: copertura Model → Migration / Seeder / Factory


# Rating: copertura Model → Migration / Seeder / Factory

Obiettivo: ogni modello concreto (non-pivot / non-astratto) deve avere
migration + seeder + factory.

## Modelli in `app/Models/*.php`

| Modello | Tipo | Tabella | Concreto? | Factory |
|---|---|---|---|---|
| `Rating` | `BaseRating` → `BaseModel` → `XotBaseModel` | `ratings` | sì | **`RatingFactory` (definition realistica)** |
| `RatingMorph` | `BaseMorphPivot` → `MorphPivot` | `rating_morph` | **pivot → skip** |: |
| `BaseRating` | astratto |: | no (abstract) |: |
| `BaseRatingMorph` | astratto |: | no (abstract) |: |
| `BaseModel` | astratto |: | no (abstract) |: |
| `BaseMorphPivot` | astratto |: | no (abstract) |: |

## Lavoro svolto

- `database/factories/RatingFactory.php`: era uno **stub** (`definition()` restituiva

### `module.md` — Rating Module: Doctrine


# Rating Module: Doctrine

## Scope (Scopo)

Rating gestisce valutazioni con scale multiple (stellari, numeriche, like/dislike), votazioni, e attributi schemaless. Trasforma opinioni in dati quantitativi.

## Religion (Religione)

**"Ogni voto è un dato, non un'opinione."** Le valutazioni sono segnali quantificabili: raccolti strutturatamente, analizzabili, aggregabili.

## Philosophy (Filosofia)

- **Inheritance pattern**: BaseRating → Rating
- **Schemaless attributes**: flessibilità per attributi extra
- **Value object**: il rating come oggetto valore
- **Aggregation-ready**: media, somme efficienti
- **Multiple scales**: supporto per scale diverse

## Policy (Politica)

### `multi-org-sync-laraxot-provtv.md` — Sincronizzazione multi-organizzazione (laraxot + provtv)


# Sincronizzazione multi-organizzazione (laraxot + provtv)

## Cosa è stato fatto

Questo repository è tracciato da due remote GitHub (`laraxot` = org upstream canonica,
`provtv` = org operativa del progetto ptvx). Il 2026-07-21 è stata eseguita una
sincronizzazione completa seguendo `bashscripts/tools/prompts/02-gitmodules-sync.md`:
fetch di tutti i remote, quality gates (PHPStan L10, PHPMD), risincronizzazione dopo ogni modifica.

## Problemi riscontrati e risolti

- **Clone shallow**: il repo era stato clonato con storia troncata, causando push
  respinti (`did not receive expected object`). Fix: `git fetch --unshallow` su tutti i remote.
- **Storie scollegate ("unrelated histories")**: alcuni repo avevano un branch `dev`
  remoto rigenerato senza antenato comune con la storia locale. 

### `no-ai-tool-scaffold-dirs.md` — Perché queste cartelle non devono esistere qui


# Perché queste cartelle non devono esistere qui

Regola canonica: [module-theme-root-cleanup.md: Rule 5](../../../../docs/wiki/rules/module-theme-root-cleanup.md).

Rimosse in questo modulo: `_docs/`, `scripts/`, `bashscripts/`, `docs/archive|archived|legacy|workbench/`, `.circleci/`, `.claude-audit/`, `tests/.claude-audit/`, `_bmad-output/`, `test-results/`, `.devcontainer/`, `.kilocode/`, `.kiro/`, `.ralph/` (dove presenti) e aggiunte al `.gitignore` di questo modulo.

**Perché**: questo modulo vive anche come repo Git indipendente (multi-repo); ogni agente/tool AI o pipeline CI che gira in quella root scrive lì la propria cache/scaffold locale (skill `.kiro/`, output `_bmad-output/`, stato `.ralph/`, audit `.claude-audit/`, log `test-results/`), ignorando che quella root è in realtà u

### `no-git-lfs.md` — Git LFS non si usa in questo progetto


# Git LFS non si usa in questo progetto

Vale per il repo root, per `bashscripts/` e per ogni modulo e tema. Questo modulo non fa
eccezione.

## La regola

I binari: immagini, font, PDF, archivi: si versionano come **blob git normali**.

Vietato:

- aggiungere `filter=lfs diff=lfs merge=lfs` in un qualunque `.gitattributes`;
- eseguire `git lfs install` o `git lfs track` dentro questo repo;
- committare come contenuto di un file il testo `version https://git-lfs.github.com/spec/v1`.

## Perche'

Non e' una preferenza di stile, e' il risultato di incidenti ripetuti.


### `nwidart-test-convention.md` — Nwidart Test Convention: Rating

# Nwidart Test Convention: Rating

- Tests: `laravel/Modules/Rating/tests/`.
- Module fixtures: `laravel/Modules/Rating/tests/Fixtures/`.
- Application, cross-module and theme tests may live under `laravel/tests/`.
- Never create a second `laravel/tests/Modules/Rating/` tree.

### `patterns.md` — Architectural Patterns – Rating


# Architectural Patterns – Rating

**Last updated:** 2026-07-28

---

## 🏗️ Core Patterns

### 1. Polymorphic Rating Pattern

**Purpose:** Share rating logic across multiple models (IndennitaResponsabilita, Performance, Progressioni).

**Implementation:**

```php
// Base trait: centralized in Rating module
namespace Modules\Rating\Models\Traits;

trait HasRatingsTrait

### `phpstan-errors-roadmap.md` — PHPStan Level 10 Errors Roadmap - Modulo Rating

> **Superseded / storico.** Canonico modulo: [phpstan-fixes.md](phpstan-fixes.md). Procedura: [11-phpstan.md](../../../../bashscripts/docs/prompts/11-phpstan.md). Indice: [index.md](index.md).

# PHPStan Level 10 Errors Roadmap - Modulo Rating

**Data**: 2026-01-12  
**Modulo**: Rating  
**Livello PHPStan**: 10  
**Status**: ✅ **COMPLETATO - 0 Errori**

---

## 📊 Errori Identificati

### Totale Errori: 2

Entrambi gli errori riguardano PHPDoc con classi sconosciute.

1. **`app/Models/Rating.php`** (Linea 121)
   - **Errore**: `PHPDoc tag @property for property $creator contains unknown class Modules\Fixcity\Models\Profile`
   - **Tipo**: `class.notFound`

### `phpstan-l10.md` — PHPStan Level 10 Compliance: Rating Module


# PHPStan Level 10 Compliance: Rating Module

## Summary

| Aspect | Value |
|--------|-------|
| **PHPStan L10** | ✅ 0 errors |
| **Status** | Complete |
| **Last verified** | 2026-08-02 |

## Patterns Applied

### 1. Rating Model Types
```php
/**
 * @return Collection<Rating>
 */
public function ratings(): Collection { }


### `phpstan-linked-to-contract.md` — Contratto linkedTo e accesso a parent_id


# Contratto linkedTo e accesso a parent_id

Ripresa della [story BMAD 5.79](../../../../docs/stories/0053-5-79-phpstan-542-errori-swarm-xot-user-longtail.story.md),
scope `codex-rating`. Il coordinatore possiede PHPStan e la cache condivisa;
il worker modifica sotto lock soltanto il metodo di relazione, l'accesso nel test
e questa documentazione. Nessuna modifica a schema o migrazioni.

## Evidenza e correzione

`git log -S 'function linkedTo'` nel repository principale identifica il commit
`2c7055584f`: durante il refactor adjacency list viene eliminato anche `linkedTo()`.
Il trait `HasRecursiveRelationships` fornisce le relazioni gerarchiche, ma non
questa relazione polimorfica. La storia del repository Rating, commit `60cc54b`,
conserva il contratto precedente:

```php
/** @return Morp

### `phpstan-swarm.md` — PHPStan swarm — Rating (2026-09-07)


# PHPStan swarm — Rating (2026-09-07)
- 815 errori iniziali mappati (subagent PHPStan)
- Corretto SupportedLocale::toArray() (override esplicito)
- DB irraggiungibile → Pest saltato
- Lock mantenuto fino a chiusura su richiesta
- Second brain aggiornato in docs/chat/quality-gates-swarm.md


### `ponytail-audit-over-engineering.md` — Ponytail audit: Rating (over-engineering)


# Ponytail audit: Rating (over-engineering)

**Ultimo run:** 2026-06-30  
**Hub:** [../../../../docs/audit/ponytail-audit.md](../../../../docs/audit/ponytail-audit.md)
**Remediation:** [../../../../docs/project/ponytail-audit-remediation.md](../../../../docs/project/ponytail-audit-remediation.md)
**GitHub monorepo:** [Issue #221](https://github.com/laraxot/<nome repository>/discussions/228)

## Esito run 2026-06-30

Lean già sul perimetro codice principale. Nessun finding P0–P1 nel run repo-wide.

Eventuali voci storiche (ActivityLogger, contratti Geo) sono in [docs/audit/ponytail-audit.md](../../../../docs/audit/ponytail-audit.md).

## Collegamenti

- [wiki/concepts/quality-testing-verification.md#ponytail-audit](./wiki/concepts/ponytail-audit.md)

### `project-completion-gaps.md` — Lacune di completamento: Rating


# Lacune di completamento: Rating

## Esito

Questo censimento documentale non certifica il completamento funzionale del module.
Il completamento resta **non dimostrato** finché non sono chiusi e verificati i criteri
sotto elencati e le story aperte del modulo/tema in `docs/sprint-status.yaml`.

## Evidenza documentale rilevata

- Markdown sotto `docs/`: **567**.
- Story BMAD trovate (`*.story.md`): **149**; il conteggio non implica che siano
  concluse né che coprano tutti i requisiti.
- Frontmatter iniziale presente: **563/567**.
- README/purpose mancanti: Nessun README/purpose mancante nella verifica.
- Controllo frontmatter: 4 Markdown senza frontmatter rilevato con controllo apertura file (`---` iniziale); correggere e validare il frontmatter.

## Lavoro necessario per poter chiudere

### `prompts/01.md` — 01


in laravel/Modules/Rating/app/Models/BaseRating.php ci deve essere use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
e non andiamo a replicare metodi come parent o children analizza a fondo il tuo errore e fa tutto il possibile a fin che non capiti mai piu' , come sempre devi fare tutto con bmad + second brain 

studia a fondo laravel/Modules/Rating/app/Models/Traits/HasRatingsTrait.php come vedi abbiamo il select , dobbiamo aggiungere "altro" e se selezionato la texarea "note" del rating morph deve essere obbligatoria , non devi fare codice , devi solo documentare e fare tutti i documenti bmad

percio' quando rating ha figli mostra 2 campi il select e una textarea , il valore del select viene salvato nel ratingmorph campo value e il valore della textarea nel ratin

### `prompts/02.md` — 02


in 'export_xls' => ExportXlsAction::make('export_xls'), se un rating ha children non devi mostrare il valore , ma mostrare il campo txt del rating con quell'id per capire meglio potresti studiare laravel/Modules/Rating/app/Models/Traits/HasRatingsTrait.php  ma dato che dobbiamo sempre pensare a componenti riutilizzabili penso che dovrei lavorare dentro il metodo getXlsFields di IndennitaResponsabilitaResource , anche perche' se il rating ha figli bisogna aggiungere anche il campo note sempre di quel pivot , come sempre analizza a fondo, ragiona a fondo, capisci lo scopo e prima crea tutti i documenti di bmad, poi li ristudi, poi implementi poi controlli 

### `purpose.md` — Rating: perche' esiste


# Rating: perche' esiste

## Lo scopo in una frase

**Rating rende "dare un punteggio a qualcosa" un meccanismo unico e riusabile, invece
di una tabella di voti reinventata in ogni modulo che valuta.**

## L'evidenza

- `Rating`, `RatingMorph`, piu' le basi `BaseRating`, `BaseRatingMorph`: il modello e'
  **polimorfico**: un punteggio puo' agganciarsi a qualunque entita'.
- Solo 59 file PHP: e' il modulo piu' piccolo del dominio, ed e' giusto cosi'.
- I moduli che lo usano si vedono dai loro modelli: `Rating`/`RatingMorph` compaiono in
  Performance, Progressioni e IndennitaResponsabilita.

## Perche' vale la pena che sia un modulo

Senza Rating, tre moduli avrebbero tre tabelle di punteggi con tre convenzioni diverse
su scala, arrotondamento e storicizzazione. La domanda "che punteggio h

### `qmd-setup.md` — QMD Setup per Module **Rating**


# QMD Setup per Module **Rating**

## Configurazione QMD per Questo Module

### Collection Configuration

Il progetto usa una collection QMD centralizzata in `.qmd/index.yml` che include tutti i moduli.

### Ricerca Locale vs Globale

**Ricerca locale** (solo questo modulo):
\`\`\`bash
qmd search "<topic>" -c rating
# Cerca solo in ./laravel/Modules/Rating/docs/wiki/
\`\`\`

**Ricerca globale** (tutto il progetto):
\`\`\`bash
qmd search "<topic>"

### `quality-audit.md` — Audit di qualita: modulo Rating


# Audit di qualita: modulo Rating

Misurato il 1 settembre 2026 a tree fermo. Ogni numero viene da un comando
eseguito, non da una stima; i comandi sono in fondo, cosi la misura si puo
rifare e contestare.

## Stato misurato

| Metrica | Valore |
|---|---:|
| File PHP | 137 |
| Righe di codice | 6678 |
| File di test `*Test.php` | 20 |
| Casi di test | 125 |
| Casi di test per file PHP | 0.91 |
| `@phpstan-ignore` nel codice | 2 |
| Rilievi PHPMD su `app/` | 38 *(analisi parziale: abortita in corso)* |
| PHPInsights: Code | 97.6 % |
| PHPInsights: Complexity | 100.0 % |

### `rating-architecture.md` — Rating System - Architecture Analysis & Fixes


> Nota 2026-10-14 (docs-audit): Analisi nata da un errore di compilazione in IndennitaResponsabilita, modulo che non esiste in questo repository (ls laravel/Modules, 2026-10-14); lo stato 'Implementation Ready' non descrive il codice di Modules/Rating. Contenuto non riscritto, verificare prima di usarlo.

# Rating System - Architecture Analysis & Fixes

**Module**: Rating (Agnostic)  
**Context**: IndennitaResponsabilita compilation error  
**Date**: 2026-02-11  
**Status**: Analysis Complete, Implementation Ready

---

## 📋 Current Problem Analysis

### Error Messages in IndennitaResponsabilita
```
The Responsabilità di spesa must be a number.
The Realizzazione piani e programmi must be a number.
The Supporto decisioni del Dirigente must be a number.
The selected tot is invalid.

### `ratings-value-field-types.md` — Analisi: tipi di campo per `value` in `rating_morph`

# Analisi: tipi di campo per `value` in `rating_morph`

## Contesto

- **Tabella**: `rating_morph` (pivot tra `ratings` e modello host)
- **Campo**: `value` (voto dell'utente su un criterio)
- **Stato attuale**: `value` è `int` nullable (NULL = non valutato, 0 = valutato zero)
- **Obiettivo**: brainstorming sui tipi di campo per `value` senza implementare

## Tipi di campo analizzati

| Tipo | Descrizione | Pro | Contro |
|------|-------------|-----|--------|
| **Intero** | `int` nullable | Semplice, queryabile | Solo numeri interi |
| **Decimale** | `decimal(10,3)` nullable | Supporta frazioni | Più complesso da gestire |
| **Select** | `int` FK verso `options` tabella | Opzioni predefinite | Richiede tabella opzioni |
| **Radio** | `int` con opzioni fixed | Scegli una opzione | Limitato 

### `readme-en.md` — ⭐ Rating: English presentation


# ⭐ Rating: English presentation

[![Domain-Rating](https://img.shields.io/badge/Domain-Polymorphic%20Rating-FF6F00.svg)](#)
[![Laravel 13](https://img.shields.io/badge/Laravel-13-red.svg)](https://laravel.com/)
[![Filament 5](https://img.shields.io/badge/Filament-5-ffab00.svg)](https://filamentphp.com/)
[![PHP 8.4+](https://img.shields.io/badge/PHP-8.4+-777BB4.svg)](https://php.net/)
[![PHPStan Level 10](https://img.shields.io/badge/PHPStan-Level%2010-brightgreen.svg)](https://phpstan.org/)
[![PSR-12](https://img.shields.io/badge/Code-PSR--12-blue.svg)](https://www.php-fig.org/psr/psr-12/)
[![Strict Types](https://img.shields.io/badge/PHP-strict__types-1-informational.svg)](#)
[![Laraxot Modules](https://img.shields.io/badge/Architecture-Modular-purple.svg)](#)
[![Rating Module](https://

### `redundancy-analysis.md` — redundancy-analysis


See canonical documentation: ../../../Themes/docs/shared-components/REDUNDANCY_ANALYSIS.md

### `redundancy-audit.md` — Rating redundancy audit 2026-05-21


# Rating redundancy audit 2026-05-21

High-risk findings:
- Favorite Livewire views are byte-identical in multiple paths:
  - `resources/views/livewire/favorite2.blade.php`
  - `resources/views/livewire/favorite/favorite2.blade.php`
  - `resources/views/livewire/favorite/streamit.blade.php`
- `favorite.blade.php` and `favorite/default.blade.php` are also byte-identical.
- `admin/dashboard/item.blade.php` is duplicated with `Modules/Fixcity`.
- PHP CS Fixer config files duplicate common module boilerplate.

Risk:
- Livewire view resolution can drift when multiple files imply the same component intent.
- Dashboard item ownership between Rating and Fixcity is unclear.

Suggested cleanup order:
1. Identify Livewire component class/view mapping, then keep only the resolved view.
2. If dashboar

### `redundancy-report.md` — Redundancy Report: Modulo Rating


- Inventario [ridondanze cross-modulo](../docs/redundancy-report.md)
- Concetti [ridondanze cross-cutting](../Xot/docs/wiki/concepts/ridondanze-cross-cutting-codebase.md)

# Redundancy Report: Modulo Rating

> Generato: 2026-05-21 | Analisi automatica deep-scan

## Rilevamenti rapidi (scan modulo)

- **Filament:** 2 `*Resource.php` (`RatingResource`, `RatingMorphResource`); nessun nome Resource duplicato a livello root, ma **classi Table gemelle** in `RatingResource/Tables/` (`RatingTable.php` + `RatingsTable.php`) e in `RatingMorphResource/Tables/` (`RatingMorphTable.php` + `RatingMorphsTable.php`): verificare quale è referenziata e rimuovere l’altra.
- **Widget / RelationManager duplicati:** `StatsOverview` in `Filament/Widgets/` e in `HasRatingResource/Widgets/`; `RatingsRelationManage

### `release-marketing-standard.md` — Release e README marketing — Rating


# Release e README marketing — Rating

## Scopo

Ogni modulo/tema deve essere pubblicabile, comprensibile e desiderabile: workflow release, changelog automatico e README vetrina.

## File canonici locali

- `../README.md`
- `../.github/workflows/semantic-release.yml`
- `../.releaserc.json`
- `../CHANGELOG.md`

## Confidenza

La configurazione usa semantic-release con Conventional Commits, changelog, GitHub release e commit automatico del changelog.

### `roadmap/acceptance-criteria.md` — Criteri di accettazione per le fasi


# Criteri di accettazione per le fasi

Criteri misurabili e verificabili per considerare completata ogni fase della roadmap.  
Riferimento architettura: [architecture.md](../../ARCHITECTURE.md).

---

## Fase 1 · Stabilizzazione della base tecnica

### PHPStan e tipi

- [ ] `./vendor/bin/phpstan analyse Modules/Rating --memory-limit=-1` eseguito dalla root `laravel/` termina con **0 errori**.
- [ ] Nessun file PHP nel modulo senza `declare(strict_types=1);`.
- [ ] Nessun metodo pubblico/protetto senza tipo di ritorno esplicito (eccetto override documentati).
- [ ] Nessun uso di `property_exists()` su istanze Eloquent; sostituiti con `isset($model->attr)` o `Schema::hasColumn()` dove appropriato.

### Modelli e relazioni

- [ ] Ogni modello in `Modules/Rating/Models/` estende `Modules\Rati

### `roadmap/dependencies.md` — Dipendenze e confini del modulo Rating


# Dipendenze e confini del modulo Rating

Relazioni con altri moduli e pacchetti, cosa il modulo **dipende** e da cosa può essere **usato**.

---

## Dipendenze in ingresso (il Rating dipende da)

- **Laravel / Framework**: Laravel 13, Eloquent, migrazioni, container.
- **Xot**: classi base Filament (`XotBaseResource`, `XotBasePage`, …), convenzioni di namespace e traduzioni, eventuale `XotBaseMigration`.
- **Spatie (se in uso)**: es. `spatie/schemaless-attributes` per `extra_attributes` sul modello Rating (vedi [architecture.md](../../ARCHITECTURE.md)); versioni allineate al `composer.json` del modulo.
- **Nessun modulo di dominio applicativo**: Rating non deve dipendere da User, Patient, Cms, ecc. per la sua logica core.

---

## Dipendenze in uscita (chi usa il Rating)

- **Moduli cons

### `roadmap/metrics.md` — Metriche e obiettivi di qualità


# Metriche e obiettivi di qualità

Indicatori misurabili per lo stato del modulo e il successo delle fasi.

---

## Qualità codice

| Metrica | Obiettivo | Come verificare |
|--------|-----------|-----------------|
| PHPStan | 0 errori Level 10 | `./vendor/bin/phpstan analyse Modules/Rating --memory-limit=-1` da `laravel/` |
| Strict types | 100% file PHP | `declare(strict_types=1);` in ogni file |
| Return types | 100% metodi pubblici/protetti | Analisi manuale o PHPStan |
| Estensione base | Tutti i modelli | Ogni modello estende `BaseModel` del modulo |

---

## Test


### `roadmap/phases.md` — Fasi di Sviluppo del Modulo Rating


# Fasi di Sviluppo del Modulo Rating

## Fase 1 · Stabilizzazione della base tecnica

### Obiettivi

- Portare il modulo a **PHPStan Level 10** senza errori.
- Allineare tutte le dipendenze e il codice a **Laravel 13** e **Filament v5**.
- Garantire che il modulo sia **sicuro da riutilizzare** in altri progetti Laraxot senza regressioni.

### Attività

- Normalizzare namespace, tipi di ritorno e nullable secondo le regole Laraxot Core.
- Verificare che tutti i modelli del modulo estendano il `BaseModel` corretto del modulo.
- Adeguare eventuali Resource / Widget Filament alle XotBase classes e alle regole:
  - niente `->label()` / `->placeholder()` / `->helperText()`
  - array con **chiavi stringa** per `getTableColumns()`, `getTableFilters()`, `getInfolistSchema()`.
- Aggiungere o correg

### `roadmap/quality.md` — Checklist Qualità Modulo Rating


# Checklist Qualità Modulo Rating

Questa checklist serve come riferimento operativo per mantenere il modulo `Rating` allineato agli standard Laraxot (PHPStan Level 10, PSR-12, documentazione aggiornata).

## Qualità del codice

- [ ] Tutti i file PHP espongono `declare(strict_types=1);`.
- [ ] Tutte le funzioni e i metodi hanno tipi di ritorno espliciti.
- [ ] Nessun uso di `mixed` se non strettamente necessario (e documentato).
- [ ] Nessun modello estende direttamente `Illuminate\Database\Eloquent\Model` o `Modules\Xot\Models\XotBaseModel`: si usa sempre il `BaseModel` del modulo.
- [ ] Nessun uso di `property_exists()` sui modelli Eloquent.
- [ ] Nessun override di `table()` o di metodi marcati come `final` nelle XotBase classes.

## Static analysis e testing

- [ ] PHPStan Level 10 p

### `roadmap/vision.md` — Visione del Modulo Rating


# Visione del Modulo Rating

Il modulo `Rating` ha l'obiettivo di fornire un'infrastruttura **agnostica e riusabile** per la gestione di criteri di valutazione e punteggi, indipendente dal dominio applicativo specifico.

## Obiettivi di business

- Definire un modello di **rating generico** applicabile a qualunque entità (utente, servizio, struttura, progetto, ecc.).
- Supportare scenari in cui **più moduli** consumano il sistema di rating senza duplicare logica o tabelle.
- Permettere la configurazione di **criteri di valutazione** flessibili (peso, scala, vincoli) mantenendo la semplicità d’uso.
- Abilitare reportistica e analisi sui punteggi senza introdurre logica di domain-specific nel modulo Rating.

## Obiettivi tecnici

- Esposizione di un `HasRatingsTrait` riusabile, con relazion

### `roadmap-miglioramenti.md` — Roadmap: Rating, il modulo più piccolo con la coscienza più pulita


# Roadmap: Rating, il modulo più piccolo con la coscienza più pulita

> Numeri misurati: [`docs/cosa-migliorare.md`](cosa-migliorare.md) (80,
> 2026-09-01): PHPStan 0, PHPMD app/ 38 ⚠, Code 97.6, Arch 78.6, 125 casi
> test, coverage 80,8%. Coverage più alta dei cinque moduli qui analizzati e
> il Code score migliore: coerente con quello che segue, un modulo piccolo
> che si prende cura di sé: con l'eccezione dei due trait morti sotto.

59 file PHP, il più snello dei cinque moduli qui analizzati, e l'unico dove i
`@phpstan-ignore` trovati in `app/` non sono scuse ma referti firmati:

```
app/Models/Traits/RatingTrait.php:20
/** @phpstan-ignore trait.unused (verificato zero consumer in questo repo il 2026-09-01) */

app/Models/Traits/HasRating.php:12
/** @phpstan-ignore trait.unused (verifi

### `root-file-policy.md` — Root file policy


# Root file policy

Updated: 2026-07-08

Root hygiene for this owner follows the project rule: no root .txt files, at most four root .md files, and at most one root .code-workspace named after the module or theme.

Archived root files live in:

- docs/root-txt-files/ (0 files)
- docs/root-md-files/ (2 files)
- docs/root-code-workspace-files/ (1 files)

Current root counts after normalization: 3 markdown files, 1 workspace files.

### `root-files-hygiene.md` — Root files hygiene


# Root files hygiene

## 2026-07-08 16:51

- created `Rating.code-workspace` as the single canonical root workspace file.

### `schema.md` — Rating Module Schema


# Rating Module Schema

> **Purpose:** Defines folder rules, frontmatter standards, and workflows for AI agents.

## Module Identity

- **Name:** Rating
- **Type:** Laravel Module (Laraxot)
- **Location:** `laravel/Modules/Rating/`
- **Docs:** `laravel/Modules/Rating/docs/`

## Wiki Rules

### raw/ Rules
- ✅ Immutable: AI reads but never modifies or deletes
- ✅ Drop liberally: articles, code snippets, decisions
- ✅ Subdivide by type: `articles/`, `papers/`, `code-examples/`, `decisions/`

### wiki/ Rules

### `scopo.md` — Rating: scopo, confini e come servirlo meglio


# Rating: scopo, confini e come servirlo meglio

## Lo scopo, dedotto dal codice

Rating non è una foglia applicativa: è **una piattaforma**, come Xot e Sigma. Non
contiene le valutazioni di nessun dominio: contiene la forma che una valutazione ha in
questo progetto, e le classi Base che i moduli di dominio estendono per averla.

| Fatto | Dove si verifica | Cosa significa |
|---|---|---|
| 10 classi fuori dal modulo estendono `BaseRating` o `BaseRatingMorph` | `Modules/{Ptv,Performance,Progressioni,IndennitaResponsabilita,IndennitaCondizioniLavoro}/app/Models/Rating.php` e `RatingMorph.php` | ogni dominio ha i propri rating, sulla propria connessione, ma la stessa struttura |
| `BaseRatingResource`, `BaseRatingMorphResource`, `BaseRatingsTable`, `BaseRatingForm`, `BaseListRatings` | `app

### `select-nelle-valutazioni-analisi.md` — Un criterio di valutazione con risposta a scelta: analisi


# Un criterio di valutazione con risposta a scelta: analisi

**Stato: brainstorming.** Nessun codice scritto, nessuna decisione presa. Serve a
mettere le strade sul tavolo con i numeri veri, non a chiuderne una.

## La domanda posta

Fra le valutazioni serve anche un **select**. Le due strade proposte:

1. aggiungere al rating un campo `data` di tipo JSON con i valori del select;
2. usare padre/figlio: `parent_id` c'è già: e far diventare i figli le opzioni.

## La domanda si sdoppia, ed è il punto

Sono **due** domande, e vengono confuse perché di solito si risolvono insieme:

| | |
|---|---|
| **dove vivono le opzioni** | la lista di scelte offerte: «Base / Media / Alta» |

### `stories/0005-rating-phpstan-fix.story.md` — BMAD Story - Rating PHPStan Fix

# BMAD Story - Rating PHPStan Fix

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0006-rating-phpstan-fix-2.story.md` — BMAD Story - Rating PHPStan Fix

# BMAD Story - Rating PHPStan Fix

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0007-base-rating-factory.story.md` — Story 1.1: `BaseRatingFactory`

# Story 1.1: `BaseRatingFactory`

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0008-create-scheda.story.md` — 1.1: Create Scheda

# 1.1: Create Scheda

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0009-search-filter.story.md` — 1.10: Scheda Search + Filter (Employee, Year, Status)

# 1.10: Scheda Search + Filter (Employee, Year, Status)

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0010-foreign-key-su-rating-parent-id.story.md` — Story 1.13: nessun vincolo su `ratings.parent_id`

# Story 1.13: nessun vincolo su `ratings.parent_id`

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0011-draft-submitted-flow.story.md` — 1.3: Draft → Submitted State Flow

# 1.3: Draft → Submitted State Flow

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0012-soft-delete-restore.story.md` — 1.4: Soft-delete + Restore Within 30 Days

# 1.4: Soft-delete + Restore Within 30 Days

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0013-bulk-create-csv.story.md` — 1.5: Bulk Create From CSV

# 1.5: Bulk Create From CSV

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0014-edit-submitted-audit-trail.story.md` — 1.8: Edit Submitted Scheda (Audit Trail)

# 1.8: Edit Submitted Scheda (Audit Trail)

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0015-approval-workflow-signoff.story.md` — 1.9: Approval Workflow (Manager Sign-off)

# 1.9: Approval Workflow (Manager Sign-off)

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0016-rating-morph-type-doppia-forma.story.md` — Story 18.35: `rating_morph.model_type` ha due forme

# Story 18.35: `rating_morph.model_type` ha due forme

## Context and Problem Statement

I record realmente valutati: almeno un `value` non nullo e diverso da zero, contando
entrambe le forme: sono **147 su 7.955**. Con la relazione cosi' com'e', 146 di quei 147
appaiono **non valutati**.

Non e' un errore che si vede: non lancia eccezioni, non compare nei log, e il numero
mostrato e' plausibile. E' il tipo di dato sbagliato peggiore, perche' nessuno lo mette in
dubbio. Tocca allo stesso modo `RatingsColumn`, `RatingsSection` e i filtri sui rating: la
causa e' una sola, sotto tutti e tre.

Query di verifica (read-only, riproducibile):

```sql
SELECT COUNT(DISTINCT model_id) FROM rating_morph
WHERE value IS NOT NULL AND value <> 0;                          -- 147

SELECT COUNT(DISTINCT mode

### `stories/0017-simplify-rating-data-create-rating-morph-data.story.md` — Story 18.36: Semplificare RatingData.php e creare RatingMorphData.php

# Story 18.36: Semplificare RatingData.php e creare RatingMorphData.php

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0018-rating-parent-adjacency-edit.story.md` — Story 18.37: Gestione parent_id e figli nel rating edit (adjacency list)

# Story 18.37: Gestione parent_id e figli nel rating edit (adjacency list)

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0019-rating-path-column.story.md` — Story 18.38: Aggiungere colonna `path` per adjacency list

# Story 18.38: Aggiungere colonna `path` per adjacency list

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0020-phpstan-level10-fix-datas-filament.story.md` — 18.39 PHPStan L10 fix: Rating Datas + Filament

# 18.39 PHPStan L10 fix: Rating Datas + Filament

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0021-ratingdata-helper-schema-migrazioni.story.md` — Story 18.39: `RatingData` come sorgente delle colonne `ratings`

# Story 18.39: `RatingData` come sorgente delle colonne `ratings`

## Context and Problem Statement

`SchedaData::updateColumns(XotBaseMigration $migration)` apre da se' il `tableUpdate()`.
Comodo, ma ogni gruppo di colonne apre il **proprio**: sei gruppi sono sei `ALTER TABLE`
sulla stessa tabella.

```php
RatingData::updateColumns(Blueprint $table, XotBaseMigration $migration)
```

Ricevendo il `Blueprint` gia' aperto dal chiamante, tutte le colonne entrano in **una sola**
`ALTER TABLE` e la migrazione resta padrona della propria transazione. Non e' una variante
del pattern: e' la stessa idea con un difetto in meno. Allineare `SchedaData` e' lavoro a
se': tocca sei metodi e le migrazioni scheda: e non si fa di passaggio.

Aggiunto anche `updateMorphColumns()` per `rating_morph`, dove viv

### `stories/0022-rating-morph-columns-nullable-e-allineamento.story.md` — Story 18.40: `rating_morph`: morphs nullable e allineamento delle installazioni

# Story 18.40: `rating_morph`: morphs nullable e allineamento delle installazioni

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0023-rating-gerarchico-figli-nell-edit.story.md` — Story 18.42: I figli di un rating nella pagina di modifica

# Story 18.42: I figli di un rating nella pagina di modifica

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0024-rating-path-column-adjacency-list.story.md` — Story 18.43: La colonna `path` nella lista dei rating

# Story 18.43: La colonna `path` nella lista dei rating

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0025-children-relationmanager-hook-e-parent-nascosto.story.md` — Story 18.44: Il RelationManager dei figli: hook al posto di `table()`, padre nascosto

# Story 18.44: Il RelationManager dei figli: hook al posto di `table()`, padre nascosto

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0026-analisi-criteri-scelta-e-tipo-campo.story.md` — Story 18.46: Criteri a scelta e tipo di campo: le due analisi

# Story 18.46: Criteri a scelta e tipo di campo: le due analisi

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0027-workflows-rating-module-roadmap.story.md` — Story 18.47: Workflows Rating Module: Roadmap Completo

# Story 18.47: Workflows Rating Module: Roadmap Completo

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0028-rating-morph-value-intero-o-decimale.story.md` — Story 18.48: `rating_morph.value`: intero o decimale, e la classe che dice entrambe

# Story 18.48: `rating_morph.value`: intero o decimale, e la classe che dice entrambe

## Context and Problem Statement

L'analisi `docs/tipo-di-campo-del-criterio.md` propone di dichiarare il tipo di un criterio,
e fra i tipi c'e' «numero con decimali». Finche' `value` e' `int(11)` quel tipo e'
**dichiarabile ma non rappresentabile**: l'utente configurerebbe un criterio con due decimali
e il sistema ne salverebbe zero, senza errore.

Un tipo offerto e non supportato e' peggio di un tipo assente, perche' chi configura ha
ragione a fidarsi.

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)

### `stories/0029-guardia-lista-rating-progressioni.story.md` — Story 18.51: la guardia sul modulo che il cambio puo' rompere

# Story 18.51: la guardia sul modulo che il cambio puo' rompere

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0030-disallineamento-tipi-chiavi-esterne.story.md` — Story 18.52: chiavi esterne piu' strette della chiave

# Story 18.52: chiavi esterne piu' strette della chiave

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0031-cinque-documenti-due-temi-consolidamento.story.md` — Story 18.54: cinque documenti, due temi

# Story 18.54: cinque documenti, due temi

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0032-rating-get-class-name-principio-unico.story.md` — Story 18.55: `Rating::getClassName()` come principio unico

# Story 18.55: `Rating::getClassName()` come principio unico

## Context and Problem Statement

`resolveRatingClass()` nel trait duplicava la logica di `getClassName()` gia'
presente su `XotBaseModel`:

- `XotBaseModel::getClassName()` (righe 64-90) legge il primo frame del
  `debug_backtrace()` che ha un `object` la cui `::class` contiene `Models\` o
  `Filament\Resources\`; se manca lancia `RuntimeException('Unable to resolve
  caller object for getClassName()')`. Poi, se l'object ha `getModelClass()`,
  usa quello; infine risolve `{$namespace}\Models\{$className}` dove `$namespace`
  deriva dal caller e `$className` dal `static::class` chiamante.
- Poiche' `static` e' `Modules\Rating\Models\Rating`, `Rating::getClassName()`
  risolve `{$namespaceDelCaller}\Models\Rating`, cioe' il Ratin

### `stories/0033-ratings-by-id-accessor.story.md` — Story 18.56: accessor `ratings_by_id` e `ratingValuePath()` in HasRatingsTrait

# Story 18.56: accessor `ratings_by_id` e `ratingValuePath()` in HasRatingsTrait

## Context and Problem Statement

`HasRatingsTrait::ratingFieldName()` (righe 297-308) e' gia' la convenzione unica del
percorso di form: `'ratings.'.$rating->id.'.pivot.'.$pivotColumn`. Il suo docblock dice il
perche': "se cambia, cambia in un posto solo". Il percorso di lettura via `data_get` e' la
controparte esatta e merita lo stesso trattamento: il componente porta la sua logica, chi
compone la chiede.

Alternative scartate (dossier di sessione, sezione 6):

- `keyBy('id')` dentro `CollectionExport` quando il campo inizia con `ratings.` (ADR-003
  del peer in `Ptv/docs/bmad/architecture/export-xls-base-list-schedas.md`): accoppia
  l'exporter generico di Xot al dominio Rating e resta ambiguo fra indice e

### `stories/0034-ratings-by-id-doppia-forma-model-type.story.md` — Story 18.57: `ratings_by_id` legge `ratingMorphs` invece di `ratings`

# Story 18.57: `ratings_by_id` legge `ratingMorphs` invece di `ratings`

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0035-pest-contract-xotbasepest.story.md` — Story 2.1: Rating: adottare il contratto Pest condiviso e alzare la coverage

# Story 2.1: Rating: adottare il contratto Pest condiviso e alzare la coverage

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0038-dod-full-closure-typecoverage-phpmd.story.md` — Rating: chiusura DoD piena

# Rating: chiusura DoD piena

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0039-ratingfilamentschematest-instance-call-fix.story.md` — Story RATING-2.5: allineare i test allo shape d'istanza di getFormSchema/getInfolistSchema

# Story RATING-2.5: allineare i test allo shape d'istanza di getFormSchema/getInfolistSchema

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0041-phpstan-fix-rating-linkedto.story.md` — 5.84 PHPStan Fix: Rating - BaseRating linkedTo Method

# 5.84 PHPStan Fix: Rating - BaseRating linkedTo Method

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0042-phpstan-fix-morphto-genericity-and-parent-id-test.story.md` — 5.85 PHPStan Fix: MorphTo + Ptv stale ignores + Progressioni

# 5.85 PHPStan Fix: MorphTo + Ptv stale ignores + Progressioni

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0046-resolve-rating-class-guardia-e-rationale.story.md` — Story 5.90: Tornare a `getClassName()`

# Story 5.90: Tornare a `getClassName()`

## Context and Problem Statement

Questa story esisteva, era gia' alla versione 2.0.0, e conteneva **la risposta e la
ritrattazione**. Alla stessa domanda ho risposto di nuovo di no, con tre argomenti: gli
stessi tre gia' smontati qui: prima di misurare le connessioni.

Non e' che mi mancasse l'informazione: era scritta nel modulo, in `docs/stories/`, a due
directory dal file che stavo leggendo. Ho ragionato da zero su un problema chiuso.

La regola dello standing order dice «interroga il second brain **prima**». Il costo di
saltarla non e' teorico: e' aver difeso in pubblico, e scritto nel doc canonico di Xot,
una conclusione che il repository aveva gia' ritirato. La correzione e' nella sezione
«Un resolver scritto a mano non e' un'alternativa» di

### `stories/0047-getratingsformschema-caller.story.md` — Story 5.91: getRatingsFormSchema nel trait con $caller

# Story 5.91: getRatingsFormSchema nel trait con $caller

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0048-get-ratings-form-schema-nel-trait.story.md` — Story 5.92: `getRatingsFormSchema()` nel trait

# Story 5.92: `getRatingsFormSchema()` nel trait

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0050-readme-agnostico-e-guardia-che-cercava-il-placeholder.story.md` — Story 5.94: Il README nominava un'installazione

# Story 5.94: Il README nominava un'installazione

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0051-rating-resource-reordering-adoption.story.md` — Story

# Story

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0053-tetto-criterio-come-dato-non-enum.story.md` — Story 8.17: Il tetto di un criterio è un dato

# Story 8.17: Il tetto di un criterio è un dato

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0054-due-model-type-punteggio-invisibile.story.md` — Story 8.18: Due `model_type` per la stessa entità

# Story 8.18: Due `model_type` per la stessa entità

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0055-signature-incompatibility-fix.story.md` — 8.26 Signature Incompatibility Fix

# 8.26 Signature Incompatibility Fix

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0056-audit-qualita.story.md` — Audit qualita' — modulo Rating

# Audit qualita' — modulo Rating

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0057-criteri-tipo-di-risposta-e-opzioni.story.md` — Story: tipo di risposta di un criterio e opzioni del select

# Story: tipo di risposta di un criterio e opzioni del select

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0058-docs-rating-verifica-ingressi.story.md` — Rating docs: ingressi verificati contro il codice

# Rating docs: ingressi verificati contro il codice

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0059-phpstan-batch.story.md` — Story

# Story

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0060-phpstan-fix.story.md` — phpstan fix.story

# phpstan fix.story

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0062-phpstan-fleet-fix.story.md` — Claim

# Claim

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0063-rating-altro-option-conditional-textarea-design.story.md` — Design: Select «altro» + note

# Design: Select «altro» + note

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0064-rating-data-migration-helper.story.md` — Story: `RatingData`: le colonne di `ratings` dichiarate una volta sola

# Story: `RatingData`: le colonne di `ratings` dichiarate una volta sola

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0065-rating-docs-graphify-tracked.story.md` — Rimuovere docs/graphify tracciato in Rating

# Rimuovere docs/graphify tracciato in Rating

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0066-rating-gerarchia-parent-id-e-figli-in-edit.story.md` — Story: gerarchia dei rating: `parent_id` e i figli nella pagina edit

# Story: gerarchia dei rating: `parent_id` e i figli nella pagina edit

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0067-rating-morph-migrazioni-doppie.story.md` — Story: `rating_morph`: due migrazioni vive per la stessa tabella

# Story: `rating_morph`: due migrazioni vive per la stessa tabella

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0068-rating-parent-id-column.story.md` — Colonna parent_id per gli alberi di criteri

# Colonna parent_id per gli alberi di criteri

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0069-ratings-column-bmad-story.story.md` — RatingsColumn: story BMAD

# RatingsColumn: story BMAD

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0070-ratings-column-section-filter.story.md` — Story: `RatingsColumn`, `RatingsSection`, `HasRatingValuesFilter`

# Story: `RatingsColumn`, `RatingsSection`, `HasRatingValuesFilter`

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/phpstan-rating-fix.md` — Story

# Story

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/ratingtrait-scopo.md` — Story

# Story

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `sustainability-and-funding.md` — Riferimento BMAD


# Riferimento BMAD

Modulo Rating: l'impatto può usare feedback aggregato, mai incentivi o ranking legati a sponsor.

Mappa modelli: [how-to-sustain.md](../../../../bmad-output/footer-sponsorship/how-to-sustain.md). Dominio: [Fixcity sustainability](../../Fixcity/docs/sustainability-and-funding.md).

Il dossier canonico, con ricerca, alternative, rischi, requisiti e gate di readiness, è in [bmad-output/footer-sponsorship](../../../../bmad-output/footer-sponsorship/README.md). La valutazione inbound marketing è in [inbound-marketing.md](../../../../bmad-output/footer-sponsorship/inbound-marketing.md).

Questa pagina evita duplicazioni: descrive il solo confine del componente e non autorizza modifiche al runtime, al JSON del footer, a Filament o ai flussi di pagamento.

## Regola di manteni

### `test-location-rule.md` — Test Location Rule: Rating

# Test Location Rule: Rating

- Tests: `laravel/Modules/Rating/tests/`.
- Module fixtures: `laravel/Modules/Rating/tests/Fixtures/`.
- `laravel/tests/` is reserved for application, cross-module and theme tests.
- Do not create `laravel/tests/Modules/Rating/` as a duplicate.

### `testing-and-coverage.md` — Rating: test e coverage


# Rating: test e coverage

## Eseguire la suite

```bash
# cwd: laravel/
./vendor/bin/pest -c Modules/Rating/phpunit.xml --no-coverage
```

`Modules/Rating/phpunit.xml` esiste per una ragione sola: **spostare il perimetro di
coverage** su `Modules/Rating/app`. La `laravel/phpunit.xml` di root dichiara
`<source><include><directory>app</directory>`, cioè lo scheletro applicativo, non i moduli:
misurata da lì, la coverage di Rating non compare affatto.

Il `bootstrap` è `../../vendor/autoload.php`: **relativo al file di config**, non alla cwd.
Le `phpunit.xml` di `Modules/Activity` e `Modules/Job` dichiarano `vendor/autoload.php` e
per questo non sono eseguibili da `laravel/`.

## Coverage

### `tipo-di-campo-del-criterio.md` — Il tipo di campo di un criterio: intero, decimale, select, radio, testo libero


# Il tipo di campo di un criterio: intero, decimale, select, radio, testo libero

Analisi, non implementazione. Prosegue
[criteri-a-scelta-multipla.md](criteri-a-scelta-multipla.md), che si fermava dicendo «prima
il criterio deve dichiarare di che tipo e'». Questo documento apre quella frase.

## Risposta breve

Il campo serve, ma **non e' un campo solo**. La frase «di che tipo e' questo criterio»
nasconde tre decisioni che oggi collassano in una:

1. **che cosa si chiede** (numero, scelta, testo): il tipo di input;
2. **dove atterra la risposta** (`value`, il figlio scelto, `note`): oggi c'e' una colonna
   sola per i numeri, e per il testo una colonna vuota che nessuno usa;
3. **quando una risposta e' obbligatoria** (il «se scegli Altro, il testo diventa
   obbligatorio»): e questa rego

### `tipo-di-risposta-del-criterio-analisi.md` — Che tipo di risposta vuole un criterio: analisi


# Che tipo di risposta vuole un criterio: analisi

**Stato: brainstorming.** Nessun codice, nessuna decisione. Segue e completa
[`select-nelle-valutazioni-analisi.md`](select-nelle-valutazioni-analisi.md), che
si fermava a questa domanda chiamandola «il problema ortogonale».

## La domanda posta

Serve un campo che dica se un criterio si compila come **intero**, **decimal**,
**select**, **radio** o **testo libero**: e, legato al select, la regola: se scegli
«Altro», il testo diventa obbligatorio.

## Prima cosa: quale «criterio»

Nel progetto la parola «criterio» copre due domini distinti, e confonderli è
l'errore più facile da fare qui:

| | *chi partecipa* | *come si valuta chi partecipa* |
|---|---|---|

### `troubleshooting.md` — Troubleshooting – Rating


# Troubleshooting – Rating

**Last updated:** 2026-07-28

---

## Error Categories

### 1. Calculation Errors

#### Error Pattern: "Invalid rating value: expected numeric, got string"

**Cause:**
- Rating value not cast to numeric in model
- Form submission with non-numeric string
- Migration missing column type definition

**Solution:**


### `up.md` — up


> Nota 2026-10-14 (docs-audit): Chiede di modificare laravel/Modules/IndennitaResponsabilita/app/Models/Rating.php, percorso che non esiste in questo repository (verificato 2026-10-14). Appunto di un altro progetto. Contenuto non riscritto, verificare prima di usarlo.

aggiungere   al file laravel/Modules/IndennitaResponsabilita/app/Models/Rating.php
 /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'extra_attributes' => SchemalessAttributes::class,
            'rule' => RuleEnum::class,
            'is_disabled' => 'boolean',
            'is_readonly' => 'boolean',
        ];
    }

    /**

### `user-interface.md` — User Interface - Modulo Rating


## User Interface - Modulo Rating

- Le risorse Filament espongono le traduzioni da `rating::` secondo la struttura espansa.
- 19/11/2025: aggiornata l'icona di navigazione di `rating_morph` eliminando il placeholder `.navigation` e usando `heroicon-o-star`.


### `workflows/estrarre-uno-schema-filament-condiviso.md` — Estrarre uno schema Filament in un trait condiviso


# Estrarre uno schema Filament in un trait condiviso

Procedura per portare un costruttore di campi da una pagina di modulo a un trait che decine di
consumatori erediteranno. Scritta durante l'analisi di
`CompilaIndennitaResponsabilita::getRatingsSchema()` → `HasRatingsTrait::getRatingsFormSchema()`.

I passi 1 e 4 esistono perché al primo tentativo sono quelli che si saltano.

---

## 1. Misurare la duplicazione **prima**, e accettare la risposta

```bash
cd laravel
# quante pagine fanno la stessa cosa?
find Modules -name "Compila*.php" -path "*/Filament/*" | wc -l
# ma quante la fanno con lo STESSO meccanismo?
grep -rln "getFormSchema" <quelle pagine>       # schema Filament
grep -rln "getViewData\|form_data"  <quelle pagine>   # pagina Blade: e' un'altra cosa
>>>>>>> laraxot/dev
