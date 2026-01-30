# Moduli Laraxot Utilizzati

## Moduli Principali

### 1. module_tenant_fila3
**Scopo**: Gestione multi-tenant per il progetto
**Motivazione**: 
- Gestisce la separazione dei dati tra diverse cliniche/strutture
- Implementa il sistema di autenticazione multi-tenant
- Fornisce middleware per la gestione del tenant corrente
- Gestisce le migrazioni specifiche per tenant

**Implementazione**:
```bash
git subtree add --prefix Modules/Tenant https://github.com/laraxot/module_tenant_fila3.git dev
```

### 2. module_user_fila3
**Scopo**: Gestione avanzata degli utenti
**Motivazione**:
- Gestisce i ruoli e i permessi degli utenti
- Integra Spatie Laravel-permission
- Fornisce interfacce Filament per la gestione utenti
- Gestisce le preferenze utente

**Implementazione**:
```bash
git subtree add --prefix Modules/User https://github.com/laraxot/module_user_fila3.git dev
```

### 3. module_notify_fila3
**Scopo**: Sistema di notifiche
**Motivazione**:
- Gestisce le notifiche per le visite
- Invia promemoria per le scadenze ISEE
- Notifica gli aggiornamenti dei trattamenti
- Supporta notifiche via email e SMS

**Implementazione**:
```bash
git subtree add --prefix Modules/Notify https://github.com/laraxot/module_notify_fila3.git dev
```

### 4. module_lang_fila3
**Scopo**: Gestione multilingua
**Motivazione**:
- Supporta l'interfaccia in italiano e inglese
- Gestisce le traduzioni dei contenuti
- Permette la personalizzazione delle etichette
- Supporta il cambio lingua in runtime

**Implementazione**:
```bash
git subtree add --prefix Modules/Lang https://github.com/laraxot/module_lang_fila3.git dev
```

## Moduli di Supporto

### 5. module_ui_fila3
**Scopo**: Componenti UI personalizzati
**Motivazione**:
- Fornisce componenti Filament personalizzati
- Implementa un tema coerente
- Gestisce le viste Blade riutilizzabili
- Supporta la personalizzazione del layout

**Implementazione**:
```bash
git subtree add --prefix Modules/UI https://github.com/laraxot/module_ui_fila3.git dev
```

### 6. module_chart_fila3
**Scopo**: Visualizzazione dati e statistiche
**Motivazione**:
- Genera grafici per le statistiche delle visite
- Visualizza trend dei pazienti
- Mostra analisi dei trattamenti
- Supporta l'esportazione dei dati

**Implementazione**:
```bash
git subtree add --prefix Modules/Chart https://github.com/laraxot/module_chart_fila3.git dev
```

## Configurazione

### 1. Registrazione dei Moduli
```php
// config/app.php
'providers' => [
    // ...
    Modules\Tenant\Providers\TenantServiceProvider::class,
    Modules\User\Providers\UserServiceProvider::class,
    Modules\Notify\Providers\NotifyServiceProvider::class,
    Modules\Lang\Providers\LangServiceProvider::class,
    Modules\UI\Providers\UIServiceProvider::class,
    Modules\Chart\Providers\ChartServiceProvider::class,
],
```

### 2. Configurazione del Multi-tenant
```php
// config/tenant.php
return [
    'middleware' => [
        'web',
        'tenant',
    ],
    'database' => [
        'prefix' => 'tenant_',
        'suffix' => '',
    ],
];
```

### 3. Configurazione delle Notifiche
```php
// config/notify.php
return [
    'channels' => [
        'mail',
        'database',
        'sms',
    ],
    'templates' => [
        'visit_reminder' => 'notify::emails.visit-reminder',
        'document_expiry' => 'notify::emails.document-expiry',
    ],
];
```

## Aggiornamento dei Moduli

Per aggiornare i moduli:
```bash

# Aggiorna un modulo specifico
git subtree pull --prefix Modules/Tenant https://github.com/laraxot/module_tenant_fila3.git dev

# Aggiorna tutti i moduli
for dir in Modules/*/; do
    if [ -f "$dir/.git" ]; then
        module_name=$(basename "$dir")
        git subtree pull --prefix "Modules/$module_name" "https://github.com/laraxot/module_${module_name,,}_fila3.git" dev
    fi
done
```

## Best Practices

1. **Versionamento**:
   - Mantenere un file `composer.json` separato per ogni modulo
   - Specificare le versioni esatte delle dipendenze
   - Documentare le incompatibilità note

2. **Testing**:
   - Eseguire i test di ogni modulo prima dell'integrazione
   - Verificare la compatibilità tra i moduli
   - Testare le funzionalità cross-module

3. **Sicurezza**:
   - Aggiornare regolarmente i moduli per le patch di sicurezza
   - Verificare le dipendenze con `composer audit`
   - Implementare controlli di accesso appropriati

4. **Performance**:
   - Ottimizzare il caricamento dei moduli
   - Utilizzare il caching quando appropriato
   - Monitorare l'impatto delle query multi-tenant

## Troubleshooting

### Problemi Comuni

1. **Conflitti di Dipendenze**:
   ```bash
   composer why-not laraxot/module_tenant_fila3
   ```

2. **Problemi di Cache**:
   ```bash
   php artisan module:cache:clear
   php artisan config:clear
   php artisan cache:clear
   ```

3. **Problemi di Permessi**:
   ```bash
   chmod -R 775 Modules/
   chown -R www-data:www-data Modules/
   ```

### Logging

```php
// config/logging.php
'channels' => [
    'modules' => [
        'driver' => 'daily',
        'path' => storage_path('logs/modules.log'),
        'level' => env('LOG_LEVEL', 'debug'),
        'days' => 14,
    ],
],
