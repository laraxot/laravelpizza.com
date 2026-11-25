---
title: "Topic duplicate-methods"
type: digest
status: active
qmd: "digest ceiling 100 duplicate-methods"
---

# Topic duplicate-methods

Sintesi automatica di 4 documenti (chiave `duplicate-methods`).

## Report: Metodi con nome duplicato nei moduli e nei temi

_Fonte: `analysis/duplicate-methods-report.md`_

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

## Analisi Metodi Duplicati - Modulo Gdpr

_Fonte: `duplicate-methods-analysis.md`_

# Analisi Metodi Duplicati - Modulo Gdpr

**Totale Gruppi di Duplicati**:

## Sommario Esecutivo

Questo documento identifica i metodi duplicati nel modulo **Gdpr** che potrebbero beneficiare di refactoring.

### Statistiche

| Tipo Refactoring | Conteggio |
|------------------|----------:|
| **Trait** | 0 |
| **Base Class** | 0 |
| **Interface** | 1 |
| **Altro** | 0 |

## Dettaglio Metodi Duplicati

### 1. Metodo: `casts`

**Tipo Refactoring**: `Interface` | **Complessità**: 🟢 Low | **Confidenza**: ❌ 33%

**Trovato in  file105 file**:

- `BaseModel::casts` - [Modules/Activity/app/Models/BaseModel.php:56](Modules/Activity/app/Models/BaseModel.php) (Modulo: Activity)
- `Article::casts` - [Modules/Blog/app/Models/Article.php:273](Modules/Blog/app/Models/Article.php) (Modulo: Blog)
- `Banner::casts` - [Modules/Blog/app/Models/Banner.php:196](Modules/Blog/app/Models/Banner.php) (Modulo: Blog)
- `BaseModel::casts` - [Modules/Blog/app/Models/BaseModel.php:65](Modules/Blog/app/Models/BaseModel.php) (Modulo: Blog)

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

## Metodi duplicati — Gdpr

_Fonte: `duplicate-methods.md`_

# Metodi duplicati — Gdpr

Analisi sintetica dei metodi PHP con lo stesso nome all’interno di questo ambito.

- File PHP analizzati: **101**
- Metodi duplicati trovati: **25**

## Metodi duplicati

| Metodo | Occorrenze | Note |
|--------|----------|------|
| `getFormSchema` | 14 | candidato a trait/helper |
| `getTableColumns` | 12 | candidato a trait/helper |
| `up` | 8 | candidato a trait/helper |
| `execute` | 7 | candidato a trait/helper |
| `getInfolistSchema` | 6 | candidato a trait/helper |
| `getPages` | 6 | candidato a trait/helper |
| `create` | 4 | candidato a trait/helper |
| `definition` | 4 | candidato a trait/helper |
| `delete` | 4 | candidato a trait/helper |
| `forceDelete` | 4 | candidato a trait/helper |
| `restore` | 4 | candidato a trait/helper |
| `update` | 4 | candidato a trait/helper |
| `view` | 4 | candidato a trait/helper |
| `viewAny` | 4 | candidato a trait/helper |
| `booted` | 3 | candidato a trait/helper |
| `getRelations` | 3 | candidato a trait/helper |
| `canView` | 2 | possibile duplicazione |
| `getOptionalConsentTypes` | 2 | possibile duplicazione |
