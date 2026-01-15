# Template delle Notifiche

## Architettura

Il sistema di template delle notifiche è progettato seguendo i principi di:
- Separazione delle responsabilità
- Type safety
- Gestione centralizzata delle traduzioni
- Modularità e riusabilità

## Struttura

### Namespace
- `Modules\Notify\Filament\Resources` - Risorse Filament
- `Modules\Notify\Models` - Modelli
- `Modules\Notify\Actions` - Azioni (usando Spatie QueableActions)

### Componenti Principali

1. **NotificationTemplateResource**
   - Estende `XotBaseResource`
   - Gestisce CRUD dei template
   - Implementa preview in tempo reale
   - Supporta traduzioni multilingua

2. **NotificationTemplate Model**
   - Implementa `HasMedia` per gestione file
   - Usa `Spatie\Translatable\HasTranslations`
   - Supporta preview data per test

3. **Preview System**
   - Pagina dedicata per preview
   - Supporto per versione testo e HTML
   - Integrazione con sistema di traduzioni

## Best Practices

1. **Traduzioni**
   - Usare sempre chiavi di traduzione
   - Evitare hardcoding di stringhe
   - Mantenere traduzioni nel modulo

2. **Type Safety**
   - Usare enum per tipi di notifica
   - Definire tipi per tutti i parametri
   - Evitare mixed quando possibile

3. **File Management**
   - Usare Spatie Media Library
   - Configurare collezioni appropriate
   - Implementare conversioni necessarie

## Integrazione

### Con altri moduli
- `User` - Per destinatari
- `Media` - Per gestione file
- `Xot` - Per funzionalità base

### Con Filament
- Usare sempre classi XotBase
- Seguire convenzioni di naming
- Implementare interfacce standard

## Sicurezza

1. **Validazione**
   - Validare input
   - Sanitizzare output
   - Gestire permessi

2. **Audit**
   - Logging delle modifiche
   - Tracciamento accessi
   - Versioning dei template

## Performance

1. **Caching**
   - Cache dei template
   - Cache delle traduzioni
   - Ottimizzazione query

2. **Queue**
   - Processamento asincrono
   - Rate limiting
   - Retry logic

## Manutenzione

1. **Testing**
   - Unit test
   - Feature test
   - Integration test

2. **Documentazione**
   - Aggiornare docs
   - Mantenere esempi
   - Documentare cambiamenti

## Link Correlati

- [Documentazione Filament](../../../project_docs/filament.md)
- [Documentazione Media Library](../../../project_docs/media-library.md)
- [Documentazione Traduzioni](../../../project_docs/translations.md) 
- [Documentazione Filament](../../../docs/filament.md)
- [Documentazione Media Library](../../../docs/media-library.md)
- [Documentazione Traduzioni](../../../docs/translations.md) 
