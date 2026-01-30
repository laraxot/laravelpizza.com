# Modifica di minimum-stability in Composer.json

## Problema Identificato

Nel file `composer.json` del progetto il progetto, il parametro `minimum-stability` è attualmente impostato a `stable`. Questo sta causando problemi significativi durante l'installazione e l'aggiornamento delle dipendenze, specialmente per quanto riguarda i moduli Laraxot e Filament.

## Analisi della Situazione

Il parametro `minimum-stability` in Composer determina quali versioni dei pacchetti possono essere installate:

- `stable`: Vengono considerate solo versioni stabili e rilasciate ufficialmente
- `dev`: Vengono considerate anche versioni di sviluppo, beta, RC (Release Candidate), alpha, ecc.

Per il progetto il progetto, l'impostazione `stable` è problematica per diverse ragioni:

1. **Moduli Laraxot in sviluppo attivo**:
   - Molti moduli Laraxot utilizzati nel progetto sono in fase di sviluppo attivo e potrebbero non avere versioni stabili
   - Questi moduli vengono frequentemente aggiornati con nuove funzionalità e correzioni di bug

2. **Compatibilità con Laravel 12**:
   - Il progetto utilizza Laravel 12, una versione recente del framework
   - Molti pacchetti e moduli non hanno ancora versioni stabili compatibili con Laravel 12

3. **Filament 4.x e sue dipendenze**:
   - Filament 4.x e alcune delle sue dipendenze potrebbero richiedere versioni dev di altre librerie
   - Con `stable`, queste catene di dipendenze non possono essere risolte correttamente

4. **Innovazione vs. Stabilità**:
   - Il progetto il progetto richiede l'utilizzo di funzionalità all'avanguardia, disponibili spesso solo nelle versioni di sviluppo

## Soluzione Proposta

Modificare il parametro `minimum-stability` da `stable` a `dev` nel file `composer.json`:

```json
"minimum-stability": "dev",
```

Questa modifica va combinata con il parametro già presente `"prefer-stable": true`, che indica a Composer di preferire versioni stabili quando disponibili. Pertanto, Composer installerà:

1. Versioni stabili quando disponibili e compatibili
2. Versioni dev solo quando necessario per risolvere le dipendenze

## Implicazioni e Gestione dei Rischi

### Vantaggi
- Accesso a funzionalità più recenti e correzioni di bug
- Risoluzione delle dipendenze più flessibile
- Compatibilità con l'ecosistema Laraxot e Filament

### Rischi e Mitigazione
- **Stabilità**: Le versioni dev possono contenere bug o API non finali
  - *Mitigazione*: Utilizzare sempre uno specifico commit o tag quando possibile
  - *Mitigazione*: Eseguire test approfonditi prima di ogni aggiornamento

- **Riproducibilità**: È più difficile riprodurre esattamente lo stesso ambiente
  - *Mitigazione*: Utilizzare `composer.lock` per bloccare le versioni esatte
  - *Mitigazione*: Documentare attentamente le versioni dei pacchetti principali

- **Aggiornamenti imprevisti**: I pacchetti dev possono cambiare rapidamente
  - *Mitigazione*: Utilizzare `composer update` con cautela, preferibilmente specificando i pacchetti da aggiornare
  - *Mitigazione*: Implementare un processo di CI/CD per testare gli aggiornamenti

## Impatto sulla Roadmap del Progetto

Questa modifica è un passo necessario per:

1. Risolvere i problemi di autoloading identificati
2. Installare correttamente Filament 4.x e le sue dipendenze
3. Utilizzare le versioni più recenti dei moduli Laraxot
4. Permettere lo sviluppo fluido del modulo Patient e altri moduli specifici

## Conclusione

La modifica di `minimum-stability` da `stable` a `dev` è una decisione tecnica necessaria che riflette la natura innovativa e in rapido sviluppo del progetto il progetto. Sebbene introduca alcuni rischi, questi possono essere adeguatamente mitigati attraverso buone pratiche di sviluppo, test approfonditi e una gestione attenta delle dipendenze. 
La modifica di `minimum-stability` da `stable` a `dev` è una decisione tecnica necessaria che riflette la natura innovativa e in rapido sviluppo del progetto <nome progetto>. Sebbene introduca alcuni rischi, questi possono essere adeguatamente mitigati attraverso buone pratiche di sviluppo, test approfonditi e una gestione attenta delle dipendenze. 
## Collegamenti tra versioni di minimum-stability.md
* [minimum-stability.md](docs/minimum-stability.md)
* [minimum-stability.md](docs/tecnico/minimum-stability.md)

