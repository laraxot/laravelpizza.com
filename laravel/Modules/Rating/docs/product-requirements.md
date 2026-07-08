# Product Requirements Document (PRD)

## Metadata

| Campo | Valore |
|-------|--------|
| **Version** | 1.0.0 |
| **Status** | Approved |
| **Last Updated** | 2026-03-03 |
| **Owner** | User Team |
| **Module** | Rating |
| **Repository** | laraxot/module_rating_fila5 |

---

## 1. Panoramica del Prodotto

### Descrizione Breve
Il modulo Rating fornisce un sistema per **ratings e valutazioni** con supporto per attributi schemaless. Permette di aggiungere valutazioni a qualsiasi entità.

### Visione
Sistema flessibile per:
- User ratings
- Reviews
- Feedback
- Polling

---

## 2. Problema

### Problema Risolto
- Ratings hardcoded
- Schema rigido
- Difficoltà estensione

---

## 3. Soluzione Proposta

### Funzionalità

#### 3.1 Rating System
- [x] Star ratings
- [x] Numerical ratings
- [x] Thumbs up/down
- [x] Custom scales

#### 3.2 Review System
- [x] Text reviews
- [x] Photos
- [x] Responses
- [x] Moderation

#### 3.3 Schemaless
- [x] Dynamic attributes
- [x] No migration needed
- [x] Flexible schema

---

## 4. Scope

### In Scope
- [x] Star ratings
- [x] Reviews
- [x] Schemaless attributes

### Out of Scope
- [ ] Gamification

---

## 5. Dipendenze

### Esterne
| Pacchetto | Scopo |
|-----------|-------|
| spatie/laravel-schemaless-attributes | Attributi dinamici |

### Interne
Xot, Tenant, User
