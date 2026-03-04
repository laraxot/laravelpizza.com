# CRITICAL ANALYSIS - Database Configuration Issue

## 🚨 PROBLEMA GRAVE IDENTIFICATO

**Il tuo file `config/local/laravelpizza/database.php` è SBAGLIATO!**

Hai violato la regola FONDAMENTALE del progetto: **NESSUNA connessione per-modulo nel database config!**

---

## ❌ **COSA HAI SBAGLIATO**

### 1. **Connessioni Modulari VIETATE**
```php
// ❌ SBAGLIATO - TUTTE QUESTE CONNESSIONI VANNO RIMOSE!
'notify' => [...],
'geo' => [...],
'media' => [...],
'job' => [...],
'xot' => [...],
'activity' => [...],
'cms' => [...],
'gdpr' => [...],
'lang' => [...],
'meetup' => [...],
'seo' => [...],
'tenant' => [...],
```

### 2. **Logica Corretta (Reference Laravel 12.x)**
```php
// ✅ CORRETTO - Structure UFFICIALE Laravel 12
return [
    'default' => env('DB_CONNECTION', 'mysql'),
    
    'connections' => [
        'mysql' => [...], // Una sola connessione standard
        'sqlite' => [...], // Più driver se servono
    ],
    
    // MAI NESSUNA CONNESSIONE PER-MODULO QUI!
];
```

### 3. **Come Dovevbero Funzionare le Connessioni Modulari**

Nel tuo file `config/local/laravelpizza/database.php` DOVRE contenere SOLO:
```php
<?php

return [
    // Heritata tutto dal file database.php standard
    // Niente di specifico qui!
];
```

Le connessioni modulari (`notify`, `geo`, etc.) vengono aggiunte **AUTOMATICAMENTE** da `TenantServiceProvider::registerDB()`!

---

## 🎯 **SOLUZIONE CORRETTIVA**

### **1. Rimuovi Tutte le Connessioni Modulari**

Sostituisci l'intero contenuto del file con:

```php
<?php

declare(strict_types=1);

/**
 * Database Configuration for laravelpizza tenant
 * 
 * ERRORE CRITICO: In questo file NON devono essere definite connessioni modulari!
 * Le connessioni modulari vengono gestite da TenantServiceProvider::registerDB()
 * 
 * @see Modules/Tenant/docs/database-config-standard.md
 * @see Modules/Tenant/app/Providers/TenantServiceProvider.php
 */

return [
    // Questa configurazione eredita tutto da config/database.php
    // NON definire connessioni modulari qui!
];
```

### **2. Verifica il TenantServiceProvider**

Assicurati che in `Modules/Tenant/app/Providers/TenantServiceProvider.php` ci sia:

```php
#[Override]
public function register(): void
{
    parent::register();
    
    // Registra automaticamente le connessioni modulari
    $this->registerDB();
}
```

---

## 📋 **REGOLA DA RICORDARE SEMPRE**

### **Database Configuration Pattern (Laravel 12 Standard)**

#### ✅ **CORRETTO**
```
config/database.php              → Connessioni standard (mysql, sqlite, pgsql)
config/local/tenant/database.php  → Vuoto, eredita dal parent
```

#### ❌ **SBAGLIATO**
```
config/local/tenant/database.php  → Connessioni per-modulo ❌
```

**PERCHÉ**: Le connessioni modulari vengono gestite dinamicamente da TenantServiceProvider e devono usare **LA STESSA CONNESSIONE** del database principale!

---

## 🔧 **Correzione Immediata**

Esegui questo comando per correggere:

```bash
# Backup del file sbagliato
cp /var/www/_bases/base_laravelpizza/laravel/config/local/laravelpizza/database.php \
   /var/www/_bases/base_laravelpizza/laravel/config/local/laravelpizza/database.php.backup

# Sostituisci con la versione corretta
cat > /var/www/_bases/base_laravelpizza/laravel/config/local/laravelpizza/database.php << 'EOF'
<?php

declare(strict_types=1);

/**
 * Database Configuration for laravelpizza tenant
 * 
 * IMPORTANTE: Le connessioni modulari sono gestite da TenantServiceProvider
 * Questo file eredita la configurazione standard da config/database.php
 */

return [
    // Configuration inherited from config/database.php
    // Modular connections (notify, geo, media, etc.) are registered
    // automatically by TenantServiceProvider::registerDB()
];
EOF

echo "Database configuration corrected!"
```

---

## 🧠 **Documentazione da Aggiornare**

### 1. Memory File da Creare
`Modules/Meetup/docs/memories/database-config-critical.md`

### 2. Documentation da aggiornare
`Modules/Tenant/docs/database-config-laravel-12-standard.md`

### 3. Rules da aggiornare
`.cursor/rules/database-config-standard.mdc`

---

## ⚡ **IMPATTO SE NON CORREGGI**

**Se non correggi questo problema:**
- ⚠️ Le connessioni modulari non funzioneranno
- ⚠️ Potrebbero verificarsi errori "database not found"
- ⚠️ Il sistema potrebbe usare connessioni errate
- ⚠️ Multi-tenancy non funzionerà correttamente

---

## 🎯 **CONCLUSIONE**

**QUESTO È IL PROBLEMA PIÙ GRAVE TROVATO!**

Il file database.php tenant contiene connessioni che **NON DOVREBBERO ESSERCI Lì**. Questo viola il principio fondamentale dell'architettura Laraxot e può rompere l'intera applicazione.

**PRIORITÀ MASSIMA**: Correggi immediatamente questo file!

---

**AGGIORNATO**: 2026-02-02  
**SEVERITÀ**: 🔴 CRITICAL  
**STATO**: 🚠 DA CORREGGERE SUBITO