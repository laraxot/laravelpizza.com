---
id: dcp-185
title: "DCP-185: TreatmentForm espone i 7 campi del trattamento (e ProfileResource perde il ponte Old)"
type: story
epic: dc-parity-v2
status: done
priority: P1
owner: module:Gdpr
module: Gdpr
created: 2026-10-14
updated: 2026-10-14
qmd: "TreatmentForm Treatment documentVersion documentUrl getFormSchemaOld DPO prova del consenso ProfileResource XotBaseResource final"
related: [dcp-184, dcp-178]
---

# DCP-185: `TreatmentForm` espone i 7 campi del trattamento

Fase BMAD: Analyze, Implement, Verify. Nata dal gate PHPStan di `Modules` (ordine permanente dell'utente) e dalla story di coordinamento DCP-184 (Xot).

## Scopo ricostruito
`Treatment` e' il trattamento dei dati personali a cui l'utente da il consenso in registrazione. `documentVersion` e `documentUrl` identificano il documento informativo legato a quel consenso, e la registrazione li scrive nella prova dei consensi (DCP-178): il DPO deve poterli aggiornare quando cambia l'informativa.
Il form vero del pannello e' `TreatmentForm` (`XotBaseResource::form()` e' `final` e usa solo la classe `*Form`). `TreatmentForm` aveva **un solo campo** (`name`). I 7 campi stavano in `TreatmentResource::getFormSchemaOld()`, un ponte di migrazione che `form()` non legge mai: non sono mai arrivati al pannello. La tabella (`TreatmentsTable`) e l'infolist (`TreatmentInfolist`) mostrano gia' versione e URL, quindi i dati esistono ma non erano modificabili da qui.

## Che cosa e' cambiato
- `TreatmentForm::getFormSchema()`: riportati **verbatim** dall'`Old` di HEAD i 7 campi `active`, `required`, `name`, `description`, `documentVersion`, `documentUrl`, `weight`, con gli stessi vincoli.
- Nuovo `Modules/Gdpr/tests/Unit/Filament/Resources/TreatmentFormTest.php`: il form deve esporre tutti e 7 i campi (helper tipizzato con `instanceof Field`, perche' `getName()` esiste solo su `Field`).
- `Gdpr/Resources/ProfileResource`: tolto `getFormSchemaOld()`. I suoi 10 campi erano identici (stessi vincoli) a `ProfileForm::getFormSchema()`: cancellazione pura, zero perdita; tolti i 3 `use` rimasti orfani dopo aver cercato i loro usi nel resto del file.

## Verifica (output reale)
- Rosso prima: `FAIL treatment_form_exposes_every_attribute_the_dpo_edits` con `Il campo "active" del trattamento non e' modificabile dal pannello.` (fallisce sul primo campo mancante, non per l'harness).
- Verde dopo: `Modules/Gdpr/tests/Unit/Filament/Resources` = **19 passed (29 assertions)**, con `pest-scratch-db.sh` e il bypass `DB_DATABASE_LIMESURVEY= APP_CONFIG_CACHE=/nonexistent/config.php`.
- PHPStan su `TreatmentForm.php`, `ProfileResource.php`, `TreatmentFormTest.php`: `[OK] No errors`.
- Il test sbagliato alla prima stesura (2 errori PHPStan, `cast.string` e `argument.type`) e' stato corretto leggendo le firme in `vendor/filament` (`getDefaultChildComponents(): array | Schema`), senza cast.
- Run completo `phpstan analyse Modules` alle 19:34 (JSON validato): `errors 0, file_errors 1`, fuori da questo scope: `Fixcity/tests/Feature/Filament/CreateTicketWidgetTest.php:225` (`getAuthIdentifier()` su `User|null`), file in modifica dalla sessione Ticket. **Non e' ancora uno zero.**

## Non verificato
- Il pannello non e' stato aperto nel browser: il form non e' stato visto renderizzato.
- Non ho contato utenti e ticket del DB di sviluppo prima e dopo Pest, come prescrive la nota sul bypass. I test lanciati non scrivono sul DB (riflessione sullo schema).

## Decisioni aperte (prodotto, non mie)
- **`active` e `required` ora sono modificabili dal DPO.** Governano quali consensi compaiono e quali sono obbligatori in registrazione. Era l'intento dello schema originale, ma e' un potere che il pannello prima non dava. Se non lo si vuole, togliere i due `Toggle`.
- `documentUrl` non ha `->url()`: l'output e' sanificato in tabella (`Str::sanitizeUrl`), l'input no. Proposta: `->url()` se i documenti sono sempre URL assoluti; non fatto per non invalidare dati gia' inseriti.

## Debito osservato, non corretto
Docblock `@property` ripetuti da `ide-helper:models` rilanciato senza reset: `Treatment` e `Event` (7 blocchi identici), `Profile`, `Consent`, `JobManager` (2 blocchi). Cosmetica; la causa e' il generatore, non i file.
