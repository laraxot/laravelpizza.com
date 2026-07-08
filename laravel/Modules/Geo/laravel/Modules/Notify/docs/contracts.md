# Contracts

Questo documento contiene i collegamenti a tutte le interfacce principali del sistema.

## User Module

- [[HasTeamsContract]] - Interfaccia per la gestione dei team
  - Definisce i metodi per la gestione dei team
  - Utilizzata da [[BaseUser]]

- [[UserContract]] - Interfaccia base per gli utenti
  - Definisce i metodi base per gli utenti
  - Utilizzata da [[BaseUser]]

- [[HasTeamsAndUserContract]] - Interfaccia che combina HasTeamsContract e UserContract
  - Fornisce un'unica interfaccia per la gestione di team e utenti
  - Estende [[HasTeamsContract]] e [[UserContract]]

## Collegamenti Correlati

- [[Models]] - Modelli che implementano queste interfacce
- [[BaseUser]] - Implementazione principale delle interfacce 
