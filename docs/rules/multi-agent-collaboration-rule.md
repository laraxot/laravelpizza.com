# Multi-Agent AI Collaboration Rule

## Regola Fondamentale

Questo progetto utilizza **multipli agenti AI** che lavorano in parallelo sullo stesso codebase.
La comunicazione tra agenti avviene **esclusivamente** tramite:

1. **GitHub Issues** - Per task, bug, feature, e tracking del lavoro
2. **GitHub Discussions** - Per decisioni architetturali, strategie, e dibattiti

## Workflow Obbligatorio

### Prima di iniziare qualsiasi lavoro

1. `gh issue list --repo laraxot/laravelpizza.com --state open` - Controlla cosa è già in corso
2. `gh issue view <ID>` - Leggi i dettagli e i commenti degli altri agenti
3. Verifica che il task non sia già stato completato o sia in corso da un altro agente
4. Se il task è libero, commenta la Issue per segnalare l'inizio del lavoro

### Durante il lavoro

1. Commenta la Issue con aggiornamenti di progresso
2. Non duplicare lavoro già fatto
3. Controlla `git log --oneline -10` per modifiche recenti nella stessa area

### Dopo il lavoro

1. Commenta la Issue con il risultato finale
2. Chiudi la Issue se completata
3. Crea nuove Issue per lavoro scoperto ma non completato
4. Aggiorna `docs/coverage-plan.md` se rilevante

## Formato Commenti

```markdown
🤖 **[Nome Agente AI]**: [Azione]

**Files modificati:**
- `path/to/file.php` - Descrizione modifica

**Risultato:**
- PHPStan: ✅ 0 errori
- Pest: ✅ N test passing
```

## Collisione tra agenti

- **MAI cancellare file** creati da altri agenti
- **Rinominare** con `.old` se necessario sostituire
- **Controllare git status** prima di modificare file condivisi
- **Aggiornamenti atomici** su docs/coverage-plan.md

## Backlink

- [.windsurf/rules/multi-agent-collaboration.md](../../.windsurf/rules/multi-agent-collaboration.md)
- [AGENTS.md](../../AGENTS.md)

## Ultimo aggiornamento

2026-03-05

## Fallback locale obbligatorio (docs/storage)

Se Project/Wiki non sono accessibili da CLI, il coordinamento non si ferma:

1. Aggiornare sempre `docs/memory/coverage-100-full-project-memory.md` con snapshot data/ora.
2. Aggiornare `docs/testing/coverage-100-plan.md` con stato reale (baseline, blocker, next step).
3. Scrivere log tecnico in `laravel/storage/app/private/coverage/coordination-log.md` con:
   - canale bloccato (`project` o `wiki`)
   - comando tentato
   - errore ottenuto
   - azione alternativa applicata in `docs/`
4. Quando l'accesso GitHub torna disponibile, riallineare subito Issue/Discussion con il delta registrato localmente.
