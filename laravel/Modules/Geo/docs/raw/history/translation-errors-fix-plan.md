# 🔧 Translation Errors - Fix Plan

> **Stato**: IN PROGRESS  
> **Priorità**: CRITICAL 🔴  
> **Data**: 2025-03-25

---

## 📊 Panoramica Errori

**Totale file traduzione**: 824 file  
**Errori stimati**: ~5000+  
**Moduli interessati**: Tutti i moduli

---

## 🚨 Tipologie Errori Trovate

### 1. ❌ Label Non Tradotte

**Problema**: Label usano nomi tecnici invece di testi descrittivi

```php
// ❌ SBAGLIATO
'fields' => [
    'matr' => ['label' => 'matr'],      // Nome campo tecnico
    'email' => ['label' => 'email'],    // Nome campo tecnico
],

// ✅ CORRETTO
'fields' => [
    'matr' => ['label' => 'Matricola'],     // Testo descrittivo
    'email' => ['label' => 'Email Aziendale'], // Testo descrittivo
],
```

**File con errore**: ~600 file  
**Correzione**: Manuale + script automatico

---

### 2. ❌ Chiavi Obbligatorie Mancanti

**Problema**: Manca struttura completa (5 chiavi per field)

```php
// ❌ SBAGLIATO - Solo label
'fields' => [
    'nome' => [
        'label' => 'Nome',
        // MANCANO: placeholder, helper_text, description, tooltip
    ],
],

// ✅ CORRETTO - 5 chiavi
'fields' => [
    'nome' => [
        'label' => 'Nome',
        'placeholder' => 'Inserisci nome',
        'helper_text' => 'Testo di aiuto',
        'description' => 'Descrizione campo',
        'tooltip' => 'Tooltip info',
    ],
],
```

**File con errore**: ~700 file  
**Correzione**: Script automatico + review manuale

---

### 3. ❌ Navigation Incompleta

**Problema**: Manca struttura navigation standard

```php
// ❌ SBAGLIATO - Struttura vecchia
'navigation' => [
    'name' => 'Progetto',
    'plural' => 'Progetti',
    'group' => [
        'name' => 'Gestione',
        'description' => '...',
    ],
],

// ✅ CORRETTO - Struttura nuova
'navigation' => [
    'label' => 'Progetto',
    'plural_label' => 'Progetti',
    'group' => 'Gestione Progetti',
    'icon' => 'heroicon-o-folder',
    'sort' => 10,
],
```

**File con errore**: ~200 file  
**Correzione**: Manuale

---

### 4. ❌ Placeholder = Label

**Problema**: Placeholder identico alla label

```php
// ❌ SBAGLIATO
'fields' => [
    'nome' => [
        'label' => 'Nome',
        'placeholder' => 'Nome',  // Uguale a label!
    ],
],

// ✅ CORRETTO
'fields' => [
    'nome' => [
        'label' => 'Nome',
        'placeholder' => 'Inserisci nome progetto',  // Diverso!
    ],
],
```

**File con errore**: ~400 file  
**Correzione**: Script automatico

---

### 5. ❌ Actions Incomplete

**Problema**: Manca success, failure, confirm messages

```php
// ❌ SBAGLIATO - Solo label
'actions' => [
    'create' => [
        'label' => 'Crea Progetto',
    ],
],

// ✅ CORRETTO - Completa
'actions' => [
    'create' => [
        'label' => 'Crea Progetto',
        'success' => 'Progetto creato con successo',
        'failure' => 'Errore nella creazione',
    ],
],
```

**File con errore**: ~500 file  
**Correzione**: Script automatico

---

## 📋 Moduli Prioritari

### Priorità 1 - Core (CRITICAL 🔴)

| Modulo | File | Errori | Status |
|--------|------|--------|--------|
| **Xot** | 50+ | ~1000 | ⏳ Da correggere |
| **User** | 30+ | ~600 | ⏳ Da correggere |
| **Tenant** | 20+ | ~400 | ⏳ Da correggere |
| **Lang** | 25+ | ~500 | ⏳ Da correggere |

### Priorità 2 - Business (HIGH 🟡)

| Modulo | File | Errori | Status |
|--------|------|--------|--------|
| **Performance** | 40+ | ~800 | ⏳ Da correggere |
| **Ptv** | 35+ | ~700 | ⏳ Da correggere |
| **Incentivi** | 25+ | ~500 | ⏳ Da correggere |
| **IndennitaResponsabilita** | 20+ | ~400 | ⏳ Da correggere |

### Priorità 3 - Secondary (MEDIUM 🟢)

| Modulo | File | Errori | Status |
|--------|------|--------|--------|
| **UI** | 15+ | ~300 | ✅ Corretto (navigation.php) |
| **Sigma** | 10+ | ~200 | ⏳ Da correggere |
| **DbForge** | 10+ | ~200 | ⏳ Da correggere |

---

## 🔧 Processo di Correzione

### Per Ogni File

1. **STUDIARE** contesto d'uso (Filament Resource? Page? Widget?)
2. **LEGGERE** documentazione translation-standards.md
3. **CORREGGERE** struttura completa
4. **VERIFICARE** tutte le lingue (it/en/de)
5. **TESTARE** in UI Filament
6. **ESEGUIRE** quality gates

### Quality Gates

```bash
# PHPStan Level 10
php -d memory_limit=2G vendor/bin/phpstan analyse

# PHPMD (Mess Detection)
vendor/bin/phpmd <path> text codesize,unusedformalparameters

# PHPInsights (Quality metrics)
vendor/bin/phpinsights analyse

# Pest (Tests)
vendor/bin/pest
```

---

## 📝 Template Correzione

### File Template Completo

```php
<?php

declare(strict_types=1);

return [
    // 1. Navigation (OBBLIGATORIO)
    'navigation' => [
        'label' => 'Singolare',
        'plural_label' => 'Plurale',
        'group' => 'Gruppo Appartenenza',
        'icon' => 'heroicon-o-xxx',
        'sort' => 10,
    ],
    
    // 2. Label Principali (OBBLIGATORIO)
    'label' => 'Singolare',
    'plural_label' => 'Plurale',
    
    // 3. Fields (OBBLIGATORIO 5 chiavi per campo)
    'fields' => [
        'campo1' => [
            'label' => 'Label Descrittiva',
            'placeholder' => 'Placeholder Utile',
            'helper_text' => 'Testo di Aiuto',
            'description' => 'Descrizione Campo',
            'tooltip' => 'Tooltip Info',
        ],
    ],
    
    // 4. Actions (OBBLIGATORIO success/failure)
    'actions' => [
        'create' => [
            'label' => 'Crea Resource',
            'success' => 'Resource creato con successo',
            'failure' => 'Errore nella creazione',
        ],
        'edit' => [
            'label' => 'Modifica Resource',
            'success' => 'Resource aggiornato con successo',
            'failure' => 'Errore nell\'aggiornamento',
        ],
        'delete' => [
            'label' => 'Elimina Resource',
            'success' => 'Resource eliminato con successo',
            'failure' => 'Errore nell\'eliminazione',
            'confirm' => 'Sei sicuro di voler eliminare?',
        ],
    ],
];
```

---

## 🤖 Multi-AI Coordination

### Assegnazione Task

| AI Agent | Modulo | File | Deadline |
|----------|--------|------|----------|
| **Qwen** | Xot, User | 80 file | 2025-03-26 |
| **Gemini** | Performance, Ptv | 75 file | 2025-03-26 |
| **Claude** | Incentivi, Indennita | 45 file | 2025-03-26 |

### Regole Coordinamento

1. **Prima di agire**: Leggi docs/translation-standards.md
2. **Durante**: Commit piccoli e frequenti
3. **Dopo**: Quality gates SEMPRE
4. **Comunica**: Aggiorna GitHub Issues

---

## 📊 Progress Tracking

### Dashboard Avanzamento

```
Correzioni Translation Files
├─✅ UI/navigation.php (1 file)
├─⏳ Xot (50 file) - 0%
├─⏳ User (30 file) - 0%
├─⏳ Tenant (20 file) - 0%
├─⏳ Lang (25 file) - 0%
├─⏳ Performance (40 file) - 0%
├─⏳ Ptv (35 file) - 0%
└─⏳ Altri (623 file) - 0%

Totale: 1/824 (0.1%)
```

### GitHub Issues

- [ ] #XXX Fix Xot translations
- [ ] #XXX Fix User translations
- [ ] #XXX Fix Tenant translations
- [ ] #XXX Fix Lang translations
- [ ] #XXX Fix Performance translations
- [ ] #XXX Fix Ptv translations

---

## 🔗 Riferimenti

- [Translation Standards](docs/translation-standards.md) - Guida completa
- [Spatie Translatable](https://spatie.be/docs/laravel-translatable/v6) - Docs ufficiali
- [Filament Translatable](https://filamentphp.com/docs/3.x/plugins/translatable) - Integration

---

*Documento creato: 2025-03-25*  
*Ultimo aggiornamento: 2025-03-25*  
*Prossimo review: 2025-03-26*
