---
title: Filament tableFilters PHPStan pattern
type: pattern
tags: [phpstan, filament, tableFilters, property.notFound, argument.type]
description: Pattern per accedere a $this->tableFilters in Filament Table classes senza errori PHPStan
qmd: phpstan filament tableFilters property.notFound
date: 2026-06-18
---

# Filament tableFilters — PHPStan Safe Access Pattern

## Problema

In Filament Table classes che estendono `XotBaseResourceTable`, `$this->tableFilters` è una proprietà magica di Livewire non dichiarata nella classe. PHPStan segnala:

- `property.notFound` — proprietà non definita
- `argument.type` — type inference fallisce (array<mixed> vs array<string, mixed>)

## Soluzione

Usare un pattern a due step con variabile intermedia:

```php
/** @phpstan-ignore-next-line property.notFound */
$rawFilters = $this->tableFilters;
/** @var array<string, mixed> $tableFilters */
$tableFilters = is_array($rawFilters) ? $rawFilters : [];
app(SomeAction::class)->execute($tableFilters);
```

## Perché funziona

1. `$rawFilters` cattura il valore della proprietà magica — l'ignore-next-line silenzia `property.notFound`
2. `@var array<string, mixed> $tableFilters` forza il type inference corretto dopo il ternary
3. L'`is_array` check runtime garantisce la sicurezza

## Stub per classi modulo mancanti

Quando un modulo referenzia classi da moduli non presenti (es. `Modules\Cms\`), creare uno stub in `phpstan-stubs/NomeStubs.php` e caricarlo in `phpstan-bootstrap.php`:

```php
// phpstan-stubs/CmsActionStubs.php
namespace Modules\Cms\Actions;
class ResolveLocalizedBlockDataAction {
    public function execute(array $data): array { return $data; }
}

// phpstan-bootstrap.php
require_once __DIR__.'/phpstan-stubs/CmsActionStubs.php';
```
