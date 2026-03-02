# Proiettori per Prediction Market

I proiettori sono utilizzati per creare viste di lettura basate sugli eventi del prediction market. Queste viste possono essere utilizzate per report, dashboard o per fornire dati in tempo reale agli utenti.

## Proiettori Principali

1. **MarketSummaryProjector**
   - **Evento gestito**: `MarketCreated`, `MarketUpdated`, `MarketResolved`
   - **Descrizione**: Aggiorna una tabella di riepilogo dei mercati con informazioni come stato, probabilità correnti e risultato finale.
   - **Tabella di destinazione**: `market_summaries`

2. **UserBetProjector**
   - **Evento gestito**: `BetPlaced`
   - **Descrizione**: Registra tutte le scommesse degli utenti per permettere di visualizzare lo storico delle scommesse.
   - **Tabella di destinazione**: `user_bets`

3. **PayoutReportProjector**
   - **Evento gestito**: `PayoutDistributed`
   - **Descrizione**: Crea un report dei pagamenti distribuiti agli utenti vincitori.
   - **Tabella di destinazione**: `payout_reports`

## Esempio di Proiettore

**MarketSummaryProjector**:
```php
namespace Modules\Activity\Projectors\PredictionMarket;

use Modules\Activity\Events\PredictionMarket\MarketCreated;
use Modules\Activity\Events\PredictionMarket\MarketUpdated;
use Modules\Activity\Events\PredictionMarket\MarketResolved;
use Modules\Activity\Models\MarketSummary;

class MarketSummaryProjector
{
    public function onMarketCreated(MarketCreated $event, string $marketId)
    {
        $summary = MarketSummary::findOrCreate($marketId);
        $summary->title = $event->title;
        $summary->description = $event->description;
        $summary->end_date = $event->endDate;
        $summary->creator_id = $event->creatorId;
        $summary->status = 'open';
        $summary->save();
    }

    public function onMarketUpdated(MarketUpdated $event, string $marketId)
    {
        $summary = MarketSummary::findOrFail($marketId);
        $summary->probabilities = $event->newProbabilities;
        $summary->save();
    }

    public function onMarketResolved(MarketResolved $event, string $marketId)
    {
        $summary = MarketSummary::findOrFail($marketId);
        $summary->status = 'resolved';
        $summary->winning_option_id = $event->winningOptionId;
        $summary->save();
    }
}
```

## Considerazioni

- I proiettori devono essere idempotenti per evitare problemi in caso di rigiocata degli eventi.
- Le tabelle di proiezione devono essere ottimizzate per le query più comuni (es. indici su `marketId` e `userId`).
