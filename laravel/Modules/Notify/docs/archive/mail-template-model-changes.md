# Modifiche al Modello MailTemplate

## Introduzione

Il modello `MailTemplate` è stato aggiornato per supportare il nuovo sistema di gestione dei template email con slug univoci e versioning. Queste modifiche sono parte di una più ampia ristrutturazione del sistema di notifiche per migliorare la manutenibilità e la scalabilità.

## Modifiche Effettuate

### 1. Aggiunta del Campo Slug
```php
protected $fillable = [
    'mailable',
    'slug',  // Nuovo campo
    'subject',
    'html_template',
    'text_template',
    'version'
];
```

**Motivazione:**
- Identificazione univoca dei template
- URL-friendly per l'accesso via API
- Migliore organizzazione dei template
- Supporto per la localizzazione

### 2. Implementazione del Versioning
```php
protected $fillable = [
    // ...
    'version'  // Nuovo campo
];

protected $casts = [
    'version' => 'string'
];
```

**Motivazione:**
- Tracciamento delle modifiche ai template
- Supporto per A/B testing
- Gestione delle compatibilità
- Rollback delle versioni

### 3. Validazione dei Campi JSON
```php
protected $casts = [
    'subject' => 'array',
    'html_template' => 'array',
    'text_template' => 'array'
];
```

**Motivazione:**
- Supporto multilingua
- Struttura dati consistente
- Validazione automatica
- Migliore gestione delle variabili

## Vantaggi delle Modifiche

1. **Migliore Organizzazione**
   - Template identificabili univocamente
   - Struttura dati standardizzata
   - Facile ricerca e filtro

2. **Supporto Multilingua**
   - Campi JSON per traduzioni
   - Gestione locale per ogni campo
   - Flessibilità nelle traduzioni

3. **Manutenibilità**
   - Versioning integrato
   - Struttura dati chiara
   - Validazione automatica

4. **Scalabilità**
   - Supporto per A/B testing
   - Facile estensione
   - API-friendly

## Impatto sul Sistema

### Template Esistenti
- Necessaria migrazione dei dati
- Generazione automatica degli slug
- Aggiornamento delle versioni

### Nuovi Template
- Richiesto slug univoco
- Versione iniziale 1.0.0
- Struttura JSON per i campi multilingua

### API e Interfacce
- Aggiornamento della documentazione
- Modifica delle query di ricerca
- Adattamento delle interfacce utente

## Best Practices

1. **Naming degli Slug**
   ```php
   // ❌ NON FARE QUESTO
   'welcome-email'
   
   // ✅ FARE QUESTO
   'welcome-email-v1'
   ```

2. **Gestione Versioni**
   ```php
   // ❌ NON FARE QUESTO
   '1.0'
   
   // ✅ FARE QUESTO
   '1.0.0'
   ```

3. **Struttura JSON**
   ```php
   // ❌ NON FARE QUESTO
   'subject' => 'Welcome'
   
   // ✅ FARE QUESTO
   'subject' => [
       'en' => 'Welcome',
       'it' => 'Benvenuto'
   ]
   ```

## Collegamenti Correlati

- [Modifiche Migrazione](./MIGRATION_CHANGES.md)
- [Regole Migrazioni](./MIGRATION_RULES.md)
- [Documentazione Template](./EMAIL_TEMPLATES.md)
- [Best Practices](./BEST-PRACTICES.md)

## Note Importanti

1. Mantenere la retrocompatibilità
2. Documentare le modifiche
3. Aggiornare i test
4. Verificare le performance

## Supporto

Per supporto tecnico:
- Email: support@example.com
- Documentazione: https://docs.example.com
- Repository: https://github.com/organization/notify 
