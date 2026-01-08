# Ordine di Implementazione il progetto

## Sequenza di Installazione e Configurazione

Questa guida definisce l'ordine corretto per l'implementazione del progetto il progetto, garantendo che tutte le dipendenze siano soddisfatte e che il sistema funzioni correttamente.

### 1. Installazione Base Laravel

```bash

# Installazione Laravel Installer
composer global require laravel/installer

# Creazione progetto Laravel (posizione corretta)
cd /var/www/html/<nome progetto>
laravel new laravel

# Installazione Laravel Modules
cd laravel
composer require nwidart/laravel-modules

# Pubblicazione configurazione Laravel Modules
php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"
```

### 2. Installazione Moduli Core (in ordine)

```bash

# 1. Modulo Xot (base)
git subtree add --prefix laravel/Modules/Xot git@github.com:laraxot/module_xot_fila3.git dev --squash

# 2. Modulo Lang (dipende da Xot)
git subtree add --prefix laravel/Modules/Lang git@github.com:laraxot/module_lang_fila3.git dev --squash

# 3. Modulo Tenant (dipende da Xot)
git subtree add --prefix laravel/Modules/Tenant git@github.com:laraxot/module_tenant_fila3.git dev --squash

# 4. Modulo UI (dipende da Xot)
git subtree add --prefix laravel/Modules/UI git@github.com:laraxot/module_ui_fila3.git dev --squash
```

### 3. Installazione Tema

```bash

# Tema One (dipende da UI)
git subtree add --prefix laravel/Themes/One git@github.com:laraxot/theme_one_fila3.git dev --squash
```

### 4. Installazione Moduli Funzionali (in ordine)

```bash

# 5. Modulo User (dipende da Xot, Tenant)
git subtree add --prefix laravel/Modules/User git@github.com:laraxot/module_user_fila3.git dev --squash

# 6. Modulo Media (dipende da Xot)
git subtree add --prefix laravel/Modules/Media git@github.com:laraxot/module_media_fila3.git dev --squash

# 7. Modulo Activity (dipende da Xot, User)
git subtree add --prefix laravel/Modules/Activity git@github.com:laraxot/module_activity_fila3.git dev --squash

# 8. Modulo GDPR (dipende da Xot, User)
git subtree add --prefix laravel/Modules/Gdpr git@github.com:laraxot/module_gdpr_fila3.git dev --squash

# 9. Modulo Notify (dipende da Xot, User)
git subtree add --prefix laravel/Modules/Notify git@github.com:laraxot/module_notify_fila3.git dev --squash

# 10. Modulo CMS (dipende da Xot, Media)
git subtree add --prefix laravel/Modules/Cms git@github.com:laraxot/module_cms_fila3.git dev --squash

# 11. Modulo Job (dipende da Xot)
git subtree add --prefix laravel/Modules/Job git@github.com:laraxot/module_job_fila3.git dev --squash
```

### 5. Configurazione Post-Installazione

```bash

# Aggiornamento dipendenze
composer update

# Pulizia cache
php artisan optimize:clear

# Installazione BashScripts
git subtree add -P bashscripts git@github.com:laraxot/bashscripts_fila3.git dev --squash

# Rimozione migrazioni centrali
rm -rf database/migrations

# Esecuzione migrazioni dai moduli
php artisan module:migrate
```

### 6. Implementazione Moduli Specifici del Progetto

Dopo l'installazione dei moduli base Laraxot, procedere con l'implementazione dei moduli specifici del progetto il progetto:

1. **Modulo Patient**: Gestione pazienti (gestanti)
2. **Modulo Dental**: Gestione visite odontoiatriche
3. **Modulo Report**: Generazione report e statistiche

### 7. Configurazione Filament Admin Panel

```bash

# Pubblicazione configurazione Filament
php artisan vendor:publish --tag=filament-config

# Creazione risorse Filament per i moduli
php artisan make:filament-resource Patient
php artisan make:filament-resource DentalVisit
```

### 8. Implementazione Frontend

1. Personalizzazione tema ThemeOne
2. Implementazione form pubblici
3. Configurazione dashboard

### 9. Testing e Deployment

1. Esecuzione test unitari e di integrazione
2. Configurazione ambiente di produzione
3. Deployment iniziale
