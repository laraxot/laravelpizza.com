# Trait HasTeams

## Descrizione
Il trait `HasTeams` fornisce funzionalità per la gestione dei team nell'applicazione. Permette agli utenti di appartenere a più team, gestire i ruoli all'interno dei team e controllare le autorizzazioni.

## Proprietà
- `$currentTeam`: Team attualmente selezionato dall'utente
- `$current_team_id`: ID del team corrente
- `$teams`: Collection di team a cui l'utente appartiene
- `$ownedTeams`: Collection di team di cui l'utente è proprietario

## Metodi Principali

### Relazioni
- `currentTeam()`: Restituisce la relazione con il team corrente
- `teams()`: Restituisce la relazione many-to-many con i team
- `ownedTeams()`: Restituisce la relazione one-to-many con i team posseduti

### Gestione Team
- `switchTeam(Team $team)`: Cambia il team corrente
- `allTeams()`: Restituisce tutti i team dell'utente
- `personalTeam()`: Restituisce il team personale dell'utente
- `createTeam(array $input)`: Crea un nuovo team
- `updateTeamName(Team $team, string $name)`: Aggiorna il nome del team
- `deleteTeam(Team $team)`: Elimina un team

### Verifiche
- `belongsToTeam(Team $team)`: Verifica se l'utente appartiene al team
- `ownsTeam(Team $team)`: Verifica se l'utente è proprietario del team
- `isCurrentTeam(TeamContract $team)`: Verifica se il team è quello corrente

### Gestione Membri
- `addTeamMember(Team $team, string $email, ?string $role)`: Aggiunge un membro al team
- `removeTeamMember(Team $team, int $userId)`: Rimuove un membro dal team
- `inviteToTeam(UserContract $user, TeamContract $team)`: Invita un utente al team
- `removeFromTeam(UserContract $user, TeamContract $team)`: Rimuove un utente dal team

### Ruoli e Permessi
- `teamRole(Team $team)`: Restituisce il ruolo dell'utente nel team
- `teamPermissions(Team $team)`: Restituisce i permessi dell'utente nel team
- `hasTeamPermission(Team $team, string $permission)`: Verifica se l'utente ha un permesso specifico
- `hasTeamRole(TeamContract $team, string $role)`: Verifica se l'utente ha un ruolo specifico

### Autorizzazioni
- `canManageTeam(Team $team)`: Verifica se l'utente può gestire il team
- `canAddTeamMembers(Team $team)`: Verifica se l'utente può aggiungere membri
- `canDeleteTeam(Team $team)`: Verifica se l'utente può eliminare il team
- `canRemoveTeamMembers(Team $team)`: Verifica se l'utente può rimuovere membri
- `canUpdateTeam(Team $team)`: Verifica se l'utente può aggiornare il team

## Utilizzo
```php
use Modules\User\Models\Traits\HasTeams;

class User extends Authenticatable
{
    use HasTeams;
    
    // ... resto del codice
}
```

## Note
- Il trait richiede che il modello utilizzi anche il trait `HasRoles` per la gestione dei ruoli
- È necessario avere una tabella pivot `team_user` con le colonne `user_id`, `team_id`, `role` e `timestamps`
- La tabella dei team deve avere le colonne `id`, `name`, `personal_team`, `owner_id` e `timestamps` 