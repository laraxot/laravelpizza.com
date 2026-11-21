---
title: "Filament User Creation PTY Error"
type: concept
tags: [filament, user, creation, pty]
created: 2026-07-14
updated: 2026-07-14
qmd: "filament-user-creation-pty-error filament user creation pty error"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./git-merge-conflict-inventory-1.md"
  - "./git-merge-conflict-inventory.md"
  - "./git-push-lfs-missing-objects.md"
  - "./phpstan-module-analysis-memory.md"
  - "./phpstan-widget-property-types-1.md"
  - "./phpstan-widget-property-types.md"
  - "./spatie-permission-team-model-not-configured.md"
---

# Filament User Creation PTY Error

## Context
When running `php artisan make:filament-user` in environments without standard TTY support (like CI/CD pipelines, Docker containers without `-it`, or AI agent environments like Qwen/Claude/Gemini), Laravel Prompts may throw a `RuntimeException` with the message: `stty: invalid argument`.

## Problem
Laravel Prompts attempts to read terminal configuration using `stty`. In non-interactive environments, this fails, preventing the interactive setup wizard from running.

## Solution

### Best Practices
- **Use Non-Interactive Flags:** Always use `--no-interaction` (or `-n`) when automating artisan commands.
- **Pass Arguments Explicitly:** Provide all required data via command-line arguments.
  ```bash
  php artisan make:filament-user --name="Admin" --email="admin@example.com" --password="password" --panel="fixcity::admin" --no-interaction
  ```

### Bad Practices
- ❌ Trying to pipe inputs (e.g., `echo "admin@example.com" | php artisan make:filament-user`) because it still triggers interactive prompt handlers that fail on `stty`.
- ❌ Modifying Laravel framework vendor files to bypass the prompt.

### False Friends
- **`--quiet` / `-q`**: While it suppresses output, it does *not* necessarily disable interactivity for `laravel/prompts`. You still need `--no-interaction`.

## Related Links
- [Laravel Prompts Documentation](https://laravel.com/docs/11.x/prompts)
- [Filament Commands](https://filamentphp.com/docs/3.x/panels/installation#create-a-user)
