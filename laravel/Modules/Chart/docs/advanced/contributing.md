# Contribuire al Modulo Chart

Grazie per il tuo interesse a contribuire al modulo Chart! Questo documento fornisce le linee guida per contribuire efficacemente allo sviluppo del modulo.

## Processo di Contribuzione

1. **Fork del Repository**: Crea un fork del repository principale.
2. **Crea un Branch**: Crea un branch per le tue modifiche con un nome descrittivo.
3. **Sviluppa le Modifiche**: Implementa le modifiche o aggiunte desiderate.
4. **Segui gli Standard di Codice**: Assicurati che il tuo codice segua gli standard di codifica del progetto.
5. **Testa le Modifiche**: Aggiungi test per le tue modifiche e assicurati che tutti i test passino.
6. **Documenta**: Aggiorna la documentazione per riflettere le tue modifiche.
7. **Invia una Pull Request**: Invia una pull request al repository principale con una descrizione dettagliata delle modifiche.

## Standard di Codifica

### PHP

- Segui il [PSR-12](https://www.php-fig.org/psr/psr-12/) per la formattazione del codice.
- Usa la tipizzazione forte per i parametri e i valori di ritorno delle funzioni.
- Aggiungi commenti PHPDoc a classi, metodi e proprietà.
- Usa il namespace `Modules\Chart` per tutte le classi del modulo.

### JavaScript / TypeScript

- Segui le convenzioni di ES6+.
- Usa TypeScript per nuove funzionalità quando possibile.
- Formatta il codice con Prettier secondo la configurazione del progetto.

### CSS

- Usa TailwindCSS per lo styling.
- Organizza le classi seguendo le convenzioni del progetto.
- Minimizza l'uso di CSS personalizzato quando possibile.

## Struttura del Modulo

Quando contribuisci, tieni a mente la struttura del modulo:

```
Chart/
├── Actions/             # Classi per azioni riutilizzabili
├── Config/              # File di configurazione
├── Console/             # Comandi artisan
├── Database/            # Migrazioni e seed
├── Filament/            # Componenti Filament
│   ├── Resources/       # Risorse Filament
│   └── Widgets/         # Widget Filament
├── Http/                # Controller e request
├── Models/              # Modelli Eloquent
├── Providers/           # Service provider
├── Resources/           # Asset e view
│   ├── css/
│   ├── js/
│   └── views/
├── Routes/              # Definizioni delle rotte
├── Services/            # Servizi business logic
└── Tests/               # Test unitari e di integrazione
```

## Test

Prima di inviare una pull request, assicurati che:

1. Tutti i test esistenti passino: `php artisan test --filter=Chart`
2. Sia stato aggiunto almeno un test per ogni nuova funzionalità o correzione di bug.
3. La copertura del codice rimanga alta.

## Linee Guida per le Pull Request

- Mantieni le pull request focalizzate su un singolo problema o funzionalità.
- Aggiungi una descrizione dettagliata che spieghi il problema risolto, l'approccio usato e eventuali decisioni di design.
- Collega eventuali issue correlate.
- Non includere cambiamenti non correlati nella stessa pull request.

## Segnalazione Bug

Quando segnali un bug, includi:

1. Passaggi dettagliati per riprodurlo
2. Output o errori ricevuti
3. Comportamento atteso vs comportamento effettivo
4. Ambiente (versione PHP, database, browser, ecc.)
5. Screenshot se applicabili

## Proposte di Nuove Funzionalità

Per proporre nuove funzionalità:

1. Descrivi il problema che la funzionalità risolverebbe
2. Spiega come pensi che la funzionalità dovrebbe funzionare
3. Fornisci alcuni casi d'uso
4. Considera le implicazioni di performance e compatibilità

## Contatti

Per domande su come contribuire, contatta il team di sviluppo attraverso:

- Email: [team@quaeris.local](mailto:team@quaeris.local)
- Discord: [Canale Quaeris](https://discord.com/invite/quaeris)

# Contribuire al Modulo Chart

Grazie per il tuo interesse a contribuire al modulo Chart! Questo documento fornisce le linee guida per contribuire efficacemente allo sviluppo del modulo.

## Processo di Contribuzione

1. **Fork del Repository**: Crea un fork del repository principale.
2. **Crea un Branch**: Crea un branch per le tue modifiche con un nome descrittivo.
3. **Sviluppa le Modifiche**: Implementa le modifiche o aggiunte desiderate.
4. **Segui gli Standard di Codice**: Assicurati che il tuo codice segua gli standard di codifica del progetto.
5. **Testa le Modifiche**: Aggiungi test per le tue modifiche e assicurati che tutti i test passino.
6. **Documenta**: Aggiorna la documentazione per riflettere le tue modifiche.
7. **Invia una Pull Request**: Invia una pull request al repository principale con una descrizione dettagliata delle modifiche.

## Standard di Codifica

### PHP

- Segui il [PSR-12](https://www.php-fig.org/psr/psr-12/) per la formattazione del codice.
- Usa la tipizzazione forte per i parametri e i valori di ritorno delle funzioni.
- Aggiungi commenti PHPDoc a classi, metodi e proprietà.
- Usa il namespace `Modules\Chart` per tutte le classi del modulo.

### JavaScript / TypeScript

- Segui le convenzioni di ES6+.
- Usa TypeScript per nuove funzionalità quando possibile.
- Formatta il codice con Prettier secondo la configurazione del progetto.

### CSS

- Usa TailwindCSS per lo styling.
- Organizza le classi seguendo le convenzioni del progetto.
- Minimizza l'uso di CSS personalizzato quando possibile.

## Struttura del Modulo

Quando contribuisci, tieni a mente la struttura del modulo:

```
Chart/
├── Actions/             # Classi per azioni riutilizzabili
├── Config/              # File di configurazione
├── Console/             # Comandi artisan
├── Database/            # Migrazioni e seed
├── Filament/            # Componenti Filament
│   ├── Resources/       # Risorse Filament
│   └── Widgets/         # Widget Filament
├── Http/                # Controller e request
├── Models/              # Modelli Eloquent
├── Providers/           # Service provider
├── Resources/           # Asset e view
│   ├── css/
│   ├── js/
│   └── views/
├── Routes/              # Definizioni delle rotte
├── Services/            # Servizi business logic
└── Tests/               # Test unitari e di integrazione
```

## Test

Prima di inviare una pull request, assicurati che:

1. Tutti i test esistenti passino: `php artisan test --filter=Chart`
2. Sia stato aggiunto almeno un test per ogni nuova funzionalità o correzione di bug.
3. La copertura del codice rimanga alta.

## Linee Guida per le Pull Request

- Mantieni le pull request focalizzate su un singolo problema o funzionalità.
- Aggiungi una descrizione dettagliata che spieghi il problema risolto, l'approccio usato e eventuali decisioni di design.
- Collega eventuali issue correlate.
- Non includere cambiamenti non correlati nella stessa pull request.

## Segnalazione Bug

Quando segnali un bug, includi:

1. Passaggi dettagliati per riprodurlo
2. Output o errori ricevuti
3. Comportamento atteso vs comportamento effettivo
4. Ambiente (versione PHP, database, browser, ecc.)
5. Screenshot se applicabili

## Proposte di Nuove Funzionalità

Per proporre nuove funzionalità:

1. Descrivi il problema che la funzionalità risolverebbe
2. Spiega come pensi che la funzionalità dovrebbe funzionare
3. Fornisci alcuni casi d'uso
4. Considera le implicazioni di performance e compatibilità

## Contatti

Per domande su come contribuire, contatta il team di sviluppo attraverso:

- Email: [team@quaeris.local](mailto:team@quaeris.local)
- Discord: [Canale Quaeris](https://discord.com/invite/quaeris)

# Contribuire al Modulo Chart

Grazie per il tuo interesse a contribuire al modulo Chart! Questo documento fornisce le linee guida per contribuire efficacemente allo sviluppo del modulo.

## Processo di Contribuzione

1. **Fork del Repository**: Crea un fork del repository principale.
2. **Crea un Branch**: Crea un branch per le tue modifiche con un nome descrittivo.
3. **Sviluppa le Modifiche**: Implementa le modifiche o aggiunte desiderate.
4. **Segui gli Standard di Codice**: Assicurati che il tuo codice segua gli standard di codifica del progetto.
5. **Testa le Modifiche**: Aggiungi test per le tue modifiche e assicurati che tutti i test passino.
6. **Documenta**: Aggiorna la documentazione per riflettere le tue modifiche.
7. **Invia una Pull Request**: Invia una pull request al repository principale con una descrizione dettagliata delle modifiche.

## Standard di Codifica

### PHP

- Segui il [PSR-12](https://www.php-fig.org/psr/psr-12/) per la formattazione del codice.
- Usa la tipizzazione forte per i parametri e i valori di ritorno delle funzioni.
- Aggiungi commenti PHPDoc a classi, metodi e proprietà.
- Usa il namespace `Modules\Chart` per tutte le classi del modulo.

### JavaScript / TypeScript

- Segui le convenzioni di ES6+.
- Usa TypeScript per nuove funzionalità quando possibile.
- Formatta il codice con Prettier secondo la configurazione del progetto.

### CSS

- Usa TailwindCSS per lo styling.
- Organizza le classi seguendo le convenzioni del progetto.
- Minimizza l'uso di CSS personalizzato quando possibile.

## Struttura del Modulo

Quando contribuisci, tieni a mente la struttura del modulo:

```
Chart/
├── Actions/             # Classi per azioni riutilizzabili
├── Config/              # File di configurazione
├── Console/             # Comandi artisan
├── Database/            # Migrazioni e seed
├── Filament/            # Componenti Filament
│   ├── Resources/       # Risorse Filament
│   └── Widgets/         # Widget Filament
├── Http/                # Controller e request
├── Models/              # Modelli Eloquent
├── Providers/           # Service provider
├── Resources/           # Asset e view
│   ├── css/
│   ├── js/
│   └── views/
├── Routes/              # Definizioni delle rotte
├── Services/            # Servizi business logic
└── Tests/               # Test unitari e di integrazione
```

## Test

Prima di inviare una pull request, assicurati che:

1. Tutti i test esistenti passino: `php artisan test --filter=Chart`
2. Sia stato aggiunto almeno un test per ogni nuova funzionalità o correzione di bug.
3. La copertura del codice rimanga alta.

## Linee Guida per le Pull Request

- Mantieni le pull request focalizzate su un singolo problema o funzionalità.
- Aggiungi una descrizione dettagliata che spieghi il problema risolto, l'approccio usato e eventuali decisioni di design.
- Collega eventuali issue correlate.
- Non includere cambiamenti non correlati nella stessa pull request.

## Segnalazione Bug

Quando segnali un bug, includi:

1. Passaggi dettagliati per riprodurlo
2. Output o errori ricevuti
3. Comportamento atteso vs comportamento effettivo
4. Ambiente (versione PHP, database, browser, ecc.)
5. Screenshot se applicabili

## Proposte di Nuove Funzionalità

Per proporre nuove funzionalità:

1. Descrivi il problema che la funzionalità risolverebbe
2. Spiega come pensi che la funzionalità dovrebbe funzionare
3. Fornisci alcuni casi d'uso
4. Considera le implicazioni di performance e compatibilità

## Contatti

Per domande su come contribuire, contatta il team di sviluppo attraverso:

- Email: [team@quaeris.local](mailto:team@quaeris.local)
- Discord: [Canale Quaeris](https://discord.com/invite/quaeris)

Grazie ancora per il tuo contributo al modulo Chart! 