## [2026-06-11] test | pest AI suite green (36 test)

- `Modules/AI/tests/TestCase` → `XotBaseTestCase` (no `RefreshDatabase`)
- `OpenAiHttpFake` per `Http::fake` e `OpenAI::fake` / `CreateResponse::fake`
- `BasicSentimentAnalyzer`: word boundary + testo vuoto
- `Menu`/`BaseTreeModel` Cms: `TypedHasRecursiveRelationships` (fix fatal migrazioni)
- Wiki: [pest-test-suite-fixes.md](troubleshooting/pest-test-suite-fixes.md)

## [2026-06-05] docs | HackerNoon harness — tips 001-022 in wiki locale

- Stub/checklist: second-brain → canon Xot, ai-harness, [hackernoon map](../../../../../docs/wiki/concepts/hackernoon-ai-coding-tips-fixcity-map.md), [llm-wiki.txt](../../../../../bashscripts/tools/prompts/llm-wiki.txt)
- GitHub: [#272](https://github.com/laraxot/base_fixcity_fila5/issues/272) / [D#273](https://github.com/laraxot/base_fixcity_fila5/discussions/273)

# AI Wiki Log

## [2026-05-11] ops | opencode runtime allineato a context-compression
- corretto il punto operativo da `.agents/config.json` a `laravel/opencode.json`.
- documentato che OpenCode abilita `provider.openrouter.options.plugins = [{ "id": "context-compression" }]`.
- documentato che `context-mode` e `qmd` sono MCP locali di supporto e che le cache QMD devono stare fuori repo in `${HOME}/.cache/fixcity/...`.

## [2026-05-04] ingest | bashscripts agents/codex skill mirror

- Aggiunta pagina `comparisons/bashscripts-agents-codex-skill-mirror.md` (ponte verso inventario bashscripts 252/252).
- Aggiornato `index.md` (tabella Compiled Pages).

## [2026-04-28] ops | context-compression plugin install + config + verify
- installato/aggiornato `context-mode@latest` (versione rilevata: `1.0.103`).
- ripulito `.agents/config.json` da marker di merge e validato JSON.
- configurato provider OpenRouter con plugin:
  - `provider.openrouter.options.plugins = [{ "id": "context-compression" }]`
- configurato MCP server locale:
  - `mcpServers.context-mode` con `npx -y context-mode`
- aggiornata documentazione del modulo:
  - `concepts/context-compression-plugin.md`

## [2026-04-15] init | wiki bootstrap
- Added schema, index, and module adoption guide.

## [2026-04-22] concept | OpenRouter context-compression plugin
- **Problema**: BMAD `create-story` fallisce con HTTP 400 quando il contesto supera 131072 token
- **Fix**: abilitare plugin `context-compression` su OpenRouter (globale in settings o via `plugins` in API request)
- **Config**: aggiunto `provider.openrouter.options.plugins` in `.agents/config.json`
- **Concept**: `concepts/openrouter-context-compression.md`

## [2026-04-15] ingest | compile first AI wiki pages
- sources:
  - `laravel/Modules/AI/docs/README.md`
  - `laravel/Modules/AI/docs/structure.md`
  - `laravel/Modules/AI/docs/mcp.md`
  - `laravel/Modules/AI/docs/mcp/mcp-integration-overview.md`
  - `laravel/Modules/AI/docs/ollama-strategy.md`
  - `laravel/Modules/AI/docs/tools.md`
- pages:
  - `laravel/Modules/AI/docs/wiki/overviews/ai-module.md`
  - `laravel/Modules/AI/docs/wiki/concepts/ai-mcp-governance.md`
  - `laravel/Modules/AI/docs/wiki/concepts/local-first-ollama-strategy.md`
- summary:
  - compiled the first durable AI module syntheses from MCP and local-first runtime docs
  - aligned the module wiki with the project-level LLM wiki model