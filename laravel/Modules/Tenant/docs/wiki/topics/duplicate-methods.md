---
title: "Topic duplicate-methods"
type: digest
status: active
qmd: "digest ceiling 100 duplicate-methods"
---

# Topic duplicate-methods

Sintesi automatica di 3 documenti (chiave `duplicate-methods`).

## Analisi Metodi Duplicati - Modulo Tenant

_Fonte: `duplicate-methods-analysis.md`_

# Analisi Metodi Duplicati - Modulo Tenant

**Totale Gruppi di Duplicati**:

## Sommario Esecutivo

Questo documento identifica i metodi duplicati nel modulo **Tenant** che potrebbero beneficiare di refactoring.

### Statistiche

| Tipo Refactoring | Conteggio |
|------------------|----------:|
| **Trait** | 0 |
| **Base Class** | 0 |
| **Interface** | 7 |
| **Altro** | 1 |

## Dettaglio Metodi Duplicati

### 1. Metodo: `trans`

**Tipo Refactoring**: `Interface` | **Complessità**: 🟢 Low | **Confidenza**: ⚠️ 66%

**Trovato in  file3 file**:

- `TransArrayAction::trans` - [Modules/Lang/app/Actions/TransArrayAction.php:44](Modules/Lang/app/Actions/TransArrayAction.php) (Modulo: Lang)
- `TransCollectionAction::trans` - [Modules/Lang/app/Actions/TransCollectionAction.php:43](Modules/Lang/app/Actions/TransCollectionAction.php) (Modulo: Lang)
- `TenantService::trans` - [Modules/Tenant/app/Services/TenantService.php:347](Modules/Tenant/app/Services/TenantService.php)

**Signature**:

## Report: Metodi con nome duplicato nei moduli e nei temi

_Fonte: `duplicate-methods-report.md`_

# Report: Metodi con nome duplicato nei moduli e nei temi

## Introduzione
Questo documento elenca i metodi PHP presenti nei sotto‑directory `laravel/Modules` e `laravel/Themes` che compaiono più di una volta nel codicebase.  
L’analisi è stata effettuata mediante **grep** ricorsivo sui file `.php` e il conteggio delle occorrenze è mostrato per ciascun metodo.

## Metodologia
```bash
grep -rhE "function\s+[a-zA-Z_][a-zA-Z0-9_]*\s*\(\)" laravel/Modules --include="*.php" | \
  grep -oE "[a-zA-Z_][a-zA-Z0-9_]*\s*\(\)" | \
  sed 's/($//' | \
  sort | \
  uniq -c | \
  sort -rn
```

Il comando restituisce il numero di occorrenze di ogni firma di metodo (`function nome()`).  
Sono stati considerati tutti i metodi pubblici, protetti e privati dichiarati all’interno dei file PHP dei moduli e dei temi.

## Risultati
Di seguito la classifica dei metodi più frequenti (solo quelli con più di una occorrenza).

| Conteggio | Nome metodo |
|---------|-------------|
| 500 | `up` |
| 467 | `definition` |
| 463 | `execute` |
| 320 | `down` |
| 257 | `getFormSchema` |
| 208 | `__construct` |

## Metodi duplicati — Tenant

_Fonte: `duplicate-methods.md`_

# Metodi duplicati — Tenant

Analisi sintetica dei metodi PHP con lo stesso nome all’interno di questo ambito.

- File PHP analizzati: **76**
- Metodi duplicati trovati: **26**

## Metodi duplicati

| Metodo | Occorrenze | Note |
|--------|----------|------|
| `execute` | 13 | candidato a trait/helper |
| `definition` | 11 | candidato a trait/helper |
| `active` | 6 | candidato a trait/helper |
| `casts` | 5 | candidato a trait/helper |
| `getJsonFile` | 5 | candidato a trait/helper |
| `run` | 5 | candidato a trait/helper |
| `canResolve` | 4 | candidato a trait/helper |
| `getRows` | 4 | candidato a trait/helper |
| `getSushiRows` | 4 | candidato a trait/helper |
| `inactive` | 4 | candidato a trait/helper |
| `resolve` | 4 | candidato a trait/helper |
| `authId` | 2 | possibile duplicazione |
| `ensureDirectoryExists` | 2 | possibile duplicazione |
| `findRowIndexById` | 2 | possibile duplicazione |
| `getFormSchema` | 2 | possibile duplicazione |
| `getOriginalConfig` | 2 | possibile duplicazione |
| `getTenantConfig` | 2 | possibile duplicazione |
| `highPriority` | 2 | possibile duplicazione |
| `loadExistingData` | 2 | possibile duplicazione |
