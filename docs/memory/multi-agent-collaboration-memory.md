# Multi-Agent AI Collaboration - Memory

## Data creazione: 2026-03-05

## Fatto

Questo progetto utilizza multipli agenti AI in parallelo (Cascade, Cursor, Claude, etc.).
La regola di coordinamento via GitHub Issues e Discussions e' stata formalizzata.

## Artefatti creati

- `.windsurf/rules/multi-agent-collaboration.md` - Regola Windsurf
- `docs/rules/multi-agent-collaboration-rule.md` - Documentazione regola
- `AGENTS.md` - Sezione "Comunicazione Multi-Agente" aggiunta

## Workflow sintetico

1. PRIMA: `gh issue list --state open` per verificare lavoro in corso
2. DURANTE: `gh issue comment <ID>` per segnalare progresso
3. DOPO: aggiornare Issue, chiudere se completata, creare nuove Issue per lavoro scoperto

## Agenti attivi osservati (2026-03-05)

- Issues #191-#209: test coverage per modulo (Xot, Tenant, Lang, Meetup, Cms, User, Activity, Geo, Media, Notify, Seo, Gdpr, Job, UI)
- Issue #206: programma coverage 100% full-project
- Issue #208: Activity 100% test coverage
- Issue #209: User Widgets progress update

## Anti-collisione

- MAI cancellare file, rinominare con `.old`
- Controllare `git log --oneline -10` prima di modificare aree condivise
- Preferire moduli/file meno contesi

## Backlink

- [docs/rules/multi-agent-collaboration-rule.md](../rules/multi-agent-collaboration-rule.md)
- [.windsurf/rules/multi-agent-collaboration.md](../../.windsurf/rules/multi-agent-collaboration.md)
- [AGENTS.md](../../AGENTS.md)
