---
title: "File byte-identical tra moduli/temi (scan statico SHA256)"
type: redundancy
owner: Modules/Xot
severity: medium
created: 2026-05-23
updated: 2026-05-25
tags: [redundancy, static-analysis, blade, scaffolding]
related:
  - ../concepts/ridondanze-cross-cutting-codebase.md
  - ./audit-profondo-ridondanze-holistic.md
  - ./xotbase-pattern-abuse.md
  - ../../../../../../docs/wiki/concepts/code-redundancy-audit.md
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/89"
  - "https://github.com/laraxot/base_fixcity_fila5/issues/90"
---

# Ridondanza: contenuto identico (byte-equal) distribuito su più owner

## Scopo (business logic)

Molti file **copiati 1:1** tra moduli/temi non sono “errori casuali”: sono **scaffold/vendor sync** (`routes/*.php`, pannelli Filament minimi, `phpstan_constants.php`). Restano comunque **debito reale**:

- chi corregge un bug o un’allineamento Filament deve **toccare decine di path uguali**, con rischio di deriva;
- le ricerche codebase ingannano (stesso snippet ovunque);
- non distingue **intenzionalmente condiviso** vs **duplicato da consolidare**.

Questa pagina riassume un **pass statico** (SHA256, file non in `vendor`/`node_modules`, esclusa cartella `tests/` nel conteggio “cross-owner”).

## Metodo (riproducibile)

Workspace: `laravel/Modules/*` + `laravel/Themes/*`. Chiave: `(size, sha256(content))`. Gruppo “interessante”: **≥2 path** e **≥2 owner** distinti (owner = nome modulo o nome tema). Output pubblicato storico (**2026-05-23**):

| Area | Gruppi duplicati (≥2 file) | Gruppi cross-owner |
|------|----------------------------|-------------------|
| `*.php` | 431\* | 72\* |
| `*.blade.php` | 179 | **53** |

\* Il conteggio `*.php = 431` era basato sulla convenzione “estensione `.php`”: nelle toolchain che classificano in fretta può essere **mistificato dai file Blade** (anch’essi finiscono in `.php`). Per comparare le metriche leggere sempre il [§ Riesame 2026-05-25](#riesame-metodologia-strict-2026-05-25).

## Riesame metodologia strict (2026-05-25)

Definizioni esplicite (riproducibili anche via script documentato in [`audit-profondo-ridondanze-holistic.md`](./audit-profondo-ridondanze-holistic.md)):

- **`*.blade.php`** — gruppi duplicati: **179**; cross-owner **53** (**stabile vs baseline sopra sulla parte trasversale Blade**).
- **`.php` puro** (file che terminano in `.php` **ma non** `.blade.php`): gruppi duplicati **247**; cross-owner **17**.

Interpretazione: quando serve un KPI “solo PHP backend”, usare il bucket **pure PHP** per evitare doppioni conteggio Blade; quando si parla delle viste Blade condivise, la colonna **`53`** resta il segnale d’allarme principale perché coincide con anni di scaffolding multi-modulo.

## Pattern ricorrenti (priorità triage)

1. **Route stub identiche** — stesso `routes/api.php` / `routes/web.php` (o equivalente) fino a **~14 moduli** nello stesso gruppo di hash. È candidato a **template singolo** o generazione da Xot in fase di `module:make`, non copia manuale perpetua.
2. **Viste Filament `pages/dashboard.blade.php` (e simili)** — stesso markup ripetuto in **Cms, Gdpr, Geo, Lang, Notify, Tenant, …**; valutare **componente/livewire/theme partial** centralizzato o default del resource page.
3. **`phpstan_constants.php`**, **`.php-cs-fixer*.php`**, **`rector.php`** — toolchain allineata per modulo è ok se **policy unica**: se cambia una regola, serve **mirror atomico** o symlink/documented generator; diversamente è rumore nei diff.
4. **Doppioni path dentro Xot** — stesso Blade (es. `admin/standalone/manage/php-array.blade.php`, `admin/store/acts/xls_import.blade.php`) sotto sia `app/Resources/views/` sia `resources/views/`: fuori standard Laravel; decidere **un solo albero** e deprecare l’altro (issue dedicata).
5. **Clock widget** — file blade/widget job vs xot **stesso contenuto**: ridondanza funzionale; **extend** widget Xot nel modulo dominio.

## Temi Sixteen ↔ TwentyOne

Stesso contenuto tra **`Themes/Sixteen/.../components/ui/placeholder.blade.php`** e **`TwentyOne/...`** (più varianti Sixteen duplicate internamente). Qui la decisione è **prodotto/UI**: tema owner della variante deve restare uno; gli altri importano tramite `@include`/`x-*`/`view()` con namespace chiaro — vedi anche hub TwentyOne aggiornato.

## Azioni consigliate (non automatizzare ciecamente)

- Aprire **issue piccole per cluster** (es. “Consolidare route stub moduli laraxot”), non un mega PR.
- Dopo refactor: rivedere i numeri con lo stesso script (baseline in commento nell’issue #90).

## Tracker

Issue di riferimento: [#89](https://github.com/laraxot/base_fixcity_fila5/issues/89), [#90](https://github.com/laraxot/base_fixcity_fila5/issues/90).

Hub cross-cutting modulo: [`ridondanze-cross-cutting-codebase.md`](../concepts/ridondanze-cross-cutting-codebase.md). Glossario rumorosità / merge-marker doc: [`audit-profondo-ridondanze-holistic.md`](./audit-profondo-ridondanze-holistic.md).
