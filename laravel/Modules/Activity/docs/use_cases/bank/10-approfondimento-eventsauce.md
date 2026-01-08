# Approfondimento: Larabank-Eventsauce

## Cos'è Eventsauce
[Eventsauce](https://eventsauce.io/) è una libreria PHP framework-agnostic per l'event sourcing, che fornisce pattern e astrazioni standard per command, eventi, aggregate root e proiezioni.

## Caratteristiche Principali
- Separazione netta tra Command, Event, Aggregate, Projector
- Nessun legame con Laravel: può essere usato in qualsiasi progetto PHP
- Serializzazione eventi, replay, testabilità avanzata
- Supporto per snapshot, upcasting eventi, message dispatching

## Differenze rispetto a spatie/laravel-event-sourcing
- **Integrazione**: Eventsauce è framework-agnostic, spatie/laravel-event-sourcing è pensato per Laravel
- **Pattern**: Eventsauce impone una struttura più rigorosa (command handler, aggregate, event, projector)
- **Estendibilità**: Eventsauce è più adatto a progetti che richiedono standardizzazione e interoperabilità
- **API**: Più verbosa e dettagliata, meno "magica" rispetto a Spatie

## Vantaggi
- Standardizzazione, portabilità tra progetti
- Testabilità e controllo su ogni fase del ciclo di vita degli eventi
- Adatto a team grandi e architetture complesse

## Svantaggi
- Maggiore complessità e curva di apprendimento
- Meno integrazione out-of-the-box con Laravel

## Esempio di Flusso (semplificato)
1. Un comando (es. `WithdrawMoney`) viene inviato a un command handler
2. Il command handler recupera l'aggregate root tramite repository
3. L'aggregate verifica le regole di business e registra uno o più eventi (`MoneyWithdrawn`, `AccountLimitHit`)
4. Gli eventi vengono persistiti e passati ai projector per aggiornare le proiezioni
5. I projector aggiornano le tabelle di lettura (es. saldo, storico)

## Quando preferire Eventsauce
- Progetti PHP non-Laravel
- Necessità di standardizzazione ES tra più team/progetti
- Integrazione con sistemi legacy o microservizi eterogenei

## Risorse
- [Sito ufficiale Eventsauce](https://eventsauce.io/)
- [Repo larabank-eventsauce](https://github.com/spatie/larabank-eventsauce) 
