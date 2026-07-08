---
title: Struttura
description: Struttura della base e dei moduli
extends: _layouts.documentation
section: content
---

# Struttura {#structure}

###  I nostri progetti hanno una struttura modulare.

Questo significa che essendo progetti grossi, per tenere in ordine le basi suddividiamo i domini di funzionalità in moduli separati.

Ogni base ha solamente i moduli necessari per il suo funzionamento (esempio: modulo Core, modulo UI, modulo Seo e modulo Dropshipping).

###  I moduli sono gestiti dal pacchetto laravel-nwidart, quindi vi invitiamo a riferirvi alla loro documentazione.

Ogni modulo è una repository a se stante.

Quindi la base è la repository principale, e ogni modulo è un git submodule.

###  I moduli sono dei git submodules e dei moduli nwidart, e sono nella cartella laravel/Modules

Il modulo che fa da core a tutto il progetto è Xot.

Il modulo che gestisce routes e pannelli è Cms.

Il modulo che gestisce i temi è UI.

Il modulo che gestisce l'autenticazione è LU.

###  I temi sono sempre dei git submodules e dei moduli nwidart, e sono nella cartella laravel/Themes.

Utilizziamo per ogni dominio un tema di backend e uno di frontend.

###  Nella cartella laravel/config ci sono le confgurazioni di tutti i virtual hosts

I file di configurazione del virtual host principali sono in laravel/config/

Le altre configurazioni, che sovrascrivono quelle in laravel/config/, si trovano in laravel/config/EXT/DOMINIO/

- xra.php dove vengono indicati i temi di front-end e back-end di quel dominio, la lingua pricipale, il modulo principale e altri dati specifici per il vhost

- morph_map.php che associa i percorsi dei modelli ai nomi corti. Esempio:

```php
    'article' => 'Modules\Blog\Models\Article',
```

quindi le relazioni verranno create utilizzando il MorphMap, ovvero la stringa 'article' anzichè 'Modules\Blog\Models\Article'

- modules_statuses.json che è la lista dei moduli abilitati all'interno del vhost

- metatag.php dove sono indicati i metatag principali del progetto, ad esempio il titolo del progetto

- menu_VARI.php dove vengono costruiti i menu di quel vhost

- filesystems.php dove si possono inserire nuovi nomi per accedere alle cartelle o a servizi di CDN esterni

- database.php dove si possono inserire nuove connessioni ai database

- app.php dove c'è scritta la lingua utilizzata. Esempio:

```php
'locale' => 'it',
```

- altri files