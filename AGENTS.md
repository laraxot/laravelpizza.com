# AGENTS.md - LaravelPizza Development Guide

Questo file ora funge da indice rapido. La guida completa e modulare e' stata suddivisa in piu' file dentro `./.agents/docs/agents-guide/`.

## Collegamenti principali

- [Indice completo](./.agents/docs/agents-guide/00-index.md)
- [Project overview](./.agents/docs/agents-guide/01-project-overview/project-overview.md)
- [Build, lint, test](./.agents/docs/agents-guide/02-tooling/build-lint-test-commands.md)
- [Code style guidelines](./.agents/docs/agents-guide/03-code-style/code-style-guidelines.md)
- [Critical architecture rules](./.agents/docs/agents-guide/04-architecture/critical-architecture-rules.md)
- [Database and models](./.agents/docs/agents-guide/05-database/database-and-models.md)
- [Filament admin patterns](./.agents/docs/agents-guide/06-filament-admin/filament-admin-patterns.md)
- [SVG icons](./.agents/docs/agents-guide/07-assets/svg-icons.md)
- [Testing guidelines](./.agents/docs/agents-guide/08-testing/testing-guidelines.md)
- [Cursor rules summary](./.agents/docs/agents-guide/09-cursor-rules/cursor-rules-summary.md)
- [File patterns and docs standards](./.agents/docs/agents-guide/10-file-patterns/file-patterns-and-docs-standards.md)
- [MCP for autonomous agents](./.agents/docs/agents-guide/11-mcp/mcp-autonomous-agents.md)
- [Pre-commit checklist](./.agents/docs/agents-guide/12-checklist/pre-commit-checklist.md)
- [Key documentation references](./.agents/docs/agents-guide/13-references/key-documentation-references.md)
- [Theme: pub_theme namespace](./.agents/docs/agents-guide/14-theme/pub-theme-namespace-critical-rule.md)
- [Theme translations critical rule](./.agents/docs/agents-guide/14-theme/theme-translations-critical-rule.md)
- [Chaos Monkey readiness](./.agents/docs/agents-guide/15-chaos-monkey/chaos-monkey-readiness.md)
- [Bug Injection Recovery Playbook](./laravel/docs/bug-injection-recovery-playbook.md) - Quando bug/file infetti sono introdotti deliberatamente

## Nota operativa

- Le regole originali sono state preservate nei file di sezione.
- Per modifiche future, aggiorna prima il file di sezione pertinente e poi l'indice `00-index.md`.
- Regola Passport/User: ogni classe concreta in `laravel/vendor/laravel/passport/src` che estende `Illuminate\Database\Eloquent\Model` deve avere un wrapper locale `Modules\User\Models\Oauth{NomeClasse}` che estende `Laravel\Passport\{NomeClasse}`. I binding vanno registrati in `Modules\User\Providers\PassportServiceProvider`.
- Regola Meetup/Schema.org: i model del modulo `Meetup` devono essere `rich snippets ready`. Questo non implica duplicare tutte le proprietà `schema.org` nel persistence layer; implica invece che ogni model rilevante abbia un mapping completo, accurato e testabile verso il tipo `schema.org` corretto, usando campi, relazioni e `meta_data` dove serve.
- Regola pagine/Schema.org: le pagine pubbliche devono avere un tipo `WebPage` coerente. Le pagine profilo devono usare `ProfilePage`; le altre devono scegliere il sottotipo corretto (`CollectionPage`, `ItemPage`, `AboutPage`, ecc.) invece di usare sempre `WebPage` generico.
- Regola Passport/User: ogni classe concreta in `laravel/vendor/laravel/passport/src` che estende `Illuminate\Database\Eloquent\Model` deve avere un wrapper locale `Modules\User\Models\Oauth{NomeClasse}` che estende la classe originale `Laravel\Passport\{NomeClasse}`. I binding vanno registrati in `Modules\User\Providers\PassportServiceProvider`.
- Regola Passport/User: ogni classe concreta in `laravel/vendor/laravel/passport/src` che estende `Illuminate\Database\Eloquent\Model` deve avere un wrapper locale `Modules\User\Models\Oauth{NomeClasse}` che estende la classe originale `Laravel\Passport\{NomeClasse}`. I binding vanno registrati in `Modules\User\Providers\PassportServiceProvider`.
