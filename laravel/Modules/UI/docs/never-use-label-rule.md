# REGOLA CRITICA: MAI usare ->label()

## ❌ ERRORE CRITICO - NON FARE MAI QUESTO

```php
// ❌ ERRORE - Non usare mai ->label()
TextColumn::make('name')->label('Nome')
Action::make('save')->label('Salva')
Select::make('status')->label('Stato')
TextInput::make('email')->label('Email')
```

## ✅ CORRETTO - Sistema Traduzioni Automatico

```php
// ✅ CORRETTO - Usa il sistema di traduzioni automatico
TextColumn::make('name')
Action::make('save')
Select::make('status')
TextInput::make('email')
```

## Perché questa Regola è Critica

### 1. Sistema Traduzioni Automatico
- Il `LangServiceProvider` gestisce automaticamente le traduzioni
- Le chiavi vengono generate automaticamente dal nome del campo
- Struttura: `modulo::risorsa.fields.campo.label`

### 2. Centralizzazione
- Tutte le traduzioni sono nei file `lang/`
- Facile manutenzione e aggiornamento
- Sincronizzazione automatica tra lingue

### 3. Type Safety
- Previene errori di digitazione nelle label
- Controllo automatico delle traduzioni mancanti
- PHPStan può verificare la presenza delle chiavi

### 4. Performance
- Nessun overhead di chiamate `__()` manuali
- Cache delle traduzioni ottimizzata
- Meno codice da mantenere

## Implementazione Corretta

### 1. Prima di usare un componente, implementa le traduzioni

```php
// File: Modules/User/lang/it/fields.php
return [
    'name' => [
        'label' => 'Nome',
        'placeholder' => 'Inserisci nome',
        'tooltip' => 'Nome completo dell\'utente',
        'helper_text' => 'Nome e cognome dell\'utente',
    ],
    'email' => [
        'label' => 'Email',
        'placeholder' => 'Inserisci email',
        'tooltip' => 'Indirizzo email dell\'utente',
        'helper_text' => 'Email valida per le comunicazioni',
    ],
];
```

### 2. Poi usa il componente senza ->label()

```php
// ✅ CORRETTO
TextColumn::make('name')
TextColumn::make('email')
```

## Esempi di Errori Comuni

### ❌ ERRORE - Label hardcoded
```php
TextColumn::make('user_name')->label('Nome Utente')
```

### ✅ CORRETTO - Traduzione automatica
```php
// Prima implementa in lang/it/fields.php
'user_name' => [
    'label' => 'Nome Utente',
    // ...
],

// Poi usa senza ->label()
TextColumn::make('user_name')
```

### ❌ ERRORE - Label in inglese
```php
TextColumn::make('status')->label('Status')
```

### ✅ CORRETTO - Traduzione italiana
```php
// Prima implementa in lang/it/fields.php
'status' => [
    'label' => 'Stato',
    // ...
],

// Poi usa senza ->label()
TextColumn::make('status')
```

## Checklist Pre-Implementazione

### Prima di usare qualsiasi componente Filament
- [ ] Implementare traduzioni in `lang/it/fields.php`
- [ ] Implementare traduzioni in `lang/en/fields.php`
- [ ] Implementare traduzioni in `lang/de/fields.php`
- [ ] Verificare struttura espansa (label, placeholder, tooltip, helper_text)
- [ ] Non usare mai `->label()` nel codice

### Prima di committare:
- [ ] Verificare che non ci siano `->label()` nel codice
- [ ] Controllare che tutte le traduzioni siano implementate
- [ ] Testare che le traduzioni funzionino correttamente

## Verifica Automatica

### PHPStan Rule (Ideale)
```php
// Regola PHPStan per rilevare ->label()
// Implementare in phpstan.neon
rules:
    - rule: Never use ->label() in Filament components
```

### Code Review Checklist
- [ ] Nessun `->label()` nel codice
- [ ] Tutte le traduzioni implementate
- [ ] Struttura espansa completa
- [ ] Sincronizzazione IT/EN/DE

## Penalità per Violazioni

### Livello 1 - Warning
- Commento nel code review
- Richiesta di correzione

### Livello 2 - Blocco
- Blocco del merge
- Correzione obbligatoria

### Livello 3 - Sanzione
- Documentazione della violazione
- Training obbligatorio

## Collegamenti

- [Translation Standards](../../../docs/translation-standards.md)
- [Filament Best Practices](../../../docs/filament-best-practices.md)
- [LangServiceProvider Documentation](../../../docs/lang-service-provider.md)

## Memoria Permanente

**RICORDA SEMPRE**:
- MAI usare `->label()` in componenti Filament
- SEMPRE implementare traduzioni nei file `lang/`
- SEMPRE struttura espansa (label, placeholder, tooltip, helper_text)
- SEMPRE sincronizzare IT/EN/DE
- SEMPRE testare le traduzioni prima del commit
# REGOLA CRITICA: MAI usare ->label()

## Data: 2025-01-06

## ❌ ERRORE CRITICO - NON FARE MAI QUESTO

```php
// ❌ ERRORE - Non usare mai ->label()
TextColumn::make('name')->label('Nome')
Action::make('save')->label('Salva')
Select::make('status')->label('Stato')
TextInput::make('email')->label('Email')
```

## ✅ CORRETTO - Sistema Traduzioni Automatico

```php
// ✅ CORRETTO - Usa il sistema di traduzioni automatico
TextColumn::make('name')
Action::make('save')
Select::make('status')
TextInput::make('email')
```

## Perché questa Regola è Critica

### 1. Sistema Traduzioni Automatico
- Il `LangServiceProvider` gestisce automaticamente le traduzioni
- Le chiavi vengono generate automaticamente dal nome del campo
- Struttura: `modulo::risorsa.fields.campo.label`

### 2. Centralizzazione
- Tutte le traduzioni sono nei file `lang/`
- Facile manutenzione e aggiornamento
- Sincronizzazione automatica tra lingue

### 3. Type Safety
- Previene errori di digitazione nelle label
- Controllo automatico delle traduzioni mancanti
- PHPStan può verificare la presenza delle chiavi

### 4. Performance
- Nessun overhead di chiamate `__()` manuali
- Cache delle traduzioni ottimizzata
- Meno codice da mantenere

## Implementazione Corretta

### 1. Prima di usare un componente, implementa le traduzioni

```php
// File: Modules/User/lang/it/fields.php
return [
    'name' => [
        'label' => 'Nome',
        'placeholder' => 'Inserisci nome',
        'tooltip' => 'Nome completo dell\'utente',
        'helper_text' => 'Nome e cognome dell\'utente',
    ],
    'email' => [
        'label' => 'Email',
        'placeholder' => 'Inserisci email',
        'tooltip' => 'Indirizzo email dell\'utente',
        'helper_text' => 'Email valida per le comunicazioni',
    ],
];
```

### 2. Poi usa il componente senza ->label()

```php
// ✅ CORRETTO
TextColumn::make('name')
TextColumn::make('email')
```

## Esempi di Errori Comuni

### ❌ ERRORE - Label hardcoded
```php
TextColumn::make('user_name')->label('Nome Utente')
```

### ✅ CORRETTO - Traduzione automatica
```php
// Prima implementa in lang/it/fields.php
'user_name' => [
    'label' => 'Nome Utente',
    // ...
],

// Poi usa senza ->label()
TextColumn::make('user_name')
```

### ❌ ERRORE - Label in inglese
```php
TextColumn::make('status')->label('Status')
```

### ✅ CORRETTO - Traduzione italiana
```php
// Prima implementa in lang/it/fields.php
'status' => [
    'label' => 'Stato',
    // ...
],

// Poi usa senza ->label()
TextColumn::make('status')
```

## Checklist Pre-Implementazione

### Prima di usare un componente Filament:
- [ ] Implementare traduzioni in `lang/it/fields.php`
- [ ] Implementare traduzioni in `lang/en/fields.php`
- [ ] Implementare traduzioni in `lang/de/fields.php`
- [ ] Verificare che le chiavi siano corrette
- [ ] Testare che le traduzioni funzionino

### Prima di committare:
- [ ] Verificare che non ci siano `->label()` nel codice
- [ ] Controllare che tutte le traduzioni siano implementate
- [ ] Testare che le traduzioni funzionino correttamente
- [ ] Implementare traduzioni in `lang/it/fields.php`
- [ ] Implementare traduzioni in `lang/en/fields.php`
- [ ] Implementare traduzioni in `lang/de/fields.php`
- [ ] Verificare struttura espansa (label, placeholder, tooltip, helper_text)
- [ ] Non usare mai `->label()` nel codice

### Prima di committare:
- [ ] Verificare che non ci siano `->label()` nel codice
- [ ] Controllare che tutte le traduzioni siano implementate
- [ ] Testare che le traduzioni funzionino correttamente
## Verifica Automatica

### PHPStan Rule (Ideale)
```php
// Regola PHPStan per rilevare ->label()
// Implementare in phpstan.neon
rules:
    - rule: Never use ->label() in Filament components
```

### Code Review Checklist
- [ ] Nessun `->label()` nel codice
- [ ] Tutte le traduzioni implementate
- [ ] Struttura espansa completa
- [ ] Sincronizzazione IT/EN/DE

## Penalità per Violazioni

### Livello 1 - Warning
- Commento nel code review
- Richiesta di correzione

### Livello 2 - Blocco
- Blocco del merge
- Correzione obbligatoria

### Livello 3 - Sanzione
- Documentazione della violazione
- Training obbligatorio

## Collegamenti

- [Translation Standards](../../../docs/translation-standards.md)
- [Filament Best Practices](../../../docs/filament-best-practices.md)
- [LangServiceProvider Documentation](../../../docs/lang-service-provider.md)

## Memoria Permanente

**RICORDA SEMPRE**:

- MAI usare `->label()` in componenti Filament

- SEMPRE implementare traduzioni nei file `lang/`

- SEMPRE struttura espansa (label, placeholder, tooltip, helper_text)

- SEMPRE sincronizzare IT/EN/DE

- SEMPRE testare le traduzioni prima del commit

*Ultimo aggiornamento: 2025-01-06*
