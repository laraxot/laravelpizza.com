# Architettura Folio + Volt + Filament in il progetto

> **NOTA**: Questo documento è stato spostato nel modulo Xot per centralizzare la documentazione tecnica generica. Consulta il documento aggiornato nel link sottostante.

## Collegamenti

- [Documentazione completa sull'architettura Folio + Volt + Filament](/var/www/html/base_<nome progetto>/laravel/Modules/Xot/docs/FOLIO_VOLT_ARCHITECTURE.md)
- [Struttura dei moduli](/var/www/html/base_<nome progetto>/laravel/Modules/Xot/docs/MODULE_STRUCTURE.md)
- [Convenzioni di naming dei campi](/var/www/html/base_<nome progetto>/docs/convenzioni-naming-campi.md)
- [Flusso di registrazione](/var/www/html/base_<nome progetto>/docs/flusso-registrazione.md)

## Sommario

il progetto utilizza un'architettura moderna basata su:

1. **Laravel Folio**: per il routing basato su file
2. **Livewire Volt**: per componenti reattivi con sintassi semplificata
3. **Filament**: per form complessi e interfacce amministrative

### Regole fondamentali

- Rispettare la case sensitivity nelle directory (`resources/` è corretto, `Resources/` è errato)
- Non creare mai rotte in `routes/web.php` per il frontoffice
- Per form complessi, utilizzare sempre i widget Filament tramite Livewire
- Seguire le convenzioni di naming (`first_name`/`last_name` invece di `name`/`surname`)

Consulta la documentazione completa nel modulo Xot per maggiori dettagli.
