---
title: Introducendo Cms
description: Introduzione a Module Cms
extends: _layouts.documentation
section: content
---

# Introducendo Cms {#introducendo-cms}


Il modulo "module_Cms" è un pacchetto per Laravel che fornisce funzionalità per la gestione di un Cms all'interno di un'applicazione Laravel. Il modulo include metodi per gestire i post del Cms, le categorie e i tag, nonché per generare la struttura del Cms e le pagine del Cms.

Per utilizzare il modulo, è necessario installarlo tramite Composer con il comando composer require laraxot/module_Cms. Una volta installato, il modulo può essere utilizzato nell'applicazione Laravel tramite il seguente codice:

```php
use Laraxot\ModuleCms\Facades\ModuleCms;
```

Il modulo include diverse funzionalità per la gestione del Cms, come ad esempio il metodo createPost() per creare un nuovo post del Cms, o il metodo *getCategories()* per recuperare tutte le categorie del Cms.

Per utilizzare il modulo, è necessario prima configurare l'applicazione per supportare le funzionalità del Cms. La configurazione può essere eseguita tramite il comando Artisan *php artisan Cms:install*, che creerà le tabelle del database necessarie per gestire i post del Cms, le categorie e i tag, e aggiungerà le route e i controller per la gestione del Cms all'applicazione.

Una volta configurato il modulo, è possibile utilizzarlo per creare e gestire i post del Cms, gestire le categorie e i tag, e generare la struttura del Cms e le pagine del Cms. Per ulteriori informazioni su come utilizzare il modulo e su tutte le sue funzionalità, consultare la documentazione disponibile nel repository su GitHub.

Dipende un po da tutti i Moduli.
## Collegamenti tra versioni di introduzione.md
* [introduzione.md](laravel/Modules/Chart/docs/introduzione.md)
* [introduzione.md](laravel/Modules/Cms/docs/introduzione.md)

