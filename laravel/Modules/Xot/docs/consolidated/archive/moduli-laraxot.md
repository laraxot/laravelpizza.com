# Moduli Laraxot per il progetto

## Panoramica

I moduli Laraxot sono componenti fondamentali del progetto il progetto, fornendo funzionalità modulari e riutilizzabili. Questa documentazione descrive la struttura, l'installazione e l'utilizzo dei moduli Laraxot nel contesto del progetto.

## Elenco Moduli Essenziali

### Moduli Core
1. **module_xot_fila3** - Modulo base con utility e configurazioni core
2. **module_lang_fila3** - Gestione multilingua
3. **module_tenant_fila3** - Supporto multi-tenant
4. **module_user_fila3** - Gestione utenti e autenticazione

### Moduli Frontend
5. **module_ui_fila3** - Interfaccia utente base
6. **theme_one_fila3** - Tema per Filament 3 (da installare in `/laravel/Themes/One/`)

### Moduli Funzionali
7. **module_media_fila3** - Gestione media e file
8. **module_activity_fila3** - Logging e monitoraggio attività
9. **module_gdpr_fila3** - Gestione privacy e GDPR
10. **module_notify_fila3** - Sistema di notifiche
11. **module_cms_fila3** - Gestione contenuti
12. **module_job_fila3** - Gestione job in background

## Struttura dei Namespace

I moduli Laraxot utilizzano una struttura particolare per i namespace:

1. **Struttura fisica**: I file si trovano nella sottodirectory `app/` del modulo
   - Esempio: `Modules/Chart/app/Providers/ChartServiceProvider.php`

2. **Namespace logico**: Nonostante la posizione fisica, il namespace NON include "App"
   - Esempio: `Modules\Chart\Providers\ChartServiceProvider`

3. **Configurazione autoload**: Nel composer.json di ogni modulo è specificato:
   ```json
   "autoload": {
       "psr-4": {
           "Modules\\ModuleName\\": "app/"
       }
   }
   ```

## Installazione dei Moduli

Per installare un modulo Laraxot, utilizzare il seguente comando:

```bash
git subtree add --prefix laravel/Modules/[NomeModulo] git@github.com:laraxot/[nome_repository].git dev --squash
```

### Ordine di Installazione (in base alle dipendenze)
1. module_xot_fila3 (base)
2. module_lang_fila3 (dipende da Xot)
3. module_tenant_fila3 (dipende da Xot)
4. module_ui_fila3 (dipende da Xot)
5. module_user_fila3 (dipende da Xot, Tenant)
6. module_media_fila3 (dipende da Xot)
7. module_activity_fila3 (dipende da Xot, User)
8. module_gdpr_fila3 (dipende da Xot, User)
9. module_notify_fila3 (dipende da Xot, User)
10. module_cms_fila3 (dipende da Xot, Media)
11. module_job_fila3 (dipende da Xot)
12. theme_one_fila3 (dipende da UI) - Da installare in `/laravel/Themes/One/`

## Separazione tra Moduli e Temi

È fondamentale mantenere la corretta separazione tra moduli e temi:

1. **Moduli**: Componenti funzionali che vanno posizionati in `/laravel/Modules/`
   - Esempi: Xot, Lang, User, Tenant, Gdpr, etc.
   - Implementano logica di business e funzionalità

2. **Temi**: Componenti di presentazione che vanno posizionati in `/laravel/Themes/`
   - Il tema principale ThemeOne va in `/laravel/Themes/One/`
   - Implementano layout, stili e componenti UI

### Installazione dei Temi
```bash
git subtree add --prefix laravel/Themes/One git@github.com:laraxot/theme_one_fila3.git dev --squash
```

## Compatibilità con Laravel 12

Laravel 12 introduce un cambiamento architetturale nella gestione dei service provider che impatta l'integrazione con i moduli Laraxot:

1. **Nuova struttura config/app.php**: In Laravel 12 questo file è semplificato e NON include più le sezioni "providers" e "aliases"

2. **Service provider**: Laravel 12 utilizza auto-discovery e bootstrap minimalista invece di elenchi espliciti di provider

3. **Soluzione corretta**:
   - Rimuovere completamente le sezioni `providers` e `aliases` dal file config/app.php
   - Mantenere solo le configurazioni base come name, env, debug, url, timezone, locale
   - Affidarsi all'auto-discovery per caricare i service provider dei moduli

## Configurazione Composer

Nel progetto il progetto, è fondamentale NON includere la riga `"Modules\\": "Modules/"` nel file composer.json:

```json
"autoload": {
    "psr-4": {
        "App\\": "app/",
        "Database\\Factories\\": "database/factories/",
        "Database\\Seeders\\": "database/seeders/"
    }
}
```

Dopo qualsiasi modifica al composer.json, eseguire sempre:
- `composer dump-autoload`
- `php artisan optimize:clear`
