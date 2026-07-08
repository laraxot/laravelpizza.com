# Strumenti di Correzione Automatica della Struttura delle Directory

## Introduzione

Il framework Laraxot PTVX richiede una struttura di directory ben definita per garantire la corretta organizzazione del codice e il funzionamento ottimale del framework. Per facilitare l'adesione a queste convenzioni, è stato sviluppato uno script di correzione automatica che analizza e sistema la struttura delle directory dei moduli.

Questo documento fornisce una guida dettagliata all'utilizzo e al funzionamento dello script di autofix.

## Lo Script di Correzione Automatica

### Posizione dello Script

Lo script si trova in:

```
bashscripts/fix_directory_structure.sh
```

### Funzionalità Principali

Lo script esegue le seguenti operazioni:

1. **Analisi della struttura delle directory**: Identifica i file che non seguono le convenzioni di Laraxot PTVX.
2. **Correzione automatica**: Sposta i file nelle posizioni corrette.
3. **Verifica finale**: Controlla che tutte le correzioni siano state applicate correttamente.

### Regole Fondamentali

Lo script applica due regole fondamentali:

1. **Il codice dell'applicazione deve essere nella directory `app/`**:
   - Models
   - Controllers
   - Enums
   - Actions
   - Datas
   - Events
   - Filament
   - Jobs
   - ecc.

2. **I file di framework devono rimanere alla radice del modulo**:
   - config
   - database
   - routes
   - lang
   - resources
   - ecc.

## Utilizzo dello Script

### Comando Base

Per correggere un singolo modulo:

```bash
./bashscripts/fix_directory_structure.sh NomeModulo
```

Per correggere tutti i moduli:

```bash
./bashscripts/fix_directory_structure.sh --all
```

### Esempio di Output

```
Correzione della struttura delle directory per il modulo Rating...
Fase 1: Identificazione dei file PHP di applicazione che devono essere in app/...
✓ Spostato: Modules/Rating/Models/Rating.php -> Modules/Rating/app/Models/Rating.php
✓ Spostato: Modules/Rating/Http/Controllers/RatingController.php -> Modules/Rating/app/Http/Controllers/RatingController.php
✓ 6 file PHP spostati in app/

Fase 2: Verifica se ci sono file di framework erroneamente in app/...
✓ Non sono stati trovati file di framework erroneamente in app/

Fase 3: Verifica dei file che sono già nella posizione corretta...
✓ 12 file di framework sono già nella posizione corretta (config, routes, lang, ecc.)

Struttura corretta per il modulo Rating.
```

## Funzionamento Interno dello Script

### Fase 1: Identificazione dei File dell'Applicazione

Lo script identifica i file che dovrebbero essere nella directory `app/` utilizzando pattern specifici:

```bash
local app_pattern="-path \"*/${MODULE}/Models/*\" -o -path \"*/${MODULE}/Http/*\" -o -path \"*/${MODULE}/Enums/*\" -o -path \"*/${MODULE}/Actions/*\" -o -path \"*/${MODULE}/Datas/*\" [...]"
```

Solo i file che corrispondono a questi pattern vengono spostati in `app/`, mantenendo la stessa struttura di sottodirectory.

### Fase 2: Correzione dei File di Framework

Lo script verifica se ci sono file di framework erroneamente posizionati nella directory `app/`:

```bash
find "$MODULE_PATH/app" -type f -name "*.php" \( -path "*/app/config/*" -o -path "*/app/routes/*" -o -path "*/app/lang/*" -o -path "*/app/database/*" \)
```

Se trovati, questi file vengono spostati nella posizione corretta alla radice del modulo.

### Fase 3: Verifica dei File Già Corretti

Lo script identifica e conta i file già posizionati correttamente, come file di configurazione, file di lingua, ecc.:

```bash
find "$MODULE_PATH" -type f -name "*.php" \( -path "*/config/*" -o -path "*/database/*" -o -path "*/routes/*" -o -path "*/lang/*" [...] \)
```

## Eccezioni e Casi Speciali

### File di Localizzazione

I file di localizzazione (`lang/`) devono rimanere alla radice del modulo e **non** devono essere spostati in `app/`:

```
Modules/Rating/lang/it/rating.php  ✓ CORRETTO (rimane qui)
```

### Configurazione

I file di configurazione (`config/`) devono rimanere alla radice del modulo:

```
Modules/Rating/config/rating.php  ✓ CORRETTO (rimane qui)
```

### Route

I file delle route devono rimanere alla radice del modulo:

```
Modules/Rating/routes/web.php  ✓ CORRETTO (rimane qui)
```

### Migrazioni e Seeder

I file di database devono rimanere alla radice del modulo:

```
Modules/Rating/database/migrations/2023_01_01_000000_create_ratings_table.php  ✓ CORRETTO (rimane qui)
```

## Verifica Manuale della Struttura

Per verificare manualmente la struttura di un modulo, puoi utilizzare questi comandi:

### Verifica dei File dell'Applicazione Fuori da app/

```bash
find Modules/Rating -path "*/Models/*" -o -path "*/Http/*" -o -path "*/Enums/*" | grep -v "/app/"
```

Qualsiasi output indica file che dovrebbero essere spostati in `app/`.

### Verifica dei File di Framework in app/

```bash
find Modules/Rating/app -path "*/config/*" -o -path "*/routes/*" -o -path "*/lang/*" -o -path "*/database/*"
```

Qualsiasi output indica file che dovrebbero essere spostati alla radice del modulo.

## Risoluzione dei Problemi

### File Non Spostati

Se alcuni file non vengono spostati, potrebbe dipendere da:

1. **Pattern mancanti**: Il pattern di riconoscimento non include il tipo di file
2. **Struttura personalizzata**: File che seguono una struttura personalizzata
3. **Permessi**: Problemi di permessi sui file

### Falsi Positivi

Lo script potrebbe incorrere in falsi positivi quando:

1. **Nomi simili**: Se un file ha un nome simile a un pattern ma non dovrebbe essere spostato
2. **File di test**: File di test che contengono pattern come "Http" o "Models" nel percorso

### Correzione Manuale

In caso di problemi, puoi sempre spostare manualmente i file:

```bash
mkdir -p Modules/Rating/app/Models
mv Modules/Rating/Models/Rating.php Modules/Rating/app/Models/
```

## Integrazione con il Workflow di Sviluppo

### Esecuzione Automatica

È consigliabile eseguire lo script come parte dei controlli pre-commit o durante la CI/CD:

```bash
# Nel pre-commit hook
./bashscripts/fix_directory_structure.sh --all
```

### Aggiornamento Incrementale

Durante lo sviluppo, è possibile eseguire lo script solo sul modulo in fase di modifica:

```bash
./bashscripts/fix_directory_structure.sh NomeModulo
```

## Conclusione

Lo script di correzione automatica della struttura delle directory è uno strumento essenziale per mantenere la coerenza e seguire le convenzioni del framework Laraxot PTVX. Utilizzandolo regolarmente, è possibile garantire che il codice segua sempre la struttura richiesta, facilitando la manutenzione e l'interoperabilità tra i vari moduli. 