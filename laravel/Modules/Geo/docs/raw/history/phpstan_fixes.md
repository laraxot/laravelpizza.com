# Correzioni PHPStan per il Modulo User

## Problemi Principali

### BaseUser.php

1. Proprietà non definite:
   - `$pivot`
   - `$email`
   - `$first_name`
   - `$last_name`
   - `$current_team_id`

2. Metodi non definiti:
   - `hasRole()`
   - `teams()`
   - `ownedTeams()`
   - `belongsToTeam()`
   - `teamRole()`
   - `ownsTeam()`
   - `hasTeamPermission()`
   - `belongsToManyX()`
   - `socialiteUsers()`
   - `authentications()`

3. Problemi di tipo:
   - Parametro `$role` in `hasRole()` senza tipo specificato
   - Parametro `$related` in `belongsToManyX()` richiede `class-string<Model>`
   - Tipo template `TRelatedModel` non risolto in `belongsToManyX()`

### Soluzioni Proposte

1. Definire le proprietà mancanti:
   ```php
   /**
    * @property string|null $email
    * @property string|null $first_name
    * @property string|null $last_name
    * @property string|null $current_team_id
    * @property \Illuminate\Database\Eloquent\Relations\Pivot|null $pivot
    */
   ```

2. Implementare i metodi mancanti:
   ```php
   public function hasRole(string $role): bool
   {
       return $this->roles()->where('name', $role)->exists();
   }

   public function teams(): BelongsToMany
   {
       return $this->belongsToManyX(Team::class);
   }
   ```


### Altri File

1. Profile.php:
   - Correggere i riferimenti alle classi non esistenti nei PHPDoc
   - Aggiungere le classi mancanti o correggere i namespace

2. HasAuthenticationLogTrait.php:
   - Implementare il metodo `authentications()`
   - Gestire correttamente i tipi di ritorno

3. HasTeams.php:
   - Implementare i metodi mancanti
   - Correggere i tipi di ritorno

4. HasTenants.php:
   - Implementare i metodi mancanti
   - Correggere i tipi di ritorno

## Prossimi Passi

1. Correggere il modello `BaseUser.php`
2. Aggiornare i trait con i metodi mancanti
3. Correggere i tipi nei modelli e nelle relazioni
4. Aggiornare la documentazione delle classi
5. Eseguire nuovamente PHPStan per verificare le correzioni 