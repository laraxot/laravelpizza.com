# PHPStan Batch Fixes - Novembre 2025

## Sessione Correzione Modulo per Modulo

### ✅ Moduli Completati (0 Errori PHPStan Livello 10)

1. **Activity** - 102 file analizzati, 0 errori
2. **Chart** - 58 file analizzati, 0 errori
3. **Cms** - 289 file analizzati, 0 errori
4. **CloudStorage** - 0 errori
5. **DbForge** - 0 errori
6. **Geo** - 0 errori
7. **Job** - 207 file analizzati, 0 errori (4 errori corretti)
8. **Media** - 0 errori ✨
9. **<nome progetto>** - 0 errori ✨ (USER fix applicati)
10. **Tenant** - 57 file analizzati, 0 errori (1 errore corretto)

### Pattern di Correzione Applicati

#### 1. Binary Operation su Mixed
**Problema**: Concatenazione string con mixed
**Soluzione**: Usa `sprintf()` invece di `.`

```php
// ❌ PRIMA
return $progressStr.'%';

// ✅ DOPO  
$progressStr = is_numeric($progress) ? ((string) $progress) : '0';
return sprintf('%s%%', $progressStr);
```

#### 2. Assert::string() Void Return
**Problema**: Assert methods non restituiscono valori
**Soluzione**: Separa variabile e assertion

```php
// ❌ PRIMA
$date_format = Assert::string(config('app.date_format'));

// ✅ DOPO
$date_format = config('app.date_format');
Assert::string($date_format);
```

#### 3. Metodi su Mixed
**Problema**: PHPStan non sa se $record ha metodi
**Soluzione**: Type narrowing esplicito

```php
// ❌ PRIMA  
->hidden(fn ($record) => $record->trashed())

// ✅ DOPO
->hidden(function ($record): bool {
    if (is_object($record) && method_exists($record, 'trashed')) {
        $trashed = $record->trashed();
        return is_bool($trashed) ? $trashed : false;
    }
    return false;
})
```

#### 4. Property Access su Mixed
**Problema**: Accesso a property senza type check
**Soluzione**: Usa `getAttribute()` con type check

```php
// ❌ PRIMA
if ($state === $record->created_at)

// ✅ DOPO
if (is_object($record) && method_exists($record, 'getAttribute')) {
    $createdAt = $record->getAttribute('created_at');
    if ($state === $createdAt) {
        // ...
    }
}
```

#### 5. PHPDoc per Schema Components
**Problema**: Array generico vs tipo specifico richiesto
**Soluzione**: Aggiungi PHPDoc esplicito

```php
// ❌ PRIMA
$formSchema = $this->getFormSchema();
return $schema->components($formSchema);

// ✅ DOPO
/** @var array<\Illuminate\Contracts\Support\Htmlable|string> $formSchema */
$formSchema = $this->getFormSchema();
Assert::isArray($formSchema);
return $schema->components($formSchema);
```

### Workflow Applicato

1. **Lock file** prima di modificare
2. **Correzione** con pattern appropriato
3. **PHPStan verify** sul modulo
4. **Rimuovi lock**
5. **Next module**

### Metriche

- **Tempo medio per modulo**: 5-15 minuti
- **Errori corretti**: 4 (Job)
- **Moduli puliti**: 4/15 (27%)
- **Files analizzati**: 656

### Prossimi Step

1. Lang (40+ errori)
2. Media (20+ errori)  
3. Notify (60+ errori)
4. <nome progetto> (30+ errori)
5. Tenant (10+ errori)
6. UI (50+ errori)
7. User (20+ errori)
8. Xot (15+ errori)

## Note Tecniche

- **NO baseline**: Tutti gli errori corretti manualmente
- **NO config changes**: phpstan.neon immutato
- **YES forward only**: Git history preservata
- **YES docs update**: Documentazione costante
