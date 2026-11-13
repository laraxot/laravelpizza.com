# Architettura del Carrello della Spesa

## Introduzione

L'architettura di un carrello della spesa basato su Event Sourcing si concentra sulla gestione dello stato attraverso una sequenza di eventi. Questo approccio consente di tracciare ogni modifica, garantendo un audit trail completo e una separazione chiara della logica di business.

## Struttura di Laravel Shop Main

Il progetto `laravel-shop-main` è un'applicazione completa che dimostra l'uso dell'Event Sourcing per un carrello della spesa. La struttura rilevante è:

- **Domain**: Contiene la logica di business suddivisa in aggregate, eventi e azioni.
  - **Cart**: Gestisce il carrello con eventi come `CartItemAdded`, `CartCheckedOut`.
  - **Order**: Traccia gli ordini con eventi come `OrderPlaced`, `OrderPaid`.
- **Http/Controllers**: Punto di ingresso per interagire con il carrello tramite azioni come aggiungere articoli o completare il checkout.

Il flusso degli eventi è descritto in un diagramma temporale (`/docs/timeline.png`), che mostra come gli eventi modificano lo stato del carrello.

## Struttura di Laravel Shop Command Bus

Il progetto `laravel-shop-command-bus` è un pacchetto più strutturato, con un focus su un command bus per gestire i comandi e gli eventi. La struttura include:

- **Cart**: Gestione del carrello con eventi e aggregate.
- **Customer**, **Inventory**, **Order**, **Payment**, **Product**: Moduli separati per diverse entità del negozio.
- **ShopServiceProvider**: Configura il pacchetto per l'integrazione con Laravel.

## Principi di Event Sourcing

- **Eventi come Fonte di Verità**: Ogni azione (aggiungere un articolo, checkout) genera un evento che viene salvato. Lo stato del carrello è ricostruito rigiocando questi eventi.
- **Aggregate**: Incapsulano la logica di business, decidendo quali eventi generare in risposta a un comando.
- **Separazione delle Responsabilità**: I comandi modificano lo stato, mentre le query leggono lo stato ricostruito.

## Flusso Tipico

1. Un utente aggiunge un articolo al carrello (comando).
2. L'aggregate del carrello genera un evento `CartItemAdded`.
3. L'evento viene salvato e lo stato del carrello aggiornato.
4. Eventuali proiettori o listener reagiscono all'evento per aggiornare viste o triggerare altre azioni.
