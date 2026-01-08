# TeamContract

L'interfaccia `TeamContract` definisce il contratto per i team nel sistema.

## Metodi

### Gestione Utenti

- `users(): BelongsToMany<Model&UserContract>` - Ottiene tutti gli utenti che appartengono al team
- `owner(): BelongsTo` - Ottiene il proprietario del team
- `hasUser(UserContract $user): bool` - Verifica se un utente appartiene al team
- `addUser(UserContract $user, ?string $role = null): void` - Aggiunge un utente al team
- `removeUser(UserContract $user): void` - Rimuove un utente dal team
- `allUsers(): Collection<int, Model&UserContract>` - Ottiene tutti gli utenti del team, incluso il proprietario
- `members(): Collection<int, Model&UserContract>` - Ottiene tutti i membri del team
- `hasUserWithEmail(string $email): bool` - Verifica se il team ha un utente con l'email specificata

### Gestione Permessi

- `getPermissionsFor(UserContract $user): array<string, bool>` - Ottiene i permessi per un utente specifico
- `userHasPermission(UserContract $user, string $permission): bool` - Verifica se un utente ha un permesso specifico

### Gestione Inviti

- `teamInvitations(): HasMany<TeamInvitation>` - Ottiene gli inviti pendenti per il team

### Altre Operazioni

- `purge(): void` - Elimina tutte le risorse del team
- `fresh($with = []): ?static` - Ricarica un'istanza fresca del modello dal database

## Note Importanti

- L'interfaccia estende `ModelContract`
- Richiede che la classe che la implementa estenda `Model` (`@phpstan-require-extends Model`)
- Gestisce sia gli utenti che i permessi del team
- Supporta il concetto di ruoli e permessi granulari

## Collegamenti Correlati

- [[ModelContract]]
- [[UserContract]]
- [[TeamInvitation]]
- [[Team]]
- [[User]] 
