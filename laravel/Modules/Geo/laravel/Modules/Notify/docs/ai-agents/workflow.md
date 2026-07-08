# Workflow (Claude)

## Operating mode

- Work module-by-module.
- Study module docs before changes.
- Apply small safe edits.
- Use MCP tools when encountering file access limitations.
- In chaos conditions, apply minimal recovery first, then hardening.

## Per-module loop

1. Read `laravel/Modules/{Module}/docs/**`.
2. Review package impact (`composer show` + package risk matrix).
3. Run PHPStan for the module: `./vendor/bin/phpstan analyse Modules/ModuleName --memory-limit=-1`
4. Write/update roadmap in module docs.
5. Fix file-by-file following Laraxot principles.
6. Re-run quality tools.
7. Commit when the module is clean.
8. Use MCP tools when needed for protected files.

## Chaos Monkey mode

1. Classify incident layer (`theme`, `cms`, `lang`, `tenant`, `xot`).
2. Reproduce with localized URL and exact failing scenario.
3. Fix only the immediate contract break.
4. Run focused quality checks on impacted module/theme.
5. Update docs, memory, and skills before handoff.

## MCP Integration

When file access is restricted:
1. Check `laravel/.mcp.json` configuration
2. Use MCP commands for file operations when needed
3. Follow MCP security protocols
4. Document MCP-specific changes

## Links

- [Claude docs index](./context.md)
- [PHPStan workflow prompt](../../../tools/prompts/05-phpstan-patterns.md)
- [General docs](../../../../docs/index.md)
