# Profile Contract DocBlock Memory

- Regola consolidata: `creator`, `updater`, `deleter` devono essere annotati come `\Modules\Xot\Contracts\ProfileContract|null`.
- `ide-helper:models -W` puo' rigenerare questi PHPDoc usando un modello concreto, ad esempio `\Modules\Meetup\Models\Profile|null`.
- Quel risultato non va accettato ciecamente: e' troppo stretto rispetto al contratto reale del dominio.
