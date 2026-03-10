# Creator Profile Contract Rule

## Regola

Per i model PHPDoc del progetto, le proprieta' di audit (`creator`, `updater`, `deleter`) devono usare il contratto:

- `\Modules\Xot\Contracts\ProfileContract|null`

e non classi concrete di modulo (es. `\Modules\Meetup\Models\Profile|null`).

## Motivazione

- disaccoppia i moduli dal modello concreto profilo;
- mantiene compatibilita' con boundary condiviso Xot;
- evita regressioni di tipizzazione quando cambiano implementazioni locali.
