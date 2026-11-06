# Login FO /it/auth/login: traduzioni mancanti e copy errato

- Stato: done (2026-10-07)
- Fase BMAD: Quick Flow (analisi, fix, verifica)
- Owner: Modules/User (lang, UserForm), tema Sixteen (view widget)

## Problema

La pagina mostrava 12 chiavi grezze (`user::login.no_account`, `user::auth.login_page.*`),
il bottone in inglese ("Login"), "Parola d'ordine" al posto di "Password" e la regola
di registrazione ("Minimo 12 caratteri...") sotto la password del login.

## Cause radice

1. `lang/it/login.php` svuotato nel commit 6c1a42617: persi `no_account`, `register_now`,
   `forgot_password_text`, `reset_it`.
2. `user::auth.login_page.*` non esisteva in nessun lang file.
3. `Modules/Fixcity/lang/it.json`: `"Password": "Parola d'ordine"` (override globale).
4. `UserForm` e' condiviso da login e register, quindi il login ereditava helper e
   placeholder di `user_form.php`.
5. Bottone con testo hardcoded.

## Modifiche

- `Modules/User/lang/it/login.php`: 4 chiavi ripristinate.
- `Modules/User/lang/it/auth.php`: nuovo blocco `login_page`.
- `Modules/Fixcity/lang/it.json`: `Password` -> `Password`.
- `UserForm::getLoginFormSchema()`: `helperText(null)` e `placeholder(null)` sulla password.
- `Themes/Sixteen/.../filament/widgets/auth/login.blade.php`: label da `user::login.actions.login.label`.
- `Modules/User/lang/it/login_widget.php`: file valido con `fields.remember.label`
  (l'auto-writer lo aveva corrotto, vedi memoria).
- Test: `Modules/User/tests/Feature/LoginPageTranslationsTest.php` (13 chiavi, senza DB).

## Verifica

- Render: 0 chiavi `user::` grezze, HTTP 200, titolo "Accedi | FixCity".
- Pest: 13 passed; rosso con il vecchio `login.php`.
- Screenshot desktop 1280 e mobile 390 controllati.

## Aperto

- Locale en/de/es: `login_page` e le 4 chiavi mancano (solo `es/login.php` le ha).
- Bottone CTA verde chiaro con testo scuro: contrasto basso, e' un token tema (vedi regola
  `pa-design-colors-no-hex-overrides`), non toccato.
- `Modules/User/tests/TestCase.php` richiede il DB `fixcity_user_test`, assente in questo ambiente.
