# Architettura di un Prediction Market

## Pattern Principali
- **Event Sourcing**: ogni cambiamento di stato è registrato come evento immutabile.
- **Proiezioni**: viste di lettura generate dagli eventi (es. saldo, classifica, storico scommesse).
- **Reattori**: gestiscono effetti collaterali (notifiche, pagamenti, aggiornamento quote).
- **Aggregate Root**: incapsula la logica di business e garantisce la coerenza dello stato.
- **CQRS**: separa le operazioni di scrittura (comandi) da quelle di lettura (query).
- **Bus dei Comandi**: instrada i comandi verso le aggregate root.
- **Oracoli**: servizi che forniscono dati reali (esito eventi) agli smart contract.
- **Microservizi**: ogni dominio (mercato, utente, pagamento) può essere un servizio separato.

## Struttura Consigliata
- Moduli separati per Activity (mercati), User (utenti), Wallet (pagamenti), Oracle (esiti)
- Event sourcing tramite `spatie/laravel-event-sourcing`
- CQRS e bus dei comandi
- Integrazione con oracoli esterni per la chiusura dei mercati
- Proiezioni ottimizzate per query rapide
- Snapshotting per aggregati con molti eventi

## Approccio Minimalista e Pragmatico (ispirato a cnastasi/event-sourcing-with-laravel)
- Per PoC/demo, una struttura semplice con pochi context e comandi console è efficace e facilmente testabile.
- **Context**: separare la logica in MarketContext, UserContext, WalletContext, OracleContext.
- **Console Commands**: entrypoint principale per interagire con il dominio (es. `market:create`, `market:bet`, `market:close`, `user:deposit`, `user:withdraw`).
- **Motivazione**: semplicità, automazione, testabilità.

## Esempio di Context e Comando Console
```php
// app/Contexts/MarketContext/Console/CreateMarket.php
class CreateMarket extends Command {
    protected $signature = 'market:create {question}';
    public function handle() {
        // logica per creare un nuovo mercato
    }
}
```

## Evoluzione verso Modularità
- Da una struttura minimalista si può evolvere verso moduli separati e architetture più complesse man mano che il progetto cresce.
- Ogni context può diventare un modulo indipendente.

## Zen
- "Sii pragmatico: la semplicità vince nelle demo e nei PoC."
- "Ogni cambiamento è una storia, ogni comando è un'intenzione esplicita."
