# No /tmp Usage Memory

Data: 2026-03-09

## Vincolo utente
`/tmp` e' vietato per questo progetto.

## Decisione operativa
Tutti i file intermedi agent devono restare nel repository, preferendo:
- `docs/_work/` per note/comandi
- `storage/app/agent/` per output runtime

Promemoria forte:

- Non usare `/tmp` nemmeno per body markdown di `gh`, report di test o output diagnostici.
- Se un workflow legacy nel progetto mostra ancora `/tmp`, trattarlo come debito documentale da correggere progressivamente.

## Azione correttiva
Aggiornate rule e skill dedicate per prevenire recidive.
