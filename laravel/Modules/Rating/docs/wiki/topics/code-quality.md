---
title: "Topic code-quality"
type: digest
status: active
qmd: "digest ceiling 100 code-quality"
---

# Topic code-quality

Sintesi automatica di 3 documenti (chiave `code-quality`).

## Code Quality Analysis - Rating Module

_Fonte: `code-quality-analysis.md`_

# Code Quality Analysis - Rating Module

**Data Analisi**: 2025-01-22  
**PHPStan Level**: 10  
**Status**: ✅ PASSING

## 📊 Risultati Analisi

### PHPStan Level 10
- **Errori**: 0
- **Status**: ✅ Perfetto
- **Ultimo Fix**: Risolti errori di type narrowing in `GetSumByModelRatingIdAction.php`

### PHPMD
- **Configurazione**: `phpmd.ruleset.xml` presente nel modulo
- **Status**: Da eseguire

### PHPInsights
- **Configurazione**: Non presente
- **Raccomandazione**: Creare `phpinsights.php` per analisi completa

## 🔍 Dettagli Fix Implementati

### 1. GetSumByModelRatingIdAction.php
**Problema**: Redundant `Assert::float()` call  
**Soluzione**: Rimosso controllo ridondante, aggiunto `is_numeric` check

```php
// Prima

## Code Quality Improvement Report: Rating

_Fonte: `code-quality-improvement-report.md`_

# Code Quality Improvement Report: Rating

> Baseline statica riproducibile per orientare il miglioramento. I conteggi sono segnali, non sostituiscono PHPStan, Pest o la review del flusso reale.

## Baseline

| Indicatore | Valore |
|---|---:|
| File PHP applicativi/database/route | 69 |
| File di test PHP | 4 |
| Rapporto test/file PHP | 5% |
| Candidati senza strict types | 69 |
| Marker TODO/FIXME/HACK/XXX | 0 |
| Estensioni Filament potenzialmente dirette | 0 |
| Controller da classificare FO/BO | 0 |
| Classi in app/Services o app/Support | 0 |
| Priorità iniziale | **alta** |

Rilevazione del 17 luglio 2026 sul working tree locale; esclusi vendor e dipendenze esterne.

## Rischi e priorità

1. **Type safety:** verificare i candidati e introdurre strict types nei file toccati, con tipi concreti e senza nuovi mixed.
2. **Regressioni:** il rapporto file/test non misura copertura. Proteggere prima autorizzazioni, scritture DB, business rule e bug noti.
3. **Laraxot:** confrontare ogni estensione Filament segnalata con XotBase/LangBase. Classificare i controller: vietati nel front office.
4. **Debito:** ogni marker residuo deve avere owner, motivazione e criterio di rimozione.
5. **Boundary:** non aggiungere business logic in Service/Support; riusare Actions con QueueableAction.

## Piano

## Code quality: modulo Rating

_Fonte: `code-quality-report.md`_

# Code quality: modulo Rating

Report locale (2026-07-17). Metodo: `phpstan analyse` livello max, `phpmd` (ruleset codesize+unusedcode), grep mirati (TODO/FIXME/@deprecated, dd()/dump(), facade in app/Actions, extends Filament diretto), rapporto file test/app.

## Numeri

- File in `app/`: 57
- File di test: 4: rapporto test/app: 7%
- File con TODO/FIXME/@deprecated: 0
- PHPStan: 0 errori (livello max, sweep repo-wide 2026-07-16/17)
- Violazioni PHPMD (codesize+unusedcode): 16
- File in `app/Actions/` che importano Facade Laravel direttamente (violazione pattern QueueableAction, vedi skill `queueable-action-trait`): 0

### Complessità / dimensione classi da rivedere

- Modules/Rating/app/Datas/RatingData.php:34                                                        CyclomaticComplexity      The method fromArray() has a Cyclomatic Complexity of 11. The configured cyclomatic complexity threshold is 10.

## Stato architetturale

- Nessuna violazione `extends \Filament\...` diretto rilevata (regola XotBase rispettata).

## Azioni consigliate

- **Priorità alta**: copertura test sotto il 20%, aggiungere test Pest Feature/Unit sui path critici.
- Rifattorizzare i metodi/classi elencati sopra (complessità ciclomatica/NPath oltre soglia).

## Confronto con gli altri moduli (rapporto test/app)

| Modulo | app | test | % | facade-in-Actions |
