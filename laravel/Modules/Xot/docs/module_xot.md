# Modulo Xot

## Informazioni Generali
- **Nome**: `laraxot/module_xot_fila3`
- **Descrizione**: Modulo core del repository laraxot
- **Namespace**: `Modules\Xot`
- **Repository**: https://github.com/laraxot/module_xot_fila3

## Service Providers
1. `Modules\Xot\Providers\XotServiceProvider`
2. `Modules\Xot\Providers\Filament\ModulesServiceProvider`
3. `Modules\Xot\Providers\Filament\AdminPanelProvider`

## Struttura
```
app/
├── Filament/       # Componenti Filament
├── Http/           # Controllers e Middleware
├── Models/         # Modelli del dominio
├── Providers/      # Service Providers
└── Services/       # Servizi core
```

## Dipendenze
### Pacchetti Required
- PHP ^8.2
- Laravel Framework ^11.34
- Filament ^3.2
- Livewire
- Spatie (vari pacchetti)
- E molti altri (vedi composer.json)

### Moduli Required
- Tenant

## Database
### Factories
Namespace: `Modules\Xot\Database\Factories`

### Seeders
Namespace: `Modules\Xot\Database\Seeders`

### Migrations
Namespace: `Modules\Xot\Database\Migrations`

## Testing
Comandi disponibili:
```bash
composer test           # Esegue i test
composer test-coverage  # Genera report di copertura
composer analyse       # Analisi statica del codice
composer format        # Formatta il codice
```

## Funzionalità Core
- Gestione moduli Laravel
- Integrazione Filament
- Sistema di permessi
- Cache intelligente
- Gestione media
- Sistema di tag
- Gestione stati dei modelli
- Attributi schemaless
- Gestione code e azioni
- Sistema di salute dell'applicazione

## Configurazione
### File di Configurazione
- Configurazioni in `config/`
- Helpers in `Helpers/Helper.php`
- Supporto per Redis/Predis

## Best Practices
1. Seguire le convenzioni di naming Laravel
2. Documentare tutte le classi e i metodi pubblici
3. Mantenere la copertura dei test
4. Utilizzare il type hinting
5. Seguire i principi SOLID
6. Utilizzare i type-safe di thecodingmachine/safe
7. Implementare health checks

## Troubleshooting
### Problemi Comuni
1. **Errori di Cache**
   - Eseguire `php artisan cache:clear`
   - Verificare la configurazione Redis
   - Controllare i permessi delle directory

2. **Problemi di Performance**
   - Utilizzare il CPU Load Health Check
   - Monitorare le query con Laravel Debugbar
   - Ottimizzare le cache

3. **Errori di Moduli**
   - Verificare le dipendenze nel composer.json
   - Controllare i service provider
   - Eseguire `composer dump-autoload`

## Development Tools
- Laravel Debugbar
- Laravel IDE Helper
- Larastan
- Laravel Pint
- PHPStan
- Pest

## Changelog
Le modifiche vengono tracciate nel repository GitHub. 