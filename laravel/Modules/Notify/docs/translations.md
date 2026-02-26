# Traduzioni del Modulo Notify

## Panoramica

Il modulo Notify utilizza file di traduzione per gestire tutti i testi dell'interfaccia utente. Questo approccio garantisce la coerenza e la manutenibilità delle traduzioni.

## Struttura dei File

```
lang/
├── it/
│   └── template.php
└── en/
    └── template.php

## Formato delle Traduzioni

### Template

```php
return [
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome del template',
            'help' => 'Il nome identificativo del template',
            'tooltip' => 'Questo campo è obbligatorio',
        ],
        // Altri campi...
    'navigation' => [
        'label' => 'Template Notifiche',
        'group' => 'Notifiche',
        'icon' => 'heroicon-o-bell',
    'messages' => [
        'success' => [
            'created' => 'Template creato con successo',
            'updated' => 'Template aggiornato con successo',
            'deleted' => 'Template eliminato con successo',
        ],
        'errors' => [
            'not_found' => 'Template non trovato',
            'unauthorized' => 'Non autorizzato',
];
```

## Utilizzo

### Nei Form

```php
Forms\Components\TextInput::make('name')
// Le label sono gestite automaticamente dal file di traduzione

### Nella Navigazione

protected static function getNavigationLabel(): string
{
    return __('notify::template.navigation.label');
}

### Nei Messaggi

Notification::make()
    ->success()
    ->title(__('notify::template.messages.success.created'));
```

## Best Practices

1. **Organizzazione**
   - Separare le traduzioni per contesto
   - Mantenere una struttura coerente
   - Usare nomi di chiavi descrittivi

2. **Formato**
   - Usare array associativi per i campi
   - Includere tutte le proprietà di testo
   - Mantenere coerenza tra le lingue

3. **Manutenzione**
   - Aggiornare tutte le lingue insieme
   - Rimuovere traduzioni non utilizzate
   - Documentare le modifiche

## Collegamenti Bidirezionali

### Collegamenti nella Root
- [Architettura delle Traduzioni](../../../../docs/architecture/translations.md)
- [Gestione Lingue](../../../../docs/architecture/languages.md)

### Collegamenti ai Moduli
- [LangServiceProvider](../../Lang/docs/service-provider.md)
- [Regole Traduzioni](../../../../docs/regole/traduzioni.md)

## Note Importanti

1. Mai usare testo hardcoded nel codice
2. Mantenere le traduzioni aggiornate
3. Seguire la struttura standard
4. Documentare le modifiche
### Versione HEAD

5. Testare tutte le lingue

### Versione Incoming

```
## Collegamenti tra versioni di translations.md
* [translations.md](../../../Chart/docs/translations.md)
* [translations.md](../../../Reporting/docs/translations.md)
* [translations.md](../../../Gdpr/docs/translations.md)
* [translations.md](../../../Notify/docs/translations.md)
* [translations.md](../../../Xot/docs/roadmap/lang/translations.md)
* [translations.md](../../../Xot/docs/translations.md)
* [translations.md](../../../Dental/docs/translations.md)
* [translations.md](../../../User/docs/translations.md)
* [translations.md](../../../UI/docs/translations.md)
* [translations.md](../../../Lang/docs/packages/translations.md)
* [translations.md](../../../Lang/docs/translations.md)
* [translations.md](../../../Job/docs/translations.md)
* [translations.md](../../../Media/docs/translations.md)
* [translations.md](../../../Tenant/docs/translations.md)
* [translations.md](../../../Activity/docs/translations.md)
* [translations.md](../../../Patient/docs/translations.md)
* [translations.md](../../../Cms/docs/translations.md)

---
