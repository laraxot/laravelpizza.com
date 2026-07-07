# Guide di Sviluppo

## Panoramica
Questa sezione contiene tutte le guide per lo sviluppo del sistema Laraxot, incluse best practices e strumenti.

## Struttura

### filament/
Guide specifiche per lo sviluppo con Filament.

**Contenuti:**
- Best practices Filament
- Pattern per Resources
- Widget personalizzati
- Form e validazioni
- Azioni custom

### phpstan/
Guide per PHPStan e qualità del codice.

**Contenuti:**
- Configurazione PHPStan
- Livelli di analisi
- Fix comuni
- Best practices
- Baseline management

### translations/
Sistema di traduzioni e localizzazione.

**Contenuti:**
- Struttura traduzioni
- Best practices
- Gestione chiavi
- Localizzazione
- Pluralizzazione

### best-practices/
Best practices generali di sviluppo.

**Contenuti:**
- Codice pulito
- Performance
- Sicurezza
- Testing
- Debugging

### ui/
Guide per componenti UI e SVG.

**Contenuti:**
- Struttura SVG nei moduli
- Componenti Blade
- Icone e grafica
- Layout system
- Design patterns

## Guide Rapide

### Filament Development
```bash
# Creazione risorsa Filament
php artisan make:filament-resource ModelName

# Creazione widget
php artisan make:filament-widget WidgetName

# Creazione pagina
php artisan make:filament-page PageName
```

### PHPStan Analysis
```bash
# Analisi completa
./vendor/bin/phpstan analyse --level=9

# Analisi modulo specifico
./vendor/bin/phpstan analyse Modules/ModuleName --level=9

# Generazione baseline
./vendor/bin/phpstan analyse --generate-baseline
```

### Translation Management
```bash
# Estrazione chiavi
php artisan translation:extract

# Compilazione traduzioni
php artisan translation:compile

# Verifica traduzioni
php artisan translation:check
```

## Best Practices

### Codice Pulito
- Seguire PSR-12 per lo stile del codice
- Utilizzare type hints espliciti
- Documentare sempre i metodi pubblici
- Mantenere classi e metodi piccoli

### Performance
- Ottimizzare query database
- Utilizzare cache appropriata
- Minimizzare richieste HTTP
- Ottimizzare asset frontend

### Sicurezza
- Validare sempre input utente
- Utilizzare prepared statements
- Implementare autenticazione robusta
- Proteggere da attacchi comuni

## Collegamenti

- [Architettura](../architecture/)
- [Moduli](../modules/)
- [Troubleshooting](../troubleshooting/)
- [Guide Utente](../guides/)

---

*Ultimo aggiornamento: Agosto 2025* 