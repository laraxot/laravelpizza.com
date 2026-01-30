# Regole Fondamentali del Progetto <nome progetto>

Questo documento centralizza tutte le regole e le convenzioni del progetto <nome progetto> per garantire coerenza e facilità di accesso.

## Traduzioni e Localizzazione
- **MAI utilizzare `->label()` nei componenti Filament**. Le etichette sono gestite automaticamente dal `LangServiceProvider`. [Dettagli](/var/www/html/<nome progetto>/docs/lang-service-provider-improvements.md)
- Utilizzare sempre i file di traduzione per le etichette e i testi. [Struttura dei file di traduzione](#)

## Enum e Valori Fissi
- **Utilizzare SEMPRE ENUM per array di opzioni fisse**. Evitare array hardcoded. [Esempio di implementazione](#)

## Notifiche
- Utilizzare `RecordNotification` per le notifiche. Studiare le implementazioni esistenti prima di crearne di nuove. [Dettagli](/var/www/html/<nome progetto>/docs/record-notification-implementation.md)

## Architettura
- **NON utilizzare componenti Livewire diretti**. Usare esclusivamente Widget di Filament. [Dettagli](#)
- **NON utilizzare Services**. Usare `spatie/laravel-queueable-action` per la business logic asincrona. [Dettagli](#)

## Documentazione
- Studiare a fondo la documentazione esistente prima di proporre implementazioni. [Struttura della documentazione](#)

## Configurazioni
- Separare configurazioni generiche e specifiche per provider. [Struttura di configurazione](#)
- MAI utilizzare valori predefiniti per parametri critici nelle variabili d'ambiente. [Dettagli](#)

Questo documento è un punto di riferimento rapido. Per approfondimenti, consultare i link forniti o la documentazione completa nella directory `/docs`.
