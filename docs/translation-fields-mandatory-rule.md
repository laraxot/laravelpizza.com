# Regola Critica: Sezione "fields" Obbligatoria nelle Traduzioni

**Data**: 2026-01-09  
**Modulo**: Lang  
**Status**: 🔴 **REGOLA CRITICA DOCUMENTATA**

---

## 🔴 Regola Assoluta

**MAI rimuovere o omettere la sezione `fields` dai file di traduzione.**

### Perché è Critico

La sezione `fields` è **FONDAMENTALE** perché:

1. **Filament usa `fields` per le etichette dei campi** nei form e nelle tabelle
2. **LangServiceProvider risolve automaticamente** le traduzioni usando `fields.{field_name}.label`
3. **Senza `fields`, i campi non hanno traduzioni** e mostrano chiavi grezze o errori
4. **La struttura deve essere identica** tra tutte le lingue per garantire coerenza

---

## 📋 Struttura Obbligatoria

Ogni file di traduzione DEVE avere:

```php
return [
    'navigation' => [
        'label' => '...',
        'group' => '...',
        'icon' => '...',
        'sort' => ...,
    ],
    'label' => '...',
    'plural_label' => '...',  // Se presente nel file IT
    'fields' => [              // ← OBBLIGATORIO
        'field_name' => [
            'label' => '...',
        ],
        // Tutti i campi presenti nel file IT originale
    ],
    'actions' => [             // Se presente nel file IT
        'action_name' => [
            'label' => '...',
        ],
    ],
];
```

---

## ✅ Regola Assoluta

**Quando si creano traduzioni per altre lingue:**

1. **SEMPRE** leggere il file IT originale completo
2. **SEMPRE** mantenere tutte le sezioni presenti nel file IT
3. **SEMPRE** tradurre tutte le sezioni mantenendo la struttura identica
4. **MAI** rimuovere sezioni esistenti
5. **MAI** omettere la sezione `fields`

---

## 🔧 Pattern Corretto

### ❌ ERRATO (Rimosso fields)
```php
return [
    'navigation' => [
        'label' => 'Jobs',
    ],
    // fields mancante!
];
```

### ✅ CORRETTO (Fields presente)
```php
return [
    'navigation' => [
        'label' => 'Jobs',
        'group' => 'System',
        'icon' => 'heroicon-o-briefcase',
        'sort' => 58,
    ],
    'label' => 'Job',
    'plural_label' => 'Jobs',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'queue' => [
            'label' => 'Queue',
        ],
        // Tutti i campi del file IT originale
    ],
    'actions' => [
        'create' => [
            'label' => 'Create',
        ],
    ],
];
```

---

## 📚 Documentazione Correlata

- [Translation Standards](../../Xot/docs/translation-standards.md)
- [Job Module Error Documentation](../../Job/docs/translation-fields-critical-error-2026-01-09.md)

---

**Status**: 🔴 **REGOLA CRITICA - MAI VIOLARE**

**
