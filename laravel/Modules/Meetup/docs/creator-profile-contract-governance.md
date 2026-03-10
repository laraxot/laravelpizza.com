# Creator ProfileContract Governance

Nel modulo Meetup, le annotazioni PHPDoc di audit (`creator`, `updater`, `deleter`) devono usare:

- `\Modules\Xot\Contracts\ProfileContract|null`

Non usare il modello concreto `\Modules\Meetup\Models\Profile` nelle annotazioni audit per evitare coupling inter-modulo.

Questa regola vale anche dopo refresh automatici (`ide-helper:models -W`): se il tool reintroduce tipi concreti, correggere subito in forward-only.
