# Bugfix: PHPStan `getUrl()` signature mismatch + enum/getColumnDefinitions drift

## 🐛 Errori

**Data:** 2026-07-16/17
**Comando:** `php -d memory_limit=2048M ./vendor/bin/phpstan analyse Modules` (root, `laravel/phpstan.neon`)

### 1. `getUrl()` override incompatibile con Filament

**File:**
- `Modules/Activity/tests/Fixtures/ListLogActivitiesActionTestResource.php:20`
- `Modules/Activity/tests/Fixtures/ListLogActivitiesActionTestResourceSimple.php:20`
- `Modules/Activity/tests/Fixtures/ListLogActivitiesActionTestPage.php:26` (chiamante)

Le fixture di test dichiaravano:

```php
public static function getUrl(string $name, array $parameters = []): string
```

mentre la firma reale ereditata è
`Filament\Resources\Resource\Concerns\CanGenerateUrls::getUrl()`:

```php
public static function getUrl(?string $name = null, array $parameters = [], bool $isAbsolute = true, ?string $panel = null, ?Model $tenant = null, bool $shouldGuessMissingParameters = false, ?string $configuration = null): string
```

PHPStan (identificatori `parameter.missing`, `method.childParameterType`,
`parameter.notOptional`, tutti `non-ignorable`): 5 parametri mancanti + il
parametro `$name` non contravariante (richiesto invece che opzionale).

**Fix:** allineata la firma di entrambe le fixture a quella reale di Filament,
mantenendo solo `$name` e `$parameters` effettivamente usati nel corpo.

### 2. `getResource(): string` non narrowed a `class-string<XotBaseResource>`

**File:** `Modules/Activity/tests/Fixtures/ListLogActivitiesActionTestPage.php:28`

`self::$resourceClass` è una proprietà `private static string` mutabile via
`usingResource(string $resourceClass)` (parametro nativo `string`, non
`class-string<T>`). Il solo `@return class-string<XotBaseResource>` non basta
a PHPStan per fidarsi del narrowing lungo tutta la catena di assegnazione.

**Fix:** aggiunta `Webmozart\Assert\Assert::subclassOf(...)` sia in
`usingResource()` sia in `getResource()` prima del return — stesso pattern già
in uso in `Modules\Xot\Filament\Resources\XotBaseResource::getModel()`.

### 3. (Modulo Geo, correlato) `AddressItemEnum::getColumnDefinitions()` referenziava case commentate

Non in questo modulo, ma stessa causa radice architetturale: un enum con
alcune `case` disabilitate via commento ma ancora referenziate in un metodo
che le consuma (`self::CASE_DISABILITATA->value`) — errore `classConstant.notFound`,
avrebbe fatto fallire qualsiasi migrazione che chiamasse `EnumTrait::columns()`.
Documentato qui perché è un pattern di bug ricorrente nell'architettura
XotBase-Enum: se si commenta una `case`, va rimossa anche ovunque referenziata,
non lasciata "morta" in mappe consumate a runtime.

### 4. `CanPaginate::getTablePage()` restituiva `mixed` invece di `int`

**File:** `Modules/Activity/app/Filament/Pages/Concerns/CanPaginate.php:38-41`

```php
public function getTablePage(): int
{
    return $this->getPage($this->getPaginationPageName());
}
```

`$this->getPage()` (metodo di paginazione Livewire) ha un tipo di ritorno
non stretto (`mixed`/`int|string` a seconda del contesto), incompatibile con
il return type dichiarato `int` del metodo del trait.

**Fix:**

```php
public function getTablePage(): int
{
    $page = $this->getPage($this->getPaginationPageName());

    return is_numeric($page) ? (int) $page : 1;
}
```

Coerente con la regola del progetto di evitare `mixed`: narrowing esplicito
con `is_numeric()` + cast, fallback a `1` (prima pagina) se il valore non è
numerico, invece di propagare `mixed` o forzare un cast non sicuro.

## ✅ Verifica

```bash
cd laravel
./vendor/bin/phpstan analyse Modules/Activity --memory-limit=-1   # 0 errori (solo baseline noise)
./tools/phpmd.sh Modules/Activity/tests/Fixtures/*.php text phpmd.xml   # 0 findings
./vendor/bin/phpinsights analyse Modules/Activity/tests/Fixtures --no-interaction
```

## Riferimenti

- Issue: https://github.com/laraxot/module_activity_fila5/issues/15 (STORY-303: PHPStan zero-error Activity tests)
- Issue: https://github.com/laraxot/module_activity_fila5/issues/8 (Fix PHPStan errors: PHPDoc union syntax and return types)
- Regola correlata: `docs/wiki/rules/module-git-sync-after-fix.md` (root del progetto)
