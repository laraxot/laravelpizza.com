# Tenant Config Path - Practical Guide

**Data**: 2026-01-08
**Status**: ✅ Guida Pratica Completa
**Scopo**: Guida pratica per sviluppatori su come usare correttamente i path tenant config

---

## 🎯 Quick Reference

### ✅ Path CORRETTO (Usare SEMPRE questo)

```bash
/var/www/_bases/base_laravelpizza/laravel/config/local/laravelpizza/
```

### ❌ Path SBAGLIATO (NON usare)

```bash
/var/www/_bases/base_laravelpizza/laravel/config/laravelpizza.local/
```

---

## 📁 Struttura Directory Corretta

```
config/
└── local/                              ← Environment (local development)
    └── laravelpizza/                   ← Tenant name
        ├── app.php                     ← Override Laravel config
        ├── database.php                ← Override database config
        ├── database/
        │   └── content/
        │       ├── pages/              ← JSON page content
        │       │   ├── home.json
        │       │   ├── contact.json
        │       │   └── events.json
        │       └── sections/           ← JSON section content
        │           ├── header.json
        │           └── footer.json
        └── lang/                       ← Translations override
            └── it/
                └── custom.php
```

---

## 🔍 Come Verificare il Path Corretto

### 1. Check con GetTenantNameAction

```bash
php artisan tinker
```

```php
$action = app(\Modules\Tenant\Actions\GetTenantNameAction::class);
$tenantName = $action->execute();
echo $tenantName;  // Output: "local/laravelpizza"

$configPath = config_path($tenantName);
echo $configPath;  // Output: /var/www/.../config/local/laravelpizza
```

### 2. Check File Esistenti

```bash
# Path CORRETTO - i file REALI usati dall'app
ls -la /var/www/_bases/base_laravelpizza/laravel/config/local/laravelpizza/database/content/pages/
# Output: home.json, contact.json, events.json (timestamp recente)

# Path SBAGLIATO - copia/backup non usata (se esiste)
ls -la /var/www/_bases/base_laravelpizza/laravel/config/laravelpizza.local/database/content/pages/
# Output: home.json (timestamp vecchio, non aggiornato)
```

### 3. Check con ResolveTenantConfigValueAction

```php
// In tinker
$action = app(\Modules\Tenant\Actions\Config\ResolveTenantConfigValueAction::class);
$value = $action->execute('app.name');
echo $value;  // Output: tenant-specific app name
```

---

## 💻 Uso Pratico per Sviluppatori

### Aggiungere Nuova Pagina JSON

**✅ CORRETTO**:
```bash
# Create new page
nano /var/www/_bases/base_laravelpizza/laravel/config/local/laravelpizza/database/content/pages/about.json
```

**❌ SBAGLIATO**:
```bash
# NON creare qui!
nano /var/www/_bases/base_laravelpizza/laravel/config/laravelpizza.local/database/content/pages/about.json
```

### Override Laravel Config

**Esempio**: Override database connection per tenant

**File**: `config/local/laravelpizza/database.php`
```php
<?php

declare(strict_types=1);

return [
    'default' => 'tenant_mysql',

    'connections' => [
        'tenant_mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'database' => 'laravelpizza_db',
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
        ],
    ],
];
```

**Come viene usato**:
1. Laravel carica `config/database.php` (base)
2. `ResolveTenantConfigValueAction` carica `config/local/laravelpizza/database.php`
3. Merge: base + tenant override
4. Risultato: tenant-specific database connection

### Aggiungere Traduzioni Custom

**File**: `config/local/laravelpizza/lang/it/custom.php`
```php
<?php

declare(strict_types=1);

return [
    'welcome' => 'Benvenuto su Laravel Pizza Meetups!',
    'tagline' => 'La community italiana di Laravel che si incontra davanti ad una pizza',
];
```

**Uso in Blade**:
```blade
<h1>{{ trans('custom.welcome') }}</h1>
<p>{{ trans('custom.tagline') }}</p>
```

---

## 🔧 Comandi Utili

### Verificare Config Tenant Attivo

```bash
php artisan tinker
```

```php
// Get tenant name
$tenant = app(\Modules\Tenant\Actions\GetTenantNameAction::class)->execute();
echo "Tenant: {$tenant}\n";

// Get config path
$path = config_path($tenant);
echo "Config path: {$path}\n";

// Check if exists
echo file_exists($path) ? "✅ Exists" : "❌ Missing";
```

### Elencare Tutti i Tenant

```bash
# List all tenant directories
ls -d config/*/
# Output: config/local/, config/localhost/, config/staging/, etc.

# List tenants in local environment
ls -d config/local/*/
# Output: config/local/laravelpizza/, config/local/pizzameetup/, etc.
```

### Backup Config Tenant

```bash
# Backup CORRETTO
tar -czf laravelpizza-config-backup.tar.gz config/local/laravelpizza/

# Restore
tar -xzf laravelpizza-config-backup.tar.gz -C /var/www/_bases/base_laravelpizza/laravel/
```

---

## 🐛 Troubleshooting

### Problema: Config Tenant Non Caricato

**Sintomo**: Le modifiche in `config/local/laravelpizza/app.php` non vengono applicate

**Soluzioni**:

1. **Verificare path corretto**:
   ```bash
   # Deve essere config/local/laravelpizza/, NON config/laravelpizza.local/
   ls -la config/local/laravelpizza/app.php
   ```

2. **Clear config cache**:
   ```bash
   php artisan config:clear
   ```

3. **Verificare GetTenantNameAction**:
   ```php
   // In tinker
   $tenant = app(\Modules\Tenant\Actions\GetTenantNameAction::class)->execute();
   echo $tenant;  // Deve essere "local/laravelpizza"
   ```

4. **Check file permissions**:
   ```bash
   # Config deve essere readable
   chmod -R 755 config/local/laravelpizza/
   ```

### Problema: Pagine JSON Non Trovate

**Sintomo**: Errore "Page not found" anche se JSON esiste

**Soluzioni**:

1. **Verificare path JSON**:
   ```bash
   # Deve essere in config/local/laravelpizza/database/content/pages/
   ls -la config/local/laravelpizza/database/content/pages/home.json
   ```

2. **Verificare SushiToJsons trait**:
   ```php
   // In tinker
   $page = \Modules\Cms\Models\Page::where('slug', 'home')->first();
   dd($page);  // Deve esistere
   ```

3. **Check JSON syntax**:
   ```bash
   # Validate JSON
   cat config/local/laravelpizza/database/content/pages/home.json | jq .
   ```

### Problema: Due Directory Config (local e laravelpizza.local)

**Sintomo**: Esistono sia `config/local/laravelpizza/` che `config/laravelpizza.local/`

**Soluzione**:

L'app usa **SOLO** `config/local/laravelpizza/`. La directory `config/laravelpizza.local/` può essere:
- Copia di backup creata per errore
- Esperimento di un altro sviluppatore
- Residuo di test

**Action**:
```bash
# Verificare quale è più recente
ls -lat config/local/laravelpizza/database/content/pages/home.json
ls -lat config/laravelpizza.local/database/content/pages/home.json

# Se laravelpizza.local ha file più vecchi, rimuoverla (dopo backup)
mv config/laravelpizza.local config/laravelpizza.local.backup
```

---

## 📚 Perché Questa Struttura?

**Brevemente** (per dettagli vedi [tenant-config-path-philosophy-debate.md](../../Modules/Tenant/docs/tenant-config-path-philosophy-debate.md)):

1. **Reverse Domain Pattern**: Standard industry (Java, Android, iOS)
   - `laravelpizza.local` → split su `.` → reverse → `["local", "laravelpizza"]`

2. **Environment Hierarchy**: Raggruppamento logico
   - `config/local/` = tutti i tenant su local
   - `config/staging/` = tutti i tenant su staging
   - `config/production/` = tutti i tenant su production

3. **SOLID Principles**: Environment e tenant sono dimensioni separate
   - `config/{environment}/{tenant}/` → SRP compliance

4. **Scalability**: Facile aggiungere tenant o environment
   - Nuovo tenant: `config/local/newtenant/`
   - Nuovo environment: `config/newenv/laravelpizza/`

---

## ✅ Checklist Sviluppatore

Prima di committare modifiche config tenant:

- [ ] File è in `config/local/laravelpizza/` (NON `config/laravelpizza.local/`)
- [ ] JSON syntax è valida (`cat file.json | jq .`)
- [ ] Permissions corrette (`chmod 755` directory, `chmod 644` file)
- [ ] Config cache cleared (`php artisan config:clear`)
- [ ] Testato in browser (http://127.0.0.1:8002/it)
- [ ] Documentato il cambio (se significativo)

---

## 🔗 References

- [Tenant Config Path Philosophy](../../Modules/Tenant/docs/tenant-config-path-philosophy-debate.md) - Debate completo
- [GetTenantNameAction Source](../../Modules/Tenant/app/Actions/GetTenantNameAction.php) - Codice sorgente
- [System Architecture](./system-architecture-complete.md) - Architettura completa
- [Folio JSON System](./folio-volt-json-system-complete.md) - Sistema JSON pagine

---

**Last Updated**: 2026-01-08
**Version**: 1.0.0
**Status**: ✅ Production Guide
