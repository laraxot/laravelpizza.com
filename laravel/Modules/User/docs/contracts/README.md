---
<<<<<<< HEAD
title: "Contratti — modulo User"
type: index
tags: [contracts, actions, interfaces, user]
created: 2026-11-18
updated: 2026-11-24
---

# Contratti del modulo User

## Metodo Harness

Un contratto descrive una singola operazione pubblica con effetti collaterali, chiamate esterne o invarianti di dominio. Documenta il comportamento osservabile, inclusi errori e non-goals, senza trasformare ogni metodo interno in un contratto.

Ogni invariante ha un ID stabile, nel formato `USER-INV-N` o, per operazione, `USER-<OPERAZIONE>-INV-<N>`; il test Pest
corrispondente usa lo stesso ID come group. La classe implementatrice deve contenere `@contract docs/contracts/<file>.md`;
contratto, codice e test cambiano nello stesso commit.

Cosa promettono le Action di User che scrivono utenti, token, log o mandano email, e le interfacce di `app/Contracts`
documentate qui. Il group Pest, se c'è, prova l'invariante
(`vendor/bin/pest Modules/User/tests --group=<ID>`), «—» è debito dichiarato.

Leggili prima di chiamare, modificare o imitare un'Action di autenticazione. Formato e regola:
`Modules/Xot/docs/rules/action-behavioral-contract.md`.

## Contratto di comportamento di un'Action

Un file per Action, nome in kebab-case della classe (`create-ticket-action.md`), frontmatter `type: contract` e
`action: <FQCN>`, e queste sei sezioni nell'ordine:

```markdown
## Input
## Output
## Invarianti
## Effetti collaterali
## Errori
## Non fa
```

Il docblock dell'Action rimanda al file con il marker `@contract docs/contracts/<file>.md`, quello verificato dai test; la
riga legacy `Contratto di comportamento: docs/contracts/<file>.md` può restare. Chi cambia il comportamento aggiorna il
contratto nello stesso commit.

## Contratti di Action

- [HasVerifiedIdentityAction](has-verified-identity-action.md) — decide se l'utente è verificato: email verificata oppure accesso `spid`/`cie`; senza utente risponde `false`, non scrive nulla.
- [UpsertUserFromDigitalIdentityAction](upsert-user-from-digital-identity-action.md) — trova o crea l'utente SPID/CIE per codice fiscale.
- [RevokeUserAccessAction](revoke-user-access-action.md) — revoca token Passport, refresh token e cookie "ricordami".
- [ConsumeAuthSubmissionSlotAction](consume-auth-submission-slot-action.md) — conta un invio di registrazione/recupero per IP ed email.
- [SendOtpByUserAction](send-otp-by-user-action.md) — sostituisce la password con un OTP hashato e lo manda per email.
- [RecordAuthenticationLogAction](record-authentication-log-action.md) — scrive il registro degli accessi senza mai rompere il login.

## Interfacce (`app/Contracts`)

- [HasTeamsAndUserContract](hasteamsandusercontract.md) — unione di `HasTeamsContract` e `UserContract`, con i metodi di ruolo nel team.
- [TeamContract](teamcontract.md) — cosa deve offrire un modello team (membri, permessi, inviti).

## Indice e template

- [INDEX](INDEX.md) — tabella operativa operazione, contratto, classe, invarianti; è un elenco precedente a questo README e alcuni suoi nomi di file e classi non coincidono con i contratti qui sopra.
- [Template di contratto](_template.md) — scheletro con le sei sezioni e la tabella degli invarianti, da copiare per una nuova Action.
=======
title: "Contratti — User"
type: index
owner: User
updated: 2026-11-24
qmd: "User contract comportamentali autenticazione ruoli permessi SPID CIE invarianti USER-INV"
---

# Contratti — User

Un contract descrive una singola operazione del modulo User che muove dati personali, permessi o accessi: input, output, invarianti, effetti collaterali, errori e confini. Documenta il comportamento **implementato**, non quello desiderato. Standard: [contract-authoring-standard](../../../Xot/docs/contracts/contract-authoring-standard.md); governance: [ADR 0012](../../../Xot/docs/adr/0012-behavioral-contract-governance.md).

## Formato

Frontmatter `type: contract` e `action: "Modules\\User\\Actions\\..."`; sezioni nell'ordine `## Input`, `## Output`, `## Invarianti`, `## Effetti collaterali`, `## Errori`, `## Non fa`. Ogni invariante ha ID `USER-<AREA>-INV-<N>` e un test Pest con `->group('<ID>')`. Il registro operativo con copertura e comandi è [INDEX.md](INDEX.md).

## File presenti

Contract nel formato a sei sezioni:

- [has-verified-identity-action](has-verified-identity-action.md) (invariante in prosa, senza ID: da portare a `USER-IDV-INV-N`)
- [build-active-user-provider-action](build-active-user-provider-action.md)
- [revoke-user-access-action](revoke-user-access-action.md)
- [upsert-user-from-digital-identity-action](upsert-user-from-digital-identity-action.md)
- [set-default-roles-by-socialite-user-action](set-default-roles-by-socialite-user-action.md)

Documenti `type: concept` sulle interfacce (non sono contract formali, nessun ID): [hasteamsandusercontract](hasteamsandusercontract.md), [teamcontract](teamcontract.md). Template: [_template](_template.md). I file `*.md.bak` sono copie di lavoro, non contratti.
>>>>>>> laraxot/dev
