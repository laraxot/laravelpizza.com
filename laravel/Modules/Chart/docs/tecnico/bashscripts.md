# Script Bash per l'Automazione del Progetto il progetto

Questa documentazione descrive gli script bash utilizzati per automatizzare vari aspetti del progetto il progetto, facilitando il processo di sviluppo, configurazione e manutenzione.

## Panoramica

Gli script bash sono stati integrati nel progetto tramite il comando:
```bash
git subtree add -P bashscripts git@github.com:laraxot/bashscripts_fila3.git dev --squash
```

Oltre agli script standard di Laraxot, sono stati sviluppati script personalizzati specifici per il progetto il progetto.

## Script Disponibili

### 1. fix-namespace.sh

**Percorso**: `/var/www/html/<nome progetto>/laravel/bashscripts/fix-namespace.sh`

**Descrizione**: Corregge automaticamente i namespace non conformi nei moduli Laraxot, risolvendo la discrepanza tra i namespace dichiarati nei file PHP e la configurazione di autoloading in composer.json.

**Funzionalità**:
- Corregge i namespace da `Modules\NomeModulo\App\` a `Modules\NomeModulo\` per allinearli alla configurazione PSR-4
- Crea un backup dei file originali prima della modifica
- Genera un log dettagliato delle modifiche apportate
- Produce un file di analisi dei namespace per tutti i moduli

**Utilizzo**:
```bash

# Per correggere tutti i moduli
cd /var/www/html/<nome progetto>/laravel
./bashscripts/fix-namespace.sh

# Per correggere un modulo specifico
./bashscripts/fix-namespace.sh NomeModulo

# Esempio per il modulo Chart
./bashscripts/fix-namespace.sh Chart
```

**Output**:
- Crea un backup nella directory `namespace_backup_YYYYMMDD_HHMMSS`
- Genera un file di log `namespace_fix_YYYYMMDD_HHMMSS.log` con i dettagli delle modifiche
- Produce un file di analisi `namespace_analysis.txt` con i namespace correnti

### 2. fix-autoloading.sh

**Percorso**: `/var/www/html/<nome progetto>/laravel/bashscripts/fix-autoloading.sh`

**Descrizione**: Script per risolvere problemi di autoloading modificando il composer.json principale.

**Funzionalità**:
- Rimuove la configurazione problematica `"Modules\\": "Modules/"` da composer.json
- Modifica `minimum-stability` da `stable` a `dev`
- Aggiorna le dipendenze per risolvere i conflitti

**Utilizzo**:
```bash
cd /var/www/html/<nome progetto>/laravel
./bashscripts/fix-autoloading.sh
```

### 3. fix-theme-location.sh

**Percorso**: `/var/www/html/<nome progetto>/laravel/bashscripts/fix-theme-location.sh`

**Descrizione**: Script per correggere il posizionamento errato del tema One, spostandolo dalla directory dei moduli alla directory dei temi.

**Funzionalità**:
- Sposta il tema dalla directory errata `/var/www/html/<nome progetto>/laravel/Modules/ThemeOne` alla directory corretta `/var/www/html/<nome progetto>/laravel/Themes/One`
- Aggiorna i namespace nei file PHP da `Modules\ThemeOne` a `Themes\One`
- Identifica tutti i riferimenti al tema in altri file del progetto
- Crea un backup del tema originale prima delle modifiche
- Fornisce istruzioni per aggiornare service provider e composer.json

**Utilizzo**:
```bash
cd /var/www/html/<nome progetto>/laravel
./bashscripts/fix-theme-location.sh
```

**Output**:
- Crea un backup nella directory `theme_backup_YYYYMMDD_HHMMSS`
- Genera un file di log `theme_fix_YYYYMMDD_HHMMSS.log` con i dettagli delle modifiche
- Produce un file `theme_references.txt` con l'elenco dei file che contengono riferimenti al vecchio namespace del tema

### 4. module-setup.sh

**Percorso**: `/var/www/html/<nome progetto>/laravel/bashscripts/module-setup.sh`

**Descrizione**: Automatizza il processo di setup e configurazione di un nuovo modulo.

**Funzionalità**:
- Crea la struttura iniziale del modulo
- Configura namespace e providers
- Imposta le dipendenze di base

**Utilizzo**:
```bash
cd /var/www/html/<nome progetto>/laravel
./bashscripts/module-setup.sh NomeModulo
```

## Script Standard di Laraxot

Oltre agli script personalizzati, sono disponibili vari script standard forniti dal repository bashscripts_fila3:

### 1. composer-update-force.sh

**Descrizione**: Esegue un aggiornamento forzato delle dipendenze composer.

**Utilizzo**:
```bash
cd /var/www/html/<nome progetto>/laravel
./bashscripts/composer-update-force.sh
```

### 2. git-pull-modules.sh

**Descrizione**: Aggiorna tutti i moduli Laraxot tramite git pull.

**Utilizzo**:
```bash
cd /var/www/html/<nome progetto>/laravel
./bashscripts/git-pull-modules.sh
```

### 3. install-all.sh

**Descrizione**: Esegue l'installazione completa del progetto.

**Utilizzo**:
```bash
cd /var/www/html/<nome progetto>/laravel
./bashscripts/install-all.sh
```

### 4. artisan-optimize.sh

**Descrizione**: Ottimizza l'applicazione Laravel.

**Utilizzo**:
```bash
cd /var/www/html/<nome progetto>/laravel
./bashscripts/artisan-optimize.sh
```

## Come Rendere Eseguibili gli Script

Prima di utilizzare qualsiasi script, assicurarsi che sia eseguibile:

```bash
chmod +x /var/www/html/<nome progetto>/laravel/bashscripts/*.sh
```

## Creazione di Nuovi Script

Per creare nuovi script di automazione:

1. Creare il file nella directory `/var/www/html/<nome progetto>/laravel/bashscripts/`
2. Iniziare il file con lo shebang `#!/bin/bash`
3. Aggiungere commenti dettagliati sul funzionamento dello script
4. Renderlo eseguibile con `chmod +x nomescript.sh`
5. Aggiornare questa documentazione per includere il nuovo script

## Best Practices

- Testare sempre gli script in un ambiente di sviluppo prima di utilizzarli in produzione
- Implementare meccanismi di backup prima di apportare modifiche ai file
- Registrare tutte le operazioni in file di log
- Gestire correttamente gli errori con messaggi chiari
- Utilizzare colori ANSI per rendere l'output più leggibile
- Implementare opzioni di aiuto o flag -h/--help per la documentazione inline

## Integrazione con il Processo di Sviluppo

Gli script bash sono parte integrante del processo di sviluppo e manutenzione del progetto il progetto:

1. Facilitano l'onboarding di nuovi sviluppatori
2. Standardizzano le procedure ripetitive
3. Riducono gli errori manuali
4. Accelerano la risoluzione dei problemi comuni
5. Documentano implicitamente le procedure operative

## Considerazioni di Sicurezza

- Non includere credenziali o informazioni sensibili negli script
- Limitare i permessi degli script al minimo necessario
- Validare sempre gli input utente
- Prestare attenzione alle operazioni che modificano file o database

## Conclusione

L'automazione tramite script bash è un elemento chiave per il successo del progetto il progetto, consentendo di gestire in modo efficiente le complessità dell'architettura modulare e risolvere rapidamente i problemi comuni. Questi script sono in continua evoluzione per soddisfare le esigenze del progetto. 
L'automazione tramite script bash è un elemento chiave per il successo del progetto <nome progetto>, consentendo di gestire in modo efficiente le complessità dell'architettura modulare e risolvere rapidamente i problemi comuni. Questi script sono in continua evoluzione per soddisfare le esigenze del progetto. 

## Collegamenti tra versioni di bashscripts.md
* [bashscripts.md](docs/bashscripts.md)
* [bashscripts.md](docs/tecnico/bashscripts.md)

