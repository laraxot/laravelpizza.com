# Analisi Globale Metodi Duplicati - FixCity

**Data Generazione**: 2025-10-15 06:41:17
**Totale Metodi Analizzati**: 910
**Totale Gruppi di Duplicati**: 81

## Panoramica

Questa analisi identifica opportunità di refactoring cross-module per ridurre la duplicazione del codice e migliorare la manutenibilità.

## Top 10 Metodi Più Duplicati

| # | Metodo | Occorrenze | Tipo Refactoring | Confidenza |
|---|--------|------------|------------------|------------|
| 1 | `casts` | 105 | Interface | 33% |
| 2 | `execute` | 62 | Interface | 9% |
| 3 | `user` | 22 | BaseClass | 63% |
| 4 | `getRows` | 18 | Interface | 38% |
| 5 | `ticket` | 6 | BaseClass | 66% |
| 6 | `getInstance` | 6 | Trait | 50% |
| 7 | `users` | 6 | Interface | 16% |
| 8 | `make` | 5 | Trait | 100% |
| 9 | `category` | 4 | Pattern | 50% |
| 10 | `comments` | 4 | Interface | 25% |

## Statistiche per Tipo di Refactoring

| Tipo | Conteggio | Percentuale |
|------|-----------|-------------|
| Interface | 40 | 49.4% |
| BaseClass | 3 | 3.7% |
| Trait | 15 | 18.5% |
| Pattern | 23 | 28.4% |

## Moduli con Più Duplicazioni

| Modulo | Metodi Duplicati | Report |
|--------|------------------|--------|
| Fixcity | 76 | [Visualizza](Modules/Fixcity/docs/duplicate-methods-analysis.md) |
| User | 55 | [Visualizza](Modules/User/docs/duplicate-methods-analysis.md) |
| Geo | 46 | [Visualizza](Modules/Geo/docs/duplicate-methods-analysis.md) |
| Notify | 34 | [Visualizza](Modules/Notify/docs/duplicate-methods-analysis.md) |
| Blog | 33 | [Visualizza](Modules/Blog/docs/duplicate-methods-analysis.md) |
| Cms | 30 | [Visualizza](Modules/Cms/docs/duplicate-methods-analysis.md) |
| Job | 30 | [Visualizza](Modules/Job/docs/duplicate-methods-analysis.md) |
| Xot | 29 | [Visualizza](Modules/Xot/docs/duplicate-methods-analysis.md) |
| Lang | 21 | [Visualizza](Modules/Lang/docs/duplicate-methods-analysis.md) |
| Tenant | 11 | [Visualizza](Modules/Tenant/docs/duplicate-methods-analysis.md) |
| Activity | 10 | [Visualizza](Modules/Activity/docs/duplicate-methods-analysis.md) |
| Media | 10 | [Visualizza](Modules/Media/docs/duplicate-methods-analysis.md) |
| Rating | 8 | [Visualizza](Modules/Rating/docs/duplicate-methods-analysis.md) |
| AI | 4 | [Visualizza](Modules/AI/docs/duplicate-methods-analysis.md) |
| Comment | 3 | [Visualizza](Modules/Comment/docs/duplicate-methods-analysis.md) |
| Gdpr | 3 | [Visualizza](Modules/Gdpr/docs/duplicate-methods-analysis.md) |
| UI | 2 | [Visualizza](Modules/UI/docs/duplicate-methods-analysis.md) |
| Seo | 1 | [Visualizza](Modules/Seo/docs/duplicate-methods-analysis.md) |

## Prossimi Passi

1. Consultare i report specifici per modulo
2. Prioritizzare refactoring ad alta confidenza (>70%) e bassa complessità
3. Creare Traits per metodi identici
4. Valutare Base Classes per gerarchie condivise
5. Eseguire test approfonditi dopo ogni refactoring
6. Verificare PHPStan Level Max dopo modifiche

