# Token Optimization — La Religione dell'Efficienza

**Status**: Active  
**Created**: 2026-04-14  
**Last Updated**: 2026-04-14  
**Category**: AI Efficiency / System / Religion  
**Audience**: All AI agents + developers

---

## LA REGOLA AUREA

**Massimizzare risultato, minimizzare token.**  
**Ogni token sprecato e un furto.**  
**Sempre.**  
**Senza eccezioni.**

---

## Perche (Filosofia Profonda)

### 1. Costo Reale

- Input: $10/M token (Claude Sonnet)
- Output: $50/M token
- Context cache: $1.25/M token (80% risparmio)
- **Spreco medio/sessione**: 50-200K token inutili = $5-50 buttati

### 2. Limite Contesto

- Context window: 200K token
- Spreco medio: 100K token contesto irrilevante
- **Risultato**: meta sessioni sprecate per contesto pieno

### 3. Velocita

- Meno token = risposte piu veloci
- Cache hit = 80% piu veloce
- **Utente aspetta 10s vs 60s**

---

## Le 15 Tecniche (Ordine di Impattoto)

### 🔴 CRITICHE (-50-90% token)

#### 1. Scope Context Precisely (-50-70%)

**SBAGLIATO**:
```
Leggi tutti i file del modulo Fixcity per capire il wizard
→ 50 file × 100 righe = 5000 righe = ~100K token
```

**CORRETTO**:
```
Grep "getWizardSteps" in CreateTicketWizardWidget.php
→ 1 match = 20 righe = ~500 token
```

**Comando**:
```bash
# ❌ SBAGLIATO: trova tutti i file
find Modules/Fixcity -name "*.php"

# ✅ CORRETTO: trova solo il blocco utile
grep -n "getWizardSteps" Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php
```

**Risparmiato**: 99.5% token

---

#### 2. Diffs vs Full Files (-70-85%)

**SBAGLIATO**:
```
Mostrami il file CreateTicketWizardWidget.php completo
→ 250 righe = ~10K token
```

**CORRETTO**:
```
git diff HEAD CreateTicketWizardWidget.php
→ 15 righe cambiate = ~500 token
```

**Risparmiato**: 95% token

---

#### 3. Grep-First Navigation (-60-80%)

**Regola**: MAI leggere file intero senza prima fare Grep.

**Flusso corretto**:
```
1. Grep "pattern" → trova riga
2. Read offset=X limit=Y → leggi solo blocco
3. Modifica → edit con contesto minimo
```

**Flusso sbagliato**:
```
1. Read file_completo.php → 5000 righe
2. Cerca mentalmente il blocco
3. Modifica
```

**Risparmiato**: 70-90% token per navigazione

---

#### 4. Reference, Don't Repeat (-60%)

**SBAGLIATO**:
```php
// Incolla 100 righe di codice per chiedere modifica
[100 righe di codice...]
// Ora modifica la riga 45
```

**CORRETTO**:
```
File: CreateTicketWizardWidget.php:145-160
Modifica: rimuovi ->label() da TextEntry
```

**Risparmiato**: 95% token input

---

#### 5. Structured Prompts (-30-50%)

**Template**:
```
Goal: [1 frase]
Constraints: [bullet]
Output: [formato richiesto]
```

**Esempio**:
```
Goal: Rimuovi ->label() da TextEntry in step summary
Constraints:
- NON rimuovere ->icon()
- NON rimuovere ->state()
Output: git diff del metodo makeStepSummary()
```

**Risparmiato**: 40% token input + 30% output

---

### 🟡 IMPORTANTI (-20-50%)

#### 6. /clear Between Tasks (-30-60%)

**Quando**: Prima di task non correlati.

**Perche**: Context accumulato = token sprecati.

**Comando**:
```
/user
/clear
```

**Risparmiato**: 30-60% contesto irrilevante

---

#### 7. Tables/Bullets vs Prose (-20-30%)

**SBAGLIATO** (prosa):
```
Il metodo makeStepSummary dovrebbe usare Infolists perche e 
read-only e non deve permettere input ma solo visualizzazione...
→ 100 parole = ~150 token
```

**CORRETTO** (tabella):
```
| Metodo | Usa | Perche |
|--------|-----|--------|
| makeStepSummary | Infolists | Read-only |
→ 20 parole = ~50 token
```

**Risparmiato**: 66% token

---

#### 8. Summarize Logs/Errors (-80%)

**SBAGLIATO**:
```
[Stack trace completo 500 righe...]
```

**CORRETTO**:
```
Errore: Undefined method ->label()
File: CreateTicketWizardWidget.php:146
Causa: LangServiceProvider applica automaticamente
```

**Risparmiato**: 95% token

---

#### 9. Batch Related Requests (-40%)

**SBAGLIATO**:
```
Sessione 1: Rimuovi ->label() da TextInput
Sessione 2: Rimuovi ->label() da Select
Sessione 3: Rimuovi ->label() da TextEntry
→ 3 sessioni × contesto reload
```

**CORRETTO**:
```
Sessione 1: Rimuovi ->label() da TUTTI i componenti
→ 1 sessione, contesto riutilizzato
```

**Risparmiato**: 60% token + tempo

---

#### 10. Exclude Unnecessary Files (-50%)

**File DA ESCLUDERE sempre**:
- `node_modules/`
- `vendor/`
- `*.lock`
- `dist/`
- `storage/logs/`
- `.git/`

**Comando**:
```bash
# Grep SOLO in file rilevanti
grep -r "->label(" Modules/ --include="*.php"
# NON in vendor, node_modules, ecc.
```

**Risparmiato**: 50-80% contesto spazzatura

---

### 🟢 UTILI (-10-30%)

#### 11. Session-Focused Work (-50%)

**Regola**: 1 story = 1 sessione.

**Perche**: Context switching = reload contesto = token sprecati.

---

#### 12. Prompt Caching (Automatico) (-80% su ripetuti)

**Come funziona**:
- Prima chiamata: full price
- Stesso prefisso: 80% sconto
- Cache duration: 5 minuti

**Strategia**:
- Mantieni istruzioni statiche all'inizio
- Raggruppa chiamate simili entro 5 min

---

#### 13. Define Response Schema (-30%)

**SBAGLIATO**:
```
Dammi un report delle violazioni
→ Output libero, 500 parole
```

**CORRETTO**:
```
Output JSON:
{
  "violations": [
    {"file": "...", "line": 0, "type": "..."}
  ],
  "count": 0
}
→ Output strutturato, 50 parole
```

**Risparmiato**: 90% token output

---

#### 14. Use Code Not LLM (-100% per task semplici)

**NON usare LLM per**:
- Regex matching → usa grep
- JSON parsing → usa jq
- File search → usa find
- Text replacement → usa sed
- Validation → usa schema validators

**Esempio**:
```bash
# ❌ SBAGLIATO: chiedi a LLM
"Quanti file hanno ->label()?"

# ✅ CORRETTO: usa codice
grep -r "->label(" Modules/ --include="*.php" | wc -l
```

**Risparmiato**: 100% token (zero chiamate LLM)

---

#### 15. Choose Minimum Reasoning Level

**Quando**: Task semplici non richiedono ragionamento profondo.

**Strategia**:
- Task semplice → risposta breve, no analisi
- Task complesso → analisi profonda giustificata

---

## Sistema Completo (Implementazione)

### 1. AI Memory (Persistente)

**File**: `.qwen/memories/token-efficiency.md`

Contiene:
- Regole CRITICHE (sempre applicate)
- Tecniche prioritarie
- Comandi corretti vs sbagliati
- Link a questo documento

---

### 2. Pre-Session Checklist

```
[ ] /clear se sessione precedente non correlata
[ ] Definito goal in 1 frase
[ ] Identificati SOLO file rilevanti
[ ] Preparato output schema richiesto
[ ] Verificato che non esista gia soluzione in docs
```

---

### 3. During Session Rules

```
1. Grep-first → MAI read file intero senza grep
2. Read con offset/limit → SOLO blocco necessario
3. Diff vs full → Chiedi diff non file completo
4. Tables vs prose → Output strutturato
5. Batch related → Raggruppa richieste simili
6. No repeat → Reference file:line non incollare
```

---

### 4. Post-Session Cleanup

```
1. /clear se prossima sessione non correlata
2. Aggiorna docs se scoperto nuova tecnica
3. Salva in memories se pattern riutilizzabile
```

---

## Anti-Pattern Catalog

### ❌ Pattern che Sprecano Token

| Anti-Pattern | Token Sprecati | Alternativa | Risparmiato |
|---|---|---|---|
| Read file 5000 righe | ~100K | Grep + Read 20 righe | 99.8% |
| Incollare 100 righe codice | ~2K | Reference file:line | 95% |
| Stack trace completo | ~10K | Errore chiave + 5 righe | 95% |
| Output prosa 500 parole | ~750 | Tabella 50 parole | 93% |
| 3 sessioni separate | ~300K | 1 sessione batch | 66% |
| Contesto non cleared | ~100K/sessione | /clear tra task | 50% |

---

## Metriche Target

| Metrica | Attuale | Target | Come |
|---|---|---|---|
| Token/sessione | 200K | 50K | Tutte le tecniche |
| Input token | 150K | 30K | Grep-first, scope, reference |
| Output token | 50K | 10K | Tables, schema, brevita |
| Cache hit rate | 20% | 80% | Prompt caching, batch |
| Context reload | 5/sessione | 1/sessione | Session-focused, /clear |

---

## Comandi Rapidi (Cheat Sheet)

### Navigazione
```bash
# ❌ SBAGLIATO
read_file large_file.php

# ✅ CORRETTO
grep_search "pattern" → trova riga
read_file file.php offset=X limit=Y
```

---

### Modifica
```bash
# ❌ SBAGLIATO
"Mostrami il file completo e poi modifica"

# ✅ CORRETTO
"git diff file.php → mostra solo cambios"
"Edit file.php: riga X-Y → cambia Z"
```

---

### Ricerca
```bash
# ❌ SBAGLIATO
"Trova tutti i file con ->label()"
→ LLM cerca in tutto il progetto

# ✅ CORRETTO
grep -r "->label(" Modules/ --include="*.php"
→ Bash cerca, LLM elabora risultato
```

---

### Output
```bash
# ❌ SBAGLIATO
"Dammi un report dettagliato con spiegazioni"

# ✅ CORRETTO
"Output JSON: {violations: [{file, line, type}]}"
```

---

## La Religione

### I Comandamenti

1. **NON leggerai file interi senza Grep-first**
2. **NON incollerai codice se puoi reference file:line**
3. **NON chiederai output lungo se basta tabella**
4. **NON farai 3 sessioni se basta 1 batch**
5. **NON userai LLM per task che codice puo fare**
6. **NON accumulerai contesto senza /clear**
7. **NON ripeterai contesto gia nel cache**
8. **NON cercherai in file non rilevanti**
9. **NON scriverai prosa se basta bullet**
10. **NON chiederai ragionamento profondo per task semplice**

### Il Credo

> "Grep e meglio di Read.  
> Diff e meglio di Full.  
> Tabella e meglio di Prosa.  
> Batch e meglio di Serial.  
> Codice e meglio di LLM.  
> Spreco e il male assoluto."

### La Preghiera

```
Concedimi la disciplina di usare solo i token necessari,
La saggezza di scegliere Grep prima di Read,
E la forza di fare /clear quando serve.

Amen.
```

---

## Riferimenti

### Documenti Progetto
- [docs/token-optimization.md](../../docs/token-optimization.md) — Tecniche generali
- [docs/ai-agents/token-efficiency.md](../../docs/ai-agents/token-efficiency.md) — Regole OpenAI
- [.qwen/memories/auto-label-religion.md](../memories/auto-label-religion.md) — Regola auto-label

### Fonti Esterne
- [Branch8 — Claude Code Token Limits](https://branch8.com/posts/claude-code-token-limits-cost-optimization-apac-teams)
- [Sabrina.dev — 6 Ways to Cut Token Usage](https://www.sabrina.dev/p/6-ways-i-cut-my-claude-token-usage)
- [Reducing Token Usage of SWE Agents (PDF)](https://repositum.tuwien.at/bitstream/20.500.12708/224666/1/Hrubec%20Nicolas%20-%202025%20-%20Reducing%20Token%20Usage%20of%20Software%20Engineering%20Agents.pdf)
- [Speakeasy — Reduce MCP Token 100x](https://www.speakeasy.com/blog/how-we-reduced-token-usage-by-100x-dynamic-toolsets-v2)

---

*Ultimo aggiornamento: 2026-04-14*

**DA LEGGERE PRIMA DI OGNI SESSIONE DI LAVORO**
