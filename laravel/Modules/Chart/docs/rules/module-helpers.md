# Funzioni Helper per Moduli

## Funzioni Disponibili

1. **module_asset()**
   ```php
   // Definita in Modules/Xot/Helpers/Helper.php
   function module_asset(string $moduleName, string $path): string
   {
       return asset("Modules/{$moduleName}/Resources/assets/{$path}");
   }
   ```

2. **Registrazione Helper**
   ```php
   // composer.json
   "autoload": {
       "files": [
           "Modules/Xot/Helpers/Helper.php"
       ]
   }
   ```

## Uso Corretto

1. **Assets dei Moduli**
   ```blade
   {{-- ✅ Corretto --}}
   <script src="{{ module_asset('Reporting', 'js/charts.js') }}"></script>
   <link href="{{ module_asset('Reporting', 'css/charts.css') }}" rel="stylesheet">

   {{-- ❌ Errato --}}
   <script src="/Modules/Reporting/assets/js/charts.js"></script>
   ```

2. **Struttura Assets**
   ```
   Modules/
   └── ModuleName/
       └── Resources/
           └── assets/
               ├── js/
               ├── css/
               └── images/
   ```

## Best Practices

1. **Verifica Esistenza**
   ```php
   if (!function_exists('module_asset')) {
       function module_asset(string $moduleName, string $path): string {
           return asset("Modules/{$moduleName}/Resources/assets/{$path}");
       }
   }
   ```

2. **Pubblicazione Assets**
   ```php
   // ModuleServiceProvider.php
   public function boot()
   {
       $this->publishes([
           __DIR__.'/../Resources/assets' => public_path("modules/{$this->moduleNameLower}"),
       ], "{$this->moduleNameLower}-module-assets");
   }
   ```

3. **Cache Busting**
   ```php
   module_asset('Reporting', 'js/charts.js').'?v='.filemtime(...)
   ```

## Errori Comuni

1. ❌ **Percorso Diretto**
   ```blade
   <script src="/modules/reporting/js/charts.js"></script>
   ```
   Problema: Non usa la funzione helper, può causare problemi con asset publishing

2. ❌ **Asset() Base**
   ```blade
   <script src="{{ asset('js/charts.js') }}"></script>
   ```
   Problema: Non rispetta la struttura modulare

3. ❌ **URL Hardcoded**
   ```blade
   <script src="https://example.com/modules/reporting/js/charts.js"></script>
   ```
   Problema: Non è portabile tra ambienti

## Checklist

Prima di usare assets in un modulo:
- [ ] La funzione helper è disponibile?
- [ ] Gli assets sono nella directory corretta?
- [ ] Gli assets sono pubblicati?
- [ ] Il modulo è registrato correttamente?

## Documentazione Correlata
- [Laravel Asset Management](https://laravel.com/docs/10.x/mix#introduction)
- [Module Assets Best Practices](https://nwidart.com/laravel-modules/v6/advanced-tools/publishing-assets)
- [Cache Busting in Laravel](https://laravel.com/docs/10.x/mix#versioning-and-cache-busting) 