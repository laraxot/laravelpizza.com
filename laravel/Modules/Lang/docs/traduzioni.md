# Traduzioni nel Progetto

## Regole Fondamentali

### Regola #1: MAI utilizzare ->label() o metodi simili

❌ **NON FARE MAI**:
```php
TextInput::make('nome')
    ->label('Nome Utente')
    ->placeholder('Inserisci il nome')
    ->helperText('Il nome completo dell\'utente');
```

✅ **FARE SEMPRE**:
```php
TextInput::make('nome')  // Le traduzioni vengono gestite automaticamente dal LangServiceProvider
```

**Motivazione**: 
Il metodo `->label()` e simili non devono mai essere utilizzati direttamente nei componenti Filament. Le etichette vengono gestite automaticamente dal `LangServiceProvider` che intercetta la creazione dei componenti e applica le traduzioni dai file di lingua.

## Struttura delle Traduzioni

### File di Traduzione
```php
// resources/lang/it/module-name.php
return [
    'fields' => [
        'nome' => [
            'label' => 'Nome Utente',
            'placeholder' => 'Inserisci il nome',
            'helper_text' => 'Il nome completo dell\'utente',
            'tooltip' => 'Inserisci il nome come appare sul documento',
            'validation' => [
                'required' => 'Il nome è obbligatorio',
                'min' => 'Il nome deve contenere almeno :min caratteri',
            ],
        ],
    ],
    'sections' => [
        'personal_info' => [
            'title' => 'Informazioni Personali',
            'description' => 'Inserisci i tuoi dati personali',
        ],
    ],
    'actions' => [
        'save' => [
            'label' => 'Salva',
            'tooltip' => 'Salva le modifiche',
            'confirmation' => 'Sei sicuro di voler salvare?',
        ],
    ],
];
```

## Gestione Automatica delle Traduzioni

Il `LangServiceProvider` gestisce automaticamente:
- Label dei campi
- Placeholder
- Helper text
- Tooltip
- Messaggi di validazione
- Titoli delle sezioni
- Descrizioni
- Messaggi di conferma

## Best Practices

1. **Organizzazione**
   - Un file di traduzione per modulo
   - Struttura gerarchica chiara
   - Separazione per tipo (fields, sections, actions)
   - Mantenere coerenza tra le lingue

2. **Naming**
   - Usare snake_case per le chiavi
   - Nomi descrittivi e significativi
   - Mantenere coerenza in tutto il progetto
   - Evitare abbreviazioni

3. **Validazione**
   - Includere tutti i messaggi di validazione
   - Usare i placeholder per i valori dinamici
   - Messaggi chiari e concisi
   - Feedback utile all'utente

4. **Manutenzione**
   - Aggiornare regolarmente le traduzioni
   - Verificare la completezza
   - Mantenere la documentazione aggiornata
   - Seguire le convenzioni stabilite

## Checklist di Verifica

Prima di committare:
1. [ ] Verificare di non aver usato ->label() o metodi simili
2. [ ] Controllare che tutte le stringhe siano nei file di traduzione
3. [ ] Verificare la coerenza delle traduzioni tra le lingue
4. [ ] Testare la visualizzazione in tutte le lingue supportate

## Note Importanti

1. **Sicurezza**
   - Non includere dati sensibili nelle traduzioni
   - Sanitizzare i valori dinamici
   - Evitare XSS attraverso le traduzioni

2. **Performance**
   - Caricare solo le traduzioni necessarie
   - Utilizzare il caching delle traduzioni
   - Ottimizzare la struttura dei file

3. **Internazionalizzazione**
   - Supportare tutte le lingue necessarie
   - Gestire correttamente i plurali
   - Considerare le differenze culturali
   - Mantenere la stessa struttura per tutte le lingue

## Documentazione Correlata

- [Filament Translations](/.cursor/rules/filament-translations.rule)
- [Laravel Localization](https://laravel.com/docs/10.x/localization)
- [Best Practices](/.cursor/rules/translations.rule)