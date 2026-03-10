# Memory: Profile Contract PHPDoc

- I PHPDoc di relazioni audit/profile (`creator`, `updater`, `deleter`) devono usare `\Modules\Xot\Contracts\ProfileContract|null`.
- Un riferimento a `Modules\*\Models\Profile` in questi campi e' una regressione di tipizzazione, anche se il model concreto oggi coincide con l'implementazione corrente.
- La regola vale soprattutto dopo wave `ide-helper:models -W`, che possono reintrodurre tipi concreti troppo stretti.
