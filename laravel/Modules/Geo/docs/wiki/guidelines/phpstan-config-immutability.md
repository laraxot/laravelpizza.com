---
title: "PHPStan Config Immutability"
type: guideline
tags: [phpstan, configuration, agents, quality]
created: 2026-07-07
updated: 2026-07-07
qmd: "phpstan config immutability laravel phpstan neon only user agents no alternate configuration"
issues:
  - "https://github.com/provtv/base_ptv_fila5/issues/180"
related:
  - "../memories/phpstan-neon-immutable-agents.md"
  - "../troubleshooting/phpstan-stale-ignore-pattern.md"
  - "../rules/00-TRIGGER_MAP.md"
---

# PHPStan Config Immutability

> Linea guida root: gli agenti usano `laravel/phpstan.neon`, ma non lo modificano.

## Policy

| Azione | Esito |
|---|---|
| Eseguire PHPStan da `laravel/` | OK |
| Usare la config `laravel/phpstan.neon` | OK |
| Modificare `laravel/phpstan.neon` | Vietato agli agenti |
| Creare neon alternativi, baseline o config temporanee | Vietato |
| Usare `--configuration` verso config diverse | Vietato |
| Correggere codice, test e PHPDoc precisi | Obbligatorio |

## Note operative

- Se PHPStan segnala errori, correggere la causa nel codice.
- `mixed` e' ultima spiaggia: preferire shape array, template, class-string, union precise e generics nei PHPDoc.
- I generics non entrano nei typehint nativi PHP: restano nei docblock.
- `@phpstan-ignore` e' ammesso solo su problema specifico residuo, con commento sul trade-off.

## Comando canonico

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules
```