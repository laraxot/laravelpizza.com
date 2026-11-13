# Bugfix: `getTablePage()` returns `mixed` instead of `int` (PHPStan)

## 🐛 Errore

**Data:** 2026-07-17
**Comando:** `php -d memory_limit=2048M ./vendor/bin/phpstan analyse Modules` (root, `laravel/phpstan.neon`, invariata)

**File:** `Modules/Activity/app/Filament/Pages/Concerns/CanPaginate.php` (segnalato
"in context of class `Modules\Activity\Filament\Pages\ListLogActivities`")

```
Method Modules\Activity\Filament\Pages\ListLogActivities::getTablePage()
should return int but returns mixed.
```

### Causa

`getTablePage()` chiama `$this->getPage($this->getPaginationPageName())`.
`getPage()` **non** è definito dal trait `CanPaginate` stesso: viene risolto
da `Livewire\Features\SupportPagination\HandlesPagination::getPage($pageName = 'page')`,
che non ha alcun tipo di ritorno dichiarato (nè nativo nè PHPDoc) e internamente
legge da `public $paginators = [];` (proprietà non tipizzata) — quindi PHPStan
inferisce `mixed`.

Il codice originale:

```php
return is_numeric($page) ? (int) $page : 1;
```

In questa versione di PHPStan, la funzione di type-guard `is_numeric()` **non
restringe in modo affidabile un valore tipizzato come `mixed` puro** (a
differenza di union type più specifiche): il ramo vero del ternario restava
`mixed`, quindi il tipo di ritorno complessivo restava `mixed` invece di `int`.

### Fix

Cast esplicito, che PHPStan considera sempre attendibile indipendentemente dal
tipo sorgente:

```php
public function getTablePage(): int
{
    $page = $this->getPage($this->getPaginationPageName());

    return (int) ($page ?? 1);
}
```

## ✅ Verifica

```bash
cd laravel
./vendor/bin/phpstan clear-result-cache
./vendor/bin/phpstan analyse Modules/Activity --memory-limit=-1   # 0 errori (solo baseline noise)
```

## Lezione generale

Quando un trait chiama un metodo definito **altrove** (mixin/altro trait/classe
padre) senza tipo di ritorno dichiarato, PHPStan lo tratta come `mixed` e alcune
funzioni di narrowing "leggere" (`is_numeric`, `is_scalar`) potrebbero non
restringere in modo sufficiente un `mixed` puro in ogni versione di PHPStan.
Preferire un cast esplicito (`(int) $x`) o guardie di tipo native più forti
(`is_int`/`is_string`/`is_float`) quando il valore sorgente proviene da un
metodo esterno non tipizzato.

## Riferimenti

- Issue: https://github.com/laraxot/module_activity_fila5/issues/15 (STORY-303: PHPStan zero-error Activity tests — riaperta/verificata per questo secondo errore)
- Regola correlata: `docs/wiki/rules/module-git-sync-after-fix.md` (root del progetto)
