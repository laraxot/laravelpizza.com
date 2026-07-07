# NotebookLM Skill - Configuration & Usage Guide

**Project**: FixCity  
**Skill Location**: `~/.claude/skills/notebooklm/`  
**Status**: ✅ **INSTALLED & READY**  
**Last Updated**: 2026-03-30

---

## Cos'è NotebookLM

**Google NotebookLM** è un AI research assistant che:

- ✅ Fornisce risposte **source-grounded** (solo dai tuoi documenti)
- ✅ Riduce drasticamente le allucinazioni
- ✅ Supporta 50+ fonti per notebook (PDF, docs, website, GitHub, YouTube)
- ✅ Genera risposte con citazioni
- ✅ È gratuito (Google account richiesto)
- ✅ Usa Gemini 2.5 come motore AI

**Importante**: NotebookLM **NON ha API pubbliche** - questo skill usa browser automation.

---

## Architettura

```
~/.claude/skills/notebooklm/
├── SKILL.md                 # Claude instructions
├── scripts/
│   ├── ask_question.py      # Query NotebookLM
│   ├── notebook_manager.py  # Library management
│   └── auth_manager.py      # Authentication
├── .venv/                   # Python environment (auto-created)
└── data/                    # Local data (gitignored)
    ├── library.json         # Notebook library
    ├── auth_info.json       # Auth status
    └── browser_state/       # Browser cookies
```

### Come Funziona

```
User Query → Claude Code → NotebookLM Skill → Browser Automation
    ↓
NotebookLM (Gemini) → Source-grounded answer → Claude → Code
```

**Vantaggio**: Claude non legge file per file (costoso in token), ma chiede a NotebookLM che ha già indicizzato tutto.

---

## ✅ Installazione (GIÀ FATTA)

### Verifica

```bash
ls -la ~/.claude/skills/notebooklm/
# Deve mostrare: SKILL.md, scripts/, .venv/, data/
```

### Struttura Attuale

```
notebooklm/
├── .git/                    # Git repository
├── .venv/                   # Python 3.8+ environment ✅
├── data/                    # Notebook library ✅
├── scripts/                 # Automation scripts ✅
├── SKILL.md                 # Instructions ✅
├── README.md                # Documentation ✅
└── requirements.txt         # Dependencies ✅
```

**Status**: ✅ **Tutto installato e pronto**

---

## 🔐 Setup Iniziale

### Step 1: Autenticazione (One-Time)

**Comando in Claude Code**:
```
"Set up NotebookLM authentication"
```

**Cosa succede**:
1. ✅ Chrome si apre automaticamente
2. ✅ Login con Google account
3. ✅ Auth persiste tra le sessioni
4. ✅ Dati salvati in `data/auth_info.json`

**Security Best Practices**:
- ✅ Usa un Google account dedicato
- ✅ Le credenziali restano sul tuo PC
- ✅ Browser gira in locale
- ⚠️ Google potrebbe rilevare automazione (lo skill ha humanization)

### Step 2: Creare Notebook

1. Vai su **notebooklm.google.com**
2. Click **Create notebook**
3. Upload documenti:
   - 📄 PDF, Markdown, Text files
   - 🔗 Websites
   - 📚 GitHub repositories
   - 🎥 YouTube transcripts

**Per FixCity**:
```
Notebook Name: "FixCity Documentation"
Sources:
  - AGENTS.md
  - laravel/AGENTS.md
  - docs/**/*.md
  - .planning/**/*.md
  - laravel/Modules/docs/README.md
```

### Step 3: Condividere Notebook

1. Click **⚙️ Share**
2. Seleziona **Anyone with link**
3. **Copia il link**

### Step 4: Aggiungere alla Library

**Comando in Claude Code**:
```
"Add this NotebookLM to my library: [LINK]"
```

Oppure (smart):
```
"Query this notebook about FixCity and add it to my library: [LINK]"
```

---

## 📚 Utilizzo

### Comandi Base

| Comando | Azione |
|---------|--------|
| `"What skills do I have?"` | Lista skills |
| `"Set up NotebookLM authentication"` | Login Google |
| `"Add [LINK] to my NotebookLM library"` | Aggiungi notebook |
| `"Show my NotebookLM notebooks"` | Lista notebook |
| `"Ask my FixCity docs about [topic]"` | Query notebook |
| `"Use the FixCity notebook"` | Set active |
| `"Clear NotebookLM data"` | Reset (keep library) |
| `"Reset NotebookLM authentication"` | Re-auth |

### Esempi Pratici

#### 1. Query su Documentazione

```
User: "What does the FixCity documentation say about theme configuration?"

Claude → NotebookLM → Gemini synthesizes answer from docs → Claude responds
```

#### 2. Ricerca Specifica

```
User: "Check the Laraxot documentation for XotBaseModel patterns"

Result: Source-grounded answer with citations
```

#### 3. Multi-Source Correlation

```
User: "How do FixCity tickets integrate with the Geo module for location tracking?"

Result: Gemini connects info from multiple docs
```

---

## 🔧 Configurazione FixCity

### Notebook Structure Consigliata

**Notebook 1: FixCity Core**
```
Sources:
  - AGENTS.md
  - laravel/AGENTS.md
  - .planning/PROJECT.md
  - .planning/config.json
  - FIXCITY_IMPROVEMENT_PLAN.md
```

**Notebook 2: Module Documentation**
```
Sources:
  - laravel/Modules/docs/README.md
  - laravel/Modules/Fixcity/docs/
  - laravel/Modules/User/docs/
  - laravel/Modules/Cms/docs/
  - ... (altri moduli)
```

**Notebook 3: Theme Documentation**
```
Sources:
  - laravel/Themes/docs/README.md
  - laravel/Themes/Sixteen/docs/
  - .planning/THEME_CONTEXT.md
```

**Notebook 4: Technical Guides**
```
Sources:
  - docs/**/*.md (technical docs)
  - bashscripts/docs/**/*.md
  - .kilo/README.md
```

### Library Management

I notebook vengono salvati in:
```
~/.claude/skills/notebooklm/data/library.json
```

**Struttura**:
```json
{
  "notebooks": [
    {
      "name": "FixCity Core",
      "url": "https://notebooklm.google.com/notebook/...",
      "topics": ["architecture", "configuration", "setup"],
      "added_date": "2026-03-30"
    }
  ]
}
```

---

## 🎯 Best Practices

### DRY (Don't Repeat Yourself)

✅ **CORRETTO**:
```
Claude chiede a NotebookLM → NotebookLM ha già indicizzato → Risposta source-grounded
```

❌ **SBAGLIATO**:
```
Claude legge file per file → Consuma token → Possibili allucinazioni
```

### KISS (Keep It Simple, Stupid)

✅ **SEMPLICE**:
- 1 notebook per area tematica
- Nomi chiari e descrittivi
- Query dirette e specifiche

❌ **COMPLESSO**:
- Troppi notebook sovrapposti
- Nomi generici
- Query vaghe

### Security

- ✅ Usa account Google dedicato
- ✅ Non commitare `data/` directory
- ✅ Review before commit
- ✅ Test in safe environments

### Workflow

```
SENZA NotebookLM:
1. Claude legge file → 2. Trova info → 3. Scrive codice
   (lento, costoso, possibile hallucination)

CON NotebookLM:
1. Claude chiede a NotebookLM → 2. Gemini sintetizza → 3. Claude scrive codice
   (veloce, economico, source-grounded)
```

---

## ⚠️ Limitazioni

| Limitazione | Dettaglio |
|-------------|-----------|
| **Local Only** | NON funziona su Claude web UI (sandbox) |
| **No Session** | Ogni query è indipendente |
| **No Context** | Non può riferirsi a "risposta precedente" |
| **Rate Limits** | Free tier ha limiti giornalieri |
| **Manual Upload** | Devi uploadare docs su NotebookLM prima |
| **Share Required** | Notebook deve essere shared pubblicamente |

---

## 🔍 Troubleshooting

### Skill Not Found

```bash
# Verifica installazione
ls -la ~/.claude/skills/notebooklm/

# Se manca, reinstalla
cd ~/.claude/skills
git clone https://github.com/PleasePrompto/notebooklm-skill notebooklm
```

### Authentication Issues

**In Claude Code**:
```
"Reset NotebookLM authentication"
```

### Browser Crashes

**In Claude Code**:
```
"Clear NotebookLM browser data"
```

### Dependencies Issues

```bash
cd ~/.claude/skills/notebooklm
rm -rf .venv
python -m venv .venv
source .venv/bin/activate
pip install -r requirements.txt
```

### Notebook Not Found

**Verifica**:
1. Notebook è condiviso pubblicamente?
2. Link è corretto?
3. Hai fatto l'upload dei documenti?

---

## 📊 Integration with AI Tools

### OpenViking

```bash
# OpenViking per context management
openviking add-memory "NotebookLM: FixCity docs indexed"

# Claude usa NotebookLM per query source-grounded
```

### BMAD

```bash
# BMAD crea PRD
/bmad-create-prd

# NotebookLM query PRD patterns
"Ask my BMAD docs about PRD structure"
```

### GSD

```bash
# GSD execution
/gsd-plan-phase 1

# NotebookLM query GSD workflows
"What does GSD documentation say about phase planning?"
```

### Ralph Loop

```bash
# Ralph autonomous execution
./.ralph/ralph-loop.sh

# NotebookLM query Ralph patterns
"Check Ralph documentation for checkpoint management"
```

---

## 🚀 Quick Start (5 minuti)

```bash
# 1. Verifica installazione (GIÀ FATTO ✅)
ls -la ~/.claude/skills/notebooklm/

# 2. Apri Claude Code
claude

# 3. Autenticazione
"Set up NotebookLM authentication"

# 4. Crea notebook su notebooklm.google.com
#    - Upload AGENTS.md, docs/**/*.md
#    - Share → Copy link

# 5. Aggiungi a library
"Add [LINK] to my NotebookLM library"

# 6. Query
"What does FixCity documentation say about theme configuration?"
```

---

## 📖 Resources

### Official Links

- **NotebookLM**: https://notebooklm.google.com
- **Skill Repo**: https://github.com/PleasePrompto/notebooklm-skill
- **MCP Server**: https://github.com/PleasePrompto/notebooklm-mcp (alternative)

### Documentation

- **Skill README**: `~/.claude/skills/notebooklm/README.md`
- **Skill Instructions**: `~/.claude/skills/notebooklm/SKILL.md`
- **Authentication**: `~/.claude/skills/notebooklm/AUTHENTICATION.md`

### Community

- **Issues**: https://github.com/PleasePrompto/notebooklm-skill/issues
- **Discussions**: https://github.com/PleasePrompto/notebooklm-skill/discussions

---

## ✅ Checklist Setup

- [x] Skill installato (`~/.claude/skills/notebooklm/`)
- [ ] Autenticazione completata
- [ ] Notebook creato su notebooklm.google.com
- [ ] Documenti uploadati (AGENTS.md, docs/, etc.)
- [ ] Notebook condiviso pubblicamente
- [ ] Link aggiunto a Claude library
- [ ] Prima query testata

---

## 📝 Example Session

```
User: "Show my NotebookLM notebooks"

Claude: You have 1 notebook:
  - FixCity Documentation (added 2026-03-30)
    Topics: architecture, configuration, laravel, fil

User: "Ask my FixCity docs about the active theme"

Claude: Based on your FixCity Documentation notebook:

  The active theme is **Sixteen** for the domain fixcity.local.
  
  Configuration is stored in `laravel/config/localhost/xra.php`:
  
  ```php
  return [
      'pub_theme' => 'Sixteen',  // Active theme
      'adm_theme' => 'AdminLTE', // Legacy
  ];
  ```
  
  **Source**: FixCity Theme Context documentation

User: "Perfect! Now check what modules are available"

Claude: Your FixCity Documentation lists 18 active modules:

  1. Fixcity - Ticket management
  2. User - Authentication
  3. Cms - Content management
  ... (continues)
  
  **Source**: Modules Index documentation
```

---

**Status**: ✅ **INSTALLED & READY**  
**Next Step**: Complete authentication and create first notebook  
**Documentation**: This file + `~/.claude/skills/notebooklm/README.md`
