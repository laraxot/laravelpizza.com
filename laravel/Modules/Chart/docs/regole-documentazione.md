# Regole di Documentazione in il progetto

> **NOTA**: La documentazione dettagliata sulle regole di documentazione è stata centralizzata nel modulo Xot. Consulta il documento aggiornato nel link sottostante.

## Collegamenti

- [Documentazione completa sulle regole di documentazione](/var/www/html/base_<nome progetto>/laravel/Modules/Xot/docs/DOCUMENTATION_RULES.md)
- [Convenzioni di naming](/var/www/html/base_<nome progetto>/laravel/Modules/Xot/docs/NAMING_CONVENTIONS.md)
- [Struttura dei moduli](/var/www/html/base_<nome progetto>/laravel/Modules/Xot/docs/MODULE_STRUCTURE.md)

## Sommario

In il progetto, seguiamo queste regole fondamentali per la documentazione:

### Regole per i Nomi
- Il nome "il progetto" può essere utilizzato solo nella cartella docs della root del progetto
- Nella documentazione tecnica generica e nei prompt condivisi, utilizzare termini generici come "il progetto", "l'applicazione", "il sistema"
- Questo permette di riutilizzare la documentazione per progetti simili

### Struttura della Documentazione
- Documentazione generica: nella cartella docs del modulo Xot
- Documentazione specifica del progetto: nella cartella docs della root
- Documentazione dei moduli: nella cartella docs di ciascun modulo

### Collegamenti Bidirezionali
- Ogni documento deve avere collegamenti ad altri documenti correlati
- I collegamenti devono essere mantenuti aggiornati
- Utilizzare sezioni "Collegamenti" o "Documentazione Correlata"

Consulta la documentazione completa nel modulo Xot per maggiori dettagli, best practice e regole specifiche.

# Regole per la Documentazione dei Moduli

## Struttura Base

Ogni modulo DEVE avere una cartella `docs/` con la seguente struttura:

```
docs/
├── README.md           # Documentazione principale
├── CHANGELOG.md        # Storico delle modifiche
├── CONTRIBUTING.md     # Guide per i contributori
├── ARCHITECTURE.md     # Decisioni architetturali
├── DEPENDENCIES.md     # Dipendenze e requisiti
├── git-conflicts.md    # Gestione conflitti git
└── examples/          # Esempi di utilizzo
    ├── basic.md
    └── advanced.md
```

## File README.md

Il README.md di ogni modulo DEVE contenere:

1. **Descrizione**
   - Scopo del modulo
   - Funzionalità principali
   - Casi d'uso tipici

2. **Installazione**
   - Requisiti
   - Procedura di installazione
   - Configurazione iniziale

3. **Utilizzo**
   - API principali
   - Esempi base
   - Best practices

4. **Dipendenze**
   - Moduli richiesti
   - Pacchetti esterni
   - Versioni compatibili

5. **Configurazione**
   - File di configurazione
   - Opzioni disponibili
   - Valori di default

## Gestione Conflitti Git

1. **Documentazione**
   - Mantenere un file `git-conflicts.md`
   - Documentare i conflitti risolti
   - Spiegare le decisioni prese

2. **Prioritizzazione**
   - Alta priorità: File di codice
   - Media priorità: File di configurazione
   - Bassa priorità: File di documentazione

3. **Risoluzione**
   - Approccio conservativo
   - Mantenere funzionalità esistente
   - Documentare le modifiche

## Collegamenti tra Moduli

1. **Collegamenti Bidirezionali**
   - Ogni riferimento a un altro modulo deve essere bidirezionale
   - Usare path relativi per i collegamenti
   - Mantenere i collegamenti aggiornati

2. **Dipendenze**
   - Elencare tutte le dipendenze
   - Specificare le versioni compatibili
   - Documentare le dipendenze opzionali

3. **Integrazioni**
   - Documentare le integrazioni con altri moduli
   - Spiegare i flussi di dati
   - Descrivere i punti di estensione

## Standard di Codice

1. **Esempi di Codice**
   - Devono essere testati e funzionanti
   - Includere commenti esplicativi
   - Seguire le convenzioni di codice

2. **Snippets**
   - Brevi e focalizzati
   - Con contesto sufficiente
   - Con output atteso

3. **Test**
   - Documentare i test disponibili
   - Spiegare come eseguirli
   - Fornire esempi di output

## Manutenzione

1. **Aggiornamenti**
   - Aggiornare la documentazione con ogni release
   - Mantenere il CHANGELOG aggiornato
   - Documentare le breaking changes

2. **Review**
   - Review periodica della documentazione
   - Verifica dei collegamenti
   - Aggiornamento degli esempi

3. **Versioning**
   - Seguire Semantic Versioning
   - Documentare le versioni supportate
   - Mantenere la compatibilità

## Stile e Formattazione

1. **Markdown**
   - Usare Markdown standard
   - Mantenere una struttura coerente
   - Usare intestazioni gerarchiche

2. **Immagini**
   - Salvare in `docs/images/`
   - Usare nomi descrittivi
   - Ottimizzare le dimensioni

3. **Tabelle**
   - Usare per dati strutturati
   - Mantenere leggibili
   - Allineare correttamente

## Note Importanti

1. La documentazione è parte integrante del codice
2. Deve essere aggiornata con ogni modifica
3. Deve essere chiara e concisa
4. Deve essere orientata all'utente finale
5. I conflitti git devono essere documentati

## Checklist di Verifica

Prima di ogni commit, verificare:

- [ ] README.md aggiornato
- [ ] CHANGELOG.md aggiornato
- [ ] Collegamenti funzionanti
- [ ] Esempi testati
- [ ] Documentazione coerente
- [ ] Formattazione corretta
- [ ] Conflitti git documentati
