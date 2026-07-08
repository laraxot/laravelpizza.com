# Gemini — On-Demand Stub

Rules, skills, memories live only in wiki. Load on-demand.

## CRITICAL MANDATES
- **Session Start**: Every session MUST start with `git remote -v` and `gh issue list`.
- **Issue Audit Trail**: For every task, find an existing GitHub issue or create a new one (`gh issue create`). Comment with progress and wiki links.
- **Token Optimization**: Use `context-mode` and chunked reads for files > 80 lines. Follow the [Token Optimization Discipline](docs/wiki/rules/token-optimization-discipline.md) for every session.
- **Module Structure**: All functional code (Actions, Events, Listeners, Application, Models, etc.) MUST reside within the `app/` directory of the module. The `database/` directory must be strictly lowercase. Root-level capitalized directories (e.g., `Actions/`, `Database/`) are forbidden.
- **PHPStan Memory**: For heavy analyses (e.g., `Modules/` root), ALWAYS use `php -d memory_limit=-1 ./vendor/bin/phpstan`. Avoid relying solely on `--memory-limit=-1` as parallel workers may hit subprocess limits (e.g., 512M).
- **Markdown Standard**: All `.md` files must follow the [Markdown & Second Brain Standard](docs/wiki/rules/markdown-documentation-standard.md). Strictly lowercase-kebab-case filenames, NO dates in filenames, mandatory YAML front matter, and atomic notes. (Exceptions: README.md, CHANGELOG.md).

## Read First
- Risposte: italiano, sintetico, conciso.
- [Trigger Map](docs/wiki/rules/00-TRIGGER_MAP.md)
- [GitHub issue discipline](docs/wiki/how-to/github-issue-agent-discipline.md)
- [Standard Markdown (obbligatorio per `.md`)](docs/wiki/rules/markdown-documentation-standard.md)
- [GitHub Issue Discipline (obbligatorio)](docs/wiki/how-to/github-issue-agent-discipline.md)
- [Skills Index](docs/wiki/skills/INDEX.md)
- [QMD] `qmd search "<topic>"`

*Updated: 2026*
