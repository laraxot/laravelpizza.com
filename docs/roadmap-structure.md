# Struttura Roadmap - Moduli e Temi

Ogni modulo e tema ha la roadmap spezzata in file piccoli dentro `docs/roadmap/`.

## Struttura obbligatoria

```
Modules/{Module}/docs/
├── roadmap.md              ← redirect a roadmap/00-index.md
└── roadmap/
    ├── 00-index.md
    ├── 01-current-state.md
    ├── 02-goals.md
    ├── 03-workstreams.md
    ├── 04-milestones.md
    └── 05-risks.md
```

## File opzionali

- `legacy-roadmap.md` - migrazione da roadmap storiche
- `phases.md` - dettaglio fasi
- `quality.md` - quality gates
- `status.md` - stato operativo corrente
- `tasks.md` - backlog operativo

## Indice centralizzato

- [roadmap/00-index](roadmap/00-index.md) - link a tutte le roadmap
- [roadmap-progetto](roadmap-progetto.md) - stato globale, priorità

## Collegamenti

- [Modules/Cms/docs/roadmap](../Modules/Cms/docs/roadmap/00-index.md) - esempio
- [Themes/Meetup/docs/roadmap](../Themes/Meetup/docs/roadmap/00-index.md) - esempio tema
