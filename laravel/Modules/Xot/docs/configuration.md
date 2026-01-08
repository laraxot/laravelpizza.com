# Configurazione del Sistema

## Struttura delle Configurazioni

### Configurazioni Globali
- Le configurazioni globali si trovano in `laravel/config/`
- Sono applicate a tutti i domini
- Possono essere sovrascritte da configurazioni specifiche per dominio

### Configurazioni per Dominio
- Le configurazioni specifiche per dominio si trovano in `laravel/config/<dominio_inverso>/`
- Il formato del dominio è invertito (es: `local/example` per `http://example.local`)
- Sovrascrivono le configurazioni globali quando necessario

## Gestione delle Risorse

### Percorsi delle Risorse
- Le risorse sono organizzate per modulo
- Utilizzare il formato `module::path` per riferirsi alle risorse
- Il percorso si traduce in `laravel/Modules/Module/resources/path`

### Esempi di Configurazione
```php
// Configurazione globale (laravel/config/metatag.php)
return [
    'default_logo' => 'xot::images/logo.svg',
];

// Configurazione specifica per dominio (laravel/config/local/example/metatag.php)
return [
    'logo_header' => 'patient::images/logo.svg',
    'logo_header_dark' => 'patient::images/logo.svg',
];
```

## Best Practices

### Organizzazione
1. **Configurazioni Globali**:
   - Mantenere le configurazioni di base in `laravel/config/`
   - Documentare tutte le opzioni disponibili
   - Fornire valori predefiniti appropriati

2. **Configurazioni per Dominio**:
   - Creare una cartella per ogni dominio
   - Mantenere solo le configurazioni che differiscono da quelle globali
   - Documentare le differenze specifiche per dominio

3. **Risorse**:
   - Organizzare le risorse per modulo
   - Utilizzare nomi descrittivi per i file
   - Mantenere una struttura coerente

### Manutenzione
1. **Versionamento**:
   - Tenere traccia delle modifiche alle configurazioni
   - Documentare le modifiche significative
   - Mantenere la compatibilità con le versioni precedenti

2. **Documentazione**:
   - Documentare tutte le opzioni di configurazione
   - Fornire esempi di utilizzo
   - Mantenere aggiornata la documentazione

## Collegamenti
- [Gestione Domini](DOMAIN_CONFIGURATION.md)
- [Struttura del Progetto](PROJECT_STRUCTURE.md)
- [Documentazione Principale](../README.md) 
## Collegamenti tra versioni di configuration.md
* [configuration.md](docs/configuration.md)
* [configuration.md](../../../Xot/docs/configuration.md)
* [configuration.md](../../../Cms/docs/configuration.md)

