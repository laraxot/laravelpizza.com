# Analisi di LaravelFS

## Introduzione

LaravelFS è un installer alternativo per Laravel che consente di installare sia i nuovi starter kit di Laravel 12, sia quelli legacy come Breeze e Jetstream che sono stati rimossi dall'installer ufficiale. Rappresenta una soluzione comunitaria per mantenere compatibilità con gli starter kit abbandonati pur supportando le nuove funzionalità di Laravel 12.

## Caratteristiche principali

- Installazione di progetti Laravel simile all'installer ufficiale
- Supporto per Breeze e Jetstream, anche se abbandonati
- Installazione di starter kit personalizzati da Packagist
- Salvataggio e riutilizzo di configurazioni di progetto tramite Templates
- Rimozione semplificata dei template salvati
- Verifica che gli starter kit forniti siano pacchetti Composer di tipo "project"
- Comando CLI per ottenere dettagli aggiuntivi su un pacchetto starter kit

## Struttura del progetto

Il progetto ha una struttura ben organizzata:

- **bin/**: Contiene l'eseguibile `laravelfs`
- **src/**: Contiene il codice principale
  - **Concerns/**: Trait per funzionalità riutilizzabili
    - **CommandsUtils.php**: Utility per i comandi
    - **CommonTemplateUtils.php**: Utility per i template
    - **ConfiguresPrompts.php**: Gestione dei prompt CLI
    - **InteractsWithHerdOrValet.php**: Integrazione con Herd/Valet
  - **NewCommand.php**: Comando principale per la creazione di nuovi progetti
  - **NewTemplateCommand.php**: Gestione dei template
  - **RemoveTemplateCommand.php**: Rimozione dei template
  - **ShowTemplatesCommand.php**: Visualizzazione dei template disponibili
  - **UseTemplateCommand.php**: Utilizzo dei template salvati
- **stubs/**: Template e stub per generare file
- **tests/**: Test automatizzati

## Aspetti interessanti per il nostro progetto

