# Fix: Cannot Redeclare getResource() in XotBaseListRecords

## Data Intervento
**2025-01-22** - Rimozione metodo `getResource()` duplicato in `XotBaseListRecords`

## Problema Identificato

Errore: `Cannot redeclare Modules\Xot\Filament\Resources\Pages\XotBaseListRecords::getResource()` quando si accede a una pagina List di Filament (es. `/user/admin/teams`).

### Causa Radice

Il metodo `getResource()` era stato dichiarato due volte nella classe `XotBaseListRecords`:

```php
// ❌ ERRATO - Prima della correzione
class XotBaseListRecords extends FilamentListRecords
{
    /**
     * Get the resource class name.
     *
     * @return class-string
     */
    public static function getResource(): string
    {
        $resource = Str::of(static::class)->before('\\Pages\\')->toString();
        Assert::classExists($resource);

        return $resource;
    }

    /**
     * Get the resource class name.
     *
     * @return class-string
     */
    public static function getResource(): string  // ← DICHIARAZIONE DUPLICATA!
    {
        $resource = Str::of(static::class)->before('\\Pages\\')->toString();
        Assert::classExists($resource);

        return $resource;
    }
}
```

### Stack Trace

L'errore si verificava in:
- `Modules/Xot/app/Filament/Resources/Pages/XotBaseListRecords.php:51`
- Durante il caricamento della classe quando si accede a una pagina List
- Quando PHP cerca di definire la classe e trova due dichiarazioni dello stesso metodo

## Soluzione Implementata

Rimossa la dichiarazione duplicata del metodo `getResource()`, mantenendo solo la prima:

```php
// ✅ CORRETTO - Dopo la correzione
class XotBaseListRecords extends FilamentListRecords
{
    /**
     * Get the resource class name.
     *
     * @return class-string
     */
    public static function getResource(): string
    {
        $resource = Str::of(static::class)->before('\\Pages\\')->toString();
        Assert::classExists($resource);

        return $resource;
    }
}
```

## File Modificati

1. **`laravel/Modules/Xot/app/Filament/Resources/Pages/XotBaseListRecords.php`**
   - Rimossa la dichiarazione duplicata del metodo `getResource()` (righe 46-57)
   - Mantenuta solo la prima dichiarazione (righe 33-44)

## Verifica

- ✅ PHPStan livello 10 passa senza errori
- ✅ La classe viene caricata correttamente senza errori fatali
- ✅ Le pagine List di Filament funzionano correttamente

## Prevenzione Errori Futuri

### Pattern Corretto per Metodi Statici

Quando si aggiunge o modifica un metodo statico in una classe base:

1. **Verificare sempre che non esista già**:
   ```bash
   grep -n "function getResource" path/to/file.php
   ```

2. **Usare IDE con controllo duplicati**:
   - PHPStorm mostra warning per metodi duplicati
   - VS Code con estensioni PHP mostra errori

3. **Eseguire PHPStan prima del commit**:
   ```bash
   ./vendor/bin/phpstan analyse path/to/file.php --level=10
   ```

4. **Verificare che la classe compili**:
   ```bash
   php -l path/to/file.php
   ```

### Errori Comuni da Evitare

1. **❌ Copiare e incollare metodi senza verificare**:
   ```php
   // NON fare questo - può causare duplicati
   public static function getResource(): string { ... }
   // ... altro codice ...
   public static function getResource(): string { ... }  // ← Duplicato!
   ```

2. **❌ Merge conflict mal risolto**:
   
3. **❌ Refactoring incompleto**:
   ```php
   // Se si sposta un metodo, assicurarsi di rimuoverlo dalla posizione originale
   ```

## Collegamenti

- [XotBaseListRecords](../../app/Filament/Resources/Pages/XotBaseListRecords.php)
- [List Records Documentation](./listrecords.md)
- [Filament Best Practices](./filament-best-practices.md)
- [Errori Duplicati Comuni](../../Activity/docs/filament-errors-duplicate.md)

*Ultimo aggiornamento: gennaio 2025*

