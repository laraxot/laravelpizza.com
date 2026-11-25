---
title: "Topic duplicate-methods"
type: digest
status: active
qmd: "digest ceiling 100 duplicate-methods"
---

# Topic duplicate-methods

Sintesi automatica di 3 documenti (chiave `duplicate-methods`).

## Analisi Metodi Duplicati - Modulo Media

_Fonte: `duplicate-methods-analysis.md`_

# Analisi Metodi Duplicati - Modulo Media

**Totale Gruppi di Duplicati**:

## Sommario Esecutivo

Questo documento identifica i metodi duplicati nel modulo **Media** che potrebbero beneficiare di refactoring.

### Statistiche

| Tipo Refactoring | Conteggio |
|------------------|----------:|
| **Trait** | 2 |
| **Base Class** | 0 |
| **Interface** | 4 |
| **Altro** | 2 |

## Dettaglio Metodi Duplicati

### 1. Metodo: `make`

**Tipo Refactoring**: `Trait` | **Complessità**: 🟢 Low | **Confidenza**: ✅ 100%

**Trovato in  file5 file**:

- `SubtitleService::make` - [Modules/Media/app/Services/SubtitleService.php:52](Modules/Media/app/Services/SubtitleService.php)
- `SmsService::make` - [Modules/Notify/app/Services/SmsService.php:53](Modules/Notify/app/Services/SmsService.php) (Modulo: Notify)
- `ConfigService::make` - [Modules/Xot/app/Services/ConfigService.php:39](Modules/Xot/app/Services/ConfigService.php) (Modulo: Xot)
- `ModuleService::make` - [Modules/Xot/app/Services/ModuleService.php:42](Modules/Xot/app/Services/ModuleService.php) (Modulo: Xot)
- `UrlService::make` - [Modules/Xot/app/Services/UrlService.php:37](Modules/Xot/app/Services/UrlService.php) (Modulo: Xot)

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

## Metodi duplicati — Media

_Fonte: `duplicate-methods.md`_

# Metodi duplicati — Media

Analisi sintetica dei metodi PHP con lo stesso nome all’interno di questo ambito.

- File PHP analizzati: **115**
- Metodi duplicati trovati: **42**

## Metodi duplicati

| Metodo | Occorrenze | Note |
|--------|----------|------|
| `execute` | 14 | candidato a trait/helper |
| `getFormSchema` | 11 | candidato a trait/helper |
| `getTableColumns` | 8 | candidato a trait/helper |
| `getInfolistSchema` | 6 | candidato a trait/helper |
| `setUp` | 5 | candidato a trait/helper |
| `up` | 5 | candidato a trait/helper |
| `__construct` | 4 | candidato a trait/helper |
| `create` | 4 | candidato a trait/helper |
| `run` | 4 | candidato a trait/helper |
| `definition` | 3 | candidato a trait/helper |
| `delete` | 3 | candidato a trait/helper |
| `forceDelete` | 3 | candidato a trait/helper |
| `getHeaderActions` | 3 | candidato a trait/helper |
| `getPages` | 3 | candidato a trait/helper |
| `getRelations` | 3 | candidato a trait/helper |
| `getTableActions` | 3 | candidato a trait/helper |
| `getTableFilters` | 3 | candidato a trait/helper |
| `restore` | 3 | candidato a trait/helper |
| `update` | 3 | candidato a trait/helper |
