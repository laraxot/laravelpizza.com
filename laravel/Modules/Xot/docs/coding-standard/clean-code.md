# Clean Code: Linee Guida per il Progetto

Questo documento definisce le linee guida di Clean Code adottate nel progetto, basate sui principi di Robert C. Martin. Queste regole sono adattate specificamente per la struttura modulare Laravel utilizzata nel progetto.

## Regole Generali

1. **Segui le convenzioni standard**
   - Rispetta PSR-12 per la formattazione del codice PHP
   - Usa la struttura corretta dei moduli Laravel (app/Models, app/Http/Controllers, ecc.)
   - Mantieni la coerenza tra i namespace (`Modules\NomeModulo\Models`) e i percorsi fisici (`Modules/NomeModulo/app/Models`)

2. **Mantieni la semplicità (KISS)**
   - Riduci la complessità il più possibile
   - Preferisci soluzioni semplici e dirette
   - Evita overengineering e configurazioni eccessive

3. **Regola dello Scout**
   - Lascia il codice più pulito di come l'hai trovato
   - Refactoring progressivo quando possibile
   - Correggi warning e best practice quando li incontri

4. **Cerca sempre la causa principale**
   - Non applicare soluzioni provvisorie
   - Documenta i problemi risolti e le loro cause

## Regole di Design

1. **Mantieni i dati configurabili ad alto livello**
   - Usa file di configurazione nei moduli (`config/*.php`)
   - Centralizza le configurazioni per facilitarne la modifica
   - Evita valori hardcoded

2. **Preferisci il polimorfismo agli if/else o switch/case**
   - Usa il pattern Strategy quando appropriato
   - Sfrutta l'ereditarietà per specializzare i comportamenti
   - Utilizza interfacce per definire contratti chiari

3. **Separa il codice multi-thread**
   - Usa code e job per operazioni asincrone
   - Evita dipendenze tra processi paralleli

4. **Previeni l'eccessiva configurabilità**
   - Limita le opzioni di configurazione all'essenziale
   - Usa valori predefiniti sensati

5. **Usa l'injection delle dipendenze**
   - Sfrutta il container IoC di Laravel
   - Definisci dipendenze nei costruttori
   - Segui il principio dell'inversione delle dipendenze

6. **Segui la Legge di Demeter**
   - Una classe dovrebbe conoscere solo le sue dipendenze dirette
   - Evita catene di chiamate (`$a->getB()->getC()->doSomething()`)

## Nomi delle Variabili

1. **Scegli nomi descrittivi e non ambigui**
   - `$mailTemplate` invece di `$mt`
   - `$userNotification` invece di `$notif`

2. **Fai distinzioni significative**
   - Evita nomi simili per concetti diversi
   - `$activeUser` vs `$currentUser` solo se semanticamente diversi

3. **Usa nomi pronunciabili**
   - `$dailyReport` invece di `$dlyRpt`

4. **Usa nomi cercabili**
   - Evita singole lettere tranne che per iteratori locali
   - Rendi i nomi unici per facilitare la ricerca nel codice

5. **Sostituisci i numeri magici con costanti**
   - `const MAX_LOGIN_ATTEMPTS = 5;` invece di usare direttamente `5`

6. **Evita encoding**
   - No a prefissi di tipo (`$strName`)
   - No a notazioni ungheresi

## Funzioni

1. **Piccole**
   - Mantieni le funzioni sotto le 20 righe
   - Una funzione dovrebbe entrare in uno schermo

2. **Fai una cosa sola**
   - Ogni metodo dovrebbe avere una singola responsabilità
   - Estrai metodi privati per operazioni complesse

3. **Usa nomi descrittivi**
   - Il nome dovrebbe descrivere cosa fa la funzione
   - `saveUserAndSendNotification()` invece di `process()`

4. **Preferisci meno argomenti**
   - Idealmente 0-2 parametri
   - Usa oggetti per raggruppare parametri correlati

5. **Nessun effetto collaterale**
   - Una funzione dovrebbe fare ciò che promette, nulla di più
   - Evita di modificare variabili globali o di stato

6. **Non usare flag come argomenti**
   - Dividi in metodi indipendenti

## Commenti

1. **Cerca sempre di spiegarti nel codice**
   - Codice auto-esplicativo è meglio di commenti
   - Rinomina variabili e metodi per chiarezza anziché aggiungere commenti

2. **Non essere ridondante**
   - Evita commenti che ripetono ciò che il codice già dice

3. **Non aggiungere rumore ovvio**
   - Evita commenti che non aggiungono informazioni

4. **Non commentare codice**
   - Rimuovi il codice non utilizzato, non commentarlo
   - Usa il controllo versione per recuperare vecchio codice

5. **Usa commenti per spiegare l'intento**
   - Spiega il "perché", non il "cosa" o il "come"

6. **Usa PHPDoc per documentazione API**
   - Documenta parametri, tipi di ritorno e eccezioni

## Struttura del Codice Sorgente

1. **Separa concetti verticalmente**
   - Raggruppa funzionalità correlate
   - Organizza il codice in moduli logici

2. **Il codice correlato dovrebbe apparire verticalmente denso**
   - Metodi correlati dovrebbero essere vicini

3. **Dichiara variabili vicino al loro utilizzo**
   - Evita dichiarazioni all'inizio del metodo se usate solo in un punto

4. **Funzioni dipendenti dovrebbero essere vicine**
   - Organizza i metodi in base alle loro relazioni

5. **Funzioni simili dovrebbero essere vicine**
   - Raggruppa metodi con scopi simili

6. **Posiziona le funzioni nella direzione discendente**
   - Funzioni chiamanti prima delle chiamate

7. **Mantieni le righe corte**
   - Preferibilmente sotto 80-100 caratteri

8. **Usa spazi bianchi per associare cose correlate**
   - Usa la spaziatura per migliorare la leggibilità

9. **Non rompere l'indentazione**
   - Mantieni coerenza nell'indentazione

## Struttura Specifica per Laravel Modules

1. **Struttura dei Moduli**
   ```
   Modules/
     ├── NomeModulo/
     │   ├── app/                     <- Directory principale per il codice PHP
     │   │   ├── Models/              <- Modelli (namespace: Modules\NomeModulo\Models)
     │   │   ├── Http/Controllers/    <- Controller (namespace: Modules\NomeModulo\Http\Controllers)
     │   │   ├── Providers/           <- Service Provider
     │   │   └── ...
     │   ├── resources/               <- Asset, view, traduzioni
     │   ├── routes/                  <- Rotte
     │   └── ...
   ```

2. **Convenzioni di Namespace**
   - Usa `Modules\NomeModulo\Models` per i modelli in `Modules/NomeModulo/app/Models/`
   - Ricorda che il segmento `app` è presente nel percorso fisico ma NON nel namespace

3. **Organizzazione dei Test**
   - Mantieni i test nella directory `Tests/` con struttura speculare al codice
   - Usa nomi descrittivi: `UserRegistrationTest`, non `Test1`

4. **Articolazione Moduli**
   - Ogni modulo dovrebbe avere una responsabilità ben definita
   - Evita dipendenze circolari tra moduli
   - Preferisci eventi per la comunicazione cross-modulo

## Oggetti e Strutture Dati

1. **Nascondi la struttura interna**
   - Usa getter/setter quando appropriato
   - Incapsula la logica di business nei modelli

2. **Preferisci strutture dati**
   - Per semplice trasporto di dati, use DTO o Value Objects

3. **Evita strutture ibride**
   - Un oggetto dovrebbe essere o orientato ai comportamenti o ai dati, non entrambi

4. **Classi piccole**
   - Massimo 100-200 righe per classe
   - Responsabilità singola

5. **Poche variabili di istanza**
   - Meno di 10 proprietà per classe

6. **Preferisci metodi non statici a metodi statici**
   - Usa metodi statici solo per funzionalità veramente stateless

## Test

1. **Un assert per test**
   - Test unitari focalizzati su un solo aspetto
   - Nomi test descrittivi del comportamento testato

2. **Leggibili**
   - I test sono documentazione viva

3. **Veloci**
   - Test unitari eseguibili in millisecondi

4. **Indipendenti**
   - Nessuna dipendenza tra test
   - Usa fixture e factory per preparare i dati

5. **Ripetibili**
   - I test devono essere deterministici

## Code Smells (Segnali di Allarme)

1. **Rigidità**: Il software è difficile da modificare
2. **Fragilità**: Piccole modifiche causano problemi in più parti
3. **Immobilità**: Non è possibile riutilizzare parti del codice
4. **Complessità inutile**: Sovra-ingegnerizzazione
5. **Ripetizione inutile**: Codice duplicato
6. **Opacità**: Codice difficile da comprendere

## Regole specifiche per Filament e XotBaseResource

1. **Non sovracaricare metodi base**
   - Non implementare `getTableColumns()`, `getTableFilters()` nelle classi che estendono XotBaseResource
   - Implementa solo `getFormSchema()` e occasionalmente `getEloquentQuery()`

2. **Non utilizzare metodi di etichetta diretti**
   - Non usare `->label()`, `->placeholder()` o `->helperText()` nei componenti Filament
   - Usa il sistema di traduzione centralizzato tramite file di lingua

3. **Mantieni le proprietà critiche**
   - Non rimuovere `public ?array $data = []` da XotBaseWidget
   - Non alterare le proprietà cruciali delle classi base

4. **Rispetta la struttura standard dei moduli**
   - Usa il percorso `/var/www/html/base_<nome progetto>/laravel/Modules/NomeModulo/app/Models/` per i modelli
   - Usa il namespace `Modules\NomeModulo\Models` (senza "app")
