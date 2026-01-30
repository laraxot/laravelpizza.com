# Regole per le Traduzioni

## Regola Fondamentale

Le label e i testi dell'interfaccia devono essere gestiti tramite file di traduzione, mai hardcoded nel codice.

## Struttura dei File

```
Modules/
└── ModuleName/
    └── lang/
        ├── it/
        │   ├── fields.php
        │   ├── messages.php
        │   └── navigation.php
        └── en/
            ├── fields.php
            ├── messages.php
            └── navigation.php
```

## Formato delle Traduzioni

### ✅ FARE QUESTO

```php
<?php

declare(strict_types=1);

return [
    'name' => [
        'label' => 'Nome',
        'placeholder' => 'Inserisci il nome',
        'help' => 'Il nome completo dell\'utente',
        'tooltip' => 'Questo campo è obbligatorio',
        'helper_text' => '', // Se uguale alla chiave, altrimenti testo descrittivo
    ],
];
```

### ❌ NON FARE QUESTO

```php
// Sintassi array vecchia
return array(
    'name' => 'Nome',
);

// Manca strict types
return [
    'name' => 'Nome',
];

// Helper text uguale alla chiave
'name' => [
    'label' => 'Nome',
    'helper_text' => 'name', // ERRORE: deve essere vuoto o diverso
];
```

## Struttura delle Chiavi

### Campi
```php
'field_name' => [
    'label' => 'Etichetta',
    'placeholder' => 'Testo placeholder',
    'help' => 'Testo di aiuto',
    'tooltip' => 'Testo tooltip',
    'helper_text' => '', // Se uguale alla chiave, altrimenti testo descrittivo
    'validation' => [
        'required' => 'Il campo è obbligatorio',
        'min' => 'Il campo deve contenere almeno :min caratteri',
    ],
],
```

### Navigazione
```php
'navigation' => [
    'label' => 'Etichetta menu',
    'group' => 'Gruppo menu',
    'icon' => 'heroicon-o-users',
    'tooltip' => 'Descrizione del menu',
    'helper_text' => '',
],
```

### Messaggi
```php
'messages' => [
    'success' => [
        'created' => 'Elemento creato con successo',
        'updated' => 'Elemento aggiornato con successo',
        'deleted' => 'Elemento eliminato con successo',
    ],
    'errors' => [
        'not_found' => 'Elemento non trovato',
        'unauthorized' => 'Non autorizzato',
    ],
],
```

## Regole Critiche

### 1. Strict Types OBBLIGATORIO
```php
<?php

declare(strict_types=1);

return [
    // contenuto
];
```

### 2. Sintassi Array Breve
```php
// ✅ CORRETTO
return [
    'key' => 'value',
];

// ❌ ERRATO
return array(
    'key' => 'value',
);
```

### 3. Helper Text Rules
**REGOLA CRITICA**: Se `helper_text` è uguale alla chiave dell'array, impostare `'helper_text' => ''`

```php
'address' => [
    'label' => 'Indirizzo',
    'placeholder' => 'Inserisci il tuo indirizzo',
    'help' => 'Indica l\'indirizzo di residenza o domicilio',
    'helper_text' => '', // Vuoto perché diverso da 'address'
],

'name' => [
    'label' => 'Nome',
    'placeholder' => 'Inserisci il nome',
    'helper_text' => 'name', // ERRORE: uguale alla chiave
],
```

### 4. Struttura Espansa OBBLIGATORIA
Tutti i campi devono avere struttura espansa completa:

```php
'field_name' => [
    'label' => 'Etichetta Campo',
    'placeholder' => 'Placeholder diverso',
    'help' => 'Testo di aiuto specifico',
    'tooltip' => 'Tooltip descrittivo',
    'helper_text' => '', // Se uguale alla chiave
    'description' => 'Descrizione dettagliata',
],
```

### 5. NO ->label() nei Componenti Filament
**VIETATO**: Utilizzare `->label()` nei form components

```php
// ✅ CORRETTO
TextInput::make('name')->required()

// ❌ ERRATO
TextInput::make('name')
    ->label('Nome')
    ->required()
```

### 6. Preservazione Totale
**REGOLA ASSOLUTA**: MAI rimuovere contenuto dalle traduzioni esistenti
- ✅ Aggiungere nuove chiavi
- ✅ Migliorare traduzioni esistenti
- ✅ Espandere strutture incomplete
- ❌ MAI rimuovere o eliminare

### 7. Terminologia Corretta
- **Italiano**: "Referto" (NON "Report") - specialmente in ambito medico
- **Inglese**: "Report"
- **Tedesco**: "Bericht"

### 8. Sincronizzazione Multilingua
- **SEMPRE** implementare traduzioni complete in italiano, inglese e tedesco
- **SEMPRE** mantenere la stessa struttura in tutte le lingue
- **SEMPRE** verificare che tutte le chiavi esistano in tutte le lingue

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

4. **Controlli Qualità**
   - Verificare che non ci siano traduzioni hardcoded
   - Controllare che tutte le lingue abbiano le stesse sezioni
   - Validare la coerenza terminologica

## Errori Comuni da Evitare

1. **Parentesi mancanti in array annidati**
2. **Virgole mancanti tra elementi dell'array**
3. **Etichette non tradotte (stesse chiavi come valori)**
4. **Mescolanza di stili array (`array()` e `[]`)**
5. **Riferimenti a traduzioni inesistenti**
6. **Mancanza di `declare(strict_types=1);`**
7. **Campi `helper_text` vuoti o duplicati**
8. **Conflitti di merge non risolti**
9. **Helper text uguale alla chiave dell'array**
10. **Mancanza di sintassi array breve**
11. **Traduzioni incomplete tra lingue**
12. **Uso di ->label() nei componenti Filament**

## Checklist Operativa

### Pre-Intervento
- [ ] Verificare presenza `declare(strict_types=1);`
- [ ] Controllare sintassi array breve `[]`
- [ ] Verificare helper_text non uguale alla chiave
- [ ] Controllare struttura espansa completa

### Durante Sviluppo
- [ ] Implementare traduzioni in tutte le lingue (IT/EN/DE)
- [ ] Usare struttura espansa per tutti i campi
- [ ] Verificare helper_text rules
- [ ] Mantenere coerenza terminologica

### Post-Sviluppo
- [ ] Controllare traduzioni in tutte le lingue
- [ ] Verificare che non ci siano ->label() hardcoded
- [ ] Testare funzionalità in ambiente di sviluppo
- [ ] Aggiornare documentazione

## Collegamenti Bidirezionali

### Collegamenti nella Root
- [Architettura delle Traduzioni](../architecture/translations.md)
- [Gestione Lingue](../architecture/languages.md)

### Collegamenti ai Moduli
- [LangServiceProvider](../../laravel/Modules/Lang/docs/service-provider.md)
- [Traduzioni Notify](../../laravel/Modules/Notify/docs/translations.md)
- [Regole Xot](../../laravel/Modules/Xot/docs/translation_rules.md)
- [Regole User](../../laravel/Modules/User/docs/translation_keys_rules.md)

## Note Importanti

1. Mai usare testo hardcoded nel codice
2. Mantenere le traduzioni aggiornate
3. Seguire la struttura standard
4. Documentare le modifiche
5. Testare tutte le lingue
6. Preservare sempre il contenuto esistente
7. Usare terminologia appropriata per il contesto
8. Sincronizzare sempre tutte le lingue

---

**Ultimo aggiornamento**: Giugno 2025
**Versione**: 2.0
**Compatibilità**: Laravel 12.x, Filament 4.x 
