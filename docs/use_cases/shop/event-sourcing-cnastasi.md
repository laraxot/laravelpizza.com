# Event Sourcing con Laravel: Analisi del Repository di cnastasi

## Introduzione

Questo documento analizza il repository [https://github.com/cnastasi/event-sourcing-with-laravel](https://github.com/cnastasi/event-sourcing-with-laravel) creato da cnastasi, che presenta una demo live sull'implementazione di Event Sourcing con Laravel, come illustrato nel talk al Laravel Day 2023. L'obiettivo è integrare le lezioni apprese da questo repository nella nostra documentazione per il caso d'uso `Shop` nel modulo `Activity`, arricchendo la nostra comprensione dell'Event Sourcing applicato a un sistema di gestione del magazzino e degli ordini.

## Panoramica del Repository

Il repository `event-sourcing-with-laravel` offre un esempio pratico di come implementare Event Sourcing in un'applicazione Laravel per gestire un magazzino di prodotti e gli ordini. Si concentra su un approccio minimalista e didattico, mostrando come tracciare eventi per operazioni come la registrazione di prodotti, l'acquisto e il rifornimento del magazzino.

### Struttura del Progetto

Il repository segue la struttura standard di un progetto Laravel, con directory chiave come:
- `app`: Contiene la logica di business, probabilmente con aggregate, eventi e proiettori.
- `database`: Per le migrazioni che configurano le tabelle degli eventi.
- `routes`: Per eventuali endpoint API o web.

Questa struttura è simile a quella vista nei progetti Spatie (`laravel-shop-main` e `laravel-shop-command-bus`), ma è più semplificata, essendo una demo educativa.

## Configurazione e Installazione

Il repository fornisce istruzioni chiare per configurare il progetto:

1. **Clonazione del Repository**:
   ```bash
   git clone https://github.com/cnastasi/event-sourcing-with-laravel.git
   ```

2. **Installazione delle Dipendenze**:
   ```bash
   composer install
   ```

3. **Configurazione del Database**:
   - Si consiglia l'uso di SQLite per semplicità in ambiente locale:
     ```bash
     touch storage/database.sqlite
     ```
   - Configurazione del file `.env`:
     ```
     DB_CONNECTION=sqlite
     DB_DATABASE=/path/assoluto/del/database/database.sqlite
     ```
   - Esecuzione delle migrazioni:
     ```bash
     php artisan migrate
     ```

**Lezione Appresa**: L'uso di SQLite per demo o test è una scelta pratica che riduce la complessità di configurazione, utile per prototipi o apprendimento nel contesto del nostro modulo `Activity`.

## Comandi Disponibili

Il repository include comandi da console personalizzati per interagire con il sistema di Event Sourcing. Questi comandi sono progettati per gestire operazioni di magazzino e ordini:

- **`product:list`**: Elenca i prodotti disponibili nel magazzino.
- **`product:orders`**: Elenca gli ordini effettuati.
- **`product:purchase <productId> <quantity>`**: Compra un prodotto specificando ID e quantità.
- **`product:register <name> <quantity> <price>`**: Registra una nuova tipologia di prodotto nel magazzino.
- **`product:replenish <productId> <quantity>`**: Aggiunge nuovi prodotti al magazzino.

**Lezione Appresa**: Questi comandi dimostrano come l'Event Sourcing possa essere integrato con l'interfaccia a riga di comando di Laravel per eseguire operazioni di business. Nel nostro caso d'uso `Shop`, possiamo creare comandi simili per gestire carrelli (`cart:add-item`, `cart:checkout`) e ordini, come già documentato in `console_commands.md`.

## Principi di Event Sourcing Applicati

Anche se il codice specifico non è stato visualizzato nei chunk, il repository si basa su concetti fondamentali di Event Sourcing:

- **Eventi come Fonte di Verità**: Ogni operazione (es. acquisto, registrazione prodotto) genera un evento che viene salvato. Questo permette di ricostruire lo stato del magazzino in qualsiasi momento, un principio chiave anche per il nostro carrello della spesa.
- **Aggregate per la Logica di Business**: È probabile che il progetto utilizzi aggregate per gestire la logica di business, decidendo quali eventi generare in risposta a comandi come `product:purchase`.
- **Proiezioni per Query**: Gli elenchi generati da comandi come `product:list` suggeriscono l'uso di proiezioni o modelli di lettura ottimizzati, creati a partire dagli eventi.

**Lezione Appresa**: Questo approccio minimalista ci insegna che anche un sistema semplice può trarre vantaggio dall'Event Sourcing per tracciabilità e flessibilità. Possiamo applicare lo stesso principio al nostro caso d'uso `Shop`, concentrandoci su eventi chiave come `CartItemAdded`, `CartCheckedOut` e creando comandi da console per testare queste operazioni.

## Confronto con i Progetti Spatie

Rispetto ai progetti Spatie (`laravel-shop-main` e `laravel-shop-command-bus`) già analizzati, il repository di cnastasi è più didattico e meno complesso:

- **Semplicità**: Si concentra su un dominio ristretto (magazzino e ordini) con comandi base, mentre Spatie offre un sistema più completo per un carrello della spesa.
- **Obiettivo Educativo**: Il focus di cnastasi è insegnare i concetti di Event Sourcing, come dimostrato dal talk al Laravel Day 2023, mentre Spatie mira a fornire soluzioni pronte per l'uso.
- **Struttura**: Entrambi seguono i principi di Event Sourcing (eventi, aggregate, proiezioni), ma Spatie utilizza una struttura a `Domain` più organizzata.

**Lezione Appresa**: Per il nostro modulo `Activity`, possiamo adottare l'approccio educativo di cnastasi per creare prototipi o demo di Event Sourcing prima di scalare a una soluzione più strutturata come quella di Spatie.

## Applicazione al Caso d'Uso Shop

Integrando le lezioni dal repository di cnastasi, possiamo migliorare il nostro approccio al caso d'uso `Shop`:

- **Prototipazione Veloce**: Usare SQLite e configurazioni semplici per testare rapidamente nuove funzionalità del carrello della spesa basate su Event Sourcing.
- **Comandi Didattici**: Creare comandi da console non solo per operazioni amministrative, ma anche per scopi di apprendimento o dimostrazione, come `shop:demo-cart` per simulare un flusso completo di acquisto.
- **Focus su Eventi Chiave**: Identificare un set minimo di eventi per il carrello (es. `ItemAdded`, `ItemRemoved`, `CheckoutCompleted`) e costruire su questi, evitando complessità inutili nelle fasi iniziali.

## Conclusione

Il repository di cnastasi fornisce un'introduzione pratica e accessibile all'Event Sourcing con Laravel, dimostrando come applicare questi principi a un sistema di gestione del magazzino. Le sue lezioni sulla semplicità, i comandi da console e la configurazione rapida sono direttamente applicabili al nostro caso d'uso `Shop` nel modulo `Activity`. Integrando questi concetti con le strutture più avanzate dei progetti Spatie, possiamo sviluppare un sistema di carrello della spesa che sia allo stesso tempo educativo, scalabile e robusto.
