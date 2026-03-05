# Multi-Agent Coordination Memory

## Critical Rule (SEMPRE ricordare)

**Questo progetto ha MOLTEPLICI agenti AI che lavorano in parallelo.**

❌ **NON** lavorare in isolamento
✅ **SEMPRE** coordinare via GitHub Issues e Discussions

## Come Coordinare

### 1. Prima di Iniziare Qualsiasi Task
```bash
# Controlla:
# 1. GitHub Issues (open) - quali task sono già in progress?
# 2. GitHub Discussions - altri agenti che cosa dicono?
# 3. Comments su issues - chi sta lavorando su cosa?
```

### 2. Durante il Lavoro
- Posta commenti negli issues pertinenti
- Menziona altri agenti: `@agent-00`, `@agent-01`
- Aggiorna coverage-plan.md, rules, memories, skills
- Segnala dipendenze tra task

### 3. Dopo il Lavoro
- Commenta l'issue con lo stato finale
- Aggiorna il coverage tracker
- Spiega quali docs/rules/memories hai aggiornato

## Epic Attivo (#191)

**100% Pest Coverage Across All Modules**
- Issues #192-205: Uno per cada modulo
- Issue #209: Status update multi-agent
- Issue #208: Activity refactoring (Laraxot rules)

### Stato Attuale (2026-03-05)
- Xot: 250+ test coverage target
- Meetup: ~56/250 test creati (in progress)
- User: Widget tests in progress (#209)
- Tenant, Lang, Cms, Media: TODO
- Activity: Needs Action refactoring (#208)

## Quando Usare GitHub

| Situazione | Azione |
|-----------|--------|
| Inizio nuovo task | Commenta l'issue pertinente |
| Task ha dipendenza | Menziona l'agente che deve finire prima |
| Finito il task | Commenta "DONE: ..." |
| Problema bloccante | Commenta e menziona chi può aiutare |
| Aggiornamenti docs | Allega link a rule/memory/skill creata |

## Esempio Real

```
Issue #195 (Meetup coverage)

Agent-00: "Starting Meetup model tests (50 models). 
         Will coordinate with @agent-01 on Actions."

Agent-01: "Understood. Will wait for models → Actions sequence."

[Agent-00 lavora, crea tests, aggiorna docs/rules]

Agent-00: "Completed Meetup models (56/250 tests). 
         Created: Modules/Meetup/docs/test-strategy.md, 
         Updated: .cursor/rules/pest-testing-patterns.md
         @agent-01 puoi iniziare Actions ora."

Agent-01: "Acknowledged. Starting Actions..."
```

## Non Dimenticare

- 🚨 **SEMPRE** controllare issues prima di iniziare
- 💬 **SEMPRE** coordinare via comments (@agent-XX)
- 📝 **SEMPRE** aggiornare docs/rules/memories/skills
- 🔗 **SEMPRE** aggiungere link alle issue quando migliori docs
- ⏸️ **SEMPRE** leggere i commenti di altri agenti (potrebbero aver risolto cose che pensi di fare)

## GitHub Resources

- **Repo**: `laraxot/laravelpizza.com`
- **Epic #191**: Coverage tracker principale
- **Issues**: Clicca su "Issues" tab per vedere tutti
- **Discussions**: Clicca su "Discussions" tab

---

**Memory Critica**: Leggi questa OGNI VOLTA prima di iniziare lavoro.
**Creata**: 2026-03-05
**Validità**: PERMANENTE
