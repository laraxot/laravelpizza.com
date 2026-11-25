---
title: "Topic duplicate-methods"
type: digest
status: active
qmd: "digest ceiling 100 duplicate-methods"
---

# Topic duplicate-methods

Sintesi automatica di 3 documenti (chiave `duplicate-methods`).

## Analisi Metodi Duplicati - Modulo Rating

_Fonte: `duplicate-methods-analysis.md`_

# Analisi Metodi Duplicati - Modulo Rating

**Data Generazione**: 2025-10-15 06:41:17
**Totale Gruppi di Duplicati**: 

## Sommario Esecutivo

Questo documento identifica i metodi duplicati nel modulo **Rating** che potrebbero beneficiare di refactoring.

### Statistiche

| Tipo Refactoring | Conteggio |
|------------------|----------:|
| **Trait** | 0 |
| **Base Class** | 1 |
| **Interface** | 4 |
| **Altro** | 1 |

## Dettaglio Metodi Duplicati

### 1. Metodo: `user`

**Tipo Refactoring**: `BaseClass` | **Complessità**: 🟡 Medium | **Confidenza**: ⚠️ 63%

**Trovato in  file22 file**:

- `extends::user` - [Modules/Activity/app/Models/Activity.php:97](Modules/Activity/app/Models/Activity.php) (Modulo: Activity)
- `Article::user` - [Modules/Blog/app/Models/Article.php:393](Modules/Blog/app/Models/Article.php) (Modulo: Blog)
- `Comment::user` - [Modules/Blog/app/Models/Comment.php:102](Modules/Blog/app/Models/Comment.php) (Modulo: Blog)
- `Activity::user` - [Modules/Fixcity/app/Models/Activity.php:58](Modules/Fixcity/app/Models/Activity.php) (Modulo: Fixcity)

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

## Metodi duplicati — Rating

_Fonte: `duplicate-methods.md`_

# Metodi duplicati — Rating

Analisi sintetica dei metodi PHP con lo stesso nome all’interno di questo ambito.

- File PHP analizzati: **79**
- Metodi duplicati trovati: **35**

## Metodi duplicati

| Metodo | Occorrenze | Note |
|--------|----------|------|
| `getTableColumns` | 6 | candidato a trait/helper |
| `up` | 5 | candidato a trait/helper |
| `getFormSchema` | 4 | candidato a trait/helper |
| `ratings` | 4 | candidato a trait/helper |
| `casts` | 3 | candidato a trait/helper |
| `create` | 3 | candidato a trait/helper |
| `execute` | 3 | candidato a trait/helper |
| `getActions` | 3 | candidato a trait/helper |
| `run` | 3 | candidato a trait/helper |
| `__construct` | 2 | possibile duplicazione |
| `delete` | 2 | possibile duplicazione |
| `dislikedBy` | 2 | possibile duplicazione |
| `down` | 2 | possibile duplicazione |
| `forceDelete` | 2 | possibile duplicazione |
| `fromArray` | 2 | possibile duplicazione |
| `getInfolistSchema` | 2 | possibile duplicazione |
| `getLabel` | 2 | possibile duplicazione |
| `getMyRatingAttribute` | 2 | possibile duplicazione |
| `getPages` | 2 | possibile duplicazione |
