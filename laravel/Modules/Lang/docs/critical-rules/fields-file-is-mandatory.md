# Regola Critica: fields.php è OBBLIGATORIO

**Data**: 2026-01-09
**Severità**: 🔴 **CRITICAL**
**Status**: ✅ **REGOLA ASSOLUTA**

---

## 🚨 La Regola

**Il file `fields.php` è OBBLIGATORIO per ogni modulo che ha Filament Resources.**

**NON è opzionale. NON può essere omesso. NON può essere sostituito.**

---

## 💡 Perché È Critico

### 1. AutoLabelAction Lo Cerca Per Primo

```php
// File: AutoLabelAction.php - riga 93
$label_tkey = $trans_key.'.fields.'.$val.'';
                         ^^^^^^^^
                         HARDCODED!
```

Il sistema **hardcoda** `.fields.` nella chiave di traduzione per ogni campo form.

### 2. GetTransPathAction Usa Il Nome File

```php
// Input: 'cms::fields.title.label'
$piece = explode('.', 'fields.title.label');
$fileName = $piece[0];  // 'fields'
$path = $langPath.'/'.$lang.'/'.$fileName.'.php';
// Risultato: Modules/Cms/lang/it/fields.php
```

Il primo elemento dopo `::` determina il **nome del file** da caricare.

### 3. Struttura Gerarchica Standardizzata

```
{namespace}::{section}.{item}.{attribute}
            ^^^^^^^^^
            Sezione = Nome file

fields.php  → Per campi form
actions.php → Per azioni/bottoni
messages.php → Per messaggi
sections.php → Per sezioni/wizard steps
```

### 4. Configurazione Lo Richiede

```php
// File: config/lang.php
'structure' => [
    'required_files' => [
        'fields.php',      // ← OBBLIGATORIO
        'actions.php',
        'messages.php',
        'validation.php',
    ],
],
```

---

## ✅ Struttura Corretta

### Minima (Ma Completa)

```php
<?php
// File: Modules/{Module}/lang/it/fields.php

declare(strict_types=1);

return [
    'name' => [
        'label' => 'Nome',
        'placeholder' => 'Inserisci il nome',
    ],
    'email' => [
        'label' => 'Email',
        'placeholder' => 'Inserisci l\'email',
    ],
];
```

### Completa (Tutti gli Attributi)

```php
<?php
declare(strict_types=1);

return [
    'title' => [
        'label' => 'Titolo',
        'placeholder' => 'Inserisci il titolo',
        'help' => 'Il titolo deve essere univoco',
        'description' => 'Titolo principale dell\'elemento',
        'tooltip' => 'Verrà mostrato nell\'elenco',
    ],
    'content' => [
        'label' => 'Contenuto',
        'placeholder' => 'Scrivi qui il contenuto...',
        'help' => 'Supporta Markdown',
        'description' => 'Contenuto principale dell\'articolo',
    ],
    'status' => [
        'label' => 'Stato',
        'placeholder' => 'Seleziona uno stato',
        'help' => 'Lo stato determina la visibilità',
    ],
];
```

### Con Nesting

```php
<?php
declare(strict_types=1);

return [
    'author' => [
        'name' => [
            'label' => 'Nome Autore',
            'placeholder' => 'Inserisci nome autore',
        ],
        'email' => [
            'label' => 'Email Autore',
            'placeholder' => 'email@example.com',
        ],
    ],
    'category' => [
        'name' => [
            'label' => 'Nome Categoria',
        ],
        'slug' => [
            'label' => 'Slug Categoria',
        ],
    ],
];
```

---

## ❌ Errori Comuni

### Errore 1: File Mancante

```php
// ❌ SBAGLIATO - Nessun file fields.php
Modules/Cms/lang/it/
├── cms.php        // ❌ Nome sbagliato
├── labels.php     // ❌ Nome sbagliato
└── validation.php

// ✅ CORRETTO
Modules/Cms/lang/it/
├── fields.php     // ✅ OBBLIGATORIO
├── actions.php
├── messages.php
└── validation.php
```

### Errore 2: Struttura Piatta

```php
// ❌ SBAGLIATO - Struttura piatta
return [
    'name_label' => 'Nome',
    'name_placeholder' => 'Inserisci nome',
    'email_label' => 'Email',
];

// ✅ CORRETTO - Struttura nidificata
return [
    'name' => [
        'label' => 'Nome',
        'placeholder' => 'Inserisci nome',
    ],
    'email' => [
        'label' => 'Email',
    ],
];
```

### Errore 3: Hardcoding nel Resource

```php
// ❌ SBAGLIATO - Label hardcoded
TextInput::make('name')->label('Nome');
TextInput::make('name')->label(__('cms::fields.name.label'));

// ✅ CORRETTO - Nessuna label, AutoLabelAction la aggiunge
TextInput::make('name');
```

### Errore 4: Nome File Sbagliato

```php
// ❌ SBAGLIATO
Modules/Cms/lang/it/
├── Fields.php       // ❌ Maiuscola
├── field.php        // ❌ Singolare
├── form_fields.php  // ❌ Nome custom

// ✅ CORRETTO
Modules/Cms/lang/it/
└── fields.php       // ✅ Lowercase, plurale, esatto
```

---

## 🔍 Come Verificare

### 1. Check File Esiste

```bash
# Per ogni modulo, verifica che esista fields.php
ls -la Modules/*/lang/it/fields.php

# Output atteso:
Modules/Cms/lang/it/fields.php
Modules/User/lang/it/fields.php
Modules/Geo/lang/it/fields.php
...
```

### 2. Check Struttura

```bash
# Verifica che il file contenga array associativi nidificati
cat Modules/Cms/lang/it/fields.php | grep -A 3 "'label'"
```

### 3. Test AutoLabelAction

```php
// In un Resource, crea un campo senza label
TextInput::make('test_field')

// Visita la pagina nel browser
// Se AutoLabelAction funziona:
// - Label apparirà come 'Test Field' (fallback)
// - Verrà creato automaticamente in fields.php

// Controlla il file:
cat Modules/{Module}/lang/it/fields.php
// Dovresti vedere:
// 'test_field' => ['label' => 'test_field'],
```

---

## 📖 Riferimenti

### Codice Sorgente

- `Modules/Lang/app/Actions/Filament/AutoLabelAction.php:93`
- `Modules/Lang/app/Actions/GetTransPathAction.php:18`
- `Modules/Lang/app/Actions/SaveTransAction.php:20`
- `Modules/Lang/app/Providers/LangServiceProvider.php:46`

### Documentazione

- `Modules/Lang/docs/FILOSOFIA_MODULO_LANG.md`
- `Modules/Lang/docs/filament-label.md`
- `Modules/Lang/docs/architecture/translation-field-structure-complete.md`

### Esempi Reali

- `Modules/User/lang/it/fields.php`
- `Modules/Geo/lang/it/fields.php`
- `Modules/Cms/lang/it/fields.php`

---

## ⚠️ Conseguenze della Violazione

Se `fields.php` manca o ha struttura sbagliata:

1. ❌ **AutoLabelAction fallisce** - Nessuna label automatica
2. ❌ **SaveTransAction crea file sbagliato** - Traduzioni perse
3. ❌ **GetTransPathAction ritorna path errato** - FileNotFound
4. ❌ **Form Filament senza label** - UX terribile
5. ❌ **Inconsistenza multi-lingua** - Traduzioni incomplete

---

## 🎯 Checklist Compliance

Prima di considerare un modulo "completo":

- [ ] File `fields.php` esiste in `lang/it/` ✅
- [ ] File `fields.php` esiste in `lang/en/` ✅
- [ ] Struttura è nidificata: `'field' => ['label' => '...']` ✅
- [ ] TUTTI i campi del Resource hanno traduzione ✅
- [ ] Attributi usati: label, placeholder, help (minimo) ✅
- [ ] Nessuna label hardcoded nei Resource ✅
- [ ] Test: Form mostra label corrette ✅

---

## 🏆 Regola d'Oro

**"Un modulo senza fields.php è un modulo incompleto."**

**"fields.php non è un'opzione, è un requisito."**

**"Ogni campo deve avere la sua traduzione in fields.php, nessuna eccezione."**

---

**Versione**: 1.0
**Data**: 2026-01-09
**Autore**: System Architect (dopo litigata interna)
**Status**: ✅ **REGOLA DEFINITIVA**
