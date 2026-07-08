---
type: analysis
topic: METODI_DUPLICATI_CENSIMENTO
tags: [metodi-duplicati, refactoring, code-quality, dry]
description: Censimento completo dei metodi con nome uguale in moduli diversi, con classificazione per modulo e analisi di refactoring
---

# Metodi Duplicati — Censimento Completo

## Panoramica

**937 metodi** compaiono in almeno 2 file diversi nel codebase.  
Di questi, **881 sono metodi di dominio** (escluso boilerplate framework).

### Metodologia

Cercati tutti i file PHP (esclusi vendor/, .git/, node_modules/, storage/),  
estratte definizioni `function nomeMetodo(`, raggruppate per nome.

### Statistiche per modulo

| Modulo | Metodi duplicati |
|--------|-----------------:|
| Xot | 251 |
| Sigma | 179 |
| User | 165 |
| Progressioni | 106 |
| Performance | 84 |
| Pdnd | 82 |
| Notify | 67 |
| Ptv | 63 |
| IndennitaResponsabilita | 50 |
| IndennitaCondizioniLavoro | 42 |
| UI | 38 |
| Job | 36 |
| Incentivi | 34 |
| Media | 32 |
| Lang | 29 |
| Tenant | 28 |
| DbForge | 24 |
| Rating | 21 |
| Seo | 19 |
| Activity | 13 |
| Gdpr | 9 |
| Setting | 8 |
| MobilitaVolontaria | 2 |

## Pattern Identificati

### 1. Duplicazione accidentale (candidate per refactoring)

Metodi che implementano la **stessa logica** copiata in più moduli:

- **getter/setter generici** (`get*`, `set*`) — ripetuti identici. Candidati per trait Xot.
- **Utility/calcolo** (`calc*`, `compute*`, `format*`) — helper condivisi.
- **Query/filtro** — stessi filtri su tabelle diverse. Candidati per trait `CommonScope`/`BaseModel`.
- **Metodi di notifica** (`via`, `toArray`) — ogni modulo riscrive la stessa logica.
- **Policy method** (`populateFromLastYear` in Progressioni) — 14 policy hanno lo stesso metodo.

### 2. Duplicazione accettabile (da mantenere)

- **Override framework** — Filament (`getFormSchema`, `getTableColumns`), Policy CRUD.
- **Implementazioni interfacce** — ogni modulo personalizza la logica di dominio.
- **Factory method** — `definition()` in Factory, specifico per modello.

### 3. Pattern emergenti

- **`perCodiceFiscale`** — presente in più modelli Sigma, stessa logica di query.
- **`stabiDirigente`** — relazione ripetuta in 7 moduli. Candidato per trait.
- **`aggiornaTot` / `aggiornaPerc`** — calcolo finanziario copiato in 22/16 moduli.

## Candidate Prioritari per Refactoring

1. **Trait XotBaseRelation** — unificare `stabiDirigente`, `qua00f`, `rep00f` (parzialmente fatto con `EnteMatrRelationship`).
2. **Helper Xot** — estrarre `perCodiceFiscale`, `populateFromLastYear`, `getUser`.
3. **Service condiviso** — logiche `aggiornaTot`/`aggiornaPerc` in servizio unico.
4. **CommonScope arricchito** — filtri data ricorrenti già parzialmente coperti.

## Note

- Generato: 2026-06-15
- Tool: `find + grep` su definizioni `function nome(`
- Escluse: migrations (up/down), factories (definition), vendor/, .git/
