# Meetup Lifecycle + GDPR Integration Rule

## Regola

Le funzionalita' di proposta/approvazione meetup, RSVP, commenti, GDPR e profilo utente devono essere implementate come flusso integrato su moduli esistenti (`Meetup`, `Gdpr`, `User`) con test Pest end-to-end.

## Vincoli

1. Nessun nuovo modulo per sotto-domini eventi.
2. Ogni requisito deve avere almeno un test Pest di comportamento.
3. Le policy di visibilita' (`pending` owner-only, `approved` public) sono obbligatorie.
4. Ogni milestone deve essere tracciata in issue/discussion.
