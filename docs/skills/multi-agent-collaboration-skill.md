# Multi-Agent AI Collaboration - Skill Operativa

## Quando usare

Sempre. Questa skill e' attiva permanentemente per ogni agente AI che lavora su questo progetto.

## Comandi rapidi

```bash
# 1. PRIMA di lavorare - controlla cosa e' in corso
gh issue list --repo laraxot/laravelpizza.com --state open --limit 20

# 2. Leggi una issue specifica
gh issue view <ID> --repo laraxot/laravelpizza.com

# 3. Segnala inizio lavoro (claim)
gh issue comment <ID> --repo laraxot/laravelpizza.com \
  --body "🤖 **[NomeAgente]**: Inizio lavoro su [descrizione]. Files target: [lista]"

# 4. Segnala completamento (release)
gh issue comment <ID> --repo laraxot/laravelpizza.com \
  --body "✅ **[NomeAgente]**: Completato. Files: [lista]. Test: [risultato]"

# 5. Chiudi issue completata
gh issue close <ID> --repo laraxot/laravelpizza.com \
  --comment "✅ Completato da [NomeAgente]"

# 6. Crea nuova issue per lavoro scoperto
gh issue create --repo laraxot/laravelpizza.com \
  --title "[Tipo] Descrizione" --body "..."

# 7. Controlla discussions
gh api graphql -f query='{ repository(owner:"laraxot", name:"laravelpizza.com") { discussions(first:10) { nodes { number title } } } }'

# 8. Controlla modifiche recenti di altri agenti
git log --oneline -10
git status
```

## Formato commento standard

```markdown
🤖 **Cascade AI**: [Azione]

**Files target:**
- `path/to/file1.php`
- `path/to/file2.php`

**Risultato:**
- PHPStan: ✅/❌
- Pest: N test passing
- Note: [eventuali note]
```

## Checklist pre-lavoro

- [ ] `gh issue list --state open` controllato
- [ ] Nessun altro agente sta lavorando sugli stessi file
- [ ] Claim pubblicato su Issue rilevante
- [ ] `git log --oneline -10` verificato

## Backlink

- [docs/rules/multi-agent-collaboration-rule.md](../rules/multi-agent-collaboration-rule.md)
- [docs/memory/multi-agent-collaboration-memory.md](../memory/multi-agent-collaboration-memory.md)
