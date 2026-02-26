---
title: Errori Comuni
description: Come Risolvere gli Errori più Comuni
extends: _layouts.documentation
section: content
---

# Come Risolvere gli Errori più Comuni {#issues}

### Errore **Secret is not set in JWTAuth**. Dalla cartella laravel:

```bash
php artisan jwt:secret
```

### Errore: include(/var/www/base_BASE/laravel/vendor/composer/../../Modules/NOME_MODULO/Models/FILE.php): Failed to open stream: No such file or directory se il file esiste. Dalla cartella laravel:
    
```bash
composer dump autoload
```

- alternativa: controllare se il namespace del file è giusto

### Target class [\Modules\BASE\Models\FILE.php] does not exist. Dalla cartella laravel:

- mettere l'esensione della migrations FILE a .old

### Errore StubService riga 418 (StubService:418). 

Significa che devi spostare il modello dal vendor al nostro modulo ed estenderlo, e cambiare in config la path nel nostro modulo.
Gli stub sono dei file da dove poi vengono generati i modelli, pannelli e altri file di partenza.

### pagina 404 

controlla le route con uno dei seguenti comandi e vedi se esistono:

da url:

```bash
http://VIRTUAL_HOST.EXT/?_act=artisan&cmd=routelist1
```

oppure:
```bash
http://VIRTUAL_HOST.EXT/?_act=artisan&cmd=routelist
```

oppure da terminale:

```bash
php artisan route:list
```

- Se vedi poche route solo di base allora devi abilitare tutti i moduli, forse anche in tutti i file modules_status.json

- Se non funzionasse metti in 404.blade.php (guarda il percorso nel quale ti trovi nella debug bar) il seguente codice:

```php
{{ dddx(get_defined_vars()) }}
```

potrebbe dare una spiegazione dell’errore nella variabile message. Ad esempio se è un nuovo modulo potrebbe mancare _ModulePanel e /Policies/_ModelPanelPolicy

### pagina 403 su un modulo

controlla su XotBasePanelPolicy home se hai l’area abilitata.

Per farlo puoi andare su pagina 403 e fare:

```php
@php
dddx($profile->hasArea('NOME_AREA'));
@endphp
```

### The "/var/www/html/BASE/laravel/Modules/Test/Providers/../Http/Livewire" directory does not exist

Aggiungere la cartella nel MODULO/Http/Livewire con dentro il file .gitkeep

### file_put_contents(/var/www/html/BASE/laravel/Modules/Test/Providers/../Http/Livewire/_components.json): Failed to open stream: Permission denied 

```bash
sudo chmod PERMESSI_CORRETTI -R .
```

### Errore: Livewire encountered corrupt data when trying to hydrate the [modules.MODULO.http.livewire.form.nexi.payment] component. 

Ensure that the [name, id, data] of the Livewire component wasn't tampered with between requests.

Vedere di non aver passato dati name, id e data o variabili riservate

Analizzare che parametri siano stati passati con la richiesta.

IMPORTANTE: sui modal pro non serve il mount, basta dichiarare le variabili nella classe e passarli come public tramite l’emit

### Errore “Unable to call component method. Public method [METODO] not found on component: [COMPONENTE ESTESO]” 

Il div nella view potrebbe non essere stato chiuso correttamente, o potrebbe essere stato chiuso due volte. Formattare view e controllare

### Errore Cannot declare interface Modules\MODULO\Contracts\PanelContract, because the name is already in use, se non è vero che è già in uso il nome
Dalla cartella laravel:

```bash
composer dumpautoload
```

### Se lavorando con l’assegnazione dei ruoli hai l’errore “The given role or permission should use guard `` instead of `web`” a volte può essere risolto mettendo nel modello che ha il ruolo da associare:

```php
protected $guard_name = 'web';
```

### Errore 500 e PAGINA BIANCA oppure PAGINA NERA

Leggeva un allegato pdf con l’id sbagliato (id di company invece di profile).

Per scoprire il problema ho dovuto fare **debug del file “laravel/vendor/laravel/framework/src/Illuminate/Mail/Mailer.php”** sul **metodo sendSymfonyMessage** e aggiungere il **catch(\Exception $e)**.

Poi tolto perchè **non vanno mai modificati i vendor**.

### Errore delle tabelle temporanee di Sushi

Esempio:

```php
SQLSTATE[HY000]: General error: 1 no such table: homes (Connection: , SQL: select * from "homes" where ("id" = 1) limit 1)
```

Soluzione:

Nella cartella **STORAGE: cancellare le tabelle temporanee di Sushi**

### TIPS

Altri trucchi e sistemi per risolvere errori o installare server sono scritti nella cartella ./bashscripts/tips/

### BACKUP DEL PROGETTO

E' possibile fare un backup del progetto con il file

```bash
./bashscripts/backup.sh
```


