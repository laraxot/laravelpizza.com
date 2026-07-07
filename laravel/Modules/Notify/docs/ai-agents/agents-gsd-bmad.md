# AGENTS GSD BMAD Workflow

Workflow per AI-driven development usando GSD e BMAD.

## GSD (Get Sh*t Done)

**Path**: `.codex/` (installato per Codex)

### Comandi Principali

```bash
# Nuovo progetto
$gsd-new-project

# Workflow principali
$gsd-discuss-phase [N]     # Cattura decisioni implementative
$gsd-plan-phase [N]         # Crea piano eseguibile
$gsd-execute-phase [N]      # Esegue piani in onde
$gsd-verify-work [N]        # Verifica UAT
$gsd-complete-milestone     # Archivia milestone
$gsd-new-milestone          # Avvia ciclo successivo

# Quick mode per task ad-hoc
$gsd-quick "task"
```

### Documentazione
- [GSD GitHub](https://github.com/gsd-build/get-shit-done)
- [GSD Docs](https://gsd-build-get-shit-done.mintlify.app/)

---

## BMAD (Breakthrough Method for Agile AI-Driven Development)

**Path**: `_bmad/` (installato localmente)

### Moduli BMAD

| Modulo | Descrizione |
|--------|-------------|
| **BMM** (Core) | 34+ workflow per AI development |
| **BMB** | Creazione agenti custom |
| **CIS** | Innovation/brainstorming |
| **GDS** | Integrazione GSD |
| **TEA** | Test architecture |
| **WDS** | Web design |

### Comandi

```bash
# Con bmad-help skill in agente AI
bmad-help                    # Mostra aiuto contestuale
bmad-new-project             # Inizializza progetto
bmad-discuss-phase [N]        # Discussione fase
bmad-plan-phase [N]          # Pianificazione
bmad-execute-phase [N]       # Esecuzione
bmad-verify-work [N]         # Verifica
```

### Documentazione
- [BMAD GitHub](https://github.com/bmad-code-org/BMAD-METHOD)
- [BMAD Docs](https://docs.bmad-method.org/)

---

## Quando Usare GSD vs BMAD

| Scenario | Usa GSD | Usa BMAD |
|----------|---------|----------|
| Implementazione feature concreta | ✅ | ❌ |
| Architecture design alto livello | ❌ | ✅ |
| Task con requisiti chiari | ✅ | ❌ |
| Brainstorming iniziale | ❌ | ✅ |
| Verifica e testing | ✅ | ✅ |
| Product strategy | ❌ | ✅ |

**Regola**: BMAD per design/pianificazione, GSD per esecuzione verificata.

---

## BMAD Agent Roles

| Agente | Scopo | Quando Usare |
|--------|-------|--------------|
| **PM** | Requirements, prioritization | Inizio progetto |
| **Architect** | Architecture decisions | Design tecnico |
| **Developer** | Implementation | Code implementation |
| **UX Designer** | UI/UX design | User experience |
| **QA** | Testing, verification | Quality gate |
| **Analyst** | Research, benchmarking | Analysis |

---

## Coordinamento Multi-Agente

### Workflow

1. **Leggere prima** [gsd-and-bmad-workflow.md](../../docs/project/gsd-and-bmad-workflow.md)
2. **Verificare** `.planning/STATE.md` per stato corrente
3. **Non duplicare** — se un agente ha già iniziato, continua da lì
4. **Commit atomici** — un commit per task
5. **Aggiornare** `STATE.md` e coordination doc

---

## 🔗 Link

- [Indice AGENTS](./agents-split-index.md)
- [gsd-bmad-comprehensive-guide.md](./gsd-bmad-comprehensive-guide.md)
- [AGENTS.md originale](../../AGENTS.md)
- [Index principale](./index.md)

## Differenze vs Originale

- Tabella comparativa GSD vs BMAD
- Ruoli BMAD documentati
- Workflow coordinamento multi-agente
