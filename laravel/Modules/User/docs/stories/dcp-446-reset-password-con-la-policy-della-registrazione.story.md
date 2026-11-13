---
id: dcp-446
title: "DCP-446: il reset password applica la stessa policy della registrazione"
type: story
status: done-with-open-decisions
module: User
created: 2026-11-12
updated: 2026-11-12
tags: [bmad, story, user, password, reset, policy, hibp, sicurezza]
qmd: "reset password policy Password::default PasswordData minLength 8 12345678 uncompromised HIBP DEC-15 D-11 D-33 getResetPasswordFormSchema getPasswordResetConfirmFormSchema"
related:
  - ./dcp-290-pagine-di-accesso-e-reset-password-a-tema-e-accessibili.story.md
  - ./dcp-285-correttezza-di-policy-utenti-reset-password-e-revoca-consensi.story.md
  - ../filament-auth-pages-exceptions.md
  - ../../../Fixcity/docs/stories/dcp-200-registro-unico-delle-decisioni-aperte.story.md
  - ../../../../Themes/Sixteen/docs/stories/front-office-production-readiness-audit.story.md
issues: []
discussions: ["https://github.com/laraxot/theme_sixteen_fila5/discussions/94"]
---

# DCP-446: il reset password applica la stessa policy della registrazione

Status: **done con decisioni aperte** (codice chiuso il 2026-11-11 nell'audit L-11, riga E-01; documentato qui il 2026-11-12). La correzione chiude
il punto 7 di DCP-290 («password policy di reset… DA DECIDERE, non cambiati») **solo per la parte di coerenza**; il valore della regola e il
controllo con servizio esterno restano al titolare (vedi «Cosa non ho deciso»). Confronto con le altre decisioni dell'audit: discussion
[#94](https://github.com/laraxot/theme_sixteen_fila5/discussions/94), riga R-5.

## Richiesta

Utente, 2026-11-11: controllare integralmente il front office, da loggato e da non loggato, per andare in produzione; correggere ciò che non si vede
come dovrebbe.

## Misurato (prima)

Nella pagina di reset, `12345678` e `aaaaaaaa` venivano accettate. La registrazione richiede maiuscole, minuscole, numeri e simboli: chi resettava la
password poteva sceglierne una più debole di quella con cui si era registrato. Causa: i due schemi del reset, `UserForm::getResetPasswordFormSchema()`
(con token) e `UserForm::getPasswordResetConfirmFormSchema()` (conferma), avevano solo `minLength(8)`.

## Soluzione

| Dove | Cosa |
|---|---|
| `Modules/User/app/Filament/Resources/UserResource/Schemas/UserForm.php` | entrambi gli schemi del reset usano `->rule(Password::default())`, cioè `Password::defaults()` impostato da `PasswordData` |
| `Modules/User/tests/Unit/Filament/Schemas/PasswordResetUsesPasswordPolicyTest.php` | guardia: entrambi gli schemi rifiutano `12345678`, `aaaaaaaa`, `abc` e accettano una password forte |
| `Modules/User/docs/filament-auth-pages-exceptions.md` | sezione «5. Reset password (policy unica)» |

La policy si cambia **solo in `PasswordData`**, mai nei singoli schemi: così registrazione e reset non si disallineano di nuovo.

Nella guardia, `uncompromised` fa una chiamata a HIBP: serve `Http::fake()`, altrimenti l'esito dipende dalla rete e da quanto è nota la password di
prova. Le regole si leggono per reflection sulla proprietà `rules` del campo, perché `getValidationRules()` chiede il container del form (per `same()`) e
fuori da un form montato non è inizializzato.

## Cosa non ho deciso

Queste due decisioni sono del titolare e restano aperte. Il fix non le prende, ma le tocca:

| Decisione | Stato | Effetto di questo fix |
|---|---|---|
| **DEC-15** (registro DCP-200): valore della regola, la pagina dice «minimo 12», il server ne accetta 9; proposta del registro: server a 12 | aperta (D-11 del gap register: «titolare decide DEC-15; sviluppo esegue») | Nessuno sul valore: il reset segue `Password::defaults()`. Quando DEC-15 sarà decisa si cambia `PasswordData` e reset e registrazione si muovono insieme |
| **D-33**: `uncompromised` chiama un servizio terzo (HIBP) e non risulta dichiarato nell'informativa | aperta | **Lo estende al reset.** La registrazione lo usava già; ora lo usa anche chi resetta, quindi il punto da dichiarare nell'informativa (o da togliere) riguarda due flussi, non uno |

Se il titolare decide di togliere `uncompromised`, la sola modifica è in `PasswordData`; nella guardia `Http::fake()` diventa superfluo ma innocuo.

## Criteri di accettazione

- [x] Il reset rifiuta `12345678`, `aaaaaaaa` e `abc`, in entrambi gli schemi.
- [x] Il reset accetta una password che rispetta la policy della registrazione.
- [x] La policy è definita in un posto solo (`PasswordData`).
- [x] La guardia non dipende dalla rete (`Http::fake()`).
- [ ] DEC-15 decisa e applicata in `PasswordData` (titolare).
- [ ] D-33 decisa: tenere `uncompromised` e dichiararlo nell'informativa, oppure toglierlo (titolare).

## Verifica

Esito del 2026-11-12, lanciato dalla radice del monorepo con DB di prova:

```
bashscripts/tools/pest-scratch-db.sh Modules/User/tests/Unit/Filament/Schemas/PasswordResetUsesPasswordPolicyTest.php
```

2 test passati, 14 asserzioni, 6,9 s. La prova al contrario (guardia rossa con il solo `minLength(8)`) non è stata rifatta oggi.

## Non coperto

- Il messaggio d'errore mostrato al cittadino non è stato rivisto qui: le regole di `Password::default()` usano i testi di validazione standard.
- Il valore della regola e l'informativa su HIBP: vedi «Cosa non ho deciso».

## Lezione

Una regola di sicurezza che esiste in due posti si disallinea: qui la registrazione era stata rinforzata e il reset no, e nessun test li confrontava. La
guardia confronta i due schemi con la stessa policy invece di fissare un valore, così non cambia quando cambia DEC-15.
