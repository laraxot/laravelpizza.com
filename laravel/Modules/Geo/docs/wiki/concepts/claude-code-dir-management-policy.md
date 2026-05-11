---
type: concept
module: Geo
component: claude-code
created: 2026-04-30
updated: 2026-04-30
stories:
  - 8-99-cleanup-bmad-dir
---

# Claude Code `.claude` Directory Management Policy

## Scopo

Definire le regole per mantenere la directory `.claude` leggera (<5MB), efficiente e reattiva per gli agenti AI.

## Regola Assoluta

```
OBBLIGATORIO: mantenere .claude directory sotto i 5MB totali
VIETATO: file duplicati, ridondanti o obsoleti in .claude/
OBBLIGATORIO: consolidare contenuti simili in file mirati e piccoli
VIETATO: lasciare residue di versioni precedenti o esperimenti falliti
```

## Struttura Directory Consigliata

```
.claude/
├── skills/           ← Skill BMAD essenziali (max 10-15 file)
├── rules/            ← Regole operative (max 20 file)
├── memory/           ← Memoria persistente cross-session (auto-generata)
├── settings.json     ← Configurazione (allowlist mirata)
└── context-mode/      ← MCP installation (non toccare)
```

## Cosa Mantenere

### 1. Skills Essenziali (skills/)
- `bmad-create-story.md` — Creazione storie BMAD
- `bmad-sprint-status.md` — Gestione sprint
- `bmad-dev-story.md` — Sviluppo storie
- `bmad-code-review.md` — Review codice
- `bmad-retrospective.md` — Retrospettive
- Altri max 10-15 skills focalizzati

**Criterio**: mantieni solo skills usati negli ultimi 30 giorni.

### 2. Regole Operative (rules/)
- `post-modifica-verifica-obbligatoria.md` — Verifica post-modifica
- `llm-wiki-operational-discipline.md` — Disciplina wiki
- `second-brain-always-first.md` — Second brain prioritario
- `context-compression-discipline.md` — Gestione context window
- `no-absolute-paths-in-config.md` — No percorsi assoluti
- `filament5-section-namespace.md` — Filament 5.x namespace
- `translation-navigation-placeholder-rule.md` — Traduzioni
- `blade-component-extraction.md` — Estrazione componenti
- `playwright-test-location-policy.md` — Test location (nuovo)
- `claude-code-dir-management-policy.md` — Questa policy

**Criterio**: max 20 regole focalizzate e non sovrapposte.

### 3. Memoria (memory/)
- File auto-generati dal sistema (non cancellare)
- `MEMORY.md` — Indice centrale
- File singoli per topic (feedback_*.md)

**Criterio**: la memoria è preziosa, non cancellare.

### 4. Configurazione (settings.json)
```json
{
  "permissions": {
    "allow": [
      "Bash:npm *",
      "Bash:php artisan *",
      "Bash:git add *",
      "Bash:git commit *",
      "Bash:git status",
      "Bash:phpstan *",
      "Bash:phpmd *"
    ]
  }
}
```

**Criterio**: allowlist mirata sui comandi realmente usati.

## Cosa Rimuovere

### 1. Duplicati
```bash
# Trova file con contenuto identico
find .claude -type f -exec md5sum {} \; | sort | uniq -w32 -D
```

### 2. Ridondanti
- Skills per lo stesso compito (es. 3 varianti di "create-story")
- Regole che dicono la stessa cosa con parole diverse
- File `.md` e `.md.bak` o `.md.old`

### 3. Obsoleti
- Esperimenti falliti o abbandonati
- Versioni precedenti di skills/regole
- Cache di build o test non pulite
- File generati da comandi `--help` o debug

### 4. Temporanei
- Output di comandi di analisi one-off
- Log di sessioni precedenti
- File `.tmp`, `.bak`, `.old`, `~`

## Procedura di Pulizia

### 1. Audit
```bash
# Misura dimensione corrente
du -sh .claude/
du -sh .claude/skills/
du -sh .claude/rules/

# Conta file
find .claude -type f | wc -l
```

### 2. Identificazione
```bash
# File più grandi
find .claude -type f -exec ls -lh {} \; | sort -k5 -hr | head -20

# File duplicati (contengo simili)
fdupes -r .claude/

# File non letti da 30+ giorni
find .claude -type f -atime +30
```

### 3. Consolidamento
- Unisci regole simili in un unico file tematico
- Rimuovi ripetizioni interne ai file
- Sintetizza note lunghe in summary brevi

### 4. Rimozione
```bash
# Rimuovi duplicati (dopo verifica)
git rm .claude/skills/duplicate-skill.md

# Pulisci cache
rm -rf .claude/cache/
rm -rf .claude/.tmp/

# Commit pulizia
git add .claude/
git commit -m "chore: cleanup .claude directory (reduce to <5MB)"
```

### 5. Verifica Post-Pulizia
```bash
# Dimensione <5MB?
du -sh .claude/ | awk '$1 < 5 { print "OK: " $1 }'

# Skills funzionano?
ls .claude/skills/*.md | wc -l  # < 20

# Regole leggibili?
ls .claude/rules/*.md | wc -l  # < 25
```

## Target di Performance

| Metric | Pre-Cleanup | Post-Cleanup Target |
|--------|--------------|---------------------|
| Dimensione totale | ~400MB | **< 5MB** |
| Numero skills | 50+ | **< 20** |
| Numero regole | 30+ | **< 25** |
| File totali | 25,000+ | **< 500** |
| Startup time | ~3-5s | **< 1s** |
| Permission prompts | Frequent | **Rari** |

## Impatto su Agenti AI

### Reattività
- **Pre**: 400MB da scansionare → latenza alta
- **Post**: 5MB mirati → risposta immediata

### Efficienza
- **Pre**: Permission prompts frequenti (file non in allowlist)
- **Post**: Allowlist mirata → meno interruzioni

### Chiarezza
- **Pre**: 25k file = confusione su cosa esiste
- **Post**: <500 file = navigazione immediata

## Script di Verifica Automatica

```bash
#!/bin/bash
# .claude-health-check.sh

echo "=== .claude Health Check ==="

# 1. Dimensione
SIZE=$(du -sm .claude/ | cut -f1)
if [ "$SIZE" -gt 5 ]; then
    echo "❌ Size: ${SIZE}MB (target: <5MB)"
else
    echo "✅ Size: ${SIZE}MB"
fi

# 2. File count
COUNT=$(find .claude -type f | wc -l)
if [ "$COUNT" -gt 500 ]; then
    echo "❌ Files: $COUNT (target: <500)"
else
    echo "✅ Files: $COUNT"
fi

# 3. Skills count
SKILLS=$(ls .claude/skills/*.md 2>/dev/null | wc -l)
echo "ℹ️  Skills: $SKILLS"

# 4. Rules count
RULES=$(ls .claude/rules/*.md 2>/dev/null | wc -l)
echo "ℹ️  Rules: $RULES"

# 5. Duplicate check
DUPS=$(fdupes -r .claude/ 2>/dev/null | wc -l)
if [ "$DUPS" -gt 0 ]; then
    echo "⚠️  Duplicates found: $DUPS"
else
    echo "✅ No duplicates"
fi
```

## Integrazione con Wiki

Dopo ogni pulizia:
1. Aggiorna `docs/wiki/index.md` con nuovi documenti
2. Aggiungi entry in `docs/wiki/log.md`
3. Salva regole in `memory/feedback_claude_dir_management.md`

## Esempio di Pulizia Eseguita

```
PRE:
.claude/           → 412MB
  ├── skills/    → 350MB (50+ file)
  ├── rules/     → 45MB (30+ file)
  ├── memory/    → 15MB
  └── tmp/       → 2MB

POST:
.claude/           → 4.2MB ✅
  ├── skills/    → 2.1MB (15 file) ✅
  ├── rules/     → 1.5MB (18 file) ✅
  ├── memory/    → 0.6MB
  └── settings.json → 2KB (allowlist mirata) ✅
```

## Checklist Pre-Commit

- [ ] Dimensione < 5MB verificata
- [ ] Duplicati rimossi
- [ ] Skills ridotti a < 20
- [ ] Regole consolidate a < 25
- [ ] `settings.json` con allowlist mirata
- [ ] File essenziali preservati (memory, context-mode)
- [ ] Wiki aggiornata con nuovo documento
- [ ] Performance test: agente risponde in < 1s

## Story Correlate

- **8-74**: Agents directory audit & reduce (risultato: 21MB, 1600 markdown)
- **8-76**: Claude dir rules optimization (merge conflicts, deduplication, 26MB ridotti)
- **8-99**: Cleanup .claude dir for improved agent performance (questa story)

## Note Importanti

- **Mai** cancellare `.claude/memory/` — contiene apprendimento cross-session
- **Mai** toccare `.claude/context-mode/` — MCP installation critica
- **Mai** cancellare regole appena create — potrebbero servire tra 30 giorni
- **Sempre** verificare che gli agenti funzionino post-pulizia
- **Sempre** documentare in wiki le decisioni prese
