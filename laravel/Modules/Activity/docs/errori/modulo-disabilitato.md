# Errore: Modulo Activity Disabilitato

## Descrizione del Problema

Quando il modulo Activity è disabilitato, il ServiceProvider non viene caricato e di conseguenza:
- Il view namespace `activity::` non viene registrato
- Tutte le pagine che estendono `ListLogActivities` generano l'errore "No hint path defined for [activity]"
- Le feature del modulo non sono disponibili

## Sintomi

### Errore Tipico

```
InvalidArgumentException
No hint path defined for [activity].
```

### Route Interessate

Tutte le route che utilizzano pagine Activity, esempio:
```
GET /[modulo]/admin/[resource]/{record}/activities
```

### Come Verificare

```bash
# Verificare stato modulo
cd /var/www/html/ptvx/laravel
php artisan module:list | grep Activity

# Output se disabilitato:
# [Disabled] Activity ................................... Modules/Activity [0]

# Verificare view namespace
php artisan tinker --execute="echo 'Activity: ' . (isset(app('view')->getFinder()->getHints()['activity']) ? 'OK' : 'MISSING') . PHP_EOL;"

# Output se disabilitato:
# Activity: MISSING
```

## Causa Radice

Il modulo Activity può essere disabilitato per diversi motivi:

1. **Disabilitazione manuale**
   ```bash
   php artisan module:disable Activity
   ```

2. **Configurazione module.json**
   ```json
   {
       "active": 0  // ← Modulo disabilitato
   }
   ```

3. **Deploy o migrazione**
   - Durante deploy il modulo può essere temporaneamente disabilitato
   - Rollback incompleto dopo aggiornamento

4. **Errori di caricamento**
   - Se il modulo ha errori critici, può essere disabilitato automaticamente
   - Dipendenze mancanti (`requires` in module.json)

## Soluzione

### 1. Abilitare il Modulo

```bash
cd /var/www/html/ptvx/laravel
php artisan module:enable Activity
```

**Output atteso**:
```
Enabling Activity Module, old status: Disabled ................. DONE
```

### 2. Pulire le Cache

```bash
# Pulire tutte le cache per rigenerare view hints
php artisan optimize:clear
```

**Output atteso**:
```
INFO  Clearing cached bootstrap files.

config ....................................................... DONE
cache ........................................................ DONE
compiled ..................................................... DONE
events ....................................................... DONE
routes ....................................................... DONE
views ........................................................ DONE
blade-icons .................................................. DONE
filament ..................................................... DONE
```

### 3. Verificare Abilitazione

```bash
# Verificare che il modulo sia ora abilitato
php artisan module:list | grep Activity
```

**Output atteso**:
```
[Enabled] Activity .................................... Modules/Activity [0]
```

### 4. Verificare View Namespace

```bash
php artisan tinker --execute="echo 'Activity namespace: ' . (isset(app('view')->getFinder()->getHints()['activity']) ? 'REGISTERED' : 'NOT FOUND') . PHP_EOL;"
```

**Output atteso**:
```
Activity namespace: REGISTERED
```

## Verifica Soluzione Completa

### Test 1: Modulo Abilitato

```bash
php artisan module:list | grep Activity
# Deve mostrare: [Enabled]
```

### Test 2: View Namespace Registrato

```bash
php artisan tinker
>> app('view')->getFinder()->getHints()['activity']
# Output: ["/var/www/html/ptvx/laravel/Modules/Activity/resources/views"]
```

### Test 3: Pagina Accessibile

Provare ad accedere alla URL problematica:
```
http://personale2022.prov.tv.local/indennitaresponsabilita/admin/indennita-responsabilitas/[ID]/activities
```

Dovrebbe caricare senza errori.

## Prevenzione

### 1. Verificare Dipendenze

Il modulo Activity richiede:
```json
// module.json
"requires": ["Xot", "User"]
```

Assicurarsi che questi moduli siano abilitati PRIMA di Activity:
```bash
php artisan module:list | grep -E "(Xot|User)"
```

### 2. Priorità di Caricamento

Considerare l'aumento della priorità in `module.json`:
```json
{
    "priority": 10,  // Più alto = carica prima
    "active": 1
}
```

### 3. Health Check

Aggiungere uno script di verifica nel deployment:
```bash
#!/bin/bash
# scripts/check-modules.sh

REQUIRED_MODULES=("Xot" "User" "Activity")

for module in "${REQUIRED_MODULES[@]}"; do
    STATUS=$(php artisan module:list | grep "$module" | grep -o "Enabled\|Disabled")
    if [ "$STATUS" != "Enabled" ]; then
        echo "ERROR: Module $module is not enabled!"
        php artisan module:enable "$module"
    fi
done

php artisan optimize:clear
```

### 4. Monitor nei Test

Aggiungere test che verificano lo stato dei moduli:
```php
<?php

test('required modules are enabled', function () {
    $modules = ['Xot', 'User', 'Activity'];
    
    foreach ($modules as $moduleName) {
        $module = Module::find($moduleName);
        
        expect($module)
            ->not->toBeNull()
            ->and($module->isEnabled())
            ->toBeTrue("Module {$moduleName} should be enabled");
    }
});

test('activity view namespace is registered', function () {
    $hints = app('view')->getFinder()->getHints();
    
    expect($hints)
        ->toHaveKey('activity')
        ->and($hints['activity'][0])
        ->toContain('Modules/Activity/resources/views');
});
```

## Casi Specifici

### Durante Deploy

```bash
# Nel workflow di deploy, aggiungere:
php artisan module:enable Activity
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### In Docker

Assicurarsi che il container abbia i permessi corretti:
```dockerfile
# Dockerfile
RUN chown -R www-data:www-data /var/www/html/ptvx/laravel/Modules
```

### Multi-Ambiente

Sincronizzare stato moduli tra ambienti:
```bash
# Esportare stato moduli da produzione
php artisan tinker
>> Module::allEnabled()->pluck('name')->toJson()

# Applicare in staging/dev
php artisan module:enable Activity
```

## Troubleshooting

### Modulo Non Si Abilita

Se `module:enable Activity` non funziona:

1. **Verificare permessi file**:
   ```bash
   ls -la /var/www/html/ptvx/laravel/Modules/Activity/module.json
   chmod 644 /var/www/html/ptvx/laravel/Modules/Activity/module.json
   ```

2. **Verificare module.json sintassi**:
   ```bash
   cat /var/www/html/ptvx/laravel/Modules/Activity/module.json | json_pp
   ```

3. **Verificare cache moduli**:
   ```bash
   rm -f bootstrap/cache/modules.php
   composer dump-autoload
   php artisan module:list
   ```

### View Namespace Non Registrato Dopo Abilitazione

1. **Pulire TUTTE le cache**:
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan view:clear
   rm -rf bootstrap/cache/*.php
   composer dump-autoload -o
   ```

2. **Verificare parent::boot() chiamato**:
   ```php
   // ActivityServiceProvider.php
   public function boot(): void
   {
       parent::boot();  // ← DEVE essere presente
       // ...
   }
   ```

3. **Restart application**:
   ```bash
   # Se usando php-fpm
   sudo systemctl restart php8.3-fpm
   
   # Se usando octane
   php artisan octane:reload
   ```

## Collegamenti

### Documentazione Correlata
- [No Hint Path Defined - Guida Completa](./no-hint-path-defined.md)
- [Activity Module - README](../README.md)
- [Service Provider Architecture](../../Xot/docs/service-provider-architecture.md)

### Issue Simili
- [Xot - Module Discovery](../../Xot/docs/module-discovery.md)
- [Deployment Best Practices](../../Xot/docs/deployment.md)

---

**Ultimo aggiornamento**: 27 Ottobre 2025  
**Caso Reale**: personale2022.prov.tv.local  
**Soluzione Verificata**: ✅ Testata e funzionante  
**Severità**: Critica (blocca completamente feature Activity Log)


