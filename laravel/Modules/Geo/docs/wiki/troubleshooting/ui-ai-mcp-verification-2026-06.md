# UI/AI MCP verification incidents, 2026-06

## Scope

Runbook for agent tooling used while reviewing visual Geo components. These incidents concern development tooling, not the runtime of `map-lit`.

## Impeccable URL Audit Timeout

### Symptom

```text
Error: Navigation timeout of 30000 ms exceeded
```

### Cause

`npx impeccable detect http://127.0.0.1:8000/it` waits for direct browser navigation and may time out on pages with persistent or slow network activity.

### Reliable Check

```bash
curl -s http://127.0.0.1:8000/it/ -o /tmp/fixcity-it.html
npx impeccable detect /tmp/fixcity-it.html --json
```

The check found a skipped heading level in the rendered HTML. Treat this as a real accessibility finding, but fix it in the owner theme/page rather than in Geo runtime code.

## Flowbite MCP Port Option Mismatch

### Symptom

`npx flowbite-mcp --mode http --port 3001` prints a URL on port 3001, but version 1.1.5 actually listens on port 3000.

### Verification

```bash
ss -ltnp | rg ':3000|:3001'
curl -H 'Content-Type: application/json' \
  -H 'Accept: application/json, text/event-stream' \
  -d '{"jsonrpc":"2.0","id":1,"method":"initialize","params":{"protocolVersion":"2025-03-26","capabilities":{},"clientInfo":{"name":"codex-local-check","version":"1.0.0"}}}' \
  http://localhost:3000/mcp
```

The MCP initialization succeeds. Do not rely on the printed custom port until the upstream behavior is corrected.

## Laravel Boost MCP Timeout

### Symptom

The Boost MCP `application_info` tool call timed out after 120 seconds.

### Additional Checks

- `composer show laravel/boost` reports v2.4.8.
- `php artisan boost:mcp --help` works.
- `php artisan boost:list-skills` works and lists the installed Boost skills.
- `php artisan boost:execute-tool application-info '{}'` reports that the tool is not registered or allowed.

### Decision

Laravel Boost is installed and partially functional, but the MCP tool call is not declared healthy. Diagnose tool registration and application startup cost in a dedicated backend task.

## Remote MCP Authentication

Windframe responds with HTTP 401 and OAuth resource metadata when called without credentials. This is expected and proves that the endpoint exists, not that the integration is authorized.

Tailkit and daisyUI Blueprint require a license. Do not add them to shared MCP configuration without credentials.
