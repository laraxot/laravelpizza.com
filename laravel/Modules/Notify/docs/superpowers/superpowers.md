# Superpowers - Documentazione Installazione e Utilizzo

## Cos'è Superpowers

**Superpowers** (https://github.com/obra/superpowers) è un framework di workflow per agenti AI di sviluppo software, basato su un sistema di "skills" (competenze) composabili. E' un plugin per Claude Code CLI (e altri IDE/CLI come Cursor, Gemini CLI, Codex, OpenCode).

**Autore:** Jesse Vincent / Prime Radiant
**Licenza:** MIT
**Versione installata:** 5.0.6
**Data installazione:** 2026-03-31

### Cosa fa

Superpowers trasforma Claude Code da un semplice assistente in un agente con un workflow strutturato di sviluppo software. Le skills si attivano automaticamente in base al contesto, senza bisogno di comandi espliciti.

Il sistema impone metodologie rigorose:
- **Test-Driven Development (TDD)** - RED-GREEN-REFACTOR obbligatorio
- **Brainstorming strutturato** - Prima di scrivere codice, raffina i requisiti
- **Git Worktrees** - Workspace isolati per ogni feature
- **Pianificazione dettagliata** - Task da 2-5 minuti con verifiche
- **Subagent-driven development** - Agenti paralleli con revisione a 2 stadi
- **Code review automatica** - Verifica rispetto al piano

---

## Installazione Effettuata

### Metodo usato: Claude Code Plugin via Marketplace GitHub

**Prerequisiti soddisfatti:**
- Claude Code CLI v2.1.88 installato in `/home/zorin/.local/bin/claude`
- Utente: `zorin` su WSL2/Ubuntu

**Comandi eseguiti:**

```bash
# 1. Aggiungere il marketplace di superpowers
claude plugin marketplace add obra/superpowers

# 2. Installare il plugin
claude plugin install superpowers@superpowers-dev
```

**Output installazione:**
```
Adding marketplace...
✔ Successfully added marketplace: superpowers-dev (declared in user settings)

Installing plugin "superpowers@superpowers-dev"...
✔ Successfully installed plugin: superpowers@superpowers-dev (scope: user)
```

### File installati

| Percorso | Descrizione |
|---|---|
| `/home/zorin/.claude/plugins/installed_plugins.json` | Registro plugins installati |
| `/home/zorin/.claude/plugins/known_marketplaces.json` | Marketplaces configurati |
| `/home/zorin/.claude/plugins/cache/superpowers-dev/superpowers/5.0.6/` | File del plugin |
| `/home/zorin/.claude/plugins/marketplaces/superpowers-dev/` | Cache marketplace |

**Scope:** `user` (disponibile in tutte le sessioni Claude Code dell'utente `zorin`)

**Git commit SHA:** `eafe962b18f6c5dc70fb7c8cc7e83e61f4cdde06`

---

## Skills Disponibili

Il plugin installa 14 skills nella directory `/home/zorin/.claude/plugins/cache/superpowers-dev/superpowers/5.0.6/skills/`:

### Skills di Testing
| Skill | Descrizione |
|---|---|
| `test-driven-development` | Ciclo RED-GREEN-REFACTOR obbligatorio |
| `verification-before-completion` | Verifica che il fix sia realmente applicato |

### Skills di Debugging
| Skill | Descrizione |
|---|---|
| `systematic-debugging` | Processo a 4 fasi per root cause analysis |

### Skills di Collaborazione
| Skill | Descrizione |
|---|---|
| `brainstorming` | Raffinamento Socratico del design |
| `writing-plans` | Piani di implementazione dettagliati |
| `executing-plans` | Esecuzione batch con checkpoint umani |
| `dispatching-parallel-agents` | Workflow con subagenti concorrenti |
| `subagent-driven-development` | Iterazione veloce con revisione a 2 stadi |
| `requesting-code-review` | Checklist pre-review |
| `receiving-code-review` | Risposta al feedback di review |
| `using-git-worktrees` | Branch paralleli di sviluppo |
| `finishing-a-development-branch` | Workflow merge/PR/discard |

### Skills Meta
| Skill | Descrizione |
|---|---|
| `writing-skills` | Creare nuove skills seguendo best practices |
| `using-superpowers` | Introduzione al sistema di skills |

---

## Workflow Base

Il workflow standard segue questa sequenza automatica:

```
1. brainstorming          → Prima di scrivere codice, raffina i requisiti
2. using-git-worktrees    → Crea workspace isolato su nuovo branch
3. writing-plans          → Suddivide il lavoro in task da 2-5 minuti
4. subagent-driven-dev    → Lancia subagenti per ogni task con revisione
5. test-driven-development→ RED-GREEN-REFACTOR per ogni implementazione
6. requesting-code-review → Revisione tra task
7. finishing-a-branch     → Merge/PR/cleanup
```

**Importante:** Le skills si attivano automaticamente. L'agente verifica le skills pertinenti PRIMA di qualsiasi risposta o azione.

---

## Come si Usa

### Verifica installazione

```bash
claude plugin list
```

Output atteso:
```
Installed plugins:
  ❯ superpowers@superpowers-dev
    Version: 5.0.6
    Scope: user
    Status: ✔ enabled
```

### Avviare una sessione con Superpowers

Semplicemente aprire Claude Code in qualsiasi progetto. Le skills si attivano automaticamente:

```bash
cd /var/www/_bases/base_fixcity_fila5
claude
```

Chiedere qualcosa come "help me plan this feature" o "let's debug this issue" e l'agente invocherà automaticamente la skill pertinente.

### Aggiornare il plugin

```bash
claude plugin update superpowers
```

### Disabilitare/rimuovere

```bash
claude plugin disable superpowers@superpowers-dev
# oppure
claude plugin uninstall superpowers@superpowers-dev
```

---

## Comandi Disponibili (deprecated)

I seguenti comandi esistono ma sono **deprecati** - usare le skills direttamente:

- `brainstorm.md` → usare skill `brainstorming`
- `execute-plan.md` → usare skill `executing-plans`
- `write-plan.md` → usare skill `writing-plans`

---

## Filosofia

- **Test-Driven Development** - I test vengono scritti prima, sempre
- **Sistematico vs ad-hoc** - Processo invece di intuizione
- **Riduzione complessità** - La semplicità come obiettivo primario
- **Evidenza vs affermazioni** - Verificare prima di dichiarare successo

---

## Riferimenti

- **Repository:** https://github.com/obra/superpowers
- **Marketplace:** https://github.com/obra/superpowers-marketplace
- **Blog post:** https://blog.fsck.com/2025/10/09/superpowers/
- **Discord:** https://discord.gg/Jd8Vphy9jq
- **Issues:** https://github.com/obra/superpowers/issues
