# Service Providers

## Struttura Base

Tutti i Service Provider dei moduli devono estendere `XotBaseServiceProvider` e seguire questa struttura:

```php
namespace Modules\ModuleName\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class ModuleNameServiceProvider extends XotBaseServiceProvider
{
    protected $name = 'ModuleName';
    protected $nameLower = 'modulename';
    protected $module_dir = __DIR__.'/..';
    protected $module_ns = __NAMESPACE__;

    public function boot(): void
    {
        parent::boot();
        
        // Registro solo le configurazioni specifiche del modulo
        $this->registerConfig();
    }
}
```

## Funzionalità Gestite da XotBaseServiceProvider

Il `XotBaseServiceProvider` gestisce automaticamente:

1. Registrazione delle traduzioni
2. Registrazione delle viste
3. Registrazione delle migrazioni
4. Registrazione dei componenti Livewire
5. Registrazione dei componenti Blade
6. Registrazione delle configurazioni

## Errori Comuni da Evitare

1. ❌ NON registrare manualmente i componenti Blade
   ```php
   // ERRATO
   Blade::componentNamespace('Modules\\ModuleName\\View\\Components', 'module-name');
   ```

2. ❌ NON duplicare la logica già gestita dal provider base
   ```php
   // ERRATO
   $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'module-name');
   $this->loadViewsFrom(__DIR__.'/../resources/views', 'module-name');
   ```

3. ❌ NON modificare la visibilità dei metodi ereditati
   ```php
   // ERRATO
   private function boot() { ... }
   ```

4. ❌ NON registrare manualmente le configurazioni
   ```php
   // ERRATO
   $this->publishes([
       __DIR__.'/../config/config.php' => config_path('module-name.php'),
   ], 'config');
   ```

## Best Practices

1. ✅ Estendi sempre `XotBaseServiceProvider`
2. ✅ Mantieni la struttura standard
3. ✅ Registra solo le configurazioni specifiche del modulo
4. ✅ Documenta eventuali personalizzazioni
5. ✅ Aggiorna la documentazione quando necessario
6. ✅ Studia sempre la documentazione di XotBaseServiceProvider prima di estenderlo

## Esempi di Uso Corretto

```php
namespace Modules\ModuleName\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class ModuleNameServiceProvider extends XotBaseServiceProvider
{
    protected $name = 'ModuleName';
    protected $nameLower = 'modulename';
    protected $module_dir = __DIR__.'/..';
    protected $module_ns = __NAMESPACE__;

    public function boot(): void
    {
        parent::boot();
        
        // Registro solo le configurazioni specifiche del modulo
        $this->registerConfig();
    }
}
```

## Note Importanti

1. La registrazione dei componenti Blade è gestita automaticamente da `XotBaseServiceProvider`
2. Non è necessario registrare manualmente le traduzioni o le viste
3. Mantenere la struttura standard facilita la manutenzione
4. Documentare sempre le personalizzazioni specifiche del modulo 