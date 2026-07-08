# Team

Il modello `Team` rappresenta un team nel sistema, implementando l'interfaccia `TeamContract`.

## Proprietà

- `id` - UUID del team
- `name` - Nome del team
- `owner_id` - ID del proprietario del team
- `personal_team` - Flag che indica se è un team personale

## Relazioni

- `owner` - BelongsTo con `User`, rappresenta il proprietario del team
- `users` - BelongsToMany con `User`, rappresenta i membri del team
- `teamPermissions` - HasMany con `TeamPermission`, rappresenta i permessi specifici del team

## Metodi

### Gestione Utenti

- `hasUser(UserContract $user): bool` - Verifica se un utente è membro del team
- `addUser(UserContract $user, string $role = 'member'): void` - Aggiunge un utente al team
- `removeUser(UserContract $user): void` - Rimuove un utente dal team
- `purge(): void` - Rimuove tutti gli utenti dal team

### Gestione Permessi

- `getPermissionsFor(?UserContract $user): array<string, bool>` - Ottiene i permessi di un utente nel team
- `teamPermissions(): HasMany` - Relazione con i permessi del team

## Note Importanti

- Il modello utilizza UUID come chiave primaria
- Implementa l'interfaccia `TeamContract`
- Gestisce i permessi attraverso la relazione `teamPermissions`

## Motivazione: preferire TeamContract a Team nei trait e nei metodi

Quando si sviluppano trait, metodi condivisi o interfacce che devono funzionare con diversi tipi di team (anche custom o estesi), è fondamentale tipizzare e accettare sempre `TeamContract` invece di `Team`:

- **Aderenza all'architettura modulare**: usando l'interfaccia `TeamContract`, i trait e i metodi rimangono compatibili con qualsiasi implementazione di team, anche in presenza di override o estensioni future.
- **Testabilità**: le interfacce permettono di creare facilmente mock e stub nei test, migliorando la copertura e la qualità del codice.
- **Manutenibilità**: riduce il rischio di accoppiamento rigido con una singola implementazione (`Team`), facilitando refactor e sostituzioni.
- **Compatibilità futura**: se in futuro si dovesse introdurre un nuovo tipo di team (es. `TenantTeam`, `ProjectTeam`), i trait e i metodi funzioneranno senza modifiche.
- **Best practice Laravel**: è coerente con le best practice Laravel e PHP moderne, che raccomandano di dipendere sempre da contratti/interfacce nei componenti riutilizzabili.

> **Regola**: Nei trait e nei metodi condivisi, accetta e restituisci sempre `TeamContract` (o interfacce analoghe), mai direttamente `Team`.

## Collegamenti Correlati

- [[TeamContract]]
- [[User]]
- [[TeamPermission]]
- [[HasTeamsContract]] 
