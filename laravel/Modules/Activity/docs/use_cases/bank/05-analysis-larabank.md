# Analisi di Larabank-Aggregates (Spatie)

## Regole Implementate
- Un conto non può andare sotto -5000
- Se il limite viene raggiunto 3 volte di seguito, viene proposta un'offerta di prestito

## Pattern Utilizzati
- Event sourcing con aggregate root per la logica di business
- Proiettori per generare viste di lettura (saldo, storico)
- Reattori per gestire effetti collaterali (invio email)

## Punti di Forza
- Separazione netta tra scrittura (eventi) e lettura (proiezioni)
- Facilità di audit e tracciabilità
- Estendibilità tramite nuovi eventi e reattori
- Esempio didattico chiaro per l'adozione di event sourcing in ambito bancario

## Spunti per il Progetto
- Utilizzare aggregate per tutte le regole critiche
- Gestire limiti e notifiche solo tramite eventi
- Testare ogni regola con eventi e proiezioni 
