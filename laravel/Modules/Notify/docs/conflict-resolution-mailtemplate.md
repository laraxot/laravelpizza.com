# Risoluzione Conflitti MailTemplate.php

## Contesto del Conflitto
**File**: `/var/www/html/ptvx/laravel/Modules/Notify/app/Models/MailTemplate.php`
**Linee**: 75-79
**Tipo**: Conflitto di proprietà translatable

## Descrizione del Conflitto
Il conflitto riguarda la proprietà `$translatable` che definisce quali campi del modello MailTemplate sono traducibili:

### Versione HEAD
```php
/** @var list<string> */
public array $translatable = ['subject', 'html_template', 'text_template','sms_template'];
```

### Versione Branch
```php
/** @var list<string> */
public array $translatable = ['subject', 'html_template', 'text_template'];
```

## Analisi delle Differenze
- **HEAD**: Include `sms_template` nei campi traducibili (supporto SMS completo)
- **Branch**: Non include `sms_template` nei campi traducibili (solo email)

## Strategia di Risoluzione: Mantenere Versione HEAD

### Motivazione
1. **Funzionalità completa**: La versione HEAD supporta anche i template SMS, non solo email
2. **Coerenza con architettura**: Il modulo Notify gestisce sia email che SMS
3. **Espandibilità**: Includere `sms_template` permette traduzioni multilingue anche per SMS
4. **Backward compatibility**: Aggiungere un campo traducibile non rompe funzionalità esistenti
5. **Principio di completezza**: Meglio avere funzionalità in più che in meno

### Vantaggi della Versione HEAD
- Supporto completo per template SMS multilingue
- Coerenza con l'architettura del modulo Notify
- Maggiore flessibilità per future implementazioni
- Non richiede modifiche future quando si aggiunge supporto SMS

### Implementazione
Rimuovere i marker di conflitto mantenendo la versione HEAD che include `sms_template` nei campi traducibili.

## Codice Finale
```php
/** @var list<string> */
public array $translatable = ['subject', 'html_template', 'text_template','sms_template'];
```

## Note Tecniche
- Il campo `sms_template` deve essere presente nella tabella del database
- La traduzione SMS funziona solo se il package di localizzazione è configurato correttamente
- Nessun impatto negativo su funzionalità esistenti

## Pattern Identificato
**Pattern**: Quando si aggiungono nuovi campi traducibili, includerli sempre nella proprietà `$translatable` per supporto multilingue completo

**Anti-pattern**: Escludere campi traducibili dalla proprietà `$translatable` limitando le funzionalità multilingue

## Impatto su Altri File
Verificare che:
- La migrazione della tabella `mail_templates` includa il campo `sms_template`
- I form Filament includano il campo `sms_template` se necessario
- Le traduzioni includano le chiavi per `sms_template`

## Collegamenti
- [Notify Module Documentation](README.md)
- [SMS Implementation Guide](sms_implementation.md)
- [Mail Templates Structure](mail_templates_structure.md)
- [Translation Standards](translation_standards.md)
- [Root Conflict Resolution Guidelines](../../../docs/conflict-resolution-guidelines.md)

*Ultimo aggiornamento: giugno 2025*
