# Errori comuni nei file di traduzione

## Errori di sintassi critici identificati

### 1. Dichiarazione `declare(strict_types=1)` posizionata erroneamente

**Errore comune**: La dichiarazione `declare(strict_types=1);` viene posizionata dopo il `return` o in posizione errata.

**Esempio di errore**:
```php
<?php 
return [

declare(strict_types=1);  // ERRORE: dopo return
  'navigation' => [
    'label' => 'Navigation Label',
  ],
);
```

**Correzione**:
```php
<?php

declare(strict_types=1);

return [
  'navigation' => [
    'label' => 'Navigation Label',
  ],
];
```

### 2. Parentesi mancanti in array annidati

Un errore comune nei file di traduzione è la mancanza di parentesi chiuse negli array annidati. Questo tipo di errore causa un `ParseError` che blocca l'intera applicazione.

**Esempio di errore**:
```php
return [
  'fields' => [
    'name' => [
      'label' => 'Nome',
      'placeholder' => 'Inserisci nome',
      // ERRORE: manca parentesi chiusa
    ],
  ],
]; // ERRORE: parentesi non bilanciate
```

**Correzione**:
```php
return [
  'fields' => [
    'name' => [
      'label' => 'Nome',
      'placeholder' => 'Inserisci nome',
      'helper_text' => 'Nome completo',
    ],
  ],
];
```

### 3. Traduzioni non tradotte (chiavi inglesi)

**Problema**: Utilizzo di chiavi non tradotte come valori.

**Esempio di errore**:
```php
'fields' => [
  'name' => [
    'label' => 'name',  // ERRORE: chiave non tradotta
    'placeholder' => 'name',  // ERRORE: chiave non tradotta
  ],
],
```

**Correzione**:
```php
'fields' => [
  'name' => [
    'label' => 'Nome',
    'placeholder' => 'Inserisci nome',
    'helper_text' => 'Nome completo dell\'utente',
  ],
],
```

### 4. Pattern ".navigation" non tradotto

**Problema**: Utilizzo di pattern `.navigation` invece di traduzioni appropriate.

**Esempio di errore**:
```php
'navigation' => [
  'label' => 'permission.navigation',  // ERRORE: pattern non tradotto
  'group' => 'permission.navigation',  // ERRORE: pattern non tradotto
],
```

**Correzione**:
```php
'navigation' => [
  'label' => 'Permessi',
  'group' => 'Gestione Utenti',
  'icon' => 'heroicon-o-shield-check',
],
```

## Best Practices per la Correzione

### Struttura Espansa Obbligatoria
Tutti i campi devono seguire la struttura espansa:

```php
'fields' => [
  'field_name' => [
    'label' => 'Etichetta Campo',
    'placeholder' => 'Placeholder diverso',
    'helper_text' => 'Testo di aiuto specifico'
  ]
]
```

### Helper Text Rules
- **SE** `helper_text` è uguale alla chiave → impostare `'helper_text' => ''`
- **SE** ci sono `label` e `placeholder` → **DEVE** esserci `helper_text`

### Naming Convention
- Tutti i file e cartelle in docs/ devono essere in minuscolo (eccetto README.md)
- Traduzioni in italiano per file `it/`
- Traduzioni in inglese per file `en/`

## Documentazione Correlata

- [Correzioni Errori Sintassi 2025](correzioni_errori_sintassi_2025.md)
- [Traduzioni Navigation Audit](traduzioni_navigation_2025.md)
- [Best Practices Traduzioni](../../Xot/docs/TRANSLATION_RULES.md)

*Ultimo aggiornamento: 6 Gennaio 2025*