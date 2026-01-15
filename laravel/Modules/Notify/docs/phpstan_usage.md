# Utilizzo di PHPStan nel Progetto <nome progetto>

## Esecuzione di PHPStan

PHPStan deve essere eseguito dalla directory principale di Laravel. Il comando corretto è:

```bash
cd /path/to/laravel
./vendor/bin/phpstan analyse -l 9 [percorso/al/modulo]
```

### Esempi di utilizzo

Analizzare un singolo modulo:
```bash
./vendor/bin/phpstan analyse -l 9 Modules/Notify
```

Analizzare più moduli contemporaneamente:
```bash
./vendor/bin/phpstan analyse -l 9 Modules/Rating Modules/User Modules/Notify
```

Analizzare tutti i moduli (attenzione, può richiedere tempo):
```bash
./vendor/bin/phpstan analyse -l 9 Modules/*
```

## Opzioni utili

- `-l 9` : imposta il livello di analisi a 9 (massimo)
- `--debug` : mostra ulteriori informazioni per il debugging
- `--memory-limit=2G` : imposta il limite di memoria per PHPStan (utile per progetti grandi)
- `--error-format=table` : formatta l'output come tabella
- `--no-progress` : disattiva la barra di progresso

## PHPStan e CI/CD

Quando si esegue PHPStan in un ambiente di CI/CD, è consigliabile utilizzare:

```bash
./vendor/bin/phpstan analyse -l 9 --no-progress --error-format=github Modules/*
```

## Architettura del Modulo Notify

Il modulo Notify implementa un sistema di notifiche multicanale che richiede un'attenta organizzazione strutturale per garantire l'affidabilità dell'analisi statica.

### Organizzazione Concettuale

Il modulo è organizzato seguendo il principio di separazione delle responsabilità, con differenti componenti che si occupano di:

* **Generazione notifiche**: Logica per la creazione e personalizzazione dei messaggi
* **Invio multicanale**: Adattatori per diversi canali di comunicazione (push, email, SMS)
* **Monitoraggio e tracking**: Meccanismi per tracciare le notifiche inviate

### Separazione Namespace-Directory

Il modulo segue una chiara distinzione tra organizzazione fisica e logica:

#### 1. Struttura Fisica delle Directory

* **Codice applicativo**: Risiede nella directory `app/` del modulo
  ```
  Modules/Notify/app/Models/          <-- Entità dati (Notification, Channel, ecc.)
  Modules/Notify/app/Actions/         <-- Azioni di notifica
  Modules/Notify/app/Services/        <-- Servizi di invio (in migrazione verso Actions)
  ```

* **Traduzioni**: Si trovano direttamente nella directory `lang/` del modulo
  ```
  Modules/Notify/lang/it/            <-- Traduzioni italiane delle notifiche
  Modules/Notify/lang/en/            <-- Traduzioni inglesi delle notifiche
  ```

* **Configurazione**: A livello root del modulo
  ```
  Modules/Notify/config/notification.php   <-- Configurazione canali e opzioni
  ```

La documentazione completa sulla struttura dei moduli è disponibile in `docs/directory_structure.md`.

## Risoluzione dei problemi comuni

### "Impossibile trovare file"

Se PHPStan riporta "No files found to analyse", verificare:

1. Di essere nella directory `/path/to/laravel`
2. Che il percorso al modulo sia corretto
3. Che il modulo contenga effettivamente dei file PHP

### Errori di memoria

Se si verificano errori di memoria, aumentare il limite:

```bash
php -d memory_limit=2G ./vendor/bin/phpstan analyse -l 9 Modules/*
```

### Escludere file o directory

È possibile configurare esclusioni nel file `phpstan.neon`:

```yaml
parameters:
    excludePaths:
        - Modules/*/Tests/*
        - Modules/*/Vendor/*
```

## Configurazione avanzata

Il file `phpstan.neon` nella directory Laravel contiene le configurazioni personalizzate per il progetto.
### Versione HEAD


## Collegamenti tra versioni di phpstan-usage.md
* [phpstan-usage.md](../../Chart/project_docs/phpstan-usage.md)


### Versione Incoming


---

