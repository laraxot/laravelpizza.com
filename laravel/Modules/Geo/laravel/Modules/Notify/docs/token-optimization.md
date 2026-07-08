# Token Optimization — base_fixcity_fila5

## 🔴 Documento Aggiornato: [token-efficiency-religion.md](./token-efficiency-religion.md)

**Questo documento e mantenuto per reference storico.**

**Per regole attive e complete**: Leggi [docs/token-efficiency-religion.md](./token-efficiency-religion.md)

---

## Ricerca effettuata: Aprile 2026

## Tecniche e risparmio atteso

| Tecnica | Risparmio stimato | Come applicarla |
|---------|-------------------|-----------------|
| CLAUDE.md root terse (< 500 token) | -40% input/sessione | Già applicato: `CLAUDE.md` in root |
| `/clear` tra task non correlati | -30-60% contesto | Usare prima di ogni nuova story |
| `Grep` + `offset/limit` su file grandi | -60-80% per navigazione CSS | NON fare `Read` su file > 500 righe |
| Tabelle/bullet vs prosa | -20-30% output | Usato in tutte le stories BMAD |
| Sessioni focalizzate per story | -50% contesto irrilevante | 1 story = 1 sessione |
| Prompt caching (automatico) | -90% sui token ripetuti | Nessuna azione richiesta |
| **Scope context precisely** | -30-50% input | Specificare SOLO file rilevanti nel prompt |
| **Diffs vs full files** | -70% output | Chiedere `git diff` non file completi |
| **Summarize logs/errors** | -80% input | Troncare stack trace a errore chiave |
| **Structured prompts** | -20-40% output | Template: `Goal → Constraints → Output` |
| **Batch related requests** | -40% chiamate | Raggruppare cambiamenti correlati |
| **Exclude unnecessary files** | -50% context | `.aiignore` per `node_modules/`, `*.lock`, `dist/` |
| **Reference, don't repeat** | -60% input | `Match pattern in file.ts` non incollare 100 righe |
| **System instructions block** | -50% input | Spostare regole statiche in system prompt |
| **Define response schema** | -30% output | Richiedere JSON strutturato non testo libero |

## Regole di sessione per questo progetto

### Prima di iniziare una story
1. `/clear` se sessione precedente era su argomento diverso
2. Caricare solo la story file + i file CSS/blade rilevanti
3. Non caricare l'intero `sprint-status.yaml` se serve solo 1 entry

### Durante la sessione
- `Grep` per trovare il blocco CSS, poi `Read` con `offset`+`limit`
- Non rileggere file già letti nella stessa sessione
- Output: tabelle, diff, bullet — non descrizioni verbose
- **MAI** leggere file > 500 righe senza prima fare `Grep`

### File pesanti da NON leggere intero

| File | Righe | Approccio corretto |
|------|-------|--------------------|
| `segnalazione-parity.css` | ~3900 | `Grep pattern` → `Read offset+limit` |
| `app.css` | ~700 | `Grep pattern` se basta |
| `laravel/CLAUDE.md` | ~825 | Già in contesto automaticamente |
| `sprint-status.yaml` | ~170 | `Read offset+limit` per epic specifico |

## Strategia CLAUDE.md/QWEN.md ottimale

Mantenere ≤ 2,000 token (≈ 1,500 parole). Il file root `CLAUDE.md` attuale è ~200 parole: dentro il limite.

`laravel/CLAUDE.md` è ~10,000 token ma è auto-generato da Laravel Boost — non modificabile.

## Fonti

- [Branch8 — Claude Code Token Limits Guide](https://branch8.com/posts/claude-code-token-limits-cost-optimization-apac-teams)
- [Sabrina.dev — 6 Ways to Cut Token Usage in Half](https://www.sabrina.dev/p/6-ways-i-cut-my-claude-token-usage)
- [Mindstudio — 18 Claude Code Token Hacks](https://www.mindstudio.ai/blog/claude-code-token-management-hacks-3)
- [drona23/claude-token-efficient (GitHub)](https://github.com/drona23/claude-token-efficient)
- [The New Stack — Token-Efficient Data Prep](https://thenewstack.io/a-guide-to-token-efficient-data-prep-for-llm-workloads/)
- [Sitepoint — Claude API Token Optimization](https://www.sitepoint.com/claude-api-token-optimization/)
- [Reddit — Practical Guide (Pochi)](https://www.reddit.com/r/AI_Agents/comments/1remock/wrote_a_practical_guide_on_reducing_token_usage/)
- [LogRocket — 10 Ways to Cut Token Usage](https://blog.logrocket.com/stop-wasting-ai-tokens-10-ways-to-reduce-usage/)
