---
title: "[STORY] Rimozione delle chiamate di debug dal codice di produzione (User)"
type: story
status: done
priority: high
created: 2026-10-20
updated: 2026-10-20
module: User
tags: [bmad, debug, dddx, filament, appearance, password, quality]
qmd: "user dddx dd debug produzione Appearance Alignment Logo Colors Background Favicon CustomCss Password Halt LogicException"
related:
  - ./12.3.remove-dddx-debug.story.md
  - ../bmad/filament-blueprint.md
  - ../../../Job/docs/stories/debug-calls-removal-job.story.md
  - ../../../Media/docs/stories/debug-calls-removal-media.story.md
  - ../../../Setting/docs/stories/debug-calls-removal-setting.story.md
---

# Rimozione delle chiamate di debug dal codice di produzione (User)

## Fase BMAD

Fase di implementazione e verifica (quality gate). Sostituisce nei fatti la story backlog
[12.3](./12.3.remove-dddx-debug.story.md), marcata `superseded`: la sua ipotesi (i `dddx` erano "dead code accanto alla
chiamata utile") era vera solo in parte, vedi sotto.

## Problema misurato

`dddx()` (`Xot/helpers/Helper.php`) chiude con `dd($data)` senza condizioni: in produzione stampa un dump con percorsi e dati
e termina la richiesta. Misura col tokenizer PHP (ignora commenti, stringhe e metodi) su `laravel/Modules/User/app`:
13 chiamate reali in 7 file prima, 0 dopo. Resta solo `var_export($config, true)` in `SocialiteProviderSettingsPage.php:280`,
legittimo perche' restituisce una stringa.

## Sito 1: le sei pagine del cluster Appearance

File: `app/Filament/Clusters/Appearance/Pages/{Alignment,Logo,Colors,Background,Favicon,CustomCss}.php`.

**Scopo capito.** Il cluster "Aspetto" doveva far personalizzare logo, colori, allineamento, sfondo, favicon e CSS. Le sei
pagine sono copie dello stesso scaffold: `Favicon` e `CustomCss` hanno gli stessi campi di `Background`
(`background_color`, `background`, `overlay_color`, `overlay_opacity`), quindi i form non sono ancora quelli giusti. Il salvataggio
non e' mai stato scritto: `// $this->handleRecordUpdate($this->getUser(), $data)` e' commentato, `getUser()` non esiste in
`XotBasePage`, e `handleRecordUpdate()` non ha chiamanti. Le viste chiamano `wire:submit="updateData"` (`updateLogo` per `Logo`),
quindi il metodo ha chiamanti: e' il caso "stub con chiamanti".

Il `catch (Halt)` non aveva senso: dentro il `try` solo `getState()` puo' fallire e lancia `ValidationException`, non `Halt`. Il
secondo `dddx($exception->getMessage())` non e' mai stato raggiungibile.

**Cosa ho fatto.** Il corpo di `updateData()` / `updateLogo()` e' ora
`throw new \LogicException('<Classe>::<metodo>() non implementato')`; tolto l'import `Halt`. Ho evitato di cancellare solo il
`dddx`: avrei lasciato un pulsante "Salva" che non salva e non dice nulla (falso successo, errore silenzioso). Un docblock dice come
completare (salvare `$this->form->getState()` come fa `Pages\Password`).

**Codice riattivato.** Nessuno: dopo il `dddx` c'era solo codice commentato.

**Rischio.** L'utente che preme "Salva" vede un errore Livewire (e il log riceve l'eccezione) invece di un dump con i dati del
form. Nessun salvataggio c'era prima, nessuno c'e' ora. Test aggiunto in `tests/Feature/Filament/Clusters/AppearanceClusterTest.php`
("unimplemented save handlers fail loudly instead of dumping debug output").

## Sito 2: `Pages/Password.php`

**Scopo capito.** Pagina di politica password del tenant (scadenza OTP, lunghezza, complessita'). Salva con
`SaveTenantConfigAction::execute('password', $data)` nel config del tenant, che `PasswordData::make()` rilegge. Il ramo di
successo era gia' corretto e raggiungibile. `Halt` e' il segnale Filament di "stop volontario": chi lo lancia ha gia' avvisato
l'utente, e nel `try` nessuno lo lancia.

**Cosa ho fatto.** `catch (Halt) { return; }` come fa `EditRecord::save()` in Filament, senza `report()` ne' notifica di errore
(deroga alla regola generale "report + Notification danger": `Halt` non e' un errore). In piu', il titolo hardcoded
`'Saved successfully'` della notifica di successo ora e' `__('user::notifications.settings_saved.title')`, con la chiave in
`lang/{it,en,de}/notifications.php`.

**Codice riattivato.** Nessuno.

**Rischio.** Nullo sul percorso normale. Gli errori reali di `SaveTenantConfigAction` (scrittura del file) continuano a propagarsi
come prima.

## Sito 3: `Models/BaseUser.php:245`

Falso positivo del grep: la riga e' dentro il blocco `/* ... */` che commenta `canAccessFilament()`. Il tokenizer la ignora. Nessuna
modifica.

## Decisioni aperte

1. **Dove salvare l'aspetto.** `SaveTenantConfigAction` come in `Password` e' la via naturale, ma oggi nessun codice legge chiavi
   `appearance`/`logo`/`colors`: serve prima un consumatore (tema/panel). Serve anche un form giusto per `Favicon` e `CustomCss`.
2. **Navigazione.** Finche' non c'e' persistenza, le sei pagine sono visibili nel menu e non salvano. Valutare
   `shouldRegisterNavigation(): false`.
3. **Story 12.3.** Marcata `superseded` da questa; la sua AC #2 ("era dead code, la logica resta identica") non valeva per le pagine Appearance.
4. `SaveTenantConfigAction` fallisce senza una notifica comprensibile in `Password`: valutare `report()` piu' `Notification` danger
   su un `catch` mirato, se si vuole un errore gestito.

## Verifica

- Tokenizer: 0 chiamate reali (resta il `var_export(..., true)` legittimo).
- `php -l` sugli 11 file PHP toccati (6 pagine, `Password`, 3 file lang, 1 test): nessun errore di sintassi.
- Pest (singolo file): `AppearanceClusterTest` 7 test, 46 asserzioni, verdi.
- PHPStan gated su `Modules/User` intero: exit 0, nessun errore.
