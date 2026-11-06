---
title: "Boost MCP environment and working directory"
type: troubleshooting
tags: [boost, mcp, environment, artisan, bootstrap]
status: draft
updated: 2026-10-26
qmd: "boost mcp environment and working directory xot"
---

# Boost MCP environment and working directory

Purpose: recover the development MCP server without reinstalling or patching vendor code.

## Causes

- `php laravel/artisan boost:mcp` from inside `laravel/` addresses a nonexistent
  `laravel/laravel/artisan`. Paths are relative to the current directory.
- `php artisan boost:mcp` can report no `boost` namespace when APP_ENV is testing.
  The installed BoostServiceProvider intentionally returns early for runningUnitTests(),
  before registering commands; APP_DEBUG=true does not override that guard.
- Boost 2.10.3 and Laravel MCP 1.1.1 are already installed. Xot declares Boost in its
  Composer development dependencies, and package discovery registers the provider.

## Correct environment

Use a local ignored `.env` with APP_ENV=local and keep `.env.testing` separate. Preserve
existing encryption keys/sessions and database data. Never patch shouldRun(), force Boost
into testing/production, or reinstall dependencies just to make the namespace appear.
On this checkout, previously absent local databases were initialized with empty table
structures only; existing populated databases and all source rows were left untouched.

From the repository root:

```bash
php laravel/artisan env
php laravel/artisan list --raw
php laravel/artisan boost:mcp
```

From `laravel/`, the equivalent server command is `php artisan boost:mcp`.
A stdio MCP server waits for JSON-RPC input; silence after starting is expected.
The initial root `.mcp.json` entry was verified with its expanded `${PWD}` path.
The current launcher resolves the Git project root through Bash, so it also works when
started inside the application directory. Read the current configuration rather than
copying the historical PWD-dependent form.

## Evidence

A real MCP client completed initialize (protocol 2025-03-26), tools/list (10 tools),
and tools/call for application-info. `.env.testing` was not modified, credentials
were not logged or committed, and no Composer/vendor modification was required.

Related: [project recovery](../../../../docs/second-brain/project/project-confidence-recovery.md),
[theme verification](../../../Themes/Sixteen/docs/bmad/verification-recovery.md).
