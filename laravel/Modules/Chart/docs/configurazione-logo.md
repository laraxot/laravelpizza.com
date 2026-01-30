# Configurazione e Risoluzione dei Loghi in il progetto - Indice

> **Nota**: Questo documento è un indice specifico per il progetto che punta alla documentazione generica e riutilizzabile nei moduli.

## Documentazione Principale sulla Risoluzione dei Loghi

La documentazione completa sul meccanismo di risoluzione dei loghi è disponibile nei seguenti moduli (Laravel 12.x, PHP 8.2+):

### Modulo Xot

Il modulo Xot contiene la documentazione tecnica sul processo di risoluzione:

- [Risoluzione dei Loghi](../laravel/Modules/Xot/docs/LOGO_RESOLUTION.md) - Processo dettagliato di risoluzione basato sul dominio
- [Gestione Domini e Configurazioni](../laravel/Modules/Xot/docs/DOMAIN_CONFIGURATION.md) - Struttura delle configurazioni specifiche per dominio

### Standard e Linee Guida

- [Linee Guida per i Loghi](./standards/logo_guidelines.md) - Specifiche tecniche e best practices per i file SVG dei loghi

## Principi Fondamentali in il progetto

- I loghi di il progetto sono configurati nel file `metatag.php` specifico per dominio
- Per il progetto, il dominio è `<nome progetto>.local` che diventa `local/<nome progetto>`
- I percorsi ai loghi utilizzano la notazione di namespace dei moduli (es. `patient::images/logo.svg`)
- Questa notazione si traduce in percorsi fisici nei moduli (es. `laravel/Modules/Patient/resources/images/logo.svg`)

## Collegamenti Bidirezionali

### Collegamenti ai Moduli
- [LOGO_RESOLUTION.md](../laravel/Modules/Xot/docs/LOGO_RESOLUTION.md) - Documentazione tecnica sulla risoluzione dei loghi
- [DOMAIN_CONFIGURATION.md](../laravel/Modules/Xot/docs/DOMAIN_CONFIGURATION.md) - Documentazione sulla configurazione per dominio
- [MODULE_STRUCTURE.md](../laravel/Modules/Xot/docs/MODULE_STRUCTURE.md) - Struttura standard dei moduli
- [FOLIO_VOLT_ARCHITECTURE.md](../laravel/Modules/Xot/docs/FOLIO_VOLT_ARCHITECTURE.md) - Architettura Folio + Volt

### Collegamenti ad Altri Documenti nella Root
- [standards/logo_guidelines.md](./standards/logo_guidelines.md) - Linee guida tecniche e stilistiche per i loghi
- [struttura-moduli.md](./struttura-moduli.md) - Struttura dei moduli in il progetto
- [architettura-folio-volt.md](./architettura-folio-volt.md) - Architettura Folio + Volt in il progetto
- [Standard di Progetto](./standards/README.md)
- [Gestione Temi](../laravel/Modules/Cms/docs/themes.md)
- [Gestione UI](../laravel/Modules/UI/docs/README.md)

---

### Nota Importante per il progetto
Per modificare il logo di il progetto:

1. Il dominio dell'applicazione è `<nome progetto>.local`
2. Il percorso invertito è `local/<nome progetto>`
3. Il file di configurazione si trova in `laravel/config/local/<nome progetto>/metatag.php`
4. I percorsi attuali sono:
   ```php
   'logo_header' => 'patient::images/logo.svg',
   'logo_header_dark' => 'patient::images/logo.svg',
   ```
5. I file fisici si trovano in `laravel/Modules/Patient/resources/images/logo.svg`

Per cambiare il logo, sostituire i file SVG mantenendo lo stesso nome, oppure aggiornare i percorsi nel file `metatag.php` e assicurarsi che i nuovi file esistano nei percorsi specificati.
