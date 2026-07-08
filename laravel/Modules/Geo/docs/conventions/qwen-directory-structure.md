# .qwen Directory Structure & Junction Rules

> **Regola di Organizzazione per directory `.qwen`**
> 
> **Status:** Active
> **Last Updated:** 2026-03-13
> **Owner:** AI Development Team

---

## Regola Generale

La directory `.qwen` contiene la configurazione centrale per tutti gli agenti AI. Per garantire coerenza e evitare duplicazioni, tutte le sottodirectory devono puntare alla configurazione centrale tramite symlink.

---

## Struttura

```
/var/www/_bases/base_ptvx_fila5/
├── .qwen/                              ✅ CENTRALE - Configurazione principale
│   ├── skills/  -> ../bashscripts/docs/  Symlink a bashscripts/docs
│   ├── docs/                           Documentazione
│   ├── agents/                         Agent configuration
│   ├── commands/                       Command reference
│   └── memories/                       AI memories
│
├── laravel/.qwen/                      ✅ SYMLINK - Punta a root/.qwen
│   └── skills/ -> /var/www/_bases/base_ptvx_fila5/.qwen/skills
│
└── bashscripts/ai/.qwen/               ✅ SYMLINK - Punta a root/.qwen
    └── skills/ -> /var/www/_bases/base_ptvx_fila5/.qwen/skills
```

---

## Principi

### 1. Single Source of Truth

**Tutta la configurazione risiede in `.qwen/` nella root del progetto.**

Le directory `.qwen` nei sottoprogetti (`laravel/`, `bashscripts/ai/`) contengono SOLO symlink alla configurazione centrale.

### 2. Symlink Assoluti

Usare **SEMPRE** percorsi assoluti per i symlink:

```bash
# ✅ CORRETTO - Percorso assoluto
ln -s /var/www/_bases/base_ptvx_fila5/.qwen/skills /var/www/_bases/base_ptvx_fila5/laravel/.qwen/skills

# ❌ SBAGLIATO - Percorso relativo (può creare loop)
ln -s ../../../.qwen/skills laravel/.qwen/skills
```

### 3. Directory Centralizzate

| Directory | Posizione | Scopo |
|-----------|-----------|-------|
| `.qwen/skills/` | Root | Skills e reference per AI agents |
| `.qwen/docs/` | Root | Documentazione progetto |
| `.qwen/agents/` | Root | Configurazione agenti |
| `.qwen/commands/` | Root | Comandi utili |
| `.qwen/memories/` | Root | AI memories |

---

## Setup

### Creare la Struttura

```bash
# 1. Creare .qwen nella root (se non esiste)
mkdir -p /var/www/_bases/base_ptvx_fila5/.qwen

# 2. Creare .qwen nei sottoprogetti
mkdir -p /var/www/_bases/base_ptvx_fila5/laravel/.qwen
mkdir -p /var/www/_bases/base_ptvx_fila5/bashscripts/ai/.qwen

# 3. Creare symlink alla configurazione centrale
ln -s /var/www/_bases/base_ptvx_fila5/.qwen/skills /var/www/_bases/base_ptvx_fila5/laravel/.qwen/skills
ln -s /var/www/_bases/base_ptvx_fila5/.qwen/skills /var/www/_bases/base_ptvx_fila5/bashscripts/ai/.qwen/skills
```

### Verificare Symlink

```bash
# Verificare che i symlink funzionino
ls -la /var/www/_bases/base_ptvx_fila5/.qwen/
ls -la /var/www/_bases/base_ptvx_fila5/laravel/.qwen/
ls -la /var/www/_bases/base_ptvx_fila5/bashscripts/ai/.qwen/

# Testare accesso
ls /var/www/_bases/base_ptvx_fila5/laravel/.qwen/skills/
ls /var/www/_bases/base_ptvx_fila5/bashscripts/ai/.qwen/skills/
```

---

## Regole di Organizzazione

### Skills

**Posizione:** `.qwen/skills/` (symlink a `bashscripts/docs/`)

**Contenuto:**
- Skill configuration files
- AI agent reference
- Best practices
- Command reference

**File Importanti:**
```
.qwen/skills/
├── README.md              # Skills overview
├── INDEX.md               # Navigation index
├── laravel-expert.md      # Laravel development
├── documentation-master.md # Documentation standards
├── ai-agent-coordination.md # AI coordination
├── bash-scripts.md        # Bash scripting
└── phpstan-guardian.md    # PHPStan compliance
```

### Documentation

**Posizione:** `.qwen/docs/`

**Contenuto:**
- Project documentation
- Architecture guides
- Module rules
- Testing guides

### Agents

**Posizione:** `.qwen/agents/`

**Contenuto:**
- Agent configuration
- Team setup
- Coordination rules

---

## Best Practices

### Prima di Modificare

1. **Verificare la posizione:**
   ```bash
   # Sei nella directory corretta?
   pwd
   
   # Stai modificando file centrale o symlink?
   ls -la
   ```

2. **Modificare sempre la root:**
   ```bash
   # ✅ CORRETTO - Modifica file centrale
   cd /var/www/_bases/base_ptvx_fila5/.qwen/skills/
   vim laravel-expert.md
   
   # ❌ SBAGLIATO - Modifica tramite symlink (può creare confusione)
   cd /var/www/_bases/base_ptvx_fila5/laravel/.qwen/skills/
   vim laravel-expert.md
   ```

### Manutenzione

```bash
# Verificare integrità symlink
find /var/www/_bases/base_ptvx_fila5 -name ".qwen" -type d -exec ls -la {} \;

# Verificare loop
find /var/www/_bases/base_ptvx_fila5/.qwen -type l -exec file {} \;

# Pulire symlink rotti
find /var/www/_bases/base_ptvx_fila5 -xtype l -delete
```

---

## Troubleshooting

### Symlink Loop

**Sintomo:**
```
ls: cannot read symbolic link: Too many levels of symbolic links
```

**Soluzione:**
```bash
# 1. Identificare symlink problematico
find .qwen -type l -exec file {} \;

# 2. Rimuovere symlink circolare
rm .qwen/skills  # Se punta a se stesso

# 3. Ricreare correttamente
ln -s /var/www/_bases/base_ptvx_fila5/bashscripts/docs .qwen/skills
```

### File Non Accessibili

**Sintomo:**
```
Permission denied o File not found
```

**Soluzione:**
```bash
# Verificare permessi
ls -la /var/www/_bases/base_ptvx_fila5/.qwen/

# Correggere permessi
chmod -R 755 .qwen/
chown -R zorin:zorin .qwen/
```

---

## Violazioni

| Violazione | Gravità | Correzione |
|------------|---------|------------|
| Symlink relativo invece di assoluto | Alta | Ricreare con percorso assoluto |
| File duplicati invece di symlink | Alta | Spostare in root, creare symlink |
| Symlink circolare | Critica | Rimuovere immediatamente |
| Modifica file tramite symlink | Media | Modificare sempre file centrale |

---

## Riferimenti

### Documenti Correlati

- [AGENTS.md](../../AGENTS.md)
- [AI Agent Coordination](../../docs/ai-agent-coordination.md)
- [Skills Configuration Report](../../docs/reports/skills-configuration-report.md)

### Comandi Utili

```bash
# Verificare struttura
tree -L 2 .qwen/

# Verificare symlink
ls -la .qwen/

# Testare accesso
cat .qwen/skills/README.md
```

---

## Changelog

| Date | Change | Author |
|------|--------|--------|
| 2026-03-13 | Initial structure created | AI Development Team |
| 2026-03-13 | Symlink rules documented | AI Agent |
| 2026-03-13 | Junction structure finalized | AI Agent |

---

*Ultimo aggiornamento: 2026-03-13*
