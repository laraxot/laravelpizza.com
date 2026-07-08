# Guida Completa per Bug Fixing - Laraxot

## Principi Fondamentali

### Analisi Sistematica
- **Comprensione della causa radice**: Analisi approfondita del codice e del contesto
- **Approccio metodico**: Seguire sempre un processo sistematico di risoluzione
- **Integrità documentazione**: Mantenere la documentazione aggiornata durante tutto il processo
- **Rispetto dei confini**: Rispettare i confini e le responsabilità dei moduli
- **Aggiornamento continuo**: Aggiornare costantemente le cartelle docs come fonte primaria di memoria

## Processo di Documentazione

### Prima di Apportare Modifiche
1. **Studio della documentazione**: Analizzare la documentazione nella cartella `docs` del modulo (NON nella cartella `docs` della root)
2. **Collegamenti bidirezionali**: Creare collegamenti tra documentazione del modulo e documentazione root
3. **Aggiornamento preventivo**: Aggiornare la documentazione pertinente prima di implementare le correzioni
4. **Verifica duplicazioni**: Controllare che non esistano già file che trattano lo stesso argomento

### Struttura della Documentazione
- **Documentazione locale**: `Modules/<ModuleName>/docs/` per contenuti specifici del modulo
- **Documentazione root**: `/docs/` per panoramiche generali e collegamenti
- **File .mdc**: Posizionare in `.windsurf/rules/` e `.cursor/rules/` della root del progetto
- **Convenzioni naming**: Tutti i file e cartelle in `docs/` devono essere in minuscolo (eccetto `README.md`)

## Organizzazione del Codice

### Struttura Namespace
- **Corretto**: `Modules\<module>\` (NON `Modules\<module>\App\`)
- **Componenti Filament**: `Modules\<module>\Filament`
- **Estensioni**: Mai estendere classi Filament direttamente - utilizzare classi XotBase
- **ServiceProvider**: Estendere `Modules\Xot\Providers\XotBaseServiceProvider` invece di `Illuminate\Support\ServiceProvider`

### Regole per le Traduzioni
- **Mai utilizzare `->label()`**: Crea accoppiamento stretto e viola la separazione delle responsabilità
- **LangServiceProvider**: Utilizzare per tutte le traduzioni automatiche
- **Posizionamento**: Memorizzare traduzioni in `Modules/<module>/lang/<language>/`
- **Struttura espansa**: Seguire sempre la struttura di traduzione espansa
- **Placeholder file upload**: Deve indicare l'azione da compiere (es. "Carica Fattura") NON il contenuto

## Pattern di Correzione Comuni

### 1. Classi Resource
- **Rimuovere metodi vuoti**: `getTableColumn`, `getTableFilters`, `getBulkActions` se vuoti
- **Rimuovere `getPages`**: Se restituisce solo pagine di default
- **Array associativi**: Utilizzare array associativi con chiavi stringa per tutti i metodi
- **Implementare `getTableColumns()`**: Con chiavi stringa univoche

### 2. Gestione Form
- **Enum per type safety**: Convertire opzioni array in enum
- **Regole di validazione**: Utilizzare regole di validazione appropriate
- **Gestione errori**: Implementare gestione errori appropriata

### 3. ServiceProvider
- **Proprietà `$name`**: Dichiarare `public string $name = '<ModuleName>';` immediatamente dopo la dichiarazione della classe
- **Nessun docblock**: Non utilizzare docblock sopra questa proprietà
- **Visibilità public**: Mantenere per compatibilità con la classe base

## Strategia di Implementazione

### 1. Fase di Analisi
- **Contesto dell'errore**: Comprendere il contesto completo
- **Componenti correlati**: Controllare componenti correlati
- **Modifiche recenti**: Rivedere modifiche recenti
- **Classi estese**: Analizzare classi estese e traits correlati

### 2. Aggiornamento Documentazione
- **Documentazione modulo**: Aggiornare documentazione del modulo
- **Documentazione root**: Creare/aggiornare documentazione root
- **Collegamenti bidirezionali**: Aggiungere collegamenti bidirezionali
- **Coerenza**: Verificare coerenza con documentazione esistente

### 3. Implementazione
- **Principi DRY e KISS**: Seguire principi di codice pulito
- **Implicazioni architetturali**: Considerare implicazioni architetturali
- **Compatibilità**: Mantenere compatibilità all'indietro
- **Spatie Laravel Data**: Utilizzare per DTO
- **Spatie QueableActions**: Preferire invece di services tradizionali

### 4. Testing e Qualità
- **Test della correzione**: Testare la correzione implementata
- **Controllo regressioni**: Controllare regressioni
- **Aggiornamento test**: Aggiornare test se necessario
- **Test di regressione**: Scrivere test di regressione
- **Integrazione moduli**: Verificare integrazione con moduli interconnessi

## Controllo Qualità

### Standard di Codice
- **PHPStan**: Eseguire PHPStan (livello 10)
- **PSR-12**: Garantire conformità PSR-12
- **Type safety**: Verificare type safety
- **Sicurezza**: Controllare implicazioni di sicurezza
- **Strict types**: Utilizzare `declare(strict_types=1);` in tutti i file PHP

### Best Practices
- **Modifiche minime**: Mantenere modifiche minime e focalizzate
- **Documentazione decisioni**: Documentare decisioni e motivazioni
- **Performance**: Considerare implicazioni di performance
- **Principio sorpresa minima**: Seguire il principio della sorpresa minima
- **Type hints espliciti**: Utilizzare type hints espliciti e specifici
- **Evitare mixed**: Evitare l'uso di `mixed` quando possibile

## Errori Comuni da Evitare

### Anti-Pattern Architetturali
- **Estensioni dirette Filament**: Mai estendere direttamente classi Filament
- **Stringhe hardcoded**: Evitare stringhe e label hardcoded
- **Confini moduli**: Non ignorare confini dei moduli
- **Documentazione**: Non saltare aggiornamenti documentazione
- **ServiceProvider sbagliato**: Non utilizzare `Illuminate\Support\ServiceProvider`
- **Metodi `getHeaderActions`**: Che restituiscono solo `DeleteAction`

### Errori di Sintassi Comuni
- **Metodi fuori dalla classe**: ParseError per metodi dichiarati fuori dal blocco della classe
- **Parentesi graffa finale**: La chiusura della classe (`}`) deve essere l'ultima istruzione del file
- **Metodi orfani**: Controllare sempre che non restino metodi orfani dopo refactor

### Esempio Corretto
```php
class Example {
    public function foo() {}
    // ...
} // <--- questa DEVE essere l'ultima parentesi graffa
```

## Gestione ParseError Specifici

### Causa Tipica
Un errore `ParseError: syntax error, unexpected token "protected", expecting end of file` si verifica quando una funzione viene dichiarata **fuori dal blocco della classe**. Questo accade spesso dopo una parentesi graffa di chiusura `}` della classe, lasciando il metodo "orfano".

### Soluzione
1. **Spostare metodi**: Sempre all'interno della classe corretta
2. **Verificare chiusura**: La parentesi graffa di chiusura della classe sia l'ultima istruzione
3. **Eliminare se inutile**: Se il metodo non serve più, eliminarlo

### Best Practice
- Ogni funzione/membro deve essere dichiarato **all'interno** della classe
- La chiusura della classe (`}`) deve essere l'ultima istruzione del file
- Dopo ogni refactor, controllare che non restino metodi orfani
- Utilizzare sempre editor con linting attivo per prevenire errori di sintassi

## Processo di Revisione

### Auto-Revisione
- **Revisione modifiche**: Auto-revisione delle modifiche
- **Problemi simili**: Controllare problemi simili nel codebase
- **Documentazione**: Aggiornare documentazione pertinente
- **Test automatizzati**: Considerare creazione test automatizzati
- **Categorizzazione**: Categorizzare sistematicamente i bugfix

### Gestione Post-Fix
- **Test di regressione**: Implementare test di regressione
- **Moduli interconnessi**: Verificare impatti su moduli interconnessi
- **Pattern documentation**: Documentare pattern e anti-pattern identificati
- **Contesto completo**: Registrare contesto completo del bug
- **Commit standardizzati**: Utilizzare formato `fix(modulo): breve descrizione`

## Filosofia e Principi

### Approccio Olistico
- **Filosofia**: "Il codice pulito riflette una mente ordinata"
- **Politica**: "Ogni decisione tecnica ha implicazioni architetturali"
- **Religione**: "La coerenza del codice è sacra"
- **Zen**: "Semplicità e funzionalità in equilibrio perfetto"

### Principi di Sostenibilità
- **Debito tecnico**: Prevenire accumulo di debito tecnico
- **Longevità**: Progettare per la longevità del codice
- **Manutenibilità**: Prioritizzare la manutenibilità
- **Trasparenza**: Documentare ogni decisione importante

## Aggiornamento Continuo

### Sistema di Apprendimento
- **Regole personali**: Aggiornare `.windsurf/rules`, `.cursor/rules`, `.cursor/memories`
- **Knowledge base**: Creare sistema di intelligenza artificiale personale
- **Prevenzione errori**: Implementare sistema di prevenzione errori
- **Accumulo conoscenza**: Accumulare conoscenza procedurale

### Categorizzazione Sistematica
- **Aree problematiche**: Identificare aree problematiche nel tempo
- **Pattern ricorrenti**: Riconoscere pattern ricorrenti
- **Opportunità refactoring**: Identificare opportunità di refactoring
- **Miglioramento continuo**: Utilizzare informazioni per miglioramento continuo

---

*Ultimo aggiornamento: 2025-08-04*
*Versione: 2.0*
*Compatibilità: Laraxot <nome progetto>, PHP 8.2+, Laravel 12+, Filament 3.4+*
