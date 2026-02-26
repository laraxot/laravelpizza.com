# Installazione Iniziale il progetto

## Prerequisiti

- PHP 8.2 o superiore
- Composer
- Git
- MySQL 8.0 o superiore
- Node.js e NPM (per la compilazione degli asset)

## Procedura di Installazione

Seguire rigorosamente questi passaggi nell'ordine indicato per garantire una corretta installazione del progetto il progetto.

### 1. Installazione Laravel Installer

```bash
composer global require laravel/installer
```

### 2. Creazione Progetto Laravel

È fondamentale creare il progetto nella posizione corretta:

```bash
cd /var/www/html/<nome progetto>
laravel new laravel
```

> ⚠️ **IMPORTANTE**: 
> - Il progetto DEVE essere installato in `/var/www/html/<nome progetto>/laravel`
> - NON utilizzare variazioni come `laravel new <nome progetto>` o `laravel new laravel --version=X.Y`
> - NON creare il progetto in `/var/www/html/<nome progetto>/public_html` o altre posizioni

### 3. Installazione Laravel Modules

```bash
cd laravel
composer require nwidart/laravel-modules
```

### 4. Pubblicazione Configurazione Laravel Modules

```bash
php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"
```

### 5. Configurazione Database

Modificare il file `.env` con le credenziali del database:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<nome progetto>
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Configurazione Composer

Verificare che il file `composer.json` NON contenga la riga `"Modules\\": "Modules/"` nella sezione `autoload`:

```json
"autoload": {
    "psr-4": {
        "App\\": "app/",
        "Database\\Factories\\": "database/factories/",
        "Database\\Seeders\\": "database/seeders/"
    }
}
```

### 7. Installazione BashScripts

```bash
git subtree add -P bashscripts git@github.com:laraxot/bashscripts_fila3.git dev --squash
```

## Correzione Installazione Errata

Se Laravel è stato installato nella posizione errata, utilizzare questo comando per spostarlo:

```bash
mv /var/www/html/<nome progetto>/public_html/laravel /var/www/html/<nome progetto>/laravel
```

## Verifica Installazione

Per verificare che l'installazione sia corretta:

```bash
cd /var/www/html/<nome progetto>/laravel
php artisan --version
```

Dovrebbe mostrare la versione di Laravel installata (Laravel 12.x).

## Passaggi Successivi

Dopo l'installazione iniziale, procedere con:

1. [Installazione Moduli](./ordine-implementazione.md) - Seguire l'ordine corretto di installazione dei moduli
2. [Configurazione Filament](../04-tecnico/filament.md) - Configurare il pannello di amministrazione
3. [Configurazione Tema](../07-frontend/temi.md) - Installare e configurare il tema ThemeOne

## Collegamenti tra versioni di installazione-iniziale.md
* [installazione-iniziale.md](docs/installazione-iniziale.md)
* [installazione-iniziale.md](docs/tecnico/installazione-iniziale.md)
* [installazione-iniziale.md](../../../Xot/project_docs/implementation/installazione-iniziale.md)

