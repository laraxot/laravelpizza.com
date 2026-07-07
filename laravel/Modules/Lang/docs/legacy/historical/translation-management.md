# Gestione Traduzioni - Regole Critiche

## ⚠️ REGOLA CRITICA: MAI USARE ->label() ⚠️

**MAI, MAI, MAI** usare `->label()` nei componenti Filament. Le traduzioni sono gestite automaticamente dal LangServiceProvider.

### ❌ ERRATO - MAI FARE QUESTO
```php
TextInput::make('name')->label('Nome')  // ❌ ERRORE CRITICO
Select::make('status')->label('Stato')  // ❌ ERRORE CRITICO
Action::make('save')->label('Salva')    // ❌ ERRORE CRITICO
```

### ✅ CORRETTO - SEMPRE FARE QUESTO
```php
TextInput::make('name')  // ✅ CORRETTO - Traduzione automatica
Select::make('status')   // ✅ CORRETTO - Traduzione automatica
Action::make('save')     // ✅ CORRETTO - Traduzione automatica
```

## Motivazione

1. **Centralizzazione**: Le traduzioni sono gestite dai file di lingua
2. **Consistenza**: Tutte le traduzioni seguono lo stesso pattern
3. **Manutenibilità**: Cambiare traduzioni senza toccare il codice
4. **Override**: Permette override delle traduzioni per temi/moduli
5. **Type Safety**: Evita errori di digitazione nelle stringhe

## Struttura File di Traduzione

### Posizionamento
- **Moduli**: `Modules/{ModuleName}/lang/{locale}/`
- **Temi**: `Themes/{ThemeName}/lang/{locale}/`
- **Root**: `lang/{locale}/`

### Struttura Espansa Obbligatoria
```php
// Modules/ModuleName/lang/it/fields.php
return [
    'name' => [
        'label' => 'Nome',
        'placeholder' => 'Inserisci il nome',
        'help' => 'Nome completo dell\'utente',
    ],
    'email' => [
        'label' => 'Email',
        'placeholder' => 'Inserisci l\'email',
        'help' => 'Indirizzo email valido',
    ],
];
```

## Regole Fondamentali

### 1. Mai Stringhe Hardcoded
- **VIETATO**: `->label('testo')`
- **VIETATO**: `->placeholder('testo')`
- **VIETATO**: `->helperText('testo')`
- **OBBLIGATORIO**: Usare solo `->make('campo')`

### 2. Struttura Espansa
- **SEMPRE** struttura espansa per tutti i campi
- **SEMPRE** `label`, `placeholder`, `help` per ogni campo
- **SEMPRE** `declare(strict_types=1);` nei file di traduzione

### 3. Sincronizzazione Lingue
- **SEMPRE** sincronizzare tra IT/EN/DE
- **SEMPRE** stessa struttura in tutte le lingue
- **SEMPRE** chiavi in inglese, valori nella lingua target

## Controllo Automatico

Prima di ogni commit, verificare:
- [ ] Nessun `->label()` nei componenti
- [ ] Nessun `->placeholder()` hardcoded
- [ ] Tutte le stringhe nei file di traduzione
- [ ] Struttura espansa per tutti i campi
- [ ] Sincronizzazione tra lingue

## Penalità per Violazioni

- ❌ Codice non conforme
- ❌ Difficoltà di manutenzione
- ❌ Inconsistenza nelle traduzioni
- ❌ Impossibilità di override
- ❌ Errori di type safety

## Collegamenti

- [Regole Traduzioni](../../laravel/Modules/Xot/docs/translation-standards.md)
- [Best Practices Filament](filament-widget-best-practices.md)
- [Enum Standards](enum_standards.md)

## Ultimo Aggiornamento
2025-01-27 - Regola critica per evitare ->label()
