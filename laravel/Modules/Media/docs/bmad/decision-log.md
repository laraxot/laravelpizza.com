---
title: "Decision log — Media"
type: decision-log
status: active
tags: [media, docs]
created: 2026-10-06
updated: 2026-11-16
bmad: true
module: Media
qmd: "decision log Media AwsTest S3Test guard TemporaryUpload prunable Media id cast cancellazione logica documentale StreamVideoAction codice morto"
related:
  - ./audits/media-audit.md
  - ./architecture.md
  - ./epics.md
---

# Decision log — Media

## Formato

- **Data:** YYYY-MM-DD
- **Decisione:** Breve descrizione della decisione presa
- **Stato:** PROPOSTA, APPROVATA, RIFIUTATA, OBSOLETA
- **Impatto:** Alto/Medio/Basso
- **Alternatives considerate:** Elenco delle alternative valutate
- **Conseguenze:** Implicazioni della decisione

## Registro delle decisioni

### 2026-09-29
**Decisione:** [Esempio: Utilizzare Filament Widget invece di Livewire per i componenti di UI]
**Stato:** APPROVATA
**Impatto:** Alto
**Alternatives considerate:** 
- Mantenere Livewire
- Utilizzare componenti Blade tradizionali
**Conseguenze:** 
- Migliore integrazione con Filament
- Riduzione della complessità del codice
- Necessità di migrare componenti esistenti

### 2026-09-30
**Decisione:** [Esempio: Adottare la convenzione "una chiave per riga" per gli array PHP]
**Stato:** APPROVATA
**Impatto:** Medio
**Alternatives considerate:** 
- Array inline
- Array multi-linea senza convenzione fissa
**Conseguenze:** 
- Migliore leggibilità e gestione dei conflitti in git
- Necessità di refactor esistente
Le voci di esempio del template precedente sono state rimosse: non descrivevano il modulo.
Stati ammessi: PROPOSTA, APERTA, APPROVATA, RIFIUTATA, OBSOLETA; ogni voce dichiara il perché e l'evidenza nel codice.

| ID | Data | Stato | Decisione | Perché | Evidenza |
|---|---|---|---|---|---|
| D-5 | 2026-11-16 | PROPOSTA | Cancellare o cablare con policy `StreamVideoAction`, `ConvertController`, `CreateTemporaryUploadFromDirectS3UploadRequest` | 0 caller; autorizzazione di `StreamVideoAction` aggirabile (`$media === null` o non autenticato) | `StreamVideoAction.php:71`, `ConvertController.php:17`, `routes/*.php` vuoti |
| D-4 | 2026-11-16 | PROPOSTA | `AwsTest`/`S3Test` solo `super-admin` (`SuperAdminOnlyTrait`) | Scrivono/cancellano oggetti sul bucket e mostrano config; oggi nessun `canAccess` | `AwsTest.php:345,360` |
| D-3 | 2026-11-16 | **APERTA** | Media «documentali» con sola cancellazione logica; `delete` fisico solo sui rigenerabili | Lo scopo dichiara l'allegato come prova; oggi `DeleteAction` fisico su tutto | `MediaTable.php:90`, `EditMedia.php:23`, purpose § 1 |
| D-2 | 2026-11-16 | **APERTA** | `Media::id`: togliere il cast `string` (schema bigint) o aggiornare il test | Cast contraddice `$table->id()`; test `MediaTest.php:369` fallisce | `Media.php:144`, `create_medias_table.php:23` |
| D-1 | 2026-11-16 | PROPOSTA | Implementare `prunable()` su `TemporaryUpload` con scadenza esplicita e log | `model:prune` → `LogicException`; i temporanei non si ripuliscono | `TemporaryUpload.php:82,241-244` |
| D-0 | 2026-09 | APPROVATA (storica) | `public_path()` = `public_html/`, mai `laravel/public` | Errore muto: 404 solo in produzione | [purpose § vincolo](./purpose.md) |

## D-3 — opzioni

| Opzione | Pro | Contro |
|---|---|---|
| A. `SoftDeletes` su `Media` | cancellazione reversibile ovunque | il file su disco resta; serve politica di pulizia |
| B. Collection «documentale» protetta | protegge solo ciò che è prova | serve classificare le collection esistenti |

Raccomandazione: B (più piccola, aderente allo scopo). Decide il committente.

