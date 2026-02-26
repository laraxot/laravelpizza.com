# Eccezioni alla Regola della Directory app in Laraxot <nome progetto>

## Panoramica

Mentre la regola principale in Laraxot <nome progetto> richiede che tutto il codice PHP *dell'applicazione* sia posizionato all'interno della sottodirectory `app` del modulo, esistono eccezioni legittime a questa regola che non devono essere spostate.

## Eccezioni Standard (NON spostare in app/)

I seguenti file e directory PHP devono rimanere **NELLA RADICE del modulo** e non devono essere spostati nella cartella `app/`:

### 1. File di Configurazione (config/)

```
Modules/NomeModulo/config/*.php
```

Questi file contengono configurazioni specifiche del modulo e **devono rimanere nella directory principale** per essere riconosciuti dal framework.

### 2. File di Database (database/)

```
Modules/NomeModulo/database/migrations/*.php
Modules/NomeModulo/database/seeders/*.php
Modules/NomeModulo/database/factories/*.php
```

Questi file di database **devono rimanere nella directory principale** per essere caricati correttamente.

### 3. File di Route (routes/)

```
Modules/NomeModulo/routes/*.php
```

I file di route **devono rimanere nella directory principale** per essere caricati dal sistema di routing.

### 4. File di Vista (resources/)

```
Modules/NomeModulo/resources/views/**/*.php
```

Le viste Blade (.blade.php) **devono rimanere nella directory principale** per essere caricate dal sistema di template.

### 5. File di Localizzazione (lang/)

```
Modules/NomeModulo/lang/**/*.php
```

I file di localizzazione **devono rimanere nella directory principale**:

✅ CORRETTO:
```
/var/www/html/_bases/base_<nome progetto>_fila3/laravel/Modules/Rating/lang/it/rating.php
```

❌ ERRATO:
```
/var/www/html/_bases/base_<nome progetto>_fila3/laravel/Modules/Rating/app/lang/it/rating.php
```

## Eccezioni Tecniche (NON spostare in app/)

### 1. File di Configurazione degli Strumenti

I seguenti file devono rimanere nella radice del modulo:

```
Modules/NomeModulo/.php-cs-fixer.php
Modules/NomeModulo/.php-cs-fixer.dist.php
Modules/NomeModulo/.php_cs.dist.php
Modules/NomeModulo/phpstan.neon.php
Modules/NomeModulo/phpstan_constants.php
```

### 2. Directory Nascoste

```
Modules/NomeModulo/.vscode/*.php
Modules/NomeModulo/.idea/*.php
```

## Riepilogo delle Posizioni Corrette

| File/Directory | Posizione Corretta | Posizione Errata |
|----------------|-------------------|------------------|
| Codice dell'applicazione (Controllers, Models, ecc.) | `Modules/NomeModulo/app/...` | `Modules/NomeModulo/...` |
| File di configurazione | `Modules/NomeModulo/config/...` | `Modules/NomeModulo/app/config/...` |
| File di database | `Modules/NomeModulo/database/...` | `Modules/NomeModulo/app/database/...` |
| File di route | `Modules/NomeModulo/routes/...` | `Modules/NomeModulo/app/routes/...` |
| File di localizzazione | `Modules/NomeModulo/lang/...` | `Modules/NomeModulo/app/lang/...` |
| File di vista | `Modules/NomeModulo/resources/views/...` | `Modules/NomeModulo/app/resources/views/...` |

## Configurazione degli Script

I nostri script di verifica e correzione escludono automaticamente queste posizioni legittime. Se vedi un messaggio che suggerisce di spostare questi file in app/, ignoralo - è un falso positivo.

## Aggiungere Nuove Eccezioni

Se è necessario aggiungere una nuova eccezione alla regola, assicurarsi di:

1. Documentarla in questo file
2. Aggiungerla agli script di verifica
3. Includere una giustificazione per la sua inclusione

## Perché Queste Eccezioni Sono Necessarie

Mentre la regola della directory `app` è importante per la coerenza e l'autoloading, queste eccezioni esistono per i seguenti motivi:

1. **Compatibilità con Laravel**: Il framework si aspetta certi file in posizioni specifiche
2. **Convenzioni di Modularità**: Alcuni file devono seguire convenzioni specifiche per il loading modulare
3. **Funzionalità degli Strumenti**: Certi strumenti di sviluppo richiedono file di configurazione in posizioni specifiche
4. **Separazione delle Responsabilità**: Separare il codice applicativo dai file di supporto migliora la manutenibilità 