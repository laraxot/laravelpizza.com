# Manutenzione della Documentazione

## Strategia di Documentazione

La documentazione del progetto PTVX è suddivisa in tre sezioni principali, una per ciascuno strumento AI (Claude, Gemini, iFlow). Questa struttura permette di fornire indicazioni specifiche per ciascun strumento mantenendo al contempo una base comune di conoscenze.

## Struttura della Documentazione

```
bashscripts/ai/
├── .claude/
│   └── docs/
│       ├── README.md
│       ├── architettura.md
│       ├── regole-critiche.md
│       ├── ...
│       └── claude-ptvx-guide.md
├── .gemini/
│   └── docs/
│       ├── README.md
│       ├── architettura.md
│       ├── regole-critiche.md
│       ├── ...
│       └── gemini-ptvx-guide.md
└── .iflow/
    └── docs/
        ├── README.md
        ├── architettura.md
        ├── regole-critiche.md
        ├── ...
        └── iflow-ptvx-guide.md
```

## Aggiornamento della Documentazione

Quando si apportano modifiche al codice o alle pratiche di sviluppo:

1. **Identificare l'impatto**: Determinare quale/i sezione/i sono interessate dalle modifiche
2. **Aggiornare tutti i livelli**: Modificare i file appropriati in tutte e tre le sezioni se necessario
3. **Mantenere coerenza**: Assicurarsi che le informazioni fondamentali siano consistenti tra tutte le sezioni
4. **Verificare i collegamenti**: Controllare che tutti i collegamenti funzionino correttamente

## Contenuti da Documentare

### Modifiche Architetturali
- Nuovi pattern di estensione
- Cambiamenti nelle regole Laraxot
- Aggiornamenti alle dipendenze principali

### Pratiche di Sviluppo
- Nuove best practices
- Cambiamenti nei processi di quality assurance
- Aggiornamenti ai workflow di sviluppo

### Strumenti e Automazione
- Nuovi script o modifiche agli esistenti
- Cambiamenti nei processi di testing o linting
- Aggiornamenti alle procedure di deployment

## Revisione della Documentazione

La documentazione dovrebbe essere rivista periodicamente per assicurare che rimanga accurata e utile:

- Durante i refactoring principali
- Quando si introducono nuovi moduli
- Quando cambiano le tecnologie principali (Laravel, Filament, ecc.)
- In caso di problemi ricorrenti segnalati dagli utenti degli strumenti AI