---
title: "[STORY] PHPStan trait.unused: relazioni estratte nei *RelationsTrait e non composte"
type: story
status: review
priority: high
created: 2026-11-05
updated: 2026-11-05
scope: module:User (+ rimando module:Lang)
tags: [phpstan, trait-unused, merge-regression, user, lang, bmad, swarm]
related:
  - "../../../Lang/docs/stories/phpstan-zero-errors-lang.story.md"
  - "13.9.baseuser-trait-consolidation.story.md"
  - "5.1.user-lang-phpstan-debt.story.md"
---
# Story: PHPStan trait.unused (14 trait User + 2 trait Lang)

Fase BMAD: analisi -> fix -> verifica. Swarm `phpstan-swarm-unused-traits`.

## User Request
16 errori `trait.unused` ("is used zero times and is not analysed"). Un trait mai usato e' un segnale di design: va capito
se il modello doveva comporlo, se e' codice morto o se e' duplicato, prima di toccare qualunque cosa.

## Analysis (causa radice)
Un solo evento, non 16 svarioni.

| Commit | Cosa |
|--------|------|
| `bd6a68733` (2026-11-05 20:20) | merge da `laraxot/dev`: crea i `*RelationsTrait` **e** fa comporre ai modelli `use XRelationsTrait;` (stato coerente) |
| `dc34e53d6` (20:29, commit `.`) | spazza nel repo i modelli con marcatori `<<<<<<< HEAD / >>>>>>> laraxot/dev`: lato HEAD = relazioni **inline**, lato `laraxot/dev` = `use XRelationsTrait;` |
| worktree (20:37) | risoluzione dei marcatori scegliendo ovunque il lato HEAD: i modelli riavuti con le relazioni inline, i trait orfani |

Verifica che non si tratta di relazioni mancanti: per tutti e 14 i trait User, nome e corpo di ogni metodo sono identici
(spazi normalizzati, Reflection) al metodo inline del modello. A runtime nulla mancava; mancava la composizione voluta
dal design a trait di `bd6a68733` (relazioni di un modello in un trait dedicato, come gia' `BaseUserRelations`).
Per Lang: due copie di ciascun trait. Le sottocartelle `Traits/Mutators/` e `Traits/Relationships/` (con `.gitkeep`) arrivano
col merge coerente e hanno `getTxt(?string $value = null)`; le copie piatte `Traits/PostMutators.php` e `PostRelations.php`
sono entrate solo col commit `.` (contenuto stale, `getTxt(?string $value)` con argomento obbligatorio). Nessun chiamante di `getTxt()`.

Regola applicata (memoria `merge-script-collision-patterns`): scegliere per significato, non "ours/theirs" alla cieca; il lato stale non e' una decisione.

## Decisione per trait

| Trait | Scopo | Decisione | Prova |
|-------|-------|-----------|-------|
| `SsoProviderRelationsTrait` | `users()` | composto in `SsoProvider` | corpi identici; `SsoProvider::users` -> HasMany |
| `AuthenticationLogRelationsTrait` | `authenticatable()` | composto in `AuthenticationLog` | idem; -> MorphTo |
| `AuthenticationRelationsTrait` | `authenticatable()` | composto in `Authentication` | idem; -> MorphTo |
| `OauthPersonalAccessClientRelationsTrait` | `client()` | composto in `OauthPersonalAccessClient` | idem; -> BelongsTo |
| `BaseTeamUserRelationsTrait` | `user()`, `team()` | composto in `BaseTeamUser` | idem; `TeamUser::user/team` -> BelongsTo |
| `ProfileRelationsTrait` | `teams()` | composto in `Profile` come unico `use`; dal 2026-11-06 senza `insteadof` (vedi "Aggiornamento Profile") | classe caricata da Reflection; `Profile::teams` -> BelongsToMany |
| `DeviceRelationsTrait` | `users()` | composto in `Device` | idem; -> BelongsToMany |
| `DeviceUserRelationsTrait` | `device()`, `user()`, `profile()` | composto in `DeviceUser` | idem; 3 BelongsTo |
| `RoleRelationsTrait` | `team()`, `permissions()` | composto in `Role` | idem; BelongsTo + BelongsToMany |
| `TeamPermissionRelationsTrait` | `team()`, `user()` | composto in `TeamPermission` | idem; 2 BelongsTo |
| `SocialiteUserRelationsTrait` | `user()` | composto in `SocialiteUser` | idem; -> BelongsTo |
| `TeamInvitationRelationsTrait` | `team()` | composto in `TeamInvitation` | idem; -> BelongsTo |
| `BaseTeamRelationsTrait` | `owner()`, `users()`, `teamUsers()`, `members()`, `teamInvitations()` | composto in `BaseTeam` | idem; `Team::owner/users/members/teamUsers/teamInvitations` ok |
| `BaseTenantRelationsTrait` | `members()`, `users()` | composto in `BaseTenant` (edit mirata, vedi "Fuori perimetro") | idem; `Tenant::members/users` -> BelongsToMany |
| `Lang\...\Mutators\PostMutators` | accessor/mutator di `Post` | composto in `Post` al posto della copia piatta | `Post::getTxt()` senza argomenti -> `''`; classe caricata |
| `Lang\...\Relationships\PostRelations` | `linkable()` | composto in `Post` al posto della copia piatta | `Post::linkable` -> MorphTo |

Esecuzione: per 13 modelli il contenuto e' stato riscritto in avanti da `git show bd6a68733:<file>` dopo aver verificato che il diff
rispetto a quel commit contenesse solo relazioni inline, import e newline finale. `BaseTenant` e `Post` con edit mirata. Nessun file cancellato,
nessun `@phpstan-ignore`, nessuna baseline, `phpstan.neon` intatto.

## Aggiornamento Profile (2026-11-06, collisione del sync delle 07:38)
Il sync ha di nuovo incrociato due versioni di `Profile`: il lato nostro componeva `use HasRoles, HasSchemalessAttributes, InteractsWithMedia, ProfileRelationsTrait { ProfileRelationsTrait::teams insteadof HasRoles; }`,
il lato `laraxot/dev` solo `use ProfileRelationsTrait;` accanto a `use HasRoles;`. Il secondo e' un **fatal in autoload**
(`Trait method Spatie\Permission\Traits\HasRoles::teams has not been applied as Modules\User\Models\Profile::teams, because of collision with ProfileRelationsTrait::teams`,
provato con bootstrap reale: `php -l` non lo vede). Il primo funziona, ma l'`insteadof` esiste solo perche' `Profile` ricompone tre trait che `BaseProfile` usa gia'.

Riscrittura: `Profile` compone solo `ProfileRelationsTrait` (e non dichiara piu' `implements HasMedia`, che `BaseProfile` eredita da `ProfileContract`). Il metodo del trait
sovrascrive quello ereditato da Spatie, come faceva il metodo inline di prima del sync: nessun alias, nessuna collisione. Prova per Reflection contro la versione `insteadof`:
597 metodi non privati con stessi nomi, firme e file di origine; `class_uses_recursive` (25) e `class_implements` (11) uguali; `teams()` -> `BelongsToMany(Team)` definito in `ProfileRelationsTrait.php`.
Unica differenza: tre cache `private` del trait Spatie (`roleClass`, `permissionClass`, `wildcardClass`) non sono piu' duplicate nella sottoclasse. Dettagli nella story `collision-rewrite-complete-files`
([Xot](../../../Xot/docs/stories/collision-rewrite-complete-files.story.md)).

## Fuori perimetro (serve decisione umana)
1. **Candidati a rimozione, non cancellati:** `Lang/app/Models/Traits/PostMutators.php` e `PostRelations.php` (copie piatte stale). Ora PHPStan li segnala
   `trait.unused`: sono il duplicato effettivo, sostituito dalle copie nelle sottocartelle.
2. **`BaseTenant` ha perso `HasUuids`** (con l'alias di `resolveRouteBindingQuery`) nella stessa risoluzione dei marcatori: `bd6a68733` aveva
   `use HasUuids` + il commento "La chiave e' una stringa: senza un id esplicito viene generato un UUID". Restano `$incrementing = false` e
   `$keyType = 'string'`, quindi un tenant creato senza `id` non riceve piu' la chiave. Non toccato: non e' una relazione; va deciso da chi ha risolto.
3. Rimasti `trait.unused` non di questo lotto: `HasStrictTranslations` (Lang), `BaseUserUniqueNameAttribute`, `HasPasswordExpiry`, `Traits/HasRoles` (User).
4. Pest non eseguibile in questo ambiente: `TestCase` fallisce con `Access denied for user ''@'localhost'` (credenziali DB di test mancanti), indipendente da questa modifica.

## Verifica
- `php -l` su 15 file: nessun errore.
- Reflection: le 14 classi User e `Post` si caricano (all'epoca anche `insteadof` di `Profile`, poi superato: vedi "Aggiornamento Profile").
- Runtime senza query: 25 relazioni costruite sui modelli (HasMany/BelongsTo/BelongsToMany/MorphTo attesi).
- Pint: `single_blank_line_at_eof` su `BaseTenant`, `phpdoc_align` su `Post`.
- PHPStan `analyse Modules/User/app/Models Modules/Lang/app/Models`: errori 20 -> 6, tutti `trait.unused`. I 16 del lotto sono risolti e nessun errore nuovo
  e' comparso dentro i trait ora analizzati. I 6 residui: 4 di altri lotti (punto 3) + le 2 copie piatte di Lang (punto 1).

## GitHub (tracciamento)
- Issue: TODO (`gh` non disponibile in questo ambiente)
- Discussion: TODO
