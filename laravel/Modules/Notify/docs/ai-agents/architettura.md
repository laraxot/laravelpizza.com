# Architettura e Struttura

Il progetto utilizza un'architettura modulare basata su Laravel con il framework Laraxot, seguendo un pattern di estensioni base per tutti i componenti:

## Pattern di Estensione

Il sistema è costruito attorno a una gerarchia di classi base che fornisce funzionalità comuni a tutti i componenti:

- [Regole Critiche Laraxot](./regole-critiche.md) - Approfondimento sulle regole fondamentali
- [Componenti Chiave](./componenti-chiave.md) - Descrizione dei componenti principali

## Moduli

Il sistema è organizzato in moduli indipendenti che possono essere abilitati/disabilitati secondo necessità. Ogni modulo contiene:

- Modelli (Models)
- Risorse Filament (Filament Resources)
- Azioni (Actions)
- Provider (Service Providers)
- Configurazioni specifiche