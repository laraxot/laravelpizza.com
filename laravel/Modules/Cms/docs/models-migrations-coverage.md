---
type: note
tags: [documentation]
updated: 2026-09-26
qmd: "models migrations coverage"
issues: []
discussions: []
title: "Cms — copertura Models / Migration / Seeder / Factory"
created: 2026-07-24
last_updated: 2026-07-24
status: "implemented"
---

# Cms — copertura Model ↔ Migration ↔ Seeder ↔ Factory

Regola: ogni modello concreto (esclusi base/abstract) deve avere migration + seeder + factory
**per la propria tabella fisica**. I modelli backed da Sushi (dati in-memory da JSON/config) NON
hanno una tabella persistente e quindi NON richiedono migration.

## Modelli base (esclusi)

- `BaseModel`, `BaseModelLang`, `BaseTreeModel`, `BasePivot`, `BaseMorphPivot` — astratti/di supporto.

## Modelli concreti

| Modello | Backing | Tabella fisica | Migration | Seeder | Factory | Nota |
|---------|---------|----------------|-----------|--------|---------|------|
| `PageContent` | Eloquent (`cms`) | `page_contents` | ✅ `create_page_contents_table` | ✅ | ✅ | tabella reale |
| `Menu` | Eloquent (`cms`) | `menus` | ✅ `create_menus_table` | ✅ | ✅ | tabella reale |
| `Page` | **Sushi** (`SushiToJsons`) | — (JSON `database/content/`) | ⚠️ `create_cms_pages_table` legacy | ✅ | ✅ | vedi sotto |
| `Section` | **Sushi** (`SushiToJsons`) | — (JSON `database/content/`) | ❌ non necessaria | ✅ | ✅ | skip legittimo |
| `Conf` | **Sushi** (`getRows` da config tenant) | — (in-memory) | ❌ non necessaria | ✅ | ✅ | skip legittimo |
| `Module` | **Sushi** (`getRows` da nwidart modules) | — (in-memory) | ❌ non necessaria | ✅ | ✅ | skip legittimo |
| `Attachment` | **Sushi** (`SushiToJsons`) + Spatie Media | — (JSON + tabella `media` in modulo Media) | ❌ non necessaria | ✅ | ✅ | skip legittimo |

## Perché i gap migration sono legittimi

Il presunto gap (7 modelli, 3 migration) NON è un buco reale: **4 modelli su 7 usano Sushi**
(`Sushi\Sushi` / trait `Modules\Tenant\Models\Traits\SushiToJsons`). I modelli Sushi generano una
tabella SQLite in-memory al volo a partire da array/file JSON, quindi non hanno — e non devono avere —
una migration persistente:

- `Page`, `Section`, `Attachment` → dati letti da file JSON in `database/content/<tabella>/*.json`
  tramite `SushiToJsons` (schema definito nella property `$schema` del modello).
- `Conf` → righe da `GetTenantConfigNamesAction`.
- `Module` → righe dai moduli nwidart attivi (`NwModule::getByStatus`).

Le uniche tabelle fisiche sono `page_contents` (`PageContent`) e `menus` (`Menu`), entrambe già
coperte da migration.

`Attachment` inoltre usa Spatie Media Library: la relazione media punta alla tabella `media` che è di
competenza del modulo Media, non di Cms.

### Nota su `create_cms_pages_table`

Esiste una migration `2024_01_01_000005_create_cms_pages_table.php` ma `Page` è oggi backed da Sushi
(`SushiToJsons`) e non legge da quella tabella. La migration è quindi **legacy/residuale**: lasciata
in loco (forward-only, nessuna rimozione), ma non è la fonte dati del modello.

## Esito

Nessuna nuova migration creata per Cms: tutti i modelli senza migration sono Sushi-backed e il gap è
legittimo e documentato.
