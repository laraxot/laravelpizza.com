---
<<<<<<< HEAD
title: "Contratti"
type: index
tags: [contracts, actions, interfaces]
created: 2026-11-18
updated: 2026-11-18
---

# Contratti

Cosa promette la superficie pubblica di questo pacchetto: le Action che scrivono dati, chiamano servizi esterni o hanno
effetti collaterali, e le interfacce (`app/Contracts`). Regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`.
=======
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
>>>>>>> laraxot/dev

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

<<<<<<< HEAD
Il docblock dell'Action rimanda al file con la riga `Contratto di comportamento: docs/contracts/<file>.md`.
Chi cambia il comportamento aggiorna il contratto nello stesso commit.

## Contratti

=======
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
>>>>>>> laraxot/dev
