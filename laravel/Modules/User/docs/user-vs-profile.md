---
title: "User e Profile: due modelli, due responsabilita'"
type: concept
module: User
tags: [user, profile, uuid, avatar, models]
qmd: "user vs profile separazione modelli BaseProfile uuid id autoincrement avatar UserDropdown schemaless extra"
---

# User e Profile

## Decisione

Il modulo separa **identita' di accesso** e **dati personali**:

| | `User` (`BaseUser`) | `Profile` (`BaseProfile`) |
|---|---|---|
| Responsabilita' | autenticazione e autorizzazione | dati di profilo e preferenze |
| Contenuto tipico | `email`, `password`, `remember_token`, `email_verified_at`, `type`, `state`, `is_active`, `lang`, `deleted_at`, colonne 2FA, `current_team_id` | `first_name`, `last_name`, `phone`, `address`, `birth_date`, `gender`, `email`, `bio`, `avatar`, `timezone`, `locale`, `preferences`, `status`, `is_active`, `extra` |
| Mai | dati anagrafici pubblici | credenziali e token |
| Relazione | `BaseUserRelations::profile()` = `hasOne(XotData::make()->getProfileClass())` | `user_id` verso l'utente; `$with = ['user']` |
| Connessione | `user` | `user` (la aggiunge anche il progetto che ne estende il modello) |

Motivi: la tabella utenti e' sul percorso critico dell'autenticazione (ogni richiesta, ogni cache di sessione) e deve restare piccola
e stabile; i dati di profilo cambiano per progetto e per tipo di utente e non devono viaggiare con il token. L'alternativa "un unico
modello" e' piu' semplice (nessun join, transazioni piu' facili) ma mescola credenziali e dati pubblici; si usa solo dove il progetto
non ha dati di profilo propri. La classe concreta di User e di Profile si risolve sempre con `XotData::make()->getUserClass()` e
`->getProfileClass()`, mai con un nome hardcodato.

## Contratto di identita' del Profile

- `id`: chiave primaria intera auto-increment (join, indici, relazioni legacy).
- `uuid`: identificatore esterno separato, char(36) univoco, per API, import e correlazione tra sistemi (non espone id sequenziali).
- `BaseProfile` genera `uuid` in `booted()` con `Str::uuid()` se manca; `id` non e' in `$fillable`. Per lookup da API: scope
  `byUuid($uuid)`.
- Riparazione di installazioni con `id` UUID: vedi la tabella "Correzioni di schema" di [migration-consolidation.md](migration-consolidation.md).

## Tipi di utente

`User::$childTypes` (pacchetto Parental, colonna `type`) mappa i valori `master_admin`, `backoffice_user`, `customer_user`, `system`,
`technician`, `waiter_user` sulla stessa classe `User`; l'enum `UserType` (`master_admin`, `backoffice_user`, `customer_user`,
`system`, `technician`) fornisce etichetta, colore, icona e guard predefinita (`api` per `technician`, `web` per gli altri). Vedi
[models-and-inheritance.md](models-and-inheritance.md).

## Avatar

- `UserDropdown` risolve l'avatar con questo ordine: `Profile::getAvatarUrl()` se il metodo esiste, poi `$profile->avatar_url`, poi un
  fallback predefinito (SVG di avatar). `BaseProfile` e `User` usano `InteractsWithMedia` (Spatie MediaLibrary) per i file caricati.
- Gli SVG predefiniti non sono inline nelle Blade: file `.svg` registrati come icone (vedi la regola SVG di piattaforma).
- `UserDropdown::logout()` e' un secondo punto di uscita (guard `web`, invalidazione sessione, redirect a `/{locale}`): per la regola
  generale vedi [logout.md](logout.md).

## Dati liberi e profilo esteso

`Profile` usa `SchemalessAttributes` (Spatie) sulla colonna `extra` per attributi non strutturati. Il formato JSON-LD `schema.org/Person`
per il profilo pubblico non e' implementato nel modulo (nel codice non esiste alcun generatore): se serve, va progettato nel tema o in un
modulo di SEO, non in User.

## Verifica

- `tests/Unit/Models/` (modelli), `tests/Feature/UserModelTest.php`, factory `ProfileFactory`/`UserFactory` (vedi [testing-and-factories.md](testing-and-factories.md)).
