Aggiornamento avanzamento:

- root cause confermato e corretto in `Modules/Cms/app/Actions/ResolvePageAction.php`;
- il dettaglio evento ora riceve il model dinamico invece di cadere sul fallback CMS;
- `/it/events/ut-quae-facere-placeat-labore-expedita-TwKN` risponde `200`;
- il contenuto contiene il titolo atteso e non mostra piu `Nessun evento trovato`.

Verifica automatizzata eseguita:

- `Modules/Cms/tests/Unit/Actions/ResolvePageActionTest.php`
- `Modules/Meetup/tests/Feature/EventDetailPageTest.php`

Esito Pest: `5 passed (14 assertions)`.
