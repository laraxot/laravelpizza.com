# Modulo Lang

## Informazioni Generali
- **Nome**: `laraxot/module_lang_fila5`
- **Descrizione**: Modulo per la gestione delle traduzioni e localizzazione
- **Namespace**: `Modules\Lang`
- **Repository**: https://github.com/laraxot/module_lang_fila5.git

## Service Providers
1. `Modules\Lang\Providers\LangServiceProvider`
2. `Modules\Lang\Providers\Filament\AdminPanelProvider`

## Struttura
```
app/
├── Filament/       # Componenti Filament
├── Http/           # Controllers e Middleware
├── Models/         # Modelli del dominio
├── Providers/      # Service Providers
└── Services/       # Servizi di localizzazione
```

## Dipendenze
### Pacchetti Required
- `mcamara/laravel-localization`
- `spatie/laravel-sluggable`

### Moduli Required
- Xot
- Tenant
- UI

## Database
### Factories
Namespace: `Modules\Lang\Database\Factories`

### Seeders
Namespace: `Modules\Lang\Database\Seeders`

## Testing
Comandi disponibili:
```bash
composer test           # Esegue i test
composer test-coverage  # Genera report di copertura
composer analyse       # Analisi statica del codice
composer format        # Formatta il codice
```

## Funzionalità
- Gestione traduzioni
- URL localizzati
- Slug multilingua
- Middleware di localizzazione
- Interfaccia admin per traduzioni
- Supporto RTL
- Fallback language
- Cache traduzioni

## Configurazione
### Localizzazione
- Configurazione in `config/laravellocalization.php`
- Lingue supportate
- Formati data/ora
- Timezone

### Slug
- Configurazione generazione slug
- Supporto caratteri speciali
- Unicità per lingua

## Best Practices
1. Seguire le convenzioni di naming Laravel
2. Documentare tutte le classi e i metodi pubblici
3. Mantenere la copertura dei test
4. Utilizzare il type hinting
5. Seguire i principi SOLID
6. Utilizzare file di lingua
7. Implementare fallback
8. Ottimizzare cache traduzioni

## Troubleshooting
### Problemi Comuni
1. **Errori di Routing**
   - Verificare middleware
   - Controllare prefissi lingua
   - Verificare redirect

2. **Problemi di Slug**
   - Verificare unicità
   - Controllare caratteri speciali
   - Gestire collisioni

3. **Cache Traduzioni**
   - Pulire cache dopo modifiche
   - Verificare permessi file
   - Controllare chiavi mancanti

## Internazionalizzazione
### Formati
- Date e orari
- Numeri e valute
- Pluralizzazione

### File di Lingua
- Struttura
- Convenzioni di naming
- Gestione gruppi

### Middleware
- Rilevamento lingua
- Redirect
- SEO

## Links
- Documentazione Laravel Localization
- Guida all'upgrade
- Introduzione al modulo
- Tutorial e esempi

## Changelog
Le modifiche vengono tracciate nel repository GitHub. 