---
type: story
tags: [registration, gdpr, privacy, terms, PA, compliance]
created: 2026-10-14
updated: 2026-10-14
qmd: "registrazione checkbox privacy termini cookie-policy obbligatori PA a norma"
issues: []
discussions: []
id: "2026-10-14-dcp-164"
epic: 164
title: "Registrazione con consenso privacy/termini obbligatori (PA)"
slug: registrazione-consenso-obbligatorio-PA
status: ready-for-dev
scope: module:User, theme:Sixteen
github:
  repository: https://github.com/laraxot/module_gdpr_fila5
  issues: https://github.com/laraxot/module_gdpr_fila5/issues/64
  discussions: https://github.com/laraxot/module_gdpr_fila5/discussions/65
  issue_status: "aperta"
related:
  - ../docs/stories/dcp-156-pagine-legali-complete-a-norma.story.md
  - ../docs/stories/dcp-157-cookie-policy-footer-link.story.md
  - ../docs/stories/dcp-161-verifica-disclaimer-a-norma.story.md
---

# 2026-10-14 DCP-164 Registrazione con consenso privacy/termini obbligatori (PA)

## Perché

Per essere messo online e usato da una PA, la pagina diizzazione deve:
1. Richiedere l'accettazione **privacy policy** e **termini/cookie policy** (checkbox obbligatorie, `required`).
2. Fornire **link cliccabili** alle pagine legali (non solo testo).
3. Permettere la **deregistrazione** (GDPR art. 17).
4. Essere **multilingua** (it/en/de/es).

## Stato attuale

- `Modules/User/resources/views/auth/register.blade.php`: mancano i checkbox GDPR.
- `Modules/Gdpr/app/Filament/Widgets/Auth/RegisterWidget.php`: ha i checkbox Livewire ma con **marker di merge** non risolti (risolti in questa tornata).
- Pagine legali già linkabili: `/it/informativa-privacy`, `/it/cookie-policy`, `/it/note-legali`.

## Obiettivo

- Aggiungere i 3 checkbox (privacy, termini, marketing) alla view principale con link cliccabili.
- Risolvere il marker di merge in `RegisterWidget.php`.
- Aggiungere la deregistrazione (route + view + lang).

## Accettazione

1. Checkbox privacy/termini obbligatori presenti e linkati.
2. `RegisterWidget.php` senza marker di merge.
3. Deregistrazione disponibile in 4 lingue.
4. Nessun file in `app/Http/Controllers`.

## Nota di verifica 2026-10-14 (DCP-178, altra sessione)
Verificato sul codice e con test (`Modules/Fixcity/tests/Feature/Auth/RegistrationConsentTest.php`, 8 casi verdi):
- La pagina `/{lang}/auth/register` non usa `Modules/User/resources/views/auth/register.blade.php` ma `Themes/Sixteen/resources/views/filament/widgets/auth/register.blade.php`, che ha gia' tre caselle (informativa e condizioni obbligatorie, aggiornamenti facoltativi), non preselezionate. Obbligo controllato dal server in `RegisterWidget::rules()` con messaggi tradotti.
- Link cliccabili: mancavano; aggiunti il 2026-10-14 verso `/{lang}/privacy` e `/{lang}/terms` (nuova scheda, testo accessibile) in it, en, de, es. Le pagine legali sono `/privacy`, `/terms`, `/cookie-policy`, `/note-legali`; `/it/informativa-privacy` risponde 404.
- Marker di merge in `RegisterWidget.php` e `ValidateUserDataAction.php`: erano solo nei docblock, ora risolti; nel codice non ne restano (ricerca su php, blade, json, js, css, yml).
- Mancava la prova dell'accettazione: `treatments` vuota, 0 righe in `consents`. Corretto in `SaveGdprConsentsAction`.
- **Obiettivo 3 (deregistrazione): oggi esiste codice (`DeleteAccountAction`, rotta `account.delete`) ma non funziona sullo schema reale e non cancella nulla di fatto: vedi la sezione di verifica in DCP-178. Non attivare prima della decisione sui ticket e sull'anonimizzazione.** `DeleteUserAction` cancella la riga utente e lascia le segnalazioni con `owner_id` orfano (NOT NULL, nessuna chiave esterna). Proposta di default e decisioni aperte in `dcp-178-registrazione-e-disiscrizione-a-norma.story.md` e in DCP-140.
Questa story ha il numero 164 anche in `Themes/Sixteen/docs/bmad/stories` (contatti del DPO): il numero e' ambiguo, citare sempre il percorso.
