Aggiornamento di governance collegato al fix recente:

oltre al pattern docs-first e al divieto di usare `/tmp`, ho formalizzato anche il quality gate obbligatorio post-edit per i file PHP.

Da ora, dopo ogni modifica PHP:

- `phpstan`
- `phpmd`
- `phpinsights`
- verifica/creazione/aggiornamento del test Pest associato se il comportamento e' testabile

La regola e' stata registrata nelle docs globali e negli indici docs di `Modules/Xot` e `Themes/Meetup`, cosi' i prossimi fix non si fermano al solo ripristino funzionale ma includono anche il controllo strutturale e il test associato.
