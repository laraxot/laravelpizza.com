# Database Configuration Rule - Laraxot Architecture

## 🚨 CRITICAL RULE: NEVER ADD MANUAL MODULE CONNECTIONS TO database.php

### ❌ DO NOT DO THIS
```php
// ❌ ERRATO - Questo file non deve contenere connessioni manuali
'gdpr' => [
    'driver' => 'mysql',
    'host' => env('DB_HOST', '127.0.0.1'),
    'database' => env('DB_DATABASE_GDPR', 'laravel_gdpr'),
    'username' => env('DB_USERNAME_GDPR', 'marco'),
    'password' => env('DB_PASSWORD_GDPR', 'marco'),
    // ... altre configurazioni
],
```

### ✅ CORRECT APPROACH
Il file `config/database.php` deve contenere SOLO la connessione base:
```php
'mysql' => [
    'driver' => 'mysql',
    'host' => env('DB_HOST', '127.0.0.1'),
    'database' => env('DB_DATABASE', '<nome progetto>_data'),
    'username' => env('DB_USERNAME', 'marco'),
    'password' => env('DB_PASSWORD', 'marco'),
    // ... configurazione base
],
```

## 🏗️ ARCHITETTURA AUTOMATICA

### TenantServiceProvider gestisce automaticamente:
- **`TenantServiceProvider::registerDB()`** crea automaticamente connessioni per ogni modulo
- Copia la connessione `mysql` base per `gdpr`, `user`, `geo`, `media`, `job`, ecc.
- Configura correttamente i nomi dei database con suffissi tenant
- **NESSUNA definizione manuale richiesta**

## 🎯 CONSEGUENZE DELL'ERRORE GRAVE

### Problemi architetturali:
1. **Duplicazione pericolosa** delle connessioni
2. **Violazione del principio DRY** (Don't Repeat Yourself)
3. **Incompatibilità con multi-tenant** (schema/database separati)
4. **Problemi di configurazione dinamica** automatica

### Problemi di manutenzione:
1. **Difficoltà nel mantenimento** delle connessioni
2. **Errori di sincronizzazione** tra configurazioni
3. **Problemi nei test** e ambienti di sviluppo

## 🔧 VERIFICA DELLA CONFIGURAZIONE

### ✅ File corretti:
- `laravel/config/database.php` - SOLO connessione base `mysql`
- `laravel/config/local/<nome progetto>/database.php` - configurazione locale
- Nessuna definizione manuale di connessioni modulari

### ✅ Sistema funzionante:
- `TenantServiceProvider::registerDB()` gestisce automaticamente tutte le connessioni
- Le connessioni modulari sono create dinamicamente all'avvio
- Le configurazioni ambiente sono caricate correttamente

## 📋 REGOLE ASSOLUTE

### ❌ MAI:
1. Aggiungere definizioni manuali di connessioni modulari
2. Modificare il sistema di gestione automatica
3. Creare duplicati delle connessioni

### ✅ SEMPRE:
1. Lasciare `config/database.php` con solo la connessione base `mysql`
2. Lasciare che `TenantServiceProvider` gestisca automaticamente le connessioni
3. Usare le variabili d'ambiente per la configurazione
4. Verificare che le connessioni siano caricate correttamente

## 🚨 NO CONNECTION HACKS IN MODELS
**MAI** inserire logica di switch della connessione basata sull'environment (`app()->environment('testing')`) nel costruttore o nei metodi dei Model.
- È una pratica pessima ("cagata") che rompe la separazione dei compiti.
- La connessione deve essere gestita a livello di configurazione o dinamicamente dai Service Provider (es. `TenantServiceProvider`).
- Se un modello necessita di una connessione specifica (es. `$connection = 'activity'`), questa deve essere definita come proprietà, lasciando che il framework la risolva tramite la configurazione caricata.

## 🔄 WORKFLOW CORRETTO

### 1. Configurazione ambiente:
```bash
# .env o .env.testing
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=<nome progetto>_data
DB_USERNAME=marco
DB_PASSWORD=marco
```

### 2. TenantServiceProvider gestisce automaticamente:
- `laravel_gdpr` → connessione per modulo GDPR
- `laravel_user` → connessione per modulo User
- `laravel_geo` → connessione per modulo Geo
- ecc.

### 3. Verifica funzionamento:
```bash
php artisan optimize:clear
php artisan config:clear
```

## 🚨 AVVERTENZA CRITICA

Questo errore **non deve MAI più accadere**. La gestione automatica delle connessioni è una parte fondamentale dell'architettura Laraxot e violarla compromette l'integrità del sistema.

---

**Versione**: 1.0  
**Data**: [DATE]  
**Regola**: Fondamentale per l'architettura Laraxot