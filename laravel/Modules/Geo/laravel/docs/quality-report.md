# Quality Report — Globale Moduli

**Generated:** 2026-06-18  
**Commit:** `dev` branch  

## Indice

1. [PHPStan — Static Analysis](#1-phpstan--static-analysis)
2. [PHPMD — Mess Detector](#2-phpmd--mess-detector)
3. [PHPInsights — Code Quality Scores](#3-phpinsights--code-quality-scores)
4. [Pest — Test Suite](#4-pest--test-suite)
5. [Riepilogo per Modulo](#5-riepilogo-per-modulo)
6. [Piano di Correzioni Prioritarie](#6-piano-di-correzioni-prioritarie)

---

## 1. PHPStan — Static Analysis

**Livello:** max (10)  
**Stato:** ✅ Tutti i moduli a zero errori

| Modulo | Status | Errori |
|--------|--------|--------|
| Activity | ✅ | 0 |
| IndennitaCondizioniLavoro | ✅ | 0 |
| IndennitaResponsabilita | ✅ | 0 |
| Job | ✅ | 0 |
| Lang | ✅ | 0 |
| Media | ✅ | 0 |
| Notify | ✅ | 0 |
| Pdnd | ✅ | 0 |
| Performance | ✅ | 0 |
| Progressioni | ✅ | 0 |
| Ptv | ✅ | 0 |
| Rating | ✅ | 0 |
| Seo | ✅ | 0 |
| Sigma | ✅ | 0 |
| Tenant | ✅ | 0 |
| UI | ✅ | 0 |
| User | ✅ | 0 |
| Xot | ✅ | 0 |

**Nota:** Incentivi escluso dalla configurazione root (1000+ errori, richiede baseline dedicata).

---

## 2. PHPMD — Mess Detector

**Totale violazioni:** 3 344 su 18 moduli  

### Top 10 Violazioni Cross-Modulo

| # | Regola | Conteggio | % su totale | Beneficio potenziale se corretto |
|---|--------|-----------|-------------|----------------------------------|
| 1 | **UnusedFormalParameter** | 875 | 26.2% | Riduce rumore codice, migliora leggibilità (~5-8% Style) |
| 2 | **CamelCaseVariableName** | 663 | 19.8% | Standard PSR, consistenza naming (~10-15% Style) |
| 3 | **CamelCaseParameterName** | 275 | 8.2% | Allinea parametri a standard PSR (~3-5% Style) |
| 4 | **CamelCasePropertyName** | 208 | 6.2% | Proprietà consistenti (~3-5% Style) |
| 5 | **MissingImport** | 204 | 6.1% | Chiarezza namespace, supporto IDE (~3-5% Architecture) |
| 6 | **CyclomaticComplexity** | 151 | 4.5% | Metodi più testabili, manutenibili (~5-10% Complexity) |
| 7 | **LongVariable** | 150 | 4.5% | Nomi descrittivi ma proporzionati (~2-3% Style) |
| 8 | **ShortVariable** | 144 | 4.3% | Nomi significativi invece di 1-2 caratteri (~3-5% Style) |
| 9 | **ElseExpression** | 118 | 3.5% | Early return riduce annidamento (~2-3% Complexity) |
| 10 | **UnusedLocalVariable** | 117 | 3.5% | Rimuove dead code (~1-2% Code) |

### Violazioni per Modulo

| Modulo | File PHP | Violazioni | Violazioni/File | PHPMD Densitá |
|--------|----------|------------|-----------------|---------------|
| Sigma | 359 | 682 | 1.90 | 🔴 Alta |
| User | 630 | 491 | 0.78 | 🟠 Media |
| Progressioni | 257 | 406 | 1.58 | 🔴 Alta |
| Ptv | 267 | 280 | 1.05 | 🟠 Media |
| IndennitaResponsabilita | 124 | 248 | 2.00 | 🔴 Alta |
| Notify | 211 | 217 | 1.03 | 🟠 Media |
| Performance | 279 | 209 | 0.75 | 🟡 Bassa |
| IndennitaCondizioniLavoro | 75 | 161 | 2.15 | 🔴 Alta |
| Media | 89 | 160 | 1.80 | 🔴 Alta |
| Job | 148 | 122 | 0.82 | 🟡 Bassa |
| Pdnd | 99 | 113 | 1.14 | 🟠 Media |
| UI | 109 | 91 | 0.83 | 🟡 Bassa |
| Lang | 54 | 57 | 1.06 | 🟠 Media |
| Rating | 57 | 50 | 0.88 | 🟡 Bassa |
| Tenant | 49 | 48 | 0.98 | 🟡 Bassa |
| Seo | 7 | 5 | 0.71 | 🟢 Bassa |
| Activity | 52 | 4 | 0.08 | 🟢 Bassa |
| Xot | 498 | 0 | 0.00 | 🟢 Zero |

### Categorie di Violazioni con Beneficio Stimato

| Regola | Conteggio | Sforzo Fix | Beneficio Stimato |
|--------|-----------|-----------|-------------------|
| **UnusedFormalParameter** | 875 | ⚪ Basso (rimozione parametro) | ~5-8% Style |
| **CamelCaseVariableName** | 663 | 🟡 Medio (rename in tutto il file) | ~10-15% Style |
| **CamelCaseParameterName** | 275 | 🟡 Medio (rename parametri) | ~3-5% Style |
| **CamelCasePropertyName** | 208 | 🟡 Medio (rename proprietà) | ~3-5% Style |
| **MissingImport** | 204 | ⚪ Basso (aggiungere `use` statment) | ~3-5% Architecture |
| **CyclomaticComplexity** | 151 | 🔴 Alto (refactor metodi) | ~5-10% Complexity |
| **LongVariable** | 150 | ⚪ Basso (rename) | ~2-3% Style |
| **ShortVariable** | 144 | ⚪ Basso (rename) | ~3-5% Style |
| **ElseExpression** | 118 | 🟡 Medio (early return) | ~2-3% Complexity |
| **UnusedLocalVariable** | 117 | ⚪ Basso (rimozione) | ~1-2% Code |
| **UndefinedVariable** | 95 | 🔴 Alto (potenziale bug) | ~5-8% Code + runtime safety |
| **NPathComplexity** | 84 | 🔴 Alto (refactor percorsi) | ~3-5% Complexity |
| **CouplingBetweenObjects** | 65 | 🔴 Alto (disaccoppiamento) | ~5-10% Architecture |
| **ExcessiveMethodLength** | 51 | 🔴 Alto (estrarre metodi) | ~3-5% Complexity |
| **BooleanArgumentFlag** | 43 | 🟡 Medio (split metodi) | ~2-3% Architecture |
| **CamelCaseMethodName** | 37 | 🟡 Medio (rename) | ~1-2% Style |

---

## 3. PHPInsights — Code Quality Scores

**Formato:** Code / Complexity / Architecture / Style  
**Soglia target:** 80% per ogni categoria

| Modulo | Code | Complexity | Architecture | Style | Media | Peggiore |
|--------|------|-----------|-------------|-------|-------|----------|
| Seo | **92.0** | 93.9 | **88.2** | **96.4** | 92.6 | — |
| Activity | **88.0** | **96.1** | **82.4** | **90.4** | 89.2 | — |
| Rating | **88.0** | **95.3** | 70.6 | **97.6** | 87.9 | Architecture |
| Lang | **85.0** | **92.6** | 70.6 | **94.0** | 85.6 | Architecture |
| Tenant | **85.0** | **87.0** | 70.6 | **88.0** | 82.7 | Architecture |
| Notify | **85.6** | **91.2** | 76.5 | 78.3 | 82.9 | Architecture |
| IndennitaCondizioniLavoro | **84.0** | **90.8** | **58.8** | **80.7** | 78.6 | Architecture ❌ |
| UI | **82.0** | **95.6** | 76.5 | **94.0** | 87.0 | Architecture |
| Media | **80.0** | **93.4** | **82.4** | **84.3** | 85.0 | — |
| User | **80.0** | **96.4** | 64.7 | **92.8** | 83.5 | Architecture |
| Pdnd | 77.0 | 62.1 | 58.8 | 68.7 | 66.7 | Complexity ❌ |
| IndennitaResponsabilita | 78.0 | **95.5** | 58.8 | 74.7 | 76.8 | Architecture ❌ |
| Xot | 74.2 | **91.6** | 47.1 | **92.8** | 76.4 | Architecture ❌ |
| Performance | 73.0 | **97.2** | 58.8 | 66.3 | 73.8 | Architecture ❌ |
| Progressioni | 73.0 | **98.2** | 52.9 | 74.7 | 74.7 | Architecture ❌ |
| Sigma | 73.0 | **95.2** | 52.9 | 72.3 | 73.4 | Architecture ❌ |
| Ptv | 69.0 | **89.6** | 58.8 | 67.5 | 71.2 | Architecture ❌ |
| Job | — | — | — | — | — | Non analizzabile (nessun file PHP in app/) |

**Legenda:** ❌ = sotto soglia 80% | **grassetto** = sopra 80%

### Pattern Emergenti

1. **Architecture è il collo di bottiglia**: 10 moduli su 18 sotto 80%. Il problema principale sono proprietà pubbliche, coupling elevato e import mancanti.
2. **Complexity è il punto di forza**: 16 moduli su 18 sopra 80%. Il codice è generalmente ben strutturato in termini di complessità.
3. **Code quality nella media**: 12 moduli sopra 80%, 5 tra 69% e 78%.
4. **Style generally good**: 13 moduli sopra 80%, con picchi in Rating (97.6%) e Seo (96.4%).

### Beneficio Stimato per Categoria

| Categoria | Media attuale | Target | Gap | Strategia |
|-----------|--------------|--------|-----|-----------|
| Code | 79.3% | 85% | +5.7% | Rimuovere unused vars, fix undefined vars, aggiungere type hints |
| Complexity | 91.6% | 95% | +3.4% | Ridurre cyclomatic complexity in metodi lunghi, NPath |
| Architecture | 65.2% | 80% | **+14.8%** | Disaccoppiamento, rimuovere proprietà pubbliche, aggiungere import |
| Style | 83.3% | 90% | +6.7% | Rispettare naming convention PSR (camelCase) |

---

## 4. Pest — Test Suite

**Stato:** ⚠️ Database non configurato per test

| Modulo | File Test | Eseguibili |
|--------|-----------|-----------|
| User | 112 | Solo con DB |
| Notify | 104 | Solo con DB |
| Xot | 103 | Solo con DB |
| Activity | 64 | Solo con DB |
| Job | 29 | Solo con DB |
| Tenant | 24 | Solo con DB |
| UI | 23 | Solo con DB |
| Lang | 15 | Solo con DB |
| Media | 11 | Solo con DB |
| Progressioni | 10 | Solo con DB |
| Ptv | 6 | Solo con DB |
| IndennitaCondizioniLavoro | 6 | Solo con DB |
| Performance | 5 | Solo con DB |
| Rating | 3 | Solo con DB |
| Pdnd | 2 | Solo con DB |
| IndennitaResponsabilita | 2 | Solo con DB |
| Sigma | 1 | Solo con DB |
| **Totale** | **520** | Richiedono .env.testing con DB |

**Raccomandazione:** Configurare `.env.testing` con database SQLite o MySQL di test per abilitare la suite completa.

---

## 5. Riepilogo per Modulo

| Modulo | File | PHPStan | PHPMD | Code | Compl. | Arch. | Style | Priorità Fix |
|--------|------|--------|-------|------|--------|-------|-------|-------------|
| **Xot** | 498 | ✅ | 0 | 74.2 | 91.6 | 47.1 | 92.8 | Architecture 🔴 |
| **User** | 630 | ✅ | 491 | 80.0 | 96.4 | 64.7 | 92.8 | Architecture 🟠 |
| **Sigma** | 359 | ✅ | 682 | 73.0 | 95.2 | 52.9 | 72.3 | Architecture + Style 🔴 |
| **Ptv** | 267 | ✅ | 280 | 69.0 | 89.6 | 58.8 | 67.5 | Architecture + Style 🔴 |
| **Progressioni** | 257 | ✅ | 406 | 73.0 | 98.2 | 52.9 | 74.7 | Architecture 🔴 |
| **Performance** | 279 | ✅ | 209 | 73.0 | 97.2 | 58.8 | 66.3 | Architecture + Style 🔴 |
| **Notify** | 211 | ✅ | 217 | 85.6 | 91.2 | 76.5 | 78.3 | Architecture 🟠 |
| **IndennitaResponsabilita** | 124 | ✅ | 248 | 78.0 | 95.5 | 58.8 | 74.7 | Architecture 🔴 |
| **IndennitaCondizioniLavoro** | 75 | ✅ | 161 | 84.0 | 90.8 | 58.8 | 80.7 | Architecture 🔴 |
| **Pdnd** | 99 | ✅ | 113 | 77.0 | 62.1 | 58.8 | 68.7 | Complexity + Arch 🔴 |
| **Media** | 89 | ✅ | 160 | 80.0 | 93.4 | 82.4 | 84.3 | PHPMD naming 🟠 |
| **UI** | 109 | ✅ | 91 | 82.0 | 95.6 | 76.5 | 94.0 | Architecture 🟠 |
| **Job** | 148 | ✅ | 122 | — | — | — | — | Analisi iniziale ⚪ |
| **Lang** | 54 | ✅ | 57 | 85.0 | 92.6 | 70.6 | 94.0 | Architecture 🟠 |
| **Tenant** | 49 | ✅ | 48 | 85.0 | 87.0 | 70.6 | 88.0 | Architecture 🟠 |
| **Rating** | 57 | ✅ | 50 | 88.0 | 95.3 | 70.6 | 97.6 | Architecture 🟠 |
| **Seo** | 7 | ✅ | 5 | 92.0 | 93.9 | 88.2 | 96.4 | PHPMD minore ⚪ |
| **Activity** | 52 | ✅ | 4 | 88.0 | 96.1 | 82.4 | 90.4 | PHPMD minore ⚪ |

---

## 6. Piano di Correzioni Prioritarie

### Fase 1 — Impatto Immediato (Basso sforzo, alto beneficio)
Violazioni facili da correggere con search/replace o rename automatici:

| Attivitá | Violazioni | Sforzo | Beneficio stimato |
|----------|-----------|--------|-------------------|
| 🔧 Rimuovere `UnusedFormalParameter` | 875 | 2-3 min l'una | +5-8% Style |
| 🔧 Aggiungere `MissingImport` mancanti | 204 | 30 sec l'una | +3-5% Architecture |
| 🔧 Eliminare `UnusedLocalVariable` | 117 | 1 min l'una | +1-2% Code |
| 🔧 Rinominare `ShortVariable` (1-2 char) | 144 | 2-3 min l'una | +3-5% Style |
| 🔧 Rinominare `LongVariable` (>25 char) | 150 | 1-2 min l'una | +2-3% Style |
| **Subtotale** | **1.490** | **~8-12 ore** | **+14-23% media** |

### Fase 2 — Refactoring Architetturale (Sforzo medio)
| Attivitá | Moduli interessati | Sforzo | Beneficio stimato |
|----------|-------------------|--------|-------------------|
| 🏗 Disaccoppiamento classi (CBO) | Tutti i moduli | 2-4 ore per modulo | +5-10% Architecture |
| 🏗 Ridurre proprietà pubbliche | Models, Providers | 1-2 ore per modulo | +3-5% Architecture |
| 🏗 Sostituire flag booleani con metodi dedicati | 43 occorrenze | 15 min l'una | +2-3% Architecture |
| **Subtotale** | **18 moduli** | **~20-40 ore** | **+10-18% Architecture** |

### Fase 3 — Refactoring Complessità (Sforzo alto)
| Attivitá | Occorrenze | Sforzo | Beneficio stimato |
|----------|-----------|--------|-------------------|
| 🧠 Ridurre CyclomaticComplexity (< 10) | 151 metodi | 30 min-1h l'uno | +5-10% Complexity |
| 🧠 Ridurre NPathComplexity | 84 metodi | 30 min-1h l'uno | +3-5% Complexity |
| 🧠 Estrarre metodi lunghi (ExcessiveMethodLength) | 51 metodi | 20-40 min l'uno | +3-5% Complexity |
| **Subtotale** | **286 occorrenze** | **~40-80 ore** | **+11-20% Complexity** |

### Stima Finale

| Fase | Ore | Categoria | Incremento medio |
|------|-----|-----------|-----------------|
| Fase 1 — Impatto immediato | 8-12h | Code + Style | +14-23% |
| Fase 2 — Refactoring architetturale | 20-40h | Architecture | +10-18% |
| Fase 3 — Refactoring complessità | 40-80h | Complexity | +11-20% |
| **Totale** | **68-132h** | **Tutte** | **+12-18% media** |

**Target finale:** Code ≥85%, Complexity ≥95%, Architecture ≥80%, Style ≥90%

---

*Report generato automaticamente il 2026-06-18. Tools: PHPStan max level, PHPMD 2.x (ruleset Laravel), PHPInsights 2.13.3 (preset Laravel), Pest.*
