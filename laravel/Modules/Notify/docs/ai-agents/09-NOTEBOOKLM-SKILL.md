# NotebookLM Skill - Guida Installazione e Utilizzo

**Skill**: `notebooklm`
**Path**: `~/.claude/skills/notebooklm/`
**Versione**: 1.3.0
**Stato**: ✅ Installato (auth richiesta)

---

## Cosa fa

Permette di interrogare notebook Google NotebookLM direttamente da Claude Code / Kilo Code tramite browser automation (Patchright/Chrome). Le risposte provengono **esclusivamente** dai documenti caricati sul notebook, riducendo drasticamente le allucinazioni.

**Uso tipico**: documentazione progetto, ricerca, analisi codice pre-caricato su NotebookLM.

---

## Setup (una tantum)

### 1. Installazione (già completata)

```bash
# Già installato in:
ls ~/.claude/skills/notebooklm/
```

Il venv Python + Chrome vengono creati automaticamente al primo uso.

### 2. Autenticazione Google (richiesta)

```bash
cd ~/.claude/skills/notebooklm
python scripts/run.py auth_manager.py setup
```

Si apre Chrome visibile → effettua login Google → la sessione persiste in `data/browser_state/`.

### 3. Verifica auth

```bash
python scripts/run.py auth_manager.py status
```

---

## Comandi principali

```bash
# Interroga notebook attivo
python scripts/run.py ask_question.py --question "..."

# Interroga URL specifico (senza aggiungere al library)
python scripts/run.py ask_question.py --question "..." --notebook-url "https://notebooklm.google.com/notebook/..."

# Aggiungi notebook alla library (Smart Add)
python scripts/run.py ask_question.py --question "What is this notebook about?" --notebook-url "[URL]"
python scripts/run.py notebook_manager.py add --url "[URL]" --name "..." --description "..." --topics "..."

# Lista notebook salvati
python scripts/run.py notebook_manager.py list

# Attiva notebook di default
python scripts/run.py notebook_manager.py activate --id [ID]
```

---

## Integrazione Kilo Code (`kilo.jsonc`)

Il `kilo.jsonc` è configurato con:

```jsonc
"skills": {
  "paths": ["~/.claude/skills"]
}
```

Kilo Code trova automaticamente lo skill dalla directory `~/.claude/skills/notebooklm/SKILL.md`.

---

## File di configurazione opzionale

Crea `~/.claude/skills/notebooklm/.env`:

```env
HEADLESS=true            # false = browser visibile (utile per debug)
DEFAULT_NOTEBOOK_ID=     # ID notebook di default
STEALTH_ENABLED=true
```

---

## Dati persistenti

```
~/.claude/skills/notebooklm/data/
├── library.json          # Notebook salvati
├── auth_info.json        # Stato auth
└── browser_state/
    ├── state.json        # Cookie sessione Google
    └── browser_profile/  # Profilo Chrome (NON committare)
```

---

**Riferimenti**: [GitHub](https://github.com/PleasePrompto/notebooklm-skill)
