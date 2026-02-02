# Database Configuration Standard - Laravelpizza (Laravel 12.x)

## 📋 Overview

Questo documento definisce la configurazione database standard per il progetto Laravel Pizza che segue la filosofia Laravel 12.x con multi-tenant support.

## 🎯 Filosofia Laravel 12.x

### **Single Database Connection**
- ✅ **Una sola connessione principale** (`mysql`)
- ✅ **Multi-tenant tramite database/schema separati**
- ✅ **Modular connections gestite automaticamente**

### **Configurazione Base**
```php
'default' => env('DB_CONNECTION', 'mysql'),
'connections' => [
    'mysql' => [ /* singola connessione */ ],
    'sqlite' => [ /* fallback */ ],
],
```

## 📁 File Principali

### **1. `/config/database.php`** (Laravel Standard)
- Configurazione base di Laravel 12.x
- Singola connessione `mysql`
- Supporto per SQLite fallback

### **2. `/config/local/laravelpizza/database.php`** (Tenant Override)
- Eredita configurazione standard
- Aggiunge supporto Redis
- NON deve avere connessioni modulari

## 🔧 Configurazione Corretta

### **database.php (Laravel Standard)**
```php
return [
    'default' => env('DB_CONNECTION', 'sqlite'),
    'connections' => [
        'sqlite' => [ /* ... */ ],
        'mysql' => [ /* ... */ ],
    ],
    'migrations' => [ /* ... */ ],
    'redis' => [ /* ... */ ],
];
```

### **database.php (Tenant Override)**
```php
return [
    'default' => env('DB_CONNECTION', 'mysql'),
    'connections' => [
        'mysql' => [ /* singola connessione */ ],
        'sqlite' => [ /* fallback */ ],
    ],
    'migrations' => [ /* ... */ ],
    'redis' => [ /* ... */ ],
];
```

## ❌ Configurazione Errata (Da Eliminare)

### **NON fare mai questo:**
```php
// ❌ ERRATO - Connessioni multiple per modulo
'notify' => [ /* ... */ ],
'geo' => [ /* ... */ ],
'media' => [ /* ... */ ],
'job' => [ /* ... */ ],
'xot' => [ /* ... */ ],
'activity' => [ /* ... */ ],
'cms' => [ /* ... */ ],
'gdpr' => [ /* ... */ ],
'lang' => [ /* ... */ ],
'meetup' => [ /* ... */ ],
'seo' => [ /* ... */ ],
'tenant' => [ /* ... */ ],
```

## ✅ Come Funziona il Multi-Tenant

### **TenantServiceProvider::registerDB()**
- ✅ Registra automaticamente connessioni modulari
- ✅ Gestisce database separati per ogni modulo
- ✅ Aggiorna configurazione dinamicamente

### **Struttura Database per Multi-Tenant**
```
laravelpizza/                    # Database principale
├── laravelpizza_notify_test/   # Database modulo Notify
├── laravelpizza_geo_test/      # Database modulo Geo
├── laravelpizza_media_test/    # Database modulo Media
└── ...
```

## 🚨 Problemi Identificati

### **Problema 1: Connessioni Modulari**
- ❌ File attuale ha connessioni multiple
- ❌ Violano filosofia Laravel 12.x
- ❌ Duplicano funzionalità TenantServiceProvider

### **Problema 2: Configurazione Inconsistente**
- ❌ Mischia configurazione Laravel e Tenant
- ❌ Difficoltà nel debugging
- ❌ Problemi di performance

## 📋 Checklist di Correzione

### **Fase 1: Aggiornare database.php**
- [ ] Rimuovere connessioni modulari
- [ ] Mantenere solo `mysql` e `sqlite`
- [ ] Seguire struttura Laravel standard

### **Fase 2: Verificare TenantServiceProvider**
- [ ] `registerDB()` registra connessioni modulari
- [ ] Configurazione automatica funziona
- [ ] Nessuna duplicazione necessaria

### **Fase 3: Test Database**
- [ ] Connessione principale funziona
- [ ] Multi-tenant gestito correttamente
- [ ] Nessun errore di connessione

## 🔍 Come Verificare

### **Test Connessione Principale**
```bash
php artisan tinker
>>> DB::connection()->getPdo();
```

### **Test Multi-Tenant**
```bash
php artisan tinker
>>> app('tenant')->id;
>>> config('database.connections.notify');
```

## 📚 Riferimenti Ufficiali

### **Laravel 12.x Database Docs**
- https://laravel.com/docs/12.x/database
- https://laravel.com/docs/12.x/multi-database

### **Tenant Package Docs**
- `Modules/Tenant/docs/`
- `Modules/Tenant/app/Providers/TenantServiceProvider.php`

## 🎯 Regole Fondamentali

### **1. Single Connection Rule**
> **MAI** avere più di una connessione `mysql` attiva

### **2. Multi-Tenant Rule**
> Le connessioni modulari devono essere gestite automaticamente

### **3. Inheritance Rule**
> Il file tenant override eredita sempre dalla configurazione standard

### **4. No Duplication Rule**
> Nessuna configurazione duplicata tra file diversi

## 🔄 Workflow di Sviluppo

### **Creazione Nuovo Modulo**
1. Definire schema database
2. Creare migration
3. TenantServiceProvider gestisce connessione automaticamente
4. Test multi-tenant

### **Debug Database**
1. Verificare `config('database.default')`
2. Testare `DB::connection()->getPdo()`
3. Controllare `app('tenant')->id`
4. Verificare `config('database.connections.*')`

## 📞 Supporto

### **File Relativi**
- `/config/database.php` - Configurazione base
- `/config/local/laravelpizza/database.php` - Override tenant
- `/Modules/Tenant/app/Providers/TenantServiceProvider.php` - Gestione connessioni
- `/Modules/Tenant/docs/` - Documentazione tenant

### **Comandi Utili**
```bash
php artisan config:cache
php artisan config:clear
php artisan optimize
```

---

**Ultimo Aggiornamento**: 2026-02-02  
**Versione**: 1.0  
**Stato**: ✅ Configurazione Standard Definita