# 🔧 **Troubleshooting Modulo Lang - Laraxot**

## 🎯 **Panoramica**

Questo documento fornisce soluzioni rapide e sistematiche per i problemi più comuni del modulo Lang, seguendo i principi **DRY**, **KISS**, **SOLID**, **Robust** e **Laraxot**.

---

## 🚨 **Problemi Critici**

### **1. Traduzioni Non Caricate**

#### **Sintomi**
- Chiavi di traduzione visibili invece del testo
- Errori "Translation key not found"
- Componenti Filament senza label

#### **Diagnosi Rapida**
```bash
# 1. Verifica cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# 2. Verifica file traduzioni
php artisan lang:validate

# 3. Controllo configurazione
php artisan config:show lang
```

#### **Soluzioni**
```php
// ✅ CORRETTO - Verifica struttura file
// Modules/ModuleName/lang/it/fields.php
return [
    'name' => [
        'label' => 'Nome',
        'placeholder' => 'Inserisci nome'
    ]
];

// ❌ ERRATO - Struttura non valida
return [
    'name_label' => 'Nome'
];
```

---

### **2. Performance Lente**

#### **Sintomi**
- Caricamento pagine lento
- Tempo di risposta elevato
- Uso memoria eccessivo

#### **Diagnosi**
```bash
# 1. Benchmark performance
php artisan lang:benchmark

# 2. Verifica cache
php artisan lang:cache --status

# 3. Monitor memoria
php artisan lang:memory-usage
```

#### **Soluzioni**
```php
// ✅ CORRETTO - Cache abilitata
'cache' => [
    'enabled' => true,
    'ttl' => 3600,
    'compression' => true
]

// ✅ CORRETTO - Lazy loading
$translation = app(TranslationService::class);
$text = $translation->get('key', $locale);
```

---

### **3. Errori di Validazione**

#### **Sintomi**
- Comandi `lang:validate` falliscono
- Report qualità sotto soglia
- Errori PHPStan livello 9+

#### **Diagnosi**
```bash
# 1. Validazione dettagliata
php artisan lang:validate --detailed

# 2. Report qualità
php artisan lang:report --format=json

# 3. Fix automatici
php artisan lang:fix --auto
```

#### **Soluzioni**
```php
// ✅ CORRETTO - Sintassi valida
<?php
declare(strict_types=1);

/**
 * @return array<string, array<string, string>>
 */
return [
    'field' => [
        'label' => 'Label',
        'help' => 'Help text'
    ]
];

// ❌ ERRATO - Sintassi non valida
return array(
    'field' => array(
        'label' => 'Label'
    )
);
```

---

## 🔍 **Problemi Specifici**

### **1. Integrazione Filament**

#### **Problema: Componenti Senza Label**
```php
// ❌ ERRATO - Label hardcoded
TextInput::make('name')->label('Nome');

// ✅ CORRETTO - Label automatica
TextInput::make('name');
// Carica automaticamente: fields.name.label
```

#### **Soluzione**
```bash
# Verifica file traduzioni
php artisan lang:validate --module=ModuleName

# Ricrea cache
php artisan lang:cache --clear
php artisan lang:cache
```

---

### **2. Fallback Traduzioni**

#### **Problema: Fallback Non Funziona**
```php
// Configurazione fallback
'fallback_chain' => [
    'it' => ['en', 'de'],
    'de' => ['en', 'it'],
    'en' => ['it', 'de']
]
```

#### **Soluzione**
```bash
# Verifica fallback
php artisan lang:fallback --test

# Debug traduzioni
php artisan tinker
>>> __('key', [], 'it')  // Testa fallback
```

---

### **3. Cache Corrotta**

#### **Problema: Traduzioni Non Aggiornate**
```bash
# 1. Pulizia completa
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan lang:cache --clear

# 2. Ricrea cache
php artisan lang:cache

# 3. Verifica
php artisan lang:cache --status
```

---

## 🛠️ **Strumenti di Debug**

### **1. Comandi Artisan**
```bash
# Gestione traduzioni
php artisan lang:validate          # Validazione
php artisan lang:report            # Report qualità
php artisan lang:fix               # Fix automatici
php artisan lang:cache             # Gestione cache
php artisan lang:benchmark         # Test performance
php artisan lang:debug             # Debug mode
php artisan lang:fallback          # Test fallback
php artisan lang:memory-usage      # Uso memoria
```

### **2. Debug Mode**
```php
// Abilita debug
config(['lang.debug.enabled' => true]);

// Log dettagliato
Log::channel('translations')->info('Translation loaded', [
    'key' => 'welcome',
    'locale' => 'it',
    'value' => 'Benvenuto'
]);
```

### **3. Tinker Debug**
```bash
php artisan tinker

# Test traduzioni
>>> __('lang::messages.welcome')
>>> __('fields.name.label')
>>> app('translator')->getLocale()
>>> app('translator')->getFallback()
```

---

## 📊 **Monitoraggio e Metriche**

### **1. Metriche Performance**
```bash
# Benchmark completo
php artisan lang:benchmark --detailed

# Output esempio:
# Loading time: 45ms
# Memory usage: 2.3MB
# Cache hit rate: 98%
# Translation count: 1,247
```

### **2. Qualità Traduzioni**
```bash
# Report qualità
php artisan lang:report --format=json

# Output esempio:
# {
#   "completeness": 95.2,
#   "missing_keys": 23,
#   "syntax_errors": 0,
#   "quality_score": "A"
# }
```

### **3. Monitoraggio Real-time**
```php
// Abilita monitoring
'debug' => [
    'log_performance' => true,
    'log_missing_keys' => true,
    'log_channel' => 'translations'
]
```

---

## 🔒 **Problemi di Sicurezza**

### **1. Validazione File**
```bash
# Verifica integrità file
php artisan lang:security:scan

# Controllo dimensioni
php artisan lang:security:check-size

# Scan codice malevolo
php artisan lang:security:scan-malicious
```

### **2. Rate Limiting**
```php
// Configurazione protezione
'security' => [
    'rate_limiting' => [
        'enabled' => true,
        'max_requests' => 100,
        'time_window' => 60
    ]
]
```

---

## 📋 **Checklist Troubleshooting**

### **Problema Generico**
- [ ] Verifica cache e configurazione
- [ ] Controllo file traduzioni
- [ ] Validazione sintassi
- [ ] Test fallback
- [ ] Monitor performance

### **Problema Specifico**
- [ ] Identifica sintomi precisi
- [ ] Esegui diagnostica appropriata
- [ ] Applica soluzione specifica
- [ ] Verifica risoluzione
- [ ] Documenta soluzione

### **Prevenzione**
- [ ] Validazione automatica
- [ ] Monitor performance
- [ ] Backup regolari
- [ ] Test regressione
- [ ] Documentazione aggiornata

---

## 🚨 **Emergenze e Rollback**

### **1. Rollback Rapido**
```bash
# Rollback ultima versione
php artisan lang:rollback --version=previous

# Ripristino backup
php artisan lang:restore --backup=latest

# Reset configurazione
php artisan lang:reset --force
```

### **2. Modalità Emergenza**
```php
// Configurazione emergenza
'emergency_mode' => [
    'enabled' => true,
    'fallback_locale' => 'en',
    'disable_cache' => true,
    'log_all_errors' => true
]
```

---

## 🔗 **Risorse e Supporto**

### **1. Documentazione**
- [README.md](README.md) - Documentazione principale
- [BEST_PRACTICES.md](BEST_PRACTICES.md) - Best practices
- [config/lang.php](../config/lang.php) - Configurazione

### **2. Comandi Utili**
```bash
# Help comandi
php artisan lang:help
php artisan lang:list-commands

# Info sistema
php artisan lang:info
php artisan lang:status
```

### **3. Log e Debug**
```bash
# Visualizza log
tail -f storage/logs/translations.log

# Debug configurazione
php artisan config:show lang
```

---

## 📝 **Template Segnalazione Bug**

### **Informazioni Sistema**
```
- Laravel Version: 12.x
- Filament Version: 3.x
- Lang Module Version: 2.0.0
- PHP Version: 8.2+
- Environment: Production/Development
```

### **Descrizione Problema**
```
- Sintomi osservati
- Comportamento atteso
- Passi per riprodurre
- Screenshot/Log errori
```

### **Informazioni Aggiuntive**
```
- Configurazione attuale
- File traduzioni coinvolti
- Moduli correlati
- Cronologia modifiche
```

---

**Ultimo aggiornamento**: Gennaio 2025  
**Versione**: 2.0.0  
**Autore**: Team Laraxot  
**Mantenuto da**: Community Laraxot
