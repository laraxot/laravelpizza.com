# REGOLA CRITICA: MAI ->label() nei Componenti Filament

## Principio Fondamentale
**È ASSOLUTAMENTE VIETATO utilizzare ->label() nei componenti Filament. Le traduzioni devono essere gestite ESCLUSIVAMENTE tramite i file di traduzione del modulo.**

## Perché ->label() è VIETATO

### 1. Viola la Centralizzazione delle Traduzioni
- Crea stringhe hardcoded nel codice
- Impedisce la gestione centralizzata delle traduzioni
- Rende impossibile l'override delle traduzioni

### 2. Impedisce la Localizzazione Automatica
- Il LangServiceProvider non può gestire traduzioni inline
- Filament non può caricare automaticamente le traduzioni
- Impossibile supportare multiple lingue

### 3. Viola i Principi DRY e KISS
- Duplicazione delle traduzioni nel codice
- Complessità inutile nella gestione delle label
- Manutenzione frammentata

## Anti-Pattern VIETATI

```php
// ❌ ERRORE CRITICO: ->label() è VIETATO
TextInput::make('name')->label('Nome'),
Select::make('status')->label('Stato'),
DatePicker::make('date')->label('Data'),
Textarea::make('description')->label('Descrizione'),

// ❌ ERRORE: Anche con funzioni di traduzione
TextInput::make('name')->label(__('Nome')),
TextInput::make('name')->label(trans('fields.name')),
TextInput::make('name')->label(__('modulename::fields.name.label')),

// ❌ ERRORE: Qualsiasi forma di ->label()
->label('qualsiasi cosa'),
->label(__('qualsiasi cosa')),
->label(trans('qualsiasi cosa')),
```

## Pattern CORRETTI

```php
// ✅ CORRETTO: Nessun ->label(), traduzione automatica
TextInput::make('name'),
Select::make('status'),
DatePicker::make('date'),
Textarea::make('description'),
FileUpload::make('document'),
Toggle::make('is_active'),
```

## Come Funziona la Traduzione Automatica

### 1. Struttura File di Traduzione
```php
// Modules/{ModuleName}/lang/it/resource-name.php
return [
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'helper_text' => 'Nome completo dell\'utente',
        ],
        'status' => [
            'label' => 'Stato',
            'placeholder' => 'Seleziona uno stato',
            'helper_text' => '',
        ],
    ],
];
```

### 2. LangServiceProvider
- Gestisce automaticamente le traduzioni
- Carica le traduzioni dal modulo appropriato
- Applica le traduzioni ai componenti Filament

### 3. Filament Auto-Loading
- Filament carica automaticamente le traduzioni
- Utilizza il nome del campo per trovare la traduzione
- Supporta override tramite file di traduzione

## Processo di Correzione

### 1. Identificazione
```bash
# Cerca tutti i ->label() nel codebase
grep -r "->label(" laravel/Modules/
```

### 2. Rimozione
```php
// PRIMA (ERRATO)
TextInput::make('name')->label('Nome')->required(),

// DOPO (CORRETTO)
TextInput::make('name')->required(),
```

### 3. Verifica Traduzioni
- Assicurarsi che esistano le traduzioni nei file appropriati
- Verificare la struttura espansa delle traduzioni
- Testare che le traduzioni vengano caricate correttamente

## Filosofia e Principi

### Filosofia
**"Le traduzioni sono sacre e centralizzate"**

### Politica
**"Non avrai ->label() nel tuo codice Filament"**

### Religione
**"La localizzazione è divina e automatica"**

### Zen
**"Silenzio del codice, eloquenza delle traduzioni"**

## Regola d'Oro
**"Se vedi ->label() in un componente Filament, ELIMINALO IMMEDIATAMENTE senza eccezioni."**

## Applicazione Immediata
1. **Audit completo** di tutti i file Filament nel progetto
2. **Rimozione sistematica** di TUTTI i ->label()
3. **Verifica** che le traduzioni siano presenti nei file appropriati
4. **Test** che le traduzioni vengano caricate correttamente

## Eccezioni
**NON CI SONO ECCEZIONI. Questa regola si applica a TUTTI i componenti Filament senza distinzione.**

## Collegamenti
- [Modules/UI/docs/filament/no-label-rule.md](../laravel/Modules/UI/docs/filament/no-label-rule.md)
- [docs/translation-expanded-rules.md](translation-expanded-rules.md)

*Ultimo aggiornamento: 2025-08-04*
