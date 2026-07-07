# bmad method: quick reference (fixcity)

## comandi rapidi

### help

```
skill: "bmad-help"
```

### parlare con agenti (ruoli)

| Agente | Skill | Scopo |
|---|---|---|
| Mary (analyst) | `skill: "bmad-agent-analyst"` | requisiti, analisi, ricerca |
| John (pm) | `skill: "bmad-agent-pm"` | prd, user stories |
| Sally (ux) | `skill: "bmad-agent-ux-designer"` | ux spec |
| Winston (architect) | `skill: "bmad-agent-architect"` | architettura/decisioni |
| Amelia (dev) | `skill: "bmad-agent-dev"` | implementazione |
| Quinn (qa) | `skill: "bmad-agent-qa"` | test e qualità |
| Bob (sm) | `skill: "bmad-agent-sm"` | sprint planning |
| Barry (quick dev) | `skill: "bmad-agent-quick-flow-solo-dev"` | delivery rapida (trade-off espliciti) |

## workflow tipico (feature)

1. `skill: "bmad-product-brief"`
2. `skill: "bmad-create-prd"`
3. `skill: "bmad-create-ux-design"`
4. `skill: "bmad-create-architecture"`
5. `skill: "bmad-create-epics-and-stories"`
6. `skill: "bmad-sprint-planning"`
7. `skill: "bmad-dev-story"`

## review

```
skill: "bmad-code-review"
skill: "bmad-review-edge-case-hunter"
```

## cartelle chiave

- `_bmad/` (moduli, agenti, skill, config)
- `_bmad-output/` (artefatti)
- `docs/bmad/` (questa documentazione)

## antigravity (opzionale)

IDE Google Antigravity usa slash command (`/pm`, `/dev`, …) da template esterni; in questo repo vedi [antigravity-integration](antigravity-integration.md).

## link

- [setup e configurazione](setup-guide.md)
