# TeamPermission

Il modello `TeamPermission` rappresenta i permessi specifici di un utente all'interno di un team.

## Proprietà

- `id` - UUID del permesso
- `team_id` - ID del team
- `user_id` - ID dell'utente
- `permission` - Nome del permesso
- `created_at` - Data di creazione
- `updated_at` - Data di ultimo aggiornamento

## Relazioni

- `team` - BelongsTo con `Team`, rappresenta il team a cui appartiene il permesso
- `user` - BelongsTo con `User`, rappresenta l'utente a cui è assegnato il permesso

## Note Importanti

- Il modello utilizza la connessione 'user'
- I campi fillable sono:
  - `team_id`
  - `user_id`
  - `permission`

## Collegamenti Correlati

- [[Team]]
- [[User]]
- [[HasTeamsContract]] 
