# Superpowers - Installazione e Configurazione

## Panoramica

**Superpowers** è un framework di skills per agenti di coding costruito da Jesse Vincent (obra). Fornisce un workflow completo per lo sviluppo software con TDD, debugging sistematico, e sviluppo subagent-driven.

## Installazione

### OpenCode

Aggiungere il plugin in `laravel/opencode.json`:

```json
{
    "plugin": [
        "superpowers@git+https://github.com/obra/superpowers.git"
    ]
}
```

Riavviare OpenCode. Il plugin si auto-installa e registra tutte le skills.

### Verifica Installazione

Chiedere: "Tell me about your superpowers" - L'agente dovrebbe automaticamente invocare la skill `using-superpowers`.

## Skills Disponibili

### Testing
- **test-driven-development** - RED-GREEN-REFACTOR cycle

### Debugging
- **systematic-debugging** - 4-phase root cause process
- **verification-before-completion** - Ensure it's actually fixed

### Collaborazione
- **brainstorming** - Socratic design refinement
- **writing-plans** - Detailed implementation plans
- **executing-plans** - Batch execution with checkpoints
- **dispatching-parallel-agents** - Concurrent subagent workflows
- **requesting-code-review** - Pre-review checklist
- **receiving-code-review** - Responding to feedback
- **using-git-worktrees** - Parallel development branches
- **finishing-a-development-branch** - Merge/PR decision workflow
- **subagent-driven-development** - Fast iteration with two-stage review

### Meta
- **writing-skills** - Create new skills following best practices
- **using-superpowers** - Introduction to the skills system

## Workflow Base

1. **brainstorming** - Attivato prima di scrivere codice. Raffina idee attraverso domande, esplora alternative.
2. **using-git-worktrees** - Dopo approvazione design. Crea workspace isolato su nuovo branch.
3. **writing-plans** - Con design approvato. Spezza il lavoro in task di 2-5 minuti.
4. **subagent-driven-development** - Esegue task tramite subagent con review a due stadi.
5. **test-driven-development** - Durante implementazione: RED-GREEN-REFACTOR.
6. **requesting-code-review** - Tra un task e l'altro.
7. **finishing-a-development-branch** - Quando i task sono completi.

## Aggiornamento

Gli skills si aggiornano automaticamente quando si aggiorna il plugin:

```bash
/plugin update superpowers
```

Per pinning versione specifica:

```json
{
    "plugin": ["superpowers@git+https://github.com/obra/superpowers.git#v5.0.3"]
}
```

## Riferimenti

- Repo: https://github.com/obra/superpowers
- Issues: https://github.com/obra/superpowers/issues
- Discord: https://discord.gg/Jd8Vphy9jq

---

*Documento creato: 2026-03-31*