# Blade Icons Registration Rule (XotBaseServiceProvider Handles It)

## REGOLA PERMANENTE: Vietato registrare Blade Icons nei ServiceProvider dei moduli

### Vincolo assoluto

```
VIETATO: aggiungere `registerBladeIcons()` o `callAfterResolving(BladeIconsFactory::class, ...)`
           nei ServiceProvider dei singoli moduli (es. GeoServiceProvider)
OBBLIGATORIO: affidarsi a XotBaseServiceProvider che registra globalmente tutti i set di icone
```

### Perché — La visione, la filosofia, la religione

`XotBaseServiceProvider` (modulo Xot) è il **punto unico di registrazione** per Blade Icons per tutti i moduli.

**Architettura**:
```php
// In XotBaseServiceProvider.php (Modules/Xot/app/Providers/XotBaseServiceProvider.php)
public function register(): void
{
    parent::register();
    $this->registerBladeIcons(); // ← UNICO posto dove avviene
}

protected function registerBladeIcons(): void
{
    $this->callAfterResolving(BladeIconsFactory::class, function (BladeIconsFactory $factory): void {
        // Scansiona tutti i moduli e registra le loro cartelle svg/
        foreach ($this->getModuleList() as $module) {
            $svgPath = module_path($module, 'resources/svg');
            if (is_dir($svgPath)) {
                $factory->add(strtolower($module), [
                    'path' => $svgPath,
                    'prefix' => strtolower($module),
                ]);
            }
        }
    });
}
```

**Motivazione profonda**:
1. **DRY (Don't Repeat Yourself)**: Un solo posto gestisce la registrazione per tutti i moduli — se ogni modulo lo facesse da solo, avremmo N duplicati.
2. **K.I.S.S.**: La logica di discovery è centrale; i moduli non devono preoccuparsi di come le loro icone vengono registrate.
3. **Evita collisioni**: La registrazione multipla genera eccezioni `CannotRegisterIconSet` (prefix collision).
4. **Separazione delle responsabilità**: Ogni modulo gestisce la propria logica di business; Xot gestisce le cross‑cutting concerns (icone, assets, traduzioni, ecc.).

### Cosa succede se un modulo tenta di registrare le proprie icone

```php
// ❌ SBAGLIATO — in GeoServiceProvider.php
public function register(): void
{
    parent::register();
    $this->callAfterResolving(BladeIconsFactory::class, function (BladeIconsFactory $factory): void {
        $factory->add('geo', [
            'path' => __DIR__.'/../../resources/svg',
            'prefix' => 'geo',
        ]);
    });
}
// → Lancia: BladeUI\Icons\Exceptions\CannotRegisterIconSet
//    The prefix for the "geo" collides with the one from the "default" set.
```

### Come deve essere (corretto)

```php
// ✅ CORRETTO — GeoServiceProvider.php
class GeoServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Geo';

    protected string $moduleName = 'Geo';

    protected string $namespace = 'geo';

    public function boot(): void
    {
        parent::boot();
        // Nessuna registrazione icone qui — ci pensa XotBaseServiceProvider
        $this->registerMapAssets(); // solo asset specifici del modulo
    }

    protected function registerMapAssets(): void
    {
        // Solo asset che NON sono icone (es. leaflet.css se serve)
    }
}
```

### Anti‑pattern

- `callAfterResolving(BladeIconsFactory::class, ...)` in moduli diversi da Xot
- `BladeUI\Icons\Facades\BladeIcon::register()` manuale
- Hardcodare prefix o path icon set per modulo

### Documentazione correlata

- `docs/wiki/concepts/blade-icons-registration-rule.md` (root wiki)
- `laravel/Modules/Geo/docs/wiki/concepts/lit-icons-filament-way.md`
- `bashscripts/ai/.claude/rules/svg-asset-location.md`

### Stato di aggiornamento

- **2026‑04‑27**: Regola documentata dopo errore `CannotRegisterIconSet` in GeoServiceProvider.
- Regola allineata con filosofia DRY + KISS del progetto.
