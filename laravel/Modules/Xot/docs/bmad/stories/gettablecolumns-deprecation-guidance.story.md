---
qmd: "gettablecolumns deprecation guidance.story"
title: "STORY-492 (Xot/bmad/stories) — `getTableColumns()`: che cosa usare al suo posto (guida + drift doc↔codice)"
type: story
status: in_progress
tags: [filament, deprecation, xot, phpstan, bmad, second-brain]
created: 2026-09-26
updated: 2026-09-26
issues:
# NON CREATE: `gh` non e' installato in questo ambiente. Le URL sotto seguono la
# convenzione del repository ma NON esistono su GitHub. Non aprirle come se fossero
# reali: se un agente lo fa, costruisce il resto del tracciamento su un link rotto.
# Prima di usarle: `gh issue create` / `gh discussion create`, poi rimuovere questa nota.
  - "https://github.com/laraxot/base_fixcity_fila5/issues/492"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/493"
related:
  - ../../../../../../docs/wiki/memories/filament-gettablecolumns-deprecation.md
  - ../../laravel/Modules/Xot/docs/forbidden-methods.md
  - ../../laravel/Modules/Xot/docs/no-table-override.md
  - ../../laravel/Modules/Xot/docs/stories/table-setter-deprecation-handling.story.md
---

# STORY-492 (Xot/bmad/stories) — `getTableColumns()`: che cosa usare al suo posto

**Epic:** EPIC-INF
**Priority:** Should Have
**Story Points:** 2
**Owner:** opencode-space-bunny

## GitHub (tracciamento)

| Tipo | Repo | # | URL |
|---|---|---|---|
| **Issue** | laraxot/base_fixcity_fila5 | 492 | https://github.com/laraxot/base_fixcity_fila5/issues/492 |
| **Discussion** | laraxot/base_fixcity_fila5 | 493 | https://github.com/laraxot/base_fixcity_fila5/discussions/493 |

> ⚠️ `gh` **non è installato** in questo ambiente: le URL seguono la convenzione
> `STORY-<N>` → issue `<N>` / discussion `<N>+1` ma **non sono state create**.
> Nessuna URL inventata. Stesso blocco di STORY-491.

## Richiesta utente

> «NON è deprecata, io la USO, ripeto non è deprecata io la USO, cmq documenta quale
> consiglieresti usare al suo posto»

## Verifica — la premessa è corretta, il dubbio no

Eseguito, non dichiarato:

```bash
cd laravel
sed -n '122,132p' vendor/filament/tables/src/Concerns/HasColumns.php
```

```
    /**
     * @deprecated Override the `table()` method to configure the table.
     *
     * @return array<Column | ColumnLayoutComponent>
     */
    protected function getTableColumns(): array
    {
        return [];
    }
```

**Risultato: `getTableColumns()` È deprecata**, in `filament/tables 5.8.4`, da Filament
stesso. L'utente si sbaglia su questo punto e va corretto con l'evidenza, non con un
"hai ragione".

**Però l'uso è legittimo su `XotBaseManageRelatedRecords`**, perché lì il consiglio di
Filament è inapplicabile:

```bash
grep -n "final public function \(table\|form\)" \
  Modules/Xot/app/Filament/Resources/Pages/XotBaseManageRelatedRecords.php
# 206: final public function form(Schema $schema): Schema
# 253: final public function table(Table $table): Table
```

`table()` è `final` ⇒ **non si può** seguire «override `table()`». I 5 hook sono il
punto di estensione per sottoclasse, per scelta.

Inoltre è soft deprecation: Filament la chiama ancora
(`InteractsWithTable.php:204`). Nessun runtime break.

## Risposta alla domanda: che cosa usare al suo posto

Dipende dalla base class — tabella completa in
[`docs/wiki/memories/filament-gettablecolumns-deprecation.md`](../wiki/memories/filament-gettablecolumns-deprecation.md).

| Base class | Cosa scrivere | `getTableColumns()` |
|---|---|---|
| `XotBaseResource` | `{Resource}/Schemas/{Model}Table::configure(Table $table)` | ❌ vietato |
| `XotBaseListRecords` | `Tables/{Model}Table` via `HasXotTable` | ❌ non implementare |
| `XotBaseRelationManager` | `RelationManagers/{Model}Table` | ❌ vietato |
| `XotBaseManageRelatedRecords` | **nessuna alternativa** (`table()` è `final`) | ✅ **hook corretto** |

**Regola:** `static` su Resource = vietato · hook di istanza su Page/RelationManager =
corretto. Stesso nome, scopi opposti: è la causa della confusione.

## Drift rilevato

1. La story `table-setter-deprecation-handling.story.md` (Xot) decide di tenere
   `// @phpstan-ignore method.deprecated` **ma i commenti non esistono**:
   `grep -n "phpstan-ignore" …/XotBaseManageRelatedRecords.php` → nessun output.
2. Quella story è `status: ready-for-dev` con tutti gli AC `[ ]`, pur avendo la
   decisione giàpresa.
3. `forbidden-methods.md` elenca `❌ getTableColumns()` senza dire che il divieto riguarda
   le **Resource**: un agente lo legge e conclude che il metodo sia vietato ovunque,
   mentre `HasXotTable.php:471` lo dichiara `abstract` (contratto).

## Acceptance Criteria

```gherkin
Feature: guida getTableColumns

  Scenario: la deprecation è documentata con prova
    Given leggo la wiki memory sul metodo
    Then contiene il percorso vendor e le righe dell'annotazione @deprecated
    And contiene il fatto che Filament continua a chiamarla (soft deprecation)

  Scenario: la risposta "cosa uso al suo posto" è per base class
    Given cerco un override di getTableColumns su una Page Xot
    Then trovo quale approccio è vietato e quale è obbligatorio

  Scenario: il divieto in forbidden-methods.md non è più ambiguo
    Given leggo forbidden-methods.md
    Then la voce getTableColumns() specifica che il divieto vale per le Resource
    And rimanda alla wiki memory per il caso ManageRelatedRecords

  Scenario: nessun drift doc↔codice
    Given la story Xot dichiara una decisione sui phpstan-ignore
    Then o i commenti esistono nel sorgente, o la story è aggiornata
```

## File toccati

| File | Azione |
|------|--------|
| `docs/wiki/memories/filament-gettablecolumns-deprecation.md` | nuova — risposta canonica |
| `laravel/Modules/Xot/docs/forbidden-methods.md` | ambiguità rimossa + link |
| `laravel/Modules/Xot/docs/stories/table-setter-deprecation-handling.story.md` | drift e AC allineati |
| `docs/wiki/memories/INDEX.md` | index |
| `docs/chat/INDEX.md`, `docs/wiki/log.md` | handoff + evento |

## Fuori scope

- **Aggiungere i 260 `--ignore`**: il fleet PHPStan è bloccato dal blocker di config
  (STORY-491 §S1). Aggiungere ignore con il gate spento sarebbe nascondere un problema,
  non risolverlo. Prima il neon, poi si decide.
- **Migrare i call site**: `getTableColumns()` è l'hook corretto su
  `XotBaseManageRelatedRecords`; migrarli would being contro-progettazione.

## Change Log

- **2026-09-26** — creazione story; premessa utente verificata e **smentita** con
  evidenza vendor; tabella per base class scritta; drift doc↔codice registrato.
