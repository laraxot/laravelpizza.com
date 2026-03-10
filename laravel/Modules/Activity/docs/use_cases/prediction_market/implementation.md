# Implementazione del <nome progetto>ion Market

Questa guida fornisce i passaggi per implementare un <nome progetto>ion market nel modulo `Activity` utilizzando l'Event Sourcing.

## Passaggi Principali

1. **Definizione dei Modelli e delle Tabelle di Proiezione**
   - Creare modelli per le proiezioni come `MarketSummary`, `UserBet` e `PayoutReport`.
   - Definire migration per le tabelle corrispondenti (`market_summaries`, `user_bets`, `payout_reports`).

2. **Creazione degli Eventi**
   - Definire classi per ogni evento (`MarketCreated`, `BetPlaced`, `MarketUpdated`, `MarketResolved`, `PayoutDistributed`).
   - Assicurarsi che ogni evento contenga i dati necessari per aggiornare lo stato.

3. **Implementazione della Radice Aggregate**
   - Creare `<nome progetto>ionMarketAggregateRoot` per gestire la logica di business.
   - Garantire che la radice aggregate impedisca operazioni non valide (es. scommesse su mercati chiusi).

4. **Sviluppo dei Proiettori**
   - Implementare proiettori per aggiornare le viste di lettura (`MarketSummaryProjector`, `UserBetProjector`, `PayoutReportProjector`).
   - Testare i proiettori per garantire che gestiscano correttamente gli eventi.

5. **Integrazione con l'Interfaccia Utente**
   - Creare controller per gestire le richieste degli utenti (es. creazione mercato, piazzamento scommesse).
   - Utilizzare la radice aggregate per registrare eventi in risposta alle azioni degli utenti.
   - Mostrare dati in tempo reale utilizzando le proiezioni.

6. **Testing**
   - Scrivere test per la radice aggregate, verificando che gli eventi siano registrati correttamente.
   - Testare i proiettori per garantire che le viste di lettura siano aggiornate come previsto.

## Best Practices dalle Piattaforme Esistenti

Analizzando piattaforme di successo, possiamo integrare diverse best practices nella nostra implementazione:

- **Trasparenza**: Seguire l'esempio di Polymarket e Augur, utilizzando tecnologie blockchain o registri immutabili per garantire che tutte le transazioni e i risultati siano verificabili.
- **User Experience**: Offrire un'interfaccia semplice e intuitiva come quella di Kalshi, con tutorial o mercati di prova (ispirati a Manifold Markets) per educare gli utenti.
- **Liquidità**: Implementare meccanismi come gli Automated Market Makers (AMM) di Ruckus Market per garantire che i mercati siano sempre attivi e i prezzi rappresentativi.
- **Gamification**: Aumentare l'engagement con elementi di gioco come classifiche o premi, seguendo l'approccio di Hedgehog Markets e Manifold Markets.
- **Conformità**: Considerare aspetti regolamentari, come fa Kalshi, specialmente per mercati legati a dati sensibili o decisioni sanitarie.

## Passaggi Aggiuntivi per l'Implementazione

7. **Ottimizzazione delle Performance**:
   - Implementare snapshot per ridurre il numero di eventi da rigiocare, come soluzione a mercati con alto volume (es. Polymarket durante le elezioni).
   - Utilizzare blockchain a basso costo o soluzioni layer-2 per minimizzare le spese operative, seguendo l'esempio di Hedgehog Markets su Solana.

8. **Sicurezza e Monitoraggio**:
   - Implementare controlli anti-frode, come limiti sulle scommesse per utente, e monitorare attività sospette con eventi dedicati (`SuspiciousActivityDetected`).
   - Garantire autenticazione forte per proteggere i dati degli utenti, specialmente in un contesto sanitario.

9. **Incentivazione e Community**:
   - Offrire ricompense per previsioni accurate, simile al sistema REPv2 di Augur, per migliorare la qualità dei dati raccolti.
   - Promuovere una community collaborativa, ispirandosi a Metaculus, per discutere trend sanitari o tecnologici.

## Esempio di Controller

```php
namespace Modules\Activity\Http\Controllers;

use Modules\Activity\Aggregates\<nome progetto>ionMarketAggregateRoot;
use Illuminate\Http\Request;

class <nome progetto>ionMarketController
{
    public function createMarket(Request $request)
    {
        $marketId = uniqid();
        $aggregate = <nome progetto>ionMarketAggregateRoot::createMarket(
            $marketId,
            $request->input('title'),
            $request->input('description'),
            $request->input('end_date'),
            auth()->user()->uuid
        );
        return response()->json(['market_id' => $marketId]);
    }

    public function placeBet(Request $request, $marketId)
    {
        $aggregate = <nome progetto>ionMarketAggregateRoot::retrieve($marketId);
        $aggregate->placeBet(
            auth()->user()->uuid,
            $request->input('option_id'),
            $request->input('amount'),
            now()->toString()
        );
        return response()->json(['success' => true]);
    }
}

## Considerazioni sulle Performance

- Implementare snapshot per la radice aggregate se i mercati hanno molti eventi.
- Utilizzare code per elaborare eventi in background, specialmente per l'aggiornamento delle probabilità.
