
## Fix base 2026-08-30 — proprietà `$pivot` che oscurava la relation pivot

`BaseUser` dichiarava `public ?Pivot $pivot = null;`: una proprietà PHP reale
oscura il magic `__get` di Eloquent, quindi **ogni** `belongsToMany` verso User
restituiva modelli con `->pivot === null` (e l'eager loading esplodeva in
`BelongsToMany::buildDictionary` con "Attempt to read property ... on null").
La proprietà è stata rimossa (resta il PHPDoc `@property Pivot|null $pivot`).

Regola generale: mai dichiarare proprietà PHP reali con lo stesso nome di
attributi/relazioni Eloquent — vale per `pivot` come per le colonne.

## Fix suite test User in locale (2026-08-30)

- TestCase: `prepareSharedFixcitySqliteForTesting()` in setUp (ambiente senza
  MariaDB dedicato) + `connectionsToTransact = ['user']` quando default sqlite.
  Da 1059 crash PDO → ~70 failure reali (874 pass).
- `config/permission.php`: `teams => true` ma `models.team` assente →
  `TeamModelNotConfigured` su ogni uso teams spatie. Aggiunto
  `'team' => Modules\User\Models\Team::class`.
- Fixture `HasUserTestCaseFixture`: ridefiniva `public User $user` incompatibile
  con la `protected User $user` del trait → FatalException in composizione che
  troncava l'intera suite. Rimossa la duplicazione.
- `UserModelTest` "can join ateam": `BaseUser` aliasa `HasTeams::teams as
  membershipTeams`, quindi `$user->teams` è la relazione spatie/permission
  (`model_has_role`), NON `team_user`. L'assert ora usa `membershipTeams`.
