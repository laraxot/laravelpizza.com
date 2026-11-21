---
id: story-user-roles-teams-scoping-disabled-by-override
slug: roles-teams-scoping-disabled-by-override
title: "Story: il team scoping dei ruoli e' disattivato da un override di roles()"
description: "config/permission.php dichiara 'teams' => true, ma Modules/User/app/Models/Traits/HasRoles.php sovrascrive roles() senza il vincolo sul team. Un ruolo assegnato per un team vale in tutti i tenant, e nessun punto del codice chiama setPermissionsTeamId()."
document_type: story
category: bmad
scope: module:User
status: ready-for-dev
version: 1.0.0
language: it-IT
ecosystem: Laraxot
priority: high
epic: security
epic_title: "Autorizzazioni e isolamento fra tenant"
created_at: '2026-08-07'
updated_at: '2026-08-07'
tags: [bmad, story, user, spatie-permission, teams, multi-tenant, security]
related:
  - ../../../../config/permission.php
  - ../../app/Models/Traits/HasRoles.php
  - ../../../Quaeris/docs/stories/19-15-retire-legacy-top-level-question-chart-resource.md
github:
  repository: https://github.com/laraxot/module_user_fila5
  issues: https://github.com/laraxot/module_user_fila5/issues
  discussions: https://github.com/laraxot/module_user_fila5/discussions
---

# Story: il team scoping dei ruoli e' disattivato da un override di `roles()`

## GitHub (tracciamento)

Repository letto con `cd laravel/Modules/User && git remote -v`:
**`laraxot/module_user_fila5`**.

| Risorsa | Stato | URL |
|---|---|---|
| Issue | DA CREARE | https://github.com/laraxot/module_user_fila5/issues |
| Discussion | DA CREARE | https://github.com/laraxot/module_user_fila5/discussions |

`gh` non e' autenticato in questa sessione e i repository sono privati.

## Story

Come **responsabile della sicurezza di una piattaforma multi-tenant**, voglio
**che un ruolo assegnato a un utente dentro un tenant valga solo dentro quel
tenant**, cosi' che **l'isolamento fra clienti non dipenda da quale schermata si
sta guardando**.

## Problema

`config/permission.php:136` dichiara:

```php
'teams' => true,
```

Con `teams` attivo, Spatie applica al `roles()` di ogni modello il vincolo sul
team corrente:

```php
->wherePivot($teamsKey, getPermissionsTeamId())
->where(fn ($q) => $q->whereNull($teamField)->orWhere($teamField, getPermissionsTeamId()))
```

`Modules/User/app/Models/Traits/HasRoles.php:23-30` sovrascrive `roles()` e **quel
vincolo sparisce**:

```php
return $this->belongsToManyX(Role::class, $pivotTable, 'model_id', 'role_id')
    ->where('model_type', self::class);
```

Restano solo `model_id` e `model_type`. Nessun filtro sul team.

Secondo elemento: **nessun punto del codice chiama `setPermissionsTeamId()`**
(unica occorrenza in tutto il repo: un test che legge soltanto il registrar).
Il pannello Filament configura la tenancy (`AdminPanelProvider.php:31`,
`->tenant($tenant_class, slugAttribute: 'slug')`) senza toccare il team id di Spatie.

Le due cose insieme producono lo stato osservato:

| team id corrente | `hasRole('super-admin')` |
|---|---|
| `null` (stato di oggi) | `true` |
| `1` | `false` |
| `10` (tenant `ats`) | `false` |

Tutte le righe di `roles.team_id` valgono `1`.

Quindi oggi il sistema **non nega nulla per errore**, ma per la ragione sbagliata:
il team id non viene mai impostato. La configurazione dice "isolamento per team",
il codice dice "nessun isolamento", e i due sono d'accordo solo per caso.

Due conseguenze, opposte fra loro:

1. **Sicurezza, adesso**: un ruolo assegnato per il team 1 vale in *tutti* i tenant.
   Chi assegna un ruolo dentro un cliente lo sta assegnando ovunque.
2. **Fragilita', domani**: il giorno in cui qualcuno allinea il team id al tenant —
   che e' la cosa corretta con `teams => true` — tutti i controlli di ruolo
   iniziano a rispondere `false` senza sollevare errori. Le funzioni protette da
   `hasRole()` spariscono dalla UI in silenzio. Il primo sintomo osservato sara'
   un pulsante che non c'e' piu', non un messaggio di errore.

## Utenti e permessi

- **Super-admin**: oggi `hasRole('super-admin')` risponde `true` in ogni tenant.
  E' il comportamento atteso per questo ruolo, ma lo si ottiene per assenza di
  scoping, non per una regola dichiarata.
- **Ruoli di tenant** (tutti gli altri): assegnati dentro un cliente, valgono in
  tutti. E' il difetto vero.
- La story non concede permessi: li restringe. Va pianificata con una misura di
  chi perde cosa, prima di attivarla.

## Solution Overview

1. **Decidere la semantica**, e scriverla: i ruoli sono per team (tenant) o globali?
   Non e' una scelta tecnica, e oggi non e' dichiarata da nessuna parte.
2. Se sono **per team**: rimuovere l'override di `roles()` (o riscriverlo
   includendo il vincolo sul team, se `belongsToManyX` serve per altro), e
   impostare `setPermissionsTeamId()` nel punto in cui il tenant viene risolto —
   middleware del panel o listener sull'evento di cambio tenant.
3. Prevedere il **ruolo trasversale**: `super-admin` deve valere ovunque. Con Spatie
   si ottiene con `team_id = null` sulla riga del pivot, che il vincolo
   `whereNull($teamField)` ammette esplicitamente. Va migrato il dato esistente:
   oggi tutte le righe hanno `team_id = 1`.
4. Se sono **globali**: portare `'teams' => false` in configurazione e cancellare
   la colonna dal modello mentale. Una configurazione che dichiara una feature non
   usata e' una trappola per il prossimo che la legge e si fida.
5. **Test di regressione prima del cambio**: elencare tutti i punti che chiamano
   `hasRole`, `can`, `hasPermissionTo`, e per ciascuno il comportamento atteso
   dentro e fuori dal tenant.

## Dev Notes

- L'override e' motivato (`belongsToManyX` e' il pattern del modulo) ma incompleto:
  la story non chiede di abbandonare `belongsToManyX`, chiede di non perdere il
  vincolo che Spatie aggiungeva.
- `self::class` dentro un trait risolve alla classe che lo usa, quindi il filtro
  `model_type` e' corretto: non e' quello il difetto.
- Il difetto e' emerso durante la verifica di un guard `hasRole('super-admin')` su
  un widget Filament del modulo Quaeris (vedi story correlata): il guard funziona
  oggi e smetterebbe di funzionare al primo allineamento del team id.
- Migrazione dati: `roles.team_id` e la colonna team sul pivot `model_has_roles`
  vanno guardate insieme. Il DB non e' in sola lettura qui, a differenza di
  LimeSurvey, ma resta un dato di produzione: nessuna operazione distruttiva.

## Acceptance Criteria

- [ ] La semantica dei ruoli (per team o globale) e' scritta in un documento del
      modulo, non dedotta dal codice
- [ ] `config/permission.php` e il comportamento reale di `roles()` concordano
- [ ] Se i ruoli sono per team: un utente con ruolo nel tenant A non ha quel ruolo
      nel tenant B, verificato con un test
- [ ] `super-admin` continua a valere in ogni tenant, verificato con un test
- [ ] Nessuna funzione oggi accessibile diventa inaccessibile senza che il
      cambiamento sia elencato nella story
- [ ] `setPermissionsTeamId()` viene chiamato in un solo punto, dichiarato

## Testing

- Test Pest sui tre casi: ruolo nel tenant corrente, ruolo in un altro tenant,
  ruolo globale (`team_id = null`).
- Prova manuale: stesso utente su due tenant del pannello, verifica della presenza
  o assenza delle azioni protette.
- Prima del merge: censimento dei chiamanti di `hasRole`/`can` con il comportamento
  atteso, allegato alla issue.

## Blocker

- Il punto 1 e' una decisione di prodotto, non tecnica: senza quella, ogni
  implementazione e' una scommessa.
- Serve una finestra di verifica su dati reali: il cambio tocca l'autorizzazione
  di tutti i moduli, non solo di User.
- `gh` non autenticato: issue e discussion non creabili da questa sessione.

## Note

- Trovato il 2026-08-07 durante la verifica adversarial di un fix su
  `Modules/Quaeris`. Non e' un difetto di Quaeris: e' del layer di autorizzazione,
  e per questo la story vive in `module:User`.
- Il difetto e' del tipo peggiore: oggi non produce sintomi. Si manifesta solo
  quando qualcuno fa la cosa giusta.
