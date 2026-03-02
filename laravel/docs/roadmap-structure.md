# Struttura Roadmap - Moduli e Temi

Ogni modulo e tema ha la roadmap spezzata in file piccoli dentro `docs/roadmap/`.

## Struttura obbligatoria

```
Modules/{Module}/docs/
├── roadmap.md              ← redirect a roadmap/00-index.md
└── roadmap/
    ├── 00-index.md        ← overview, indice, metriche
    ├── vision.md          ← visione e obiettivi
    ├── phases.md          ← fasi di sviluppo
    └── quality.md         ← checklist qualità
```

## File opzionali

- `status.md` - stato attuale (es. Cms)
- `tasks.md` - tabella tasks (es. Cms)
- `technical-debt.md` - debito tecnico (es. User)
- `testing.md` - testing e TDD (es. User)
- `quality-fixes-log.md` - storico correzioni (es. Gdpr)

## Indice centralizzato

- [roadmap/00-index](roadmap/00-index.md) - link a tutte le roadmap
- [roadmap-progetto](roadmap-progetto.md) - stato globale, priorità

## Collegamenti

- [Modules/Cms/docs/roadmap](../Modules/Cms/docs/roadmap/00-index.md) - esempio
- [Themes/Meetup/docs/roadmap](../Themes/Meetup/docs/roadmap/00-index.md) - esempio tema
