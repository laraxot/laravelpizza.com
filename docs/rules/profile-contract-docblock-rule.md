# Profile Contract DocBlock Rule

Quando un model espone relazioni trasversali come `creator`, `updater` o `deleter`, il PHPDoc deve usare il contratto:

- `\Modules\Xot\Contracts\ProfileContract|null`

e non un'implementazione concreta come:

- `\Modules\Meetup\Models\Profile|null`

## Motivazione

- il consumer dipende dal contratto di dominio, non dal modulo concreto attualmente risolto;
- ide-helper puo' indovinare un modello concreto sbagliato o troppo stretto;
- il PHPDoc deve restare contract-first e stabile anche se cambia l'implementazione sottostante.

## Regola operativa

- dopo `php artisan ide-helper:models -W`, controllare sempre i campi `creator`, `updater`, `deleter`;
- se il generatore scrive un tipo concreto di modulo, correggerlo forward-only al contratto `ProfileContract`.
