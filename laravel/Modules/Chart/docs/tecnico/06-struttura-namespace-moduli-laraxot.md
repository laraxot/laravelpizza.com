# Struttura dei Namespace nei Moduli Laraxot

## Introduzione

La comprensione della struttura dei namespace nei moduli Laraxot è fondamentale per risolvere i problemi di autoloading nel progetto il progetto. Questo documento descrive in dettaglio come i moduli Laraxot organizzano i namespace e come questa organizzazione influisce sulla configurazione dell'autoloading.

## Struttura Fisica vs Namespace Logico

I moduli Laraxot utilizzano una struttura particolare che differisce dalla convenzione standard Laravel:

### Struttura Fisica

```
Modules/
├── ModuleName/
│   ├── app/
│   │   ├── Providers/
│   │   │   └── ModuleNameServiceProvider.php
│   │   ├── Models/
│   │   ├── Controllers/
│   │   └── ...
│   ├── composer.json
│   ├── module.json
│   └── ...
```

### Mappatura Namespace

Nei file `composer.json` di ciascun modulo, la configurazione dell'autoloading è definita come segue:

```json
"autoload": {
    "psr-4": {
        "Modules\\ModuleName\\": "app/"
    }
}
```

Questa configurazione indica che **tutto il contenuto della directory `app/`** è mappato direttamente al namespace `Modules\ModuleName\`, **non** a `Modules\ModuleName\App\`.

Ad esempio:
- Il file `Modules/Chart/app/Providers/ChartServiceProvider.php` ha namespace `Modules\Chart\Providers`
- Il file `Modules/Xot/app/Models/User.php` ha namespace `Modules\Xot\Models`

## Implicazioni per l'Autoloading

Questa struttura ha importanti implicazioni per la configurazione dell'autoloading:

1. **Registrazione Service Provider**: Nei file `module.json`, i service provider devono essere registrati con il namespace corretto:
   ```json
   "providers": [
       "Modules\\ModuleName\\Providers\\ModuleNameServiceProvider"
   ]
   ```
   e **NON** come:
   ```json
   "providers": [
       "Modules\\ModuleName\\App\\Providers\\ModuleNameServiceProvider"
   ]
   ```

2. **Composer Main**: Nel `composer.json` principale del progetto, **non deve** esistere una mappatura come:
   ```json
   "Modules\\": "Modules/"
   ```
   poiché ciò causerebbe conflitti con l'autoloading definito nei singoli moduli.

3. **Chiamate tra Moduli**: Quando un modulo fa riferimento a classi di un altro modulo, deve utilizzare il namespace completo (es: `Modules\Chart\Models\Graph`) e non includere "App" nel percorso.

## Problemi Comuni e Soluzioni

### Errore: "Class not found"

Se si verifica un errore "Class not found" per una classe che esiste fisicamente:

1. Verificare che il namespace nel file corrisponda alla struttura sopra descritta
2. Controllare che il module.json faccia riferimento ai provider con il namespace corretto
3. Eseguire `composer dump-autoload` dopo le modifiche

### Errore: "Ambiguous class resolution"

Questo errore si verifica quando ci sono definizioni di autoloading sovrapposte:

1. Rimuovere `"Modules\\": "Modules/"` dal composer.json principale
2. Assicurarsi che ogni modulo definisca solo il proprio namespace

## Conclusioni

La corretta comprensione della struttura dei namespace dei moduli Laraxot è essenziale per la risoluzione dei problemi di autoloading. La distinzione tra la posizione fisica dei file (nella sottodirectory `app/`) e il loro namespace logico (senza `App\`) è la chiave per mantenere un sistema di autoloading funzionante e privo di conflitti nel progetto il progetto.
