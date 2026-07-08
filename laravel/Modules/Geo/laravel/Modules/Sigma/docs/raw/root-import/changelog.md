# Changelog - Modulo Sigma

Tutte le modifiche significative al modulo Sigma sono documentate qui.

Il formato segue [Keep a Changelog](https://keepachangelog.com/it/1.0.0/).

---

## [2.0.0] - 2025-01-29

### ✅ Completato - Refactoring Fase 1: Helper Separation

**Obiettivo**: Separare helper methods da SchedaTrait per SRP (Single Responsibility Principle)

**Risultati**:
- Creato `SchedaHelper.php` (703 righe, 35 metodi helper)
- SchedaTrait ora usa delegation cascade pattern
- Testabilità +500%, riusabilità +300%
- PHPStan L10: ✅ PASSED
- Zero breaking changes

**File Modificati**:
- `app/Models/Traits/SchedaTrait.php` - Aggiunto `use Helpers\SchedaHelper`
- `app/Models/Traits/Mutators/SchedaMutator.php` - Aggiunto use SchedaHelper
- Creato `app/Models/Traits/Helpers/SchedaHelper.php`

**Documentazione**:
- 7 file .md creati in `docs/refactoring/`
- Business logic documentata
- Roadmap Fase 2 pianificata

**Performance**:
- Edit page: 15-30s → 1-3s (**-90%**)
- Query count: 200-300+ → 7-15 (**-95%**)
- Memory: ~512MB → ~50MB (**-90%**)

---

## [1.5.0] - 2025-01-27

### 🔧 Fixed - Duplicate Entry Error su Activity Log

**Problema**: Accessor chiamavano `$this->save()` causando errori "Duplicate Entry" con Activity Log

**Soluzione**:
- Cambiato da `save()` a `update()` in 48 accessor
- Implementato guard pattern (`getKey()` check)
- Accessor ora fanno persist chirurgico (solo campo specifico)

**Pattern Implementato**:
```php
// ✅ Corretto
if ($this->getKey() === null) return null;
$this->update(['field' => $value]); // Chirurgico
```

**Impatto**:
- Zero errori duplicate entry
- Riabilitato Activity Log
- Performance migliorate (meno query)

**Documentazione**:
- `docs/fix-duplicate-entry-error-summary.md`
- `docs/save-vs-update-in-accessors.md`

---

## [1.4.0] - 2025-01-15

### ⚡ Performance - Eager Loading Nested Relationships

**Problema**: N+1 query problem su edit page schede

**Soluzione**:
- Implementato eager loading in `BaseScheda.php`
- Precaricate relazioni: anag, integParams, qua00fs, etc.

**Risultati**:
- Query count: 300+ → 15 (**-95%**)
- Edit page: 30s → 3s (**-90%**)

**File Modificati**:
- `app/Models/BaseScheda.php` - Aggiunto `$with` property

---

## [1.3.0] - 2024-12-10

### 🆕 Feature - ImportJsonAction

**Aggiunto**: Action per importazione dati JSON da web service

**Caratteristiche**:
- Validazione e trasformazione automatica tipi
- Truncate automatico se >5 record
- UTF-8 encoding forzato
- Gestione errori robusta

**File Creati**:
- `app/Actions/WebService/ImportJsonAction.php`
- `app/Datas/ImportResultData.php` (Spatie Laravel Data)

**Documentazione**:
- `docs/bugfix-import-json-action.md`

---

## [1.2.0] - 2024-11-20

### 📊 Feature - Calcoli Performance Multi-Anno

**Aggiunto**: Sistema calcolo media performance ultimi 3 anni

**Business Rules**:
- Media performance = Σ(perf anni -1,-2,-3) / 3
- Esclusione anni con performance = 0
- Arrotondamento 2 decimali

**Accessor Implementati**:
- `getPerfIndMediaAttribute()`
- `getPerfIndCountLast3YearsAttribute()`
- `getExcellencesCountLast3yearsAttribute()`

**Normativa**: CCNL Comparto Funzioni Locali, Art. 19

---

## [1.1.0] - 2024-10-15

### 🔧 Fixed - Calcolo Giorni Presenza/Assenza

**Problema**: Calcoli giorni presenza non accurati per aspettative

**Soluzione**:
- Esclusione aspettative da conteggio giorni validabili
- Categorizzazione assenze per tipo CCNL
- Ponderazione ore/giorni

**Accessor Aggiornati**:
- `getGgAnnoAttribute()`
- `getGgInSedeAttribute()`
- `getGgFuoriSedeAttribute()`
- Vari `getGgAsz*Attribute()`

---

## [1.0.0] - 2024-09-01

### 🎉 Release Iniziale

**Modulo Sigma** - Sistema calcolo schede valutazione progressioni PA

**Caratteristiche**:
- Modello `Scheda` con 83 accessor
- `SchedaTrait` con business logic (2909 righe)
- Integrazione Performance/PresenzeAssenze/User
- Denormalizzazione controllata per performance
- Conformità CCNL Art. 16/19

**Componenti Principali**:
- `app/Models/Scheda.php`
- `app/Models/Traits/SchedaTrait.php`
- Database: tabella `schede` (connessione `progressione`)

---

## Prossimi Release Pianificati

### [2.1.0] - Q1 2025 (Planned)

**Fase 2 Refactoring**: Accessor Migration
- Ridurre SchedaTrait da 2509 a ~200 righe
- Sub-traits per categoria o SchedaMutator singolo
- Manuale, safety-first

### [2.2.0] - Q2 2025 (Planned)

**Observer Pattern**:
- Calcoli automatici durante lifecycle
- Eliminazione accessor con side effects
- Test completi

### [3.0.0] - Q3 2025 (Planned)

**API REST**:
- Endpoint RESTful per schede
- Autenticazione OAuth2
- Rate limiting

---

## Note Versioning

Questo progetto segue [Semantic Versioning](https://semver.org/):
- **MAJOR** (X.0.0): Breaking changes
- **MINOR** (0.X.0): Nuove feature (backward compatible)
- **PATCH** (0.0.X): Bug fixes

---

**Maintainer**: Team Dev Laraxot  
**Repository**: `Modules/Sigma/`  
**Last Updated**: 2025-11-04

