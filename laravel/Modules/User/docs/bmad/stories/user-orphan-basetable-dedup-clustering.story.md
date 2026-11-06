---
title: "User: dedup BaseUsersTable orfano, colonne unificate, audit clustering"
type: story
status: in-progress
epic: "USER-MODULE-EXCELLENCE"
module: User
created: 2026-09-29
updated: 2026-09-29
supersedes: null
related:
  - user-filament-boundary-i18n.story.md
tags: [docs, user, bmad]
qmd: "story   user: dedup baseuserstable orfano + audit clustering/widget/action user"
---

# Story: User: dedup BaseUsersTable orfano + audit clustering/widget/action

## Contesto

Sessione avviata da un compito esterno che segnalava divergenza tra
`UserResource/Pages/{ListUsers,BaseListUsers}.php` e
`UserResource/Tables/BaseUsersTable.php`. Verifica sul codice reale (non sulla
sola documentazione) ha confermato che quella parte era **già stata risolta**
dalla story sorella `user-filament-boundary-i18n.story.md` (status
`review`, stesso giorno): le Pages non dichiarano più `getTable*`, la
configurazione vive solo in `UserResource/Tables/{BaseUsersTable,UsersTable}.php`.

## Problema residuo trovato (non coperto dalla story sorella)

Esisteva un **terzo** file, orfano, con un ulteriore set di colonne divergente:
`app/Filament/Resources/BaseUserResource/Tables/BaseUsersTable.php`
(namespace `Modules\User\Filament\Resources\BaseUserResource\Tables`, classe
non abstract, `extends XotBaseResourceTable` direttamente).

Verifica di vivacità: `grep -rn "BaseUsersTable"` su tutto il modulo mostra che
questa classe non è mai importata/estesa/richiamata da alcun file `.php` reale
(solo da `tests/coverage-user.xml`, artefatto generato, e da doc). `BaseUserResource.php`
(la Resource astratta madre di `UserResource`) non definisce `table()` né
riferisce questo namespace: la tabella viene risolta per convenzione da
`XotBaseResource` verso `UserResource/Tables/UsersTable.php`. Confermato: **codice
morto**.

Le colonne `state` e `password_expires_at` presenti solo nell'orfano sono
invece reali (proprietà su `Modules\User\Models\User`, colonne aggiunte dalle
migration `2026_02_13_172136_create_users_table.php` e
`2026_09_01_150113_create_users_table.php`) e utili (stato account, scadenza
password per sicurezza): non erano probe/placeholder.

## Azioni

- [x] Portate `state` e `password_expires_at` nel `BaseUsersTable` canonico
  (`UserResource/Tables/BaseUsersTable.php`), come colonne secondarie
  `toggleable(isToggledHiddenByDefault: true)`, coerenti con le altre colonne
  di stato/audit già presenti (`is_otp`, `lang`, `current_team_id`, `type`).
- [x] Rimosso `app/Filament/Resources/BaseUserResource/Tables/BaseUsersTable.php`
  (`git rm`): nessuna colonna persa, nessun chiamante reale rotto.
- [x] PHPStan sui 2 file toccati: 0 errori. PHPStan intero modulo User: 0 errori.
- [ ] Pest modulo User: da eseguire (vedi nota host sotto).
- [in corso, delegato a 2 sub-agent paralleli]: audit clustering
  RelationManagers/Widgets/Actions + dedup documentale passport/oauth cluster.
  Esito da consolidare in questa story o in story dedicate create dai sub-agent.

## Verifica

```
./vendor/bin/phpstan analyse Modules/User/app/Filament/Resources/UserResource/Tables/BaseUsersTable.php \
  Modules/User/app/Filament/Resources/UserResource/Tables/UsersTable.php --memory-limit=2G
[OK] No errors

./vendor/bin/phpstan analyse Modules/User --memory-limit=4G
[OK] No errors (1560 file)
```

## Lezione second brain

Quando esistono più `*Table`/`*Resource` con nomi quasi identici in namespace
fratelli (`UserResource/Tables/*` vs `BaseUserResource/Tables/*`), la vivacità
va sempre verificata con grep sui riferimenti reali (`extends`, `use`,
istanze) prima di assumere quale sia quella "vera": la convenzione Filament
XotBase risolve la tabella per naming dalla Resource concreta, non dalla
gerarchia di cartelle.

qmd interrogato (`qmd search "passport cluster oauth cluster"` e
"user module clustering relation manager tabs"): nessun risultato specifico
già esistente su questo dedup puntuale; risultati generici su invarianti
architetturali e coordinamento issue. L'installazione qmd locale indicizza
anche una collection di un altro checkout (`base_fixcity_fila5`), problema
già segnalato dalla story sorella.

## GitHub issue/discussion: skip documentato

Il hook post-edit ha segnalato l'issue laraxot/module_user_fila5#92 (collegata
da `docs/stories/xotbaseresourcetable-model-audit-passport-socialite-clusters-batch.story.md`)
chiedendo un commento che spieghi la modifica a `UserResource/Tables/BaseUsersTable.php`.
In questo ambiente **non è disponibile `gh` CLI** (comando assente, nessun
`~/.config/gh/`) né un `GITHUB_TOKEN` in env: impossibile autenticarsi verso
l'API GitHub. Skip documentato qui invece di essere saltato in silenzio.
Testo del commento da postare non appena disponibile un ambiente con `gh`
configurato:

> Rimosso `Modules\User\Filament\Resources\BaseUserResource\Tables\BaseUsersTable`
> (namespace `BaseUserResource/Tables/`), duplicato orfano mai referenziato da
> codice reale (solo da `tests/coverage-user.xml` generato e da doc). Le sue
> due colonne reali non presenti altrove (`state`, `password_expires_at`) sono
> state portate nel `BaseUsersTable` canonico (`UserResource/Tables/`), come
> colonne secondarie `toggleable`. PHPStan modulo User: 0 errori dopo la
> modifica. Nessuna colonna persa, nessun chiamante rotto.
