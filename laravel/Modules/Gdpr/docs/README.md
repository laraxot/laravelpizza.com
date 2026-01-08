# Modulo Gdpr - Documentazione

## Panoramica

Il modulo Gdpr gestisce il sistema completo di compliance GDPR per l'applicazione Laraxot PTVX. Implementa la gestione dei consensi, dei trattamenti dati e degli eventi di privacy in conformità con il Regolamento Generale sulla Protezione dei Dati (GDPR).

## Business Logic

### Sistema di Consensi
Il modulo implementa un sistema completo per la gestione dei consensi:

#### 1. Trattamenti (Treatments)
- **Definizione Trattamenti**: Configurazione dei diversi tipi di trattamento dati
- **Documentazione**: Versioni documenti e URL per informativa privacy
- **Ponderazione**: Sistema di pesi per priorità dei trattamenti
- **Stati**: Attivo/Inattivo e Obbligatorio/Opzionale

#### 2. Consensi (Consents)
- **Tracciamento Consensi**: Registrazione esplicita dei consensi per trattamento
- **Soggetti**: Collegamento a utenti o profili anonimi
- **Audit Trail**: Tracciamento completo data/ora e operatore
- **UUID Based**: Sistema UUID per identificazione univoca

#### 3. Eventi Privacy (Events)
- **Eventi di Privacy**: Registrazione di tutti gli eventi privacy rilevanti
- **Categorizzazione**: Diversi tipi di eventi (accesso, modifica, cancellazione)
- **Contesto**: Dettagli completi su cosa, quando, chi

#### 4. Profili (Profiles)
- **Gestione Profili**: Dati anagrafici per soggetti non utenti del sistema
- **Privacy by Design**: Architettura orientata alla privacy

## Componenti Principali

### Modelli Core
- **Treatment**: Definizione e configurazione dei trattamenti dati
- **Consent**: Registrazione consensi specifici per trattamento
- **Event**: Eventi di privacy e audit trail
- **Profile**: Gestione profili per privacy

### Filament Resources
Il modulo espone 4 risorse Filament per la gestione completa:

- **TreatmentResource**: Gestione definizioni trattamenti
- **ConsentResource**: Registrazione e gestione consensi
- **EventResource**: Visualizzazione eventi privacy
- **ProfileResource**: Gestione profili privacy

### Base Architecture
- **BaseModel**: Estensione Model con trait Xot (Updater)
- **BasePivot/BaseMorphPivot**: Relazioni pivot per consensi
- **UUID System**: Identificazione univoca per tutti i record
- **Soft Deletes**: Cancellazione logica per audit trail

## Architettura Tecnica

### Pattern Implementati
- **Repository Pattern**: Per gestione dati strutturata
- **Policy Pattern**: Per controllo accessi granulare
- **Observer Pattern**: Per audit automatico eventi
- **Factory Pattern**: Per generazione dati di test

### Integrazione con Altri Moduli
- **User**: Collegamento a utenti del sistema
- **Activity**: Tracciamento completo modifiche
- **Lang**: Sistema traduzioni completo
- **Xot**: Estensione classi base

### Database Architecture
- **Connessione Dedicata**: Usa connessione `user` per dati sensibili
- **UUID Primary Keys**: Identificazione univoca senza sequenzialità
- **Audit Fields**: Tracciamento created_by, updated_by, deleted_by
- **Soft Deletes**: Cancellazione logica per compliance

## Configurazione

### File di Configurazione
- `config/gdpr.php`: Configurazioni principali
- Variabili ambiente per parametri privacy

### Traduzioni
Struttura completa in:
- `lang/it/`: Italiano (principale)
- `lang/en/`: Inglese
- `lang/de/`: Tedesco

Supporto completo per:
- Label e placeholder per tutti i campi
- Messaggi di validazione privacy
- Azioni e operazioni GDPR
- Notifiche e feedback compliance

## Funzionalità Avanzate

### Compliance GDPR
- **Consenso Esplicito**: Registrazione consensi per ogni trattamento
- **Diritto all'Oblio**: Cancellazione dati con audit trail
- **Portabilità Dati**: Export dati in formato strutturato
- **Limitazione Trattamento**: Gestione limitazioni specifiche

### Audit Trail
- **Eventi Automatici**: Registrazione automatica di tutti gli eventi
- **Contesto Completo**: Dettagli su operazioni effettuate
- **Storico Immutabile**: Tracciamento modifiche nel tempo
- **Report Compliance**: Generazione report per verifiche

### Gestione Documenti
- **Versionamento**: Controllo versioni documenti privacy
- **URL Esterne**: Collegamento a documenti informativa
- **Validazione**: Verifica validità documenti
- **Archiviazione**: Storage sicuro documenti

## Testing

### Test Coverage
- Unit test per logica privacy
- Feature test per flussi GDPR
- Test policy e autorizzazioni
- Test audit trail e eventi

### Comandi Test
```bash
php artisan test --filter=Gdpr
php artisan test --filter=ConsentTest
php artisan test --filter=TreatmentTest
php artisan test --filter=PrivacyTest
```

## Collegamenti

### Documentazione Interna
- [Privacy Policy Implementation](./privacy-policy.md)
- [GDPR Compliance Guide](./gdpr-compliance.md)
- [Audit Trail System](./audit-trail.md)
- [Consent Management](./consent-management.md)

### Documentazione Moduli Correlati
- [Modulo Xot Service Provider Architecture](../xot/docs/service-provider-architecture.md)
- [Modulo User Authentication System](../user/docs/README.md)
- [Modulo Activity Audit Trail](../activity/docs/README.md)
- [Modulo Lang Translation System](../lang/docs/README.md)

### Documentazione Esterna
- [GDPR Official Website](https://gdpr.eu/)
- [Laravel Privacy Package](https://github.com/spatie/laravel-permission)
- [Filament GDPR Resources](https://filamentphp.com/plugins/filament-gdpr)

*Ultimo aggiornamento: Sistema di documentazione automatica*

