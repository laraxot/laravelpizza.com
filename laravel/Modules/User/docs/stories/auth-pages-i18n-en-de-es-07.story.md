# Login e registrazione in inglese, tedesco e spagnolo

- Stato: done (2026-10-07), con aperti elencati sotto
- Fase BMAD: Quick Flow (analisi, fix, verifica a browser e test)
- Owner: Modules/User (lang), Themes/Sixteen (view)
- Collegata a: [login-page-it-translations-fix-2026-10-07.story.md](./login-page-it-translations-fix-2026-10-07.story.md)
  (la sua voce "Aperto" sui locali non italiani e' chiusa qui)

## Problema

`/en/auth/login` mostrava titolo e tutti i testi in italiano, e le etichette dei campi come chiavi
grezze minuscole (`email*`, `password*`, `remember` due volte). `de` e `es` avevano lo stesso difetto.

## Cause radice

1. `login_page.*` mancava in en/de/es e `register_page.*` in de/es: Laravel ricade sul locale
   di fallback (`it`).
2. Le 4 chiavi `login.no_account`, `register_now`, `forgot_password_text`, `reset_it` e
   `registration.already_registered` mancavano in en/de; `login.actions.login.*` in de.
3. **Le etichette del form non vengono da `login_widget.php`** (come dice il docblock di `LoginWidget`)
   ma da `user_form.php`, perche' lo schema e' `UserForm`. In `en/user_form.php` e `de/user_form.php`
   l'auto-writer aveva scritto il nome del campo come valore (`'label' => 'email'`). `es/user_form.php`
   non esisteva.

## Modifiche

- `lang/{en,de,es}/auth.php`: blocchi `login_page` (e `register_page` per de/es), inseriti in coda
  al file senza riformattare.
- `lang/{en,de}/login.php`, `lang/{en,de}/registration.php`: chiavi mancanti.
- `lang/{en,de,es}/user_form.php`: email, password, remember, first_name, last_name,
  password_confirmation (label, placeholder, helper_text, description). `es` creato.
- Strategia: si imposta una chiave solo se manca o se vale il nome del campo; nessun testo
  esistente e' sovrascritto. Un'altra sessione stava traducendo gli stessi file: l'operazione
  e' idempotente e non ha sovrascritto nulla.
- Test nuovo: `tests/Feature/AuthPagesLocalesTest.php` (87 casi su en/de/es).

## Verifica

- Chiavi usate dalle pagine mancanti: en 15/26 -> 0, de 24/26 -> 2, es 17/26 -> 2, it 2.
  Le 2 residue sono `login_page.register_cta_text/link`: la route `register` non esiste, quindi
  non vengono mai renderizzate.
- Render in Chromium: `/en/auth/login`, `/en/auth/register`, `/de/auth/login`, `/es/auth/login`
  senza testo italiano ne' chiavi grezze in main, header e footer. `/it/auth/login` e' il controllo:
  il rilevatore lo segnala come italiano, come atteso.
- Pest: 87 passed (408 asserzioni). Prova di rosso: con `'label' => 'email'` in `en/user_form.php`
  il test fallisce con "e' il nome del campo", poi ripristinato.

## Aperto

- Sweep delle pagine pubbliche (`/en`, `/de`, `/es`, `/{lang}/tickets`, `/en/auth/password/reset`): chiusi i residui
  "Contatta il comune"/"Richiedi assistenza" (blocco contatti), `breadcrumb` e `Cerca` (controlli mappa, vedi
  [map-controls-i18n-it-en-de-es-2026-10-07.story.md](../../../Geo/docs/stories/map-controls-i18n-it-en-de-es-2026-10-07.story.md)).
- Pulsante di login in inglese: "Login", mentre il titolo dice "Sign in".
- Docblock di `LoginWidget` da correggere: le etichette vengono da `user_form`.
- Le chiavi morte `register_cta_*` vanno rimosse dalla view o create in tutte le lingue.
- Altre lingue sul repo (pt, ru, hi, zh) non sono supportate dal selettore lingua: non toccate.
