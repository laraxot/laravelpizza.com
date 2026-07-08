# AI Agent Team: Sync Remote Repo

> **Team Name:** `sync-subtrees-team`
> 
> **Mission:** Garantire che `bashscripts/git/subtrees/sync_remote_repo.sh` funzioni perfettamente sia da CLI che da GitHub Actions
> 
> **Created:** 2026-03-13
> **Status:** Active

---

## Team Members

### Agent Roles

| Role | Agent | Responsibilities | Status |
|------|-------|------------------|--------|
| **Team Lead** | Agent 1 | Coordination, CLI testing | 🟡 Seeking |
| **GitHub Actions Specialist** | Agent 2 | Workflow creation, CI/CD | 🟡 Seeking |
| **Script Analyst** | Agent 3 | Code review, improvements | 🟡 Seeking |
| **Documentation Lead** | Agent 4 | Docs, examples, guides | 🟡 Seeking |
| **Testing Coordinator** | Agent 5 | Test scenarios, validation | 🟡 Seeking |

### Join the Team

Se sei un agente AI e vuoi contribuire:

```bash
# 1. Leggi questo documento
cat docs/ai-agent-teams/sync-remote-repo-team.md

# 2. Scegli un ruolo
# 3. Inizia a lavorare
# 4. Aggiorna questo documento
# 5. Coordina con gli altri agenti
```

---

## Objectives

### Primary Goals

1. ✅ **CLI Functionality**: Script deve funzionare perfettamente da terminale
2. ✅ **GitHub Actions**: Workflow deve eseguire sync automaticamente
3. ✅ **Documentation**: Completa con esempi e troubleshooting
4. ✅ **Testing**: Testato in entrambi gli ambienti
5. ✅ **Coordiation**: Nessun conflitto tra agenti

### Success Criteria

- [ ] Script eseguito da CLI senza errori
- [ ] GitHub workflow triggera correttamente
- [ ] Sync pull/push funziona in entrambi i modi
- [ ] Documentazione completa e chiara
- [ ] Zero conflitti tra agenti AI

---

## Technical Requirements

### Script Requirements

```bash
# Deve funzionare in entrambi gli ambienti:

# 1. CLI (locale)
./bashscripts/git/subtrees/sync_remote_repo.sh

# 2. GitHub Actions
# Triggered by: schedule, workflow_dispatch, push

# Ambienti supportati:
- ✅ Linux (Ubuntu)
- ✅ macOS
- ✅ GitHub Actions (ubuntu-latest)
- ✅ WSL2
```

### GitHub Actions Requirements

```yaml
# Workflow deve:
- Triggerare su schedule (giornaliero/settimanale)
- Supportare manual trigger (workflow_dispatch)
- Usare secrets per authentication
- Gestire errori e notifiche
- Loggare tutte le operazioni
```

---

## Work Distribution

### Task Breakdown

| Task | Description | Assigned To | Status | Priority |
|------|-------------|-------------|---------|----------|
| **CLI Testing** | Test script da terminale | Agent ? | ⏳ Pending | P0 |
| **Workflow Creation** | Creare YAML workflow | Agent ? | ⏳ Pending | P0 |
| **Script Analysis** | Review e fix script | Agent ? | ⏳ Pending | P1 |
| **Documentation** | Scrivere docs complete | Agent ? | ⏳ Pending | P1 |
| **Integration Testing** | Test end-to-end | Agent ? | ⏳ Pending | P0 |
| **Error Handling** | Migliorare gestione errori | Agent ? | ⏳ Pending | P2 |

### Claim a Task

```bash
# Per claimare un task:
# 1. Aggiungi il tuo nome agente alla tabella
# 2. Inizia a lavorare
# 3. Aggiorna status a "In Progress"
# 4. Quando completi, aggiorna a "Done"
# 5. Coordina con il team
```

---

## Coordination

### Communication Channels

1. **GitHub Issue**: #109 (Sync Remote Repo Coordination)
2. **GitHub Discussion**: Sync Remote Repo Team Discussion
3. **Coordination Doc**: docs/ai-agent-coordination.md
4. **Team Doc**: Questo documento

### Update Frequency

- **Daily**: Aggiornare stato task
- **After each commit**: Commentare su GitHub issue
- **Before major changes**: Discutere nel team

### Conflict Resolution

Se due agenti vogliono lavorare sullo stesso task:

1. **Comunicare** immediatamente su GitHub issue
2. **Dividere** il task in subtask più piccoli
3. **Coordinare** chi fa cosa
4. **Documentare** la divisione del lavoro

---

## Technical Details

### Current Script Status

```bash
# Script esistente:
Location: bashscripts/git/subtrees/sync_remote_repo.sh
Status: ✅ Exists, needs GitHub Actions workflow
Features:
  - Parse gitmodules.ini
  - Sync pull/push
  - Conflict handling
  - Backup support
```

### Required Workflow

```yaml
# Da creare:
Location: .github/workflows/sync-remote-repo.yml
Triggers:
  - schedule: 0 2 * * * (daily at 2 AM)
  - workflow_dispatch (manual)
  - push (on specific branches)
```

### File Structure

```
bashscripts/git/subtrees/
├── sync_remote_repo.sh          # Script principale
├── sync_remote_repo.yaml        # GitHub Actions workflow
├── README.md                    # Documentazione
└── test/                        # Test scripts
    ├── cli-test.sh
    └── workflow-test.sh
```

---

## Timeline

### Phase 1: Analysis (Day 1)

- [ ] Analyze existing script
- [ ] Identify CLI vs CI requirements
- [ ] Create GitHub issue
- [ ] Form team

### Phase 2: Development (Day 2-3)

- [ ] Create GitHub workflow
- [ ] Update script for dual-mode
- [ ] Add error handling
- [ ] Test locally

### Phase 3: Testing (Day 4)

- [ ] CLI testing
- [ ] Workflow testing
- [ ] Integration testing
- [ ] Documentation

### Phase 4: Deployment (Day 5)

- [ ] Merge to main branch
- [ ] Enable workflow
- [ ] Monitor first runs
- [ ] Collect feedback

---

## Resources

### Existing Files

- Script: `bashscripts/git/subtrees/sync_remote_repo.sh`
- Gitmodules: `gitmodules.ini`
- Libs: `bashscripts/lib/custom.sh`, `bashscripts/lib/parse_gitmodules_ini.sh`

### Related Documentation

- [Git Subtrees Guide](../../docs/git/subtrees.md)
- [GitHub Actions Guide](../../docs/github/actions.md)
- [AI Agent Coordination](../../docs/ai-agent-coordination.md)

### External Resources

- [GitHub Actions Docs](https://docs.github.com/en/actions)
- [Git Subtree Documentation](https://github.com/git/git/blob/master/contrib/subtree/git-subtree.txt)

---

## Getting Started

### For New Team Members

1. **Read this document**
2. **Check GitHub issue #109**
3. **Choose a task**
4. **Start working**
5. **Update status**
6. **Coordinate with team**

### Quick Start Commands

```bash
# Test script locally
./bashscripts/git/subtrees/sync_remote_repo.sh

# View script content
cat bashscripts/git/subtrees/sync_remote_repo.sh

# Check gitmodules configuration
cat gitmodules.ini

# View recent team activity
git log --oneline --grep="sync" -10
```

---

## Contact

### Team Communication

- **GitHub Issue**: #109
- **Discussion**: Sync Remote Repo Team
- **Coordination Doc**: docs/ai-agent-coordination.md

### Escalation

Se ci sono problemi bloccanti:

1. Commenta su GitHub issue #109
2. Tagga altri agenti nel team
3. Crea discussione se necessario
4. Aggiorna coordination doc

---

*Team created: 2026-03-13*
*Status: Active - Seeking members*
*Last Updated: 2026-03-13*
