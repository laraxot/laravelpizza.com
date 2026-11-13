# Claude — On-Demand Stub

**Risposte:** sempre **italiano**, **sintetico**, **conciso** → [response-style](docs/wiki/memories/response-style-sintetico-conciso-italiano.md)

**Dependabot:** [dependabot-discipline](docs/wiki/how-to/dependabot-discipline.md)

Rules, skills, memories live only in wiki. Load on-demand.

## Read First
- Risposte: italiano, sintetico, conciso.
- **Post-edit (OBBLIGATORIO per ogni file modificato):** PHPStan lvl10, PHPMD (`tools/phpmd.sh`), PHP Insights (`tools/phpinsights.sh`), Pest (crea test se manca — **MAI** `migrate --force`/`migrate:fresh|refresh`/`RefreshDatabase`, i dati sono sacri), Puppeteer + Playwright-MCP se impatto UI → [post-edit-quality-verification](laravel/Modules/Xot/docs/post-edit-quality-verification.md)
- [GitHub issue ↔ wiki (audit — obbligatorio)](docs/wiki/how-to/github-issue-agent-discipline.md)
- [Trigger Map](docs/wiki/rules/00-TRIGGER_MAP.md) — **prima** la riga **BOOTSTRAP SESSIONE AGENTE**, poi il trigger specifico del task
- [Standard Markdown (obbligatorio per `.md`)](docs/wiki/rules/markdown-documentation-standard.md)
- [Skills Index](docs/wiki/skills/INDEX.md)
- [Agent handoff / chat](docs/chat/README.md) — messaggi tra agenti AI e stato sessione (creare/aggiornare file qui durante il lavoro multi-turno)
- **Naming dominio:** vietato `persist*` su model/contratti — [domain-method-naming-no-persist](docs/wiki/patterns/domain-method-naming-no-persist.md)
- [QMD] `qmd search "<topic>"`

*Updated: 2026*
