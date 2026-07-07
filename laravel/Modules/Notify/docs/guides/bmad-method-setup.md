# BMAD Method - Guida Installazione e Configurazione

**Versione:** 6.2.2  
**Data Setup:** 2026-04-07  
**Progetto:** FixCity Fila5 (Laraxot)

---

## documentazione canonica (naming stabile)

- [setup e configurazione](../bmad/setup-guide.md)
- [quick reference](../bmad/quick-reference.md)

## Cos'è il BMAD Method

**BMAD** = **B**reakthrough **M**ethod for **A**gile **A**i **D**riven Development

Un framework open-source (MIT) per lo sviluppo software guidato da AI che fornisce:

- **12+ agenti specializzati** (PM, Architect, Developer, UX, QA, Scrum Master, etc.)
- **Workflow strutturati** basati su best practice agili
- **Scale-Domain-Adaptive** — si adatta alla complessità del progetto
- **Party Mode** — collaborazione multi-agente in una sessione
- **Lifecycle completo** — dal brainstorming al deployment

### Sito e Risorse

| Risorsa | URL |
|---------|-----|
| Docs ufficiali | https://docs.bmad-method.org |
| Repository | https://github.com/bmad-code-org/BMAD-METHOD |
| Discord | https://discord.gg/gk8jAdXWmj |
| YouTube | https://youtube.com/@BMadCode |

---

## Prerequisiti

- **Node.js** v20+ (attuale: v25.6.0)
- **npm** v11+ (attuale: v11.8.0)
- **Python** 3.10+ (per uv)

---

## Installazione

### Installazione Interattiva (consigliata la prima volta)

```bash
cd /var/www/_bases/base_fixcity_fila5
npx bmad-method install
```

### Installazione Non-Interattiva (CI/CD)

```bash
npx bmad-method install \
  --directory /var/www/_bases/base_fixcity_fila5 \
  --modules bmm \
  --tools windsurf \
  --yes
```

### Aggiornamento

```bash
npx bmad-method install \
  --directory /var/www/_bases/base_fixcity_fila5 \
  --modules bmm \
  --tools windsurf \
  --action update \
  --yes
```

### Quick Update (preserva settings)

```bash
npx bmad-method install \
  --directory /var/www/_bases/base_fixcity_fila5 \
  --action quick-update \
  --yes
```

---

## Moduli Installati

| Modulo | ID | Versione | Tipo | Descrizione |
|--------|----|----------|------|-------------|
| **Core** | core | 6.2.2 | built-in | Framework base, help, brainstorming |
| **BMad Method** | bmm | 6.2.2 | built-in | Workflow agili completi (analysis → implementation) |
| **Creative Intelligence Suite** | cis | 0.1.9 | external | Design thinking, storytelling, problem solving |
| **Game Dev Studio** | gds | 0.2.2 | external | Sviluppo giochi (non usato attivamente) |
| **Test Architecture Enterprise** | tea | 1.7.2 | external | Test automation, framework, CI/CD quality |
| **Web Design System** | wds | 0.3.1 | external | UX design, trigger mapping, asset generation |

### Moduli Disponibili (non installati)

| Modulo | ID | Descrizione |
|--------|----|-------------|
| **BMad Builder** | bmb | Factory per creare agenti, workflow e moduli custom |

---

## Struttura File

```
_bmad/                              # Configurazione e agenti
├── _config/                        # Manifest, skill registry
│   ├── manifest.yaml              # Versioni e moduli installati
│   ├── agent-manifest.csv         # Registry agenti
│   ├── skill-manifest.csv         # Registry skills
│   ├── bmad-help.csv              # Help database
│   └── ides/                      # Config per IDE
├── agents/                         # Definizioni agenti
│   ├── analyst.md                 # Mary - Business Analyst
│   ├── architect.md               # Winston - System Architect
│   ├── dev.md                     # Amelia - Senior Developer
│   ├── pm.md                      # John - Product Manager
│   ├── qa.md                      # Quinn - QA Engineer
│   ├── sm.md                      # Bob - Scrum Master
│   ├── ux-expert.md               # Sally - UX Designer
│   ├── po.md                      # Product Owner
│   ├── bmad-master.md             # BMad Master orchestrator
│   └── bmad-orchestrator.md       # Multi-agent orchestrator
├── bmm/                           # BMad Method Module
│   ├── 1-analysis/                # Fase analisi
│   ├── 2-plan-workflows/          # Fase pianificazione
│   ├── 3-solutioning/            # Fase solutioning
│   └── 4-implementation/          # Fase implementazione
├── core/                          # Skill core
│   ├── bmad-help/                 # Sistema help intelligente
│   ├── bmad-brainstorming/       # Brainstorming facilitato
│   ├── bmad-party-mode/          # Multi-agente in sessione
│   └── bmad-distillator/         # Compressione documenti
├── cis/                           # Creative Intelligence Suite
├── gds/                           # Game Dev Studio
├── tea/                           # Test Architecture Enterprise
├── wds/                           # Web Design System
├── threads/                       # Thread di coordinamento
├── config.yaml                    # Config globale
└── config.user.yaml              # Config utente

_bmad-output/                      # Artifacts generati
├── project-context.md            # Contesto progetto per agenti
├── prd.md                        # Product Requirements Document
├── architecture.md               # Architecture Decision Document
├── ui-spec.md                    # UX Design Specification
├── epics-and-stories.md          # Product Backlog
├── sprint-plan.md                # Sprint Planning
├── adversarial-review.md         # Audit critico
├── codebase/                     # Analisi codebase
├── planning-artifacts/           # Artifacts pianificazione
└── implementation-artifacts/     # Artifacts implementazione

.windsurf/skills/                  # 110 skills per Windsurf IDE
├── bmad-*/                       # Skills BMAD (agents, workflows)
├── laravel-*/                    # Skills Laravel
├── filament-*/                   # Skills Filament
├── phpstan-*/                    # Skills PHPStan
├── gds-*/                        # Skills Game Dev
├── wds-*/                        # Skills Web Design
└── gsd-*/                        # Skills Get Shit Done
```

---

## Configurazione Attuale

### `_bmad/config.user.yaml`

```yaml
user_name: Xot
communication_language: Italiano
document_output_language: Italiano
```

### `_bmad/config.yaml`

```yaml
document_output_language: Italiano
output_folder: '{project-root}/_bmad-output'
```

### IDE Configurati

- **Windsurf** (`.windsurf/skills/` — 110 skills)
- **OpenCode** (legacy, mantenuto per compatibilità)

---

## Come Usare BMAD

### 1. Help Intelligente

Chiedi `bmad-help` per orientamento su cosa fare dopo:

```
bmad-help
bmad-help Ho appena finito l'architettura, cosa faccio?
```

### 2. Agenti Specializzati

Invoca un agente per conversazione diretta:

| Skill | Agente | Ruolo |
|-------|--------|-------|
| `bmad-agent-pm` | John | Product Manager |
| `bmad-agent-architect` | Winston | System Architect |
| `bmad-agent-dev` | Amelia | Senior Developer |
| `bmad-agent-analyst` | Mary | Business Analyst |
| `bmad-agent-ux-designer` | Sally | UX Designer |
| `bmad-agent-qa` | Quinn | QA Engineer |
| `bmad-agent-sm` | Bob | Scrum Master |
| `bmad-agent-tech-writer` | Paige | Tech Writer |
| `bmad-agent-quick-flow-solo-dev` | Barry | Quick Flow Solo Dev |

### 3. Workflow Principali (BMM)

#### Fase 1 — Analisi (opzionale)

| Skill | Scopo |
|-------|-------|
| `bmad-product-brief` | Creare/aggiornare product brief |
| `bmad-domain-research` | Ricerca dominio/industria |
| `bmad-market-research` | Analisi competitiva |
| `bmad-technical-research` | Ricerca tecnica |

#### Fase 2 — Pianificazione (richiesta)

| Skill | Scopo |
|-------|-------|
| `bmad-create-prd` | Creare PRD |
| `bmad-create-ux-design` | Spec UX/UI |
| `bmad-create-epics-and-stories` | Epiche e storie |

#### Fase 3 — Solutioning

| Skill | Scopo |
|-------|-------|
| `bmad-create-architecture` | Design architetturale |
| `bmad-generate-project-context` | Contesto progetto |
| `bmad-check-implementation-readiness` | Verifica readiness |

#### Fase 4 — Implementazione

| Skill | Scopo |
|-------|-------|
| `bmad-sprint-planning` | Pianificazione sprint |
| `bmad-create-story` | Creare story dettagliata |
| `bmad-dev-story` | Implementare story |
| `bmad-code-review` | Code review |
| `bmad-sprint-status` | Status sprint |
| `bmad-retrospective` | Retrospettiva |

### 4. Skills Test Architecture (TEA)

| Skill | Scopo |
|-------|-------|
| `bmad-testarch-framework` | Setup framework test |
| `bmad-testarch-test-design` | Design test plan |
| `bmad-testarch-automate` | Automazione test |
| `bmad-testarch-ci` | Pipeline CI/CD |
| `bmad-testarch-nfr` | Test non-funzionali |

### 5. Party Mode

Porta più agenti in una sessione per discussione collaborativa:

```
bmad-party-mode
```

---

## Best Practice

1. **Sempre chat fresche** per ogni workflow (previene problemi di contesto)
2. **Usa `bmad-help`** quando non sai cosa fare
3. **Project context** (`_bmad-output/project-context.md`) mantiene coerenza tra agenti
4. **Artifacts** vanno in `_bmad-output/` (non altrove)
5. **Thread** in `_bmad/threads/` per coordinamento multi-sessione
6. **Prerelease**: usa `npx bmad-method@next install` per features sperimentali

---

## Artifacts Esistenti

Il progetto ha già completato il workflow BMAD il 2026-04-01:

| Artifact | Status | Dettagli |
|----------|--------|----------|
| PRD | ✅ Completo | 130+ requisiti |
| Architettura | ✅ Completo | 8 ADR |
| UX Spec | ✅ Completo | 892 righe |
| Epics & Stories | ✅ Completo | 71 storie, 292 SP |
| Sprint Plan | ✅ Completo | 6 sprint |
| Adversarial Review | ✅ Completo | 47 findings |
| Codebase Analysis | ✅ Completo | 4 documenti |

**Stato attuale:** Ready for Sprint 0

---

## Troubleshooting

### L'update ha resettato i config

Dopo `--action update`, verificare che i file `config.yaml` nei moduli contengano le impostazioni corrette:

```bash
grep "user_name" _bmad/*/config.yaml
# Deve mostrare "Xot" ovunque, NON "Zorin"
```

### Skills non appaiono in Windsurf

Verificare che `.windsurf/skills/` contenga le directory delle skills:

```bash
ls .windsurf/skills/ | head -20
```

### Versione non aggiornata

```bash
npx bmad-method@latest --version
```

---

*Documento creato: 2026-04-07*  
*Ultima modifica: 2026-04-07*  
*Vedi anche: [_bmad-output/index.md](../../_bmad-output/index.md)*
