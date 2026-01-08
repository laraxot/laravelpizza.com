---
title: Installazione
description: Come Installare la Base
extends: _layouts.documentation
section: content
---

# Installazione {#installation}

### virtual host & Laragon

Il progetto può utilizzare varie configurazioni, situati dentro la cartella laravel/config.  

Crearsi il virtual host con il nome del dominio uguale a quello del file di configurazione. Esempio:

- copio la cartella laravel/config/localhost in laravel/config/local/dominio/* e imposto i parametri nei file

- questo significa che il virtual host deve chiamarsi dominio.local

Noi suggeriamo l'utilizzo di Laragon perchè crea automaticamente i virtual host.
Dopo aver installato laragon, Assicurarsi di abilitate tutte le estensioni php indicate nella foto

<img class="block m-auto" src="https://laraxot.github.io/module_xot_fila3/assets/img/php-extentions.png" alt="php extentions" />  

Configurare le preferenze di laragon come in foto

<img class="block m-auto" src="https://laraxot.github.io/module_xot_fila3/assets/img/laragon-config.png" alt="laragon config" />  


Creare una cartella _bases dentro la cartella www, in questa cartella si andrà a clonare il progetto.

### Clonare la base in locale nella cartella del server, scaricando i submodules, e senza la storia delle modifiche

```bash
git clone https://NOME_BASE.git --recurse-submodules --depth=1
git submodule foreach git pull
```

Verificare che tutti i moduli siano a master

### dalla cartella "laravel" creare il file delle variabili d'ambiente .env 
    
```bash
cp .env.latest .env
```

- modificare parametri a seconda delle necessità
- dopo aver messo i nomi dei database, in phpmyadmin creare i database vuoti

### dalla cartella laravel, lanciare in bash il comando

```bash
../bashscripts/composer_init.sh
```

alternativa: 

```bash
composer update
cd Modules/Xot/Services
composer install
php artisan key:generate
```

### vedere la lista dei moduli con il comando

alternativa da terminale:

```bash
php artisan module:list 
```

### abilitare tutti i moduli con il comando

Assicurarsi che tutti i moduli siano abilitati  
in caso eseguire:

```bash
php artisan module:enable NomeModulo
```

### fare la migration

Eseguire il comando delle migrazioni per ogni modulo:

```bash
php artisan module:migrate NomeModulo
```

### per compilare il tema (da dentro la cartella laravel/Themes/NOME_TEMA)

```bash
npm install
npm run dev
```  

### creare la Giunzione

in locale, se utilizzate Laragon, dopo aver clonato il progetto bisogna creare la giunzione nella cartella www.  
Per creare la giunzione, andare nella cartella www ed eseguire tramite il prompt dei comandi 

```bash
mklink /j nome_cartella_giuzione path_della_cartella_progetto
```  

dopo riavviare il server di laragon.

Fatto ciò, andare nel browser e inserire nell'url http://nome_cartella_giuzione.local/

### lavorare nel branch dev

Sia il progetto che ogni singolo modulo hanno un branch dev, generalmente utilizzato per lo sviluppo del progetto.  

nel singolo modulo  

```bash
git branch dev
git checkout dev
git_init.sh dev
git pull origin dev
git push origin dev -u
git merge origin master
```  

dopo aver eseguito  
git branch nome_branch  
git checkout nome_branch  

se il branch di un modulo vuole essere pubblicato, eseguire nel modulo 
```bash
../../../bascripts/git_init.sh nome_branch
```  
### Versione HEAD


## Collegamenti tra versioni di installation.md
* [installation.md](../../../Xot/docs/filament/installation.md)
* [installation.md](../../../Xot/docs/installation.md)
* [installation.md](../../../Xot/docs/base/installation.md)
* [installation.md](../../../User/docs/installation.md)
* [installation.md](../../../Lang/docs/installation.md)
* [installation.md](../../../Cms/docs/installation.md)
* [installation.md](../../../../Themes/One/docs/installation.md)


### Versione Incoming


---

