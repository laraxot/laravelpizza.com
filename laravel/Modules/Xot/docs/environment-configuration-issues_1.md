# Problemi di Configurazione Variabili d'Ambiente - Modulo Xot

## Problema: env() non funziona durante il bootstrap

### Contesto
Il modulo Xot utilizza `XotData` come classe singleton per gestire la configurazione globale dell'applicazione. Durante il bootstrap, alcune variabili d'ambiente potrebbero non essere disponibili.

### Problema Specifico
Nel file `XotData.php`, il metodo `forceSSL()` mostra valori inconsistenti:

```php
public function forceSSL(): bool
{
    dddx([
        'env'=>env('FORCE_SSL'),        // null (dovrebbe essere true)
        'config'=>config('xra.force_ssl'), // null
        'xotdata'=>$this->force_ssl,    // false
    ]);
    
    return false;
}
```

### Analisi Tecnica

#### 1. Flusso di Caricamento
```
.env (FORCE_SSL=true)
    ↓
config/localhost/xra.php ('force_ssl' => env('FORCE_SSL', false))
    ↓
TenantService::getConfig('xra')
    ↓
XotData::make() (singleton)
    ↓
XotData::from($data) (proprietà force_ssl = false)
```

#### 2. Timing del Problema
- **Bootstrap**: `XotData::make()` viene chiamato durante l'inizializzazione
- **env() non disponibile**: Le variabili d'ambiente potrebbero non essere completamente caricate
- **Configurazione statica**: Il valore viene "congelato" nel singleton

#### 3. Architettura Multi-Tenant
Il `TenantService` carica configurazioni specifiche per tenant:
- File: `config/localhost/xra.php`
- Metodo: `TenantService::filePath('xra.php')`
- Timing: Durante il bootstrap dell'applicazione

### Soluzioni Implementate

#### Soluzione 1: Caricamento Lazy (Raccomandata)
```php
public function forceSSL(): bool
{
    // Carica il valore quando necessario, non durante il bootstrap
    return config('xra.force_ssl', env('FORCE_SSL', false));
}
```

#### Soluzione 2: Configurazione Diretta
```php
// config/localhost/xra.php
'force_ssl' => true, // Valore hardcoded invece di env()
```

#### Soluzione 3: Ricaricamento Post-Bootstrap
```php
public static function make(): self
{
    if (! self::$instance) {
        $data = TenantService::getConfig('xra');
        self::$instance = self::from($data);
        
        // Ricarica valori env() dopo il bootstrap
        self::$instance->force_ssl = config('xra.force_ssl', env('FORCE_SSL', false));
    }

    return self::$instance;
}
```

### Best Practice per XotData

1. **Evitare env() in proprietà**: Non usare `env()` nelle proprietà della classe
2. **Caricamento Lazy**: Caricare valori env() quando necessario
3. **Config() preferito**: Usare `config()` che ha accesso alle variabili caricate
4. **Test di Configurazione**: Verificare sempre il caricamento corretto

### Pattern Raccomandato

```php
class XotData extends Data
{
    public bool $force_ssl = false; // Valore di default
    
    public function forceSSL(): bool
    {
        // Caricamento lazy con fallback
        return config('xra.force_ssl', env('FORCE_SSL', $this->force_ssl));
    }
    
    public function getConfigValue(string $key, $default = null)
    {
        // Pattern generico per configurazioni env()
        return config("xra.{$key}", env(strtoupper($key), $default));
    }
}
```

### Debug e Troubleshooting

#### Comando di Debug
```bash
php artisan tinker
>>> XotData::make()->forceSSL()
```

#### Verifica Configurazione
```bash
php artisan config:clear
php artisan cache:clear
php artisan config:cache
```

#### Log di Debug
```php
\Log::info('XotData Config', [
    'env' => env('FORCE_SSL'),
    'config' => config('xra.force_ssl'),
    'xotdata' => XotData::make()->force_ssl
]);
```

### Collegamenti

- [XotData.php](/laravel/Modules/Xot/app/Datas/XotData.php)
- [TenantService.php](/laravel/Modules/Tenant/app/Services/TenantService.php)
- [xra.php](/laravel/config/localhost/xra.php)
- [Documentazione Root](/docs/env-config-loading-issue.md)

*Ultimo aggiornamento: 2025-01-06* 