# Abilitare il plugin `gjs-blocks-basic` in GrapesJS

Di seguito i passi per includere e attivare il plugin `gjs-blocks-basic` nel tuo `MailTemplateResource`:

## 1. Installazione
Esegui in terminale:
```bash
npm install grapesjs-blocks-basic --save-dev
```

## 2. Configurazione del plugin
Apri il file `config/filament-grapesjs.php` e aggiungi sotto la chiave `plugins`:
```php
'plugins' => [
    'gjs-blocks-basic' => [
        'src'     => asset('vendor/filament-grapesjs/grapesjs-blocks-basic.min.js'),
        'options' => [
            // eventali opzioni aggiuntive
        ],
    ],
    // altri plugin...
],
```
Se non hai ancora pubblicato gli asset JS, esegui:
```bash
php artisan vendor:publish --tag=filament-grapesjs-assets
```

## 3. Integrazione nel Resource
Nel metodo `getFormSchema()` del file:
```
Modules/Notify/app/Filament/Resources/MailTemplateResource.php
```
includi il plugin:
```php
use Dotswan\FilamentGrapesjs\Forms\Components\Grapesjs;

Grapesjs::make('page_layout')
    ->tools([
        // lista strumenti desiderati
    ])
    ->plugins([
        'gjs-blocks-basic',
        // altri plugin...
    ])
    ->settings([
        // impostazioni storageManager, styleManager, ecc.
    ])
    ->columnSpanFull()
    ->id('page_layout');
```

## 4. Rigenerazione asset
```bash
npm run dev    # oppure npm run prod
php artisan config:clear
php artisan cache:clear
```

## 5. Verifica
Apri l’interfaccia di creazione/modifica di un MailTemplate su Filament e controlla nella sidebar di GrapesJS che i blocchi base del plugin siano disponibili.
