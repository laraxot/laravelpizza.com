# Modello di Dominio - Prediction Market

## Aggregate
- **Market**: rappresenta un mercato predittivo
- **Bet**: rappresenta una scommessa
- **Outcome**: rappresenta un possibile esito

## Eventi
- `MarketCreated`
- `BetPlaced`
- `MarketClosed`
- `PayoutProcessed`

## Comandi
- `CreateMarket`
- `PlaceBet`
- `CloseMarket`
- `ProcessPayout`

## Proiezioni
- **MarketStatus**: stato attuale dei mercati
- **UserBalance**: saldo utente aggiornato in tempo reale
- **BetHistory**: storico delle scommesse

## Esempio di evento
```php
class BetPlaced implements ShouldBeStored
{
    public function __construct(
        public string $marketUuid,
        public string $userUuid,
        public float $amount,
        public string $outcome
    ) {}
}
``` 
