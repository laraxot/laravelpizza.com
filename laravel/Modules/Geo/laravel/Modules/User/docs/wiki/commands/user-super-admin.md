---
title: "user:super-admin — assegna super-admin e admin moduli"
type: command
tags: [user, artisan, super-admin, wsl, console]
created: 2026-06-10
updated: 2026-06-10
qmd: user super-admin artisan email WSL prompts
issues: []
discussions: []
---

# user:super-admin

Assegna ruolo `super-admin` e `{modulo}::admin` per ogni modulo installato.

## Uso

```bash
# WSL / CI / script (consigliato)
php artisan user:super-admin --email=tuo@email.com

# Argomento posizionale
php artisan user:super-admin tuo@email.com

# Interattivo
php artisan user:super-admin
```

## WSL / stty

**Mai** `Laravel\Prompts\text()` — `stty` fallisce su terminali WSL.

Il comando usa `$this->ask()` con fallback `fgets(STDIN)` se il prompt avanzato non è disponibile.

## File

`Modules/User/app/Console/Commands/SuperAdminCommand.php`

## Collegamenti

- [user:change-password](user-change-password.md) — stesso pattern `--email`
