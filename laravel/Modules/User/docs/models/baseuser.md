# BaseUser

## Descrizione
Classe base per il modello User che implementa le interfacce `UserContract` e `HasTeamsContract`.
## Proprietà
### Attributi del Modello
- `id` (string): UUID dell'utente
- `name` (string|null): Nome completo dell'utente
- `first_name` (string|null): Nome dell'utente
- `last_name` (string|null): Cognome dell'utente
- `email` (string|null): Email dell'utente
- `password` (string|null): Password criptata
- `lang` (string|null): Lingua preferita
- `current_team_id` (string|null): ID del team corrente
- `is_active` (bool|null): Stato di attivazione dell'account
- `is_otp` (bool|null): Flag per One Time Password
- `password_expires_at` (DateTime|null): Data di scadenza della password
- `email_verified_at` (DateTime|null): Data di verifica email
- `remember_token` (string|null): Token per "ricordami"
### Attributi di Sistema
- `created_at` (DateTime|null): Data di creazione
- `updated_at` (DateTime|null): Data di ultimo aggiornamento
- `deleted_at` (DateTime|null): Data di cancellazione soft
- `created_by` (string|null): ID utente creatore
- `updated_by` (string|null): ID ultimo utente che ha modificato
- `deleted_by` (string|null): ID utente che ha cancellato
- `profile_photo_path` (string|null): Percorso foto profilo
### Relazioni
- `clients` (Collection<int, OauthClient>): Client OAuth
- `currentTeam` (Team|null): Team corrente
- `devices` (Collection<int, Device>): Dispositivi associati
- `notifications` (DatabaseNotificationCollection<int, DatabaseNotification>): Notifiche
- `ownedTeams` (Collection<int, Team>): Team posseduti
- `permissions` (Collection<int, Permission>): Permessi
- `roles` (Collection<int, Role>): Ruoli
- `teams` (Collection<int, Team>): Team di appartenenza
- `tenants` (Collection<int, Tenant>): Tenant di appartenenza
- `tokens` (Collection<int, OauthAccessToken>): Token OAuth
- `socialiteUsers` (Collection<int, SocialiteUser>): Account social collegati
## Metodi
- `tenants()`: BelongsToMany<Tenant>
- `teams()`: BelongsToMany<Team>
- `ownedTeams()`: HasMany<Team>
- `roles()`: BelongsToMany<Role>
- `devices()`: BelongsToMany<Device>
- `socialiteUsers()`: HasMany<SocialiteUser>
- `notifications()`: MorphMany<DatabaseNotification>
- `latestAuthentication()`: MorphOne<AuthenticationLog>
### Gestione Team
- `belongsToTeam(TeamContract $team)`: bool
- `ownsTeam(TeamContract $team)`: bool
- `teamPermissions(TeamContract $team)`: array<string, bool>
- `hasTeamPermission(TeamContract $team, string $permission)`: bool
### Gestione Ruoli
- `hasRole($roles, ?string $guard = null)`: bool
- `assignRole($roles)`: $this
- `removeRole($role)`: $this
## Trait Utilizzati
- HasApiTokens
- HasFactory
- HasRoles
- HasTeams
- HasUuids
- HasAuthenticationLogTrait
- HasTenantsRelation
- Notifiable
- RelationX
## Note PHPStan
- Tutti i metodi sono correttamente tipizzati
- Le relazioni utilizzano tipi generici
- I controlli di tipo sono implementati con `instanceof`
- La documentazione PHPDoc è completa e in italiano
## Collegamenti
- [Documentazione PHPStan](/docs/modules/user/phpstan.md)
- [Contratti del Modulo User](/docs/modules/user/contracts.md)
- [Best Practices per i Modelli](/docs/modules/user/models.md)
- [Documentazione PHPStan](/project_docs/modules/user/phpstan.md)
- [Contratti del Modulo User](/project_docs/modules/user/contracts.md)
- [Best Practices per i Modelli](/project_docs/modules/user/models.md)
