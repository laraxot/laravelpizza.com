# PHPStan Level 10 Compliance - Theme System

## 📋 Riepilogo Intervento

**Data**: 17 Novembre 2025  
**Sistema**: Themes (Zero Theme)  
**Esito**: ✅ **0 ERRORI** - PHPStan Level 10 compliant

## 🎯 Pattern Applicati dal Sistema Moduli

I temi del progetto seguono gli stessi pattern PHPStan Level 10 applicati nei moduli:

### 1. Type Safety su Components

```php
// ✅ CORRETTO - Type assertion per component data
/** @var array<string, mixed> $data */
$data = $this->getData();

// ✅ CORRETTO - instanceof per component verification
if (! $component instanceof Component) {
    continue;
}
```

### 2. Collection Type Preservation

```php
// ✅ CORRETTO - Mantieni tipi originali
static fn (mixed $heading): int|string => \is_int($heading) ? $heading : (string) $heading

// ✅ CORRETTO - Callback completo
static function (int|string $value, int $key): array {
    return [(string) $value => $value];
}
```

### 3. Assert-based Type Safety

```php
// ✅ CORRETTO - Type assertions esplicite
Assert::isArray($data);
Assert::string($url, 'URL must be a string');
Assert::isInstanceOf($user, Authenticatable::class);
```

### 4. Tipizzazione Utenti (UserContract)

**In Laraxot PTVX**, non usare mai `Model|null` per riferirsi agli utenti autenticabili nei temi o nei moduli. Utilizzare sempre `Modules\Xot\Contracts\UserContract`.

```php
use Modules\Xot\Contracts\UserContract;

/**
 * @param UserContract|null $user
 */
public function viewAny(?UserContract $user): bool
{
    return true;
}
```

## 🔧 Implementazioni Specifiche per Temi

### 1. Blade Components

I componenti Blade devono seguire questi pattern:

```php
// ✅ CORRETTO - Component con type safety
@php
    /** @var array<string, mixed> $data */
    $data = $component->all();
    
    Assert::string($title = $data['title'] ?? '');
    Assert::isArray($items = $data['items'] ?? []);
@endphp

<div>
    <h1>{{ $title }}</h1>
    @foreach($items as $item)
        <div>{{ $item['name'] ?? '' }}</div>
    @endforeach
</div>
```

### 2. Layout Templates

I layout devono includere type assertions:

```php
// ✅ CORRETTO - Layout con type safety
@php
    /** @var array<string, mixed> $data */
    $data = $slot->getAttributes();
    
    Assert::string($title = $data['title'] ?? 'Default Title');
    Assert::string($layout = $data['layout'] ?? 'default');
@endphp

<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
</head>
<body class="layout-{{ $layout }}">
    {{ $slot }}
</body>
</html>
```

### 3. Mail Templates

I template mail richiedono type checking specifico:

```php
// ✅ CORRETTO - Mail template con assertions
@php
    /** @var array<string, mixed> $data */
    $data = $component->all();
    
    Assert::string($subject = $data['subject'] ?? '');
    Assert::string($message = $data['message'] ?? '');
    Assert::isArray($attachments = $data['attachments'] ?? []);
@endphp
```

## 📊 Linee Guida per Sviluppatori Theme

### 1. PHPStan Compliance

Tutti i file PHP nei temi devono essere PHPStan Level 10 compliant:

```bash
# Verifica per ogni file PHP del tema
./vendor/bin/phpstan analyse Themes/Zero/app/**/*.php --level=10
```

### 2. Type Assertions nei Template

Usa sempre type assertions nei template Blade:

```php
@php
    /** @var array<string, mixed> $data */
    $data = $component->all();
    
    // Type assertions per sicurezza
    Assert::string($title = $data['title'] ?? '');
    Assert::isArray($items = $data['items'] ?? []);
@endphp
```

### 3. Component Safety

Verifica sempre i componenti prima dell'uso:

```php
@php
    if (! $component instanceof Component) {
        throw new \InvalidArgumentException('Invalid component');
    }
@endphp
```

### 4. Collection Handling

Tratta le collections con type safety:

```php
@php
    /** @var Collection<int, string> $items */
    $items = collect($rawItems)
        ->map(fn (mixed $item): string => (string) $item);
@endphp
```

## 🎯 Pattern Riutilizzabili dai Moduli

### 1. DashboardFilterData Pattern

```php
// Pattern da healthcare_app/DashboardFilterData.php
foreach ($components as $k => $component) {
    if (! $component instanceof Component) {
        continue;
    }
    
    $result[$k] = $component->process(['defer']);
}
```

### 2. QueryExport Pattern

```php
// Pattern da healthcare_app/QueryExport.php
$processed = $collection->mapWithKeys(
    static function (int|string $value, int $key): array {
        return [(string) $value => $value];
    }
);
```

### 3. RegistrationWidget Pattern

```php
// Pattern da User/RegistrationWidget.php
/** @var array<string, mixed> $data */
$data = $this->form->getState();

$merged = array_merge($this->data ?? [], $data);
```

## 📋 Checklist di Compliance

### ✅ Per ogni file PHP del tema:

- [ ] Type hints su tutti i parametri e return types
- [ ] PHPDoc blocks per tutti i metodi pubblici
- [ ] Type assertions per dati esterni
- [ ] instanceof checks per componenti
- [ ] Collection types specifici

### ✅ Per ogni template Blade:

- [ ] Type assertions per data arrays
- [ ] instanceof checks per componenti
- [ ] Default values sicuri
- [ ] Collection handling con type safety

### ✅ Per ogni componente:

- [ ] Property types definiti
- [ ] Method signatures complete
- [ ] Return types specifici
- [ ] Type assertions interni

## 🔍 Verifiche Automatiche

```bash
# PHPStan Level 10 completo
./vendor/bin/phpstan analyse Themes/ --memory-limit=-1

# PHPMD per code quality
./vendor/bin/phpmd Themes/ text cleancode,codesize,design

# PHP Insights per metriche
./vendor/bin/phpinsights analyse Themes/
```

## 📚 Riferimenti Incrociati

- **Xot Module**: `Modules/Xot/docs/phpstan-level10-xot-fixes.md`
- **healthcare_app Module**: `Modules/healthcare_app/docs/phpstan-level10-healthcare_app-fixes.md`
- **User Module**: `Modules/User/docs/phpstan-level10-user-fixes.md`

## 🚀 Prossimi Passi

1. **Applica pattern** a tutti i nuovi componenti del tema
2. **Verifica compliance** con PHPStan Level 10
3. **Documenta nuovi pattern** specifici del tema
4. **Mantieni aggiornata** la documentazione

## 📈 Status Attuale

- **PHPStan Level**: ✅ **10 (0 errori)**
- **Pattern applicati**: ✅ Tutti i pattern dei moduli
- **Documentazione**: ✅ Completa e aggiornata
- **Compliance**: ✅ 100% con standard del progetto

**Status**: ✅ **COMPLETATO** - Theme system PHPStan Level 10 compliant.