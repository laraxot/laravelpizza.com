---
title: helper getRouteParameters
type: concept
tags: [xot, helpers, routes, phpstan, progressioni]
created: 2026-06-15
updated: 2026-06-15
qmd: "getRouteParameters helper route parameters xot progressioni sigma"
related:
  - ../../../../Progressioni/docs/wiki/concepts/phpstan-progressioni-gate.md
  - ../../helper-functions-complete-list.md
  - ../log.md
---

# Helper `getRouteParameters()`

## Scopo

Restituisce i parametri della route HTTP corrente come array associativo. Usato da moduli dominio (Progressioni, Sigma, Ptv, IndennitaResponsabilita) per propagare contesto **anno / stabi / repar** in modelli, action e Blade legacy senza duplicare `Request::route()->parameters()`.

## Implementazione

File: `laravel/Modules/Xot/helpers/Helper.php` (incluso in `scanFiles` di `phpstan.neon`).

Comportamento:

- Console → `[]`
- Nessuna route attiva → `[]`
- Solo chiavi `string` nell'array risultato

## Utilizzo tipico

```php
$params = getRouteParameters();
// ['anno' => 2025, 'stabi' => 1, 'repar' => 0]
```

```blade
<a href="{{ route('progressioni.schede.index', getRouteParameters()) }}">Schede</a>
```

## Moduli consumer (PHP)

| Modulo | File |
|--------|------|
| Progressioni | `Scheda::updateFields`, `Pesi::copyFromLastYear`, `EsclusiExtra::updateFields` |
| Lang | `RouteServiceProvider` (commento storico) |

## PHPStan

Prima dell'implementazione (2026-06-15) compariva `function.notFound` su Progressioni. L'helper è globale e tipizzato `@return array<string, mixed>`.

## Collegamenti

- [Gate PHPStan Progressioni](../../../../Progressioni/docs/wiki/concepts/phpstan-progressioni-gate.md)
- [Lista helper completa](../../helper-functions-complete-list.md)
