---
title: "Feedback delle credenziali di accesso errate"
type: story
module: User
epic: quality
status: done
created: 2026-10-05
updated: 2026-10-05
tags: [bmad, ux, login, pest]
related:
  - ../../../../Xot/docs/bmad/stories/project-quality-audit.story.md
---

# Feedback delle credenziali di accesso errate

Il login deve mostrare un errore generico tradotto accanto al campo email quando
le credenziali sono errate, senza rivelare se un account esiste.

## Criteri di accettazione

- [x] Errore associato a `data.email`, coerente con lo schema Filament.
- [x] Messaggio scalare disponibile in italiano e inglese tramite traduzioni esistenti.
- [x] Pest verde su `login` e sull'alias `save`, senza database.
- [x] Lint, stile e analisi statica focalizzata verificati.

## Ownership e task

- Agente audit-ux: LoginWidget, AuthLoginFeedbackTest e questa story, con lock esclusivi.
- Coordinatore: sprint e second brain.
- [x] Audit in sola lettura e verifica del percorso di stato.
- [x] Test di regressione prima/dopo e modifica minima di una riga.

## Evidenze

- `XotBaseSchemaWidget::form()` imposta `statePath('data')`.
- `LoginWidget::login()` registra invece `email`, quindi il campo non riceve l'errore.
- `user::auth.messages.failed` manca in italiano e restituisce un array in inglese.
- `user::login.actions.login.error` è già un messaggio generico scalare in entrambe le lingue.
- L'audit second brain `login-page-ux-audit.md` riguarda FixCity/Sixteen e non prova lo stato PTVX.
- Il test isola autenticazione e schema; usa il vero catalogo traduzioni e l'error bag Livewire.

## Verifica

- Pest prima della correzione: 4 fallimenti per errore assente su `data.email`.
- Pest finale: 4 test superati, 32 asserzioni (`it`/`en` × `login`/`save`).
- Comando: `./vendor/bin/pest Modules/User/tests/Unit/Filament/Widgets/AuthLoginFeedbackTest.php --compact`.
- Pint e `php -l` sui due PHP: superati.
- PHPStan max sul widget e sul test, con configurazione repository e `--debug --no-progress`: zero errori.
- Test senza bootstrap applicativo, connessioni database o modifiche ai dati.
- Gli skip preesistenti nei test feature non sono stati modificati.
- Nessuna verifica browser: nessun tool browser disponibile e `ptvx.local` non risponde entro 8 secondi.

## Riferimenti

- [Widget di accesso](../../../app/Filament/Widgets/Auth/LoginWidget.php).
- [Regressione Pest](../../../tests/Unit/Filament/Widgets/AuthLoginFeedbackTest.php).
- [Story di coordinamento](../../../../Xot/docs/bmad/stories/project-quality-audit.story.md).
