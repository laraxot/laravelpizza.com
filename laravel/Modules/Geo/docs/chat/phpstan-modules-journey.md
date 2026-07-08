---
name: phpstan-modules-journey
description: PHPStan journey narrativa — campagna zero-errori per 30+ moduli Laravel, livello max, con visione spirituale e BMAD-METHOD
type: project
status: active
tags: [phpstan, laravel, quality, bmad-method, architecture, patterns, zero-errors]
created: 2026-05-27
updated: 2026-05-27
related: [phpstan-modules-coordination, phpstan-modules-inventory, bmad-method-integration]
---

# 🧘 PHPStan Modules Journey — Zero Errors as Enlightenment

> *"Errors are not bugs. They are messages from the universe asking us to see deeper."* — The Codebase Whisperer

## ✨ Introduzione: Perché Questa Campagna?

Abbiamo 30+ moduli Laravel, ognuno indipendente, ognuno con una remota GitHub propria. PHPStan **livello max** è la nostra bussola: non una semplice check di sintassi, ma una **riflessione profonda** sulla qualità del codice, sulla type safety, sulla prevenzione di errori a runtime.

Esclusioni deliberate:
- 🚫 **Pdnd** (strategia organizzativa)
- 🚫 **Incentivi** (contesto economico delicato)

Tutti gli altri moduli: **candidati al viaggio**.

---

## 🌟 Le 7 Illuminazioni PHPStan

### 1️⃣ **Il primo errore è il maestro**
Quando PHPStan grida "Type error in line 42!", non è critica. È insegnamento. Ogni errore svegli una consapevolezza nuova sul tipo di dato, sul contratto implicito tra funzioni.

### 2️⃣ **Il type è il linguaggio del codice**
`string | int | null` non è pedanteria. È **comunicazione precisa**. Type safety trasforma l'incertezza in forza.

### 3️⃣ **Zero errori è uno stato di grazia**
Quando un modulo raggiunge `0 errors` con PHPStan level max, accade qualcosa: il codice diventa più intelligente, il refactoring diventa sicuro, la manutenzione diventa gioia.

### 4️⃣ **BMAD-METHOD è il sentiero strutturato**
Non agiamo a caso. Usiamo role assignment (PM, SM, Dev, QA, Tech Writer), phase structure (0: setup, 1: story, 2: distillazione), skill mapping (`bmad-create-story`, `bmad-dev-story`).

### 5️⃣ **GitHub Issues sono il diario del viaggio**
Una issue per modulo. Descrizione precisa dell'errore. Proposta di fix senza implementazione immediata (fino a collaborazione agenti). Firma: **Agente AI + Modello**.

### 6️⃣ **Memory limit di 2GB è il mantra**
`php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/<Modulo>`. Per moduli grandi (Gdpr, ...), questa opzione non è negoziabile. Exit code 143 = Out of Memory. Ricorda.

### 7️⃣ **Atomic git = immutabile audit trail**
Forward-only commits. Nessun reset/revert. Ogni operazione è una pietra sulla strada del viaggio: `git log` racconta la storia della trasformazione.

---

## 📊 Inventory dei Moduli — Tracking Centrale

| Modulo | Stato | Errori | Scan Data | Issue | Note |
|--------|-------|--------|-----------|-------|------|
| Activity | ⏳ Pending | — | — | — | Modulo piccolo, pattern noto |
| Cms | ⏳ Pending | — | — | — | Candidate ottimale |
| CloudStorage | ⏳ Pending | — | — | — | Piccolo scope |
| Chart | ⏳ Pending | — | — | — | Type-safe patterns |
| Geo | ⏳ Pending | — | — | — | Location logic |
| Job | ⏳ Pending | — | — | — | Queue integration |
| Gdpr | ⏳ Pending | — | — | — | ⚠️ Memory limit: 2GB richiesto |
| Incentivi | 🚫 EXCLUDED | — | — | — | Contesto economico—esclusione deliberata |
| Pdnd | 🚫 EXCLUDED | — | — | — | Strategia organizzativa—esclusione deliberata |
| (altri 20+ moduli) | ⏳ Pending | — | — | — | Richiesta analysis sistematica |

**Legenda:**
- ⏳ **Pending**: In attesa di analisi PHPStan
- ✅ **Green**: 0 errori, issue chiusa, inventory aggiornato
- 🔴 **Red**: Errori identificati, issue aperta, in attesa fix collaborativo
- 🚫 **Excluded**: Non parte della campagna
- ⚠️ **Note**: Constraint speciali (memory, dipendenze, etc.)

---

## 🔧 Workflow Operativo — Come Procedere

### Fase 0: Setup
```bash
cd /var/www/_bases/base_ptvx_fila5/laravel
# Verificare PHPStan è installato
./vendor/bin/phpstan --version
# Verificare phpstan.neon è immutabile (level: max)
cat phpstan.neon | grep "level:"
```

### Fase 1: Analisi Modulo
```bash
./vendor/bin/phpstan analyse Modules/<NomeModulo> --memory-limit=2G
```

**Output atteso:**
- `0 errors` → modulo candidabile per "Green" 
- `N > 0 errors` → creare GitHub issue, documentare, non implementare

### Fase 2: GitHub Issue Template
Titolo: `[PHPStan] N errori — scan DATA (level max)`

```markdown
## Errore 1: [Identificatore PHPStan]
- **Linea**: X
- **Tipo**: [e.g., "Type mismatch"]
- **Messaggio**: [Messaggio completo PHPStan]
- **Proposta di fix**: [Come risolveremmo, senza codice]

## Errore 2: ...
```

**Firma obbligatoria:**
```
---
🤖 Scansione eseguita da: [Agente AI]
📦 Modello: [claude-haiku-4-5-20251001]
📅 Data: [2026-05-27]
```

### Fase 3: Distillazione Second Brain
Dopo ogni modulo analizzato (indipendentemente da errori):
- Aggiornare inventory table sopra
- Aggiornare `docs/wiki/memories/phpstan-modules-inventory.md`
- Documentare pattern nuovo scoperto in `docs/wiki/concepts/`
- Linkare issue GitHub da `docs/chat/phpstan-modules-coordination.md`

---

## 🎯 Integration BMAD-METHOD

Questa campagna PHPStan sfrutta **BMAD-METHOD** in `bashscripts/tools/prompts/phpstan_module.txt`:

**Per ogni modulo (campagna > 5 moduli):**

1. **PM Alignment** (`bmad-create-story`):
   - Acceptance Criteria: modulo → 0 errori PHPStan + issue chiusa + inventory green
   - Story points stimato
   - Sprint assignment

2. **SM Planning** (sprint cadence):
   - Max 2-3 moduli per sprint
   - Dependency check tra moduli

3. **Analyst Research** (`bmad-` analisi pattern):
   - Quali pattern false-friend scopriamo? (es. `isset()` su Eloquent, `__()` ritorna array?)
   - Cual è il pattern vincente per questo modulo?

4. **Dev Story** (`bmad-dev-story`):
   - Implementazione fix collaborativo con agenti AI
   - PRD di fix per modulo

5. **QA Validation**:
   - PHPStan verde
   - No regression su moduli già green

6. **Tech Writer** (`bmad-` doc):
   - Documentare learning nel wiki
   - Update PHPSTAN_PATTERNS.md (nuovo file, da creare)

---

## 🧭 Concetti Filosofici Sottostanti

### *"Type safety è libertà"*
Quando il compilatore (PHPStan) ti dice cosa può andare male, non ti limita—ti libera. Puoi refactor con certezza. Puoi dormire sapendo che `null` non verrà sorpresa a runtime.

### *"Zero errors non è perfezione, è onestà"*
Un modulo con 0 errori PHPStan non è perfetto (nessun codice lo è). Ma è **onesto**: ha affrontato ogni domanda che lo static analyzer poteva porre.

### *"La memoria di 2GB è il respiro profondo prima della meditazione"*
Quando PHPStan analizza un modulo grande (Gdpr: 15K+ LoC), ha bisogno di respiro. 2GB non è eccesso—è necessità strutturale. Accettala.

### *"Atomic commits sono poesia"*
`git log --oneline Modules/ActivityModule` racconta una storia: ogni commit è una decisione, una riflessione, una vittoria. Nessun reset, nessun squash: storia vera.

---

## 🌐 Risorse Collegate

- **Central Coordination**: [phpstan-modules-coordination.md](./phpstan-modules-coordination.md)
- **Modules Inventory (Authoritative)**: [../wiki/memories/phpstan-modules-inventory.md](../wiki/memories/phpstan-modules-inventory.md)
- **BMAD-METHOD Docs**: [../wiki/rules/bmad-method-integration.md](../wiki/rules/bmad-method-integration.md)
- **GitHub Issue Template**: [../wiki/_templates/phpstan-module-github-issue.md](../wiki/_templates/phpstan-module-github-issue.md)
- **PHPStan Prompt (Skills)**: `bashscripts/tools/prompts/phpstan_module.txt`
- **Laravel CLAUDE.md (On-Demand Pattern)**: [../../laravel/CLAUDE.md](../../laravel/CLAUDE.md)

---

## 💫 Prossimi Step

1. ✅ **File phpstan-modules-journey.md creato** (questo file) — narrativa + inventory
2. 🔄 **Selezionare modulo iniziale** — consigliato: Activity o Job (piccoli, pattern chiari)
3. 📊 **Eseguire PHPStan** — `./vendor/bin/phpstan analyse Modules/<Modulo> --memory-limit=2G`
4. 📝 **Creare GitHub issue** — uno per modulo, documentare errori, nessun fix immediato
5. 🎓 **Distillare nel wiki** — imparare, migliorare second brain, linkare tutto

---

> *"Ogni errore è un insegnante. Ogni modulo verde è una vittoria. Ogni commit è una pietra."* — Unknown Codebase Philosopher

🙏 **Che inizi il viaggio verso PHPStan enlightenment.**

---

**File versione**: 1.0 | **Creato**: 2026-05-27 | **Status**: Active
