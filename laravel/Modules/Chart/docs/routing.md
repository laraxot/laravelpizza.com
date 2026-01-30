# Routing in il progetto

Questo documento serve come indice per la documentazione sul routing nel progetto il progetto. La documentazione dettagliata è disponibile nei moduli specifici.

## Documentazione Principale

La documentazione completa sul routing è disponibile nei seguenti moduli:

- [Documentazione Generale sul Routing](/var/www/html/base_<nome progetto>/laravel/Modules/Xot/docs/ROUTING.md) - Modulo Xot
- [Routing Frontend](/var/www/html/base_<nome progetto>/laravel/Modules/Cms/docs/frontoffice/routing.md) - Modulo Cms
- [Architettura Folio + Volt + Filament](/var/www/html/base_<nome progetto>/laravel/Modules/Xot/docs/FOLIO_VOLT_ARCHITECTURE.md) - Modulo Xot

## Principi Fondamentali

1. **File-Based Routing con Folio**
   - Non utilizzare mai `routes/web.php` per il frontend
   - Utilizzare Laravel Folio per il routing automatico
   - Creare file Blade in `Themes/{ThemeName}/resources/views/pages/`

2. **Integrazione con Filament**
   - Utilizzare Widget Filament per form complessi
   - Integrare i widget nelle pagine Folio tramite Livewire

3. **Localizzazione degli URL**
   - Includere sempre il prefisso della lingua negli URL (`/{locale}/...`)
   - Utilizzare `app()->getLocale()` per ottenere la lingua corrente

## Moduli Correlati

- [Modulo Cms](/var/www/html/base_<nome progetto>/laravel/Modules/Cms/docs/README.md) - Gestione frontend e pagine
- [Modulo Lang](/var/www/html/base_<nome progetto>/laravel/Modules/Lang/docs/README.md) - Gestione traduzioni e localizzazione
- [Modulo Xot](/var/www/html/base_<nome progetto>/laravel/Modules/Xot/docs/README.md) - Funzionalità core e architettura
- [Modulo User](/var/www/html/base_<nome progetto>/laravel/Modules/User/docs/README.md) - Gestione utenti e autenticazione

## Collegamenti tra versioni di routing.md
* [routing.md](docs/routing.md)
* [routing.md](laravel/Modules/Cms/docs/frontoffice/routing.md)

