# Superpowers - Agentic Skills Framework

**Source**: https://github.com/obra/superpowers  
**Stars**: 126K  
**Version**: v5.0.6  
**License**: MIT  
**Status**: ✅ Installed

---

## Cosa è

Superpowers è un framework di skill componibili per coding agent (OpenCode, Claude Code, Cursor, Gemini CLI). Fornisce un workflow completo di sviluppo software autonomo basato su:

- **TDD** (Test-Driven Development) come default
- **Brainstorming** iterativo prima del codice
- **Pianificazione granulare** (task da 2-5 minuti)
- **Subagent-driven development** con review a due stadi
- **Systematic debugging** con processo a 4 fasi

---

## Installazione

### File: `opencode.json`

```json
{
  "plugin": ["superpowers@git+https://github.com/obra/superpowers.git"]
```

Il plugin si auto-install via Bun al riavvio di OpenCode. Si aggiorna automaticamente.

### Pin di versione

```json
{
  "plugin": ["superpowers@git+https://github.com/obra/superpowers.git#v5.0.6"]
}
```

---

## Workflow Base

```
1. brainstorming       → Refine idea, ask questions, present design in sections
2. using-git-worktrees → Create isolated workspace on new branch
3. writing-plans       → Break into 2-5 min tasks with exact file paths
4. subagent-driven     → Dispatch subagent per task (or executing-plans for batch)
5. test-driven-dev     → RED-GREEN-REFACTOR enforced per task
6. requesting-code-review → Review against plan
7. finishing-a-branch  → Verify tests, merge/PR decision
```

---

## Skill Library

### Testing
| Skill | Trigger |
|-------|---------|
| `test-driven-development` | Any implementation task |

### Debugging
| Skill | Trigger |
|-------|---------|
| `systematic-debugging` | Bug investigation, unexpected behavior |
| `verification-before-completion` | Before declaring fix complete |

### Collaboration
| Skill | Trigger |
|-------|---------|
| `brainstorming` | "help me plan", design discussion |
| `writing-plans` | After design approval |
| `executing-plans` | Batch execution with checkpoints |
| `subagent-driven-development` | Parallel subagent workflows |
| `requesting-code-review` | Between tasks |
| `using-git-worktrees` | Parallel branches |
| `finishing-a-branch` | Task completion |

### Meta
| Skill | Trigger |
|-------|---------|
| `writing-skills` | Create new skill |
| `using-superpowers` | Introduction |

---

## Tool Mapping (OpenCode)

| Superpowers (Claude Code) | OpenCode Equivalent |
|---------------------------|---------------------|
| `TodoWrite` | `todowrite` |
| `Task` (subagents) | `@mention` syntax |
| `Skill` tool | `skill` tool |
| File operations | Native OpenCode tools |

---

## Integrazione con Stack Progetto

Superpowers si integra con le metodologie già presenti:

| Metodo | Progetto | Superpowers |
|--------|----------|-------------|
| **TDD** | `skills/tdd/`, `skills/tdd-laravel/` | `test-driven-development` |
| **Brainstorming** | `skills/brainstorming-laravel/` | `brainstorming` |
| **Code Review** | `skills/bmad-code-review/` | `requesting-code-review` |
| **Debug** | `skills/systematic-debugging-laravel/` | `systematic-debugging` |
| **Planning** | `skills/gsd-plan-phase/` | `writing-plans` |
| **Execution** | `skills/gsd-execute-phase/` | `executing-plans` |
| **Skills creation** | `skills/skill-creator/` | `writing-skills` |

**Priorità**: Le skill di progetto (in `.opencode/skills/`) sovrascrivono Superpowers quando esiste overlap.

---

## Verifica Installazione

```
# In OpenCode, chiedi:
"Tell me about your superpowers"

# Oppure usa il tool skill:
skill tool → list skills → cerca superpowers/*
```

---

## Riferimenti

- [Superpowers Blog](https://blog.fsck.com/2025/10/09/superpowers/)
- [OpenCode Install Docs](https://github.com/obra/superpowers/blob/main/docs/README.opencode.md)
- [Discord Community](https://discord.gg/Jd8Vphy9jq)
- [PLUGINS_AND_SKILLS.md](../../.opencode/PLUGINS_AND_SKILLS.md)
