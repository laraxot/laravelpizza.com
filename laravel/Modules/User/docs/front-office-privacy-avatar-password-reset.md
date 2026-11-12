# Front office: avatar senza siti terzi, profilo pubblico, reset password

Decisioni prese con l'audit del front office di LaravelPizza (12/11/2026). Valgono per ogni progetto che usa
il modulo; quelle legate a un'impostazione si attivano dalla configurazione del tenant.

## Avatar: Gravatar si può spegnere

`BaseProfile::getAvatarUrl()` restituisce, in ordine: la foto caricata (media `avatar`), l'URL Gravatar
dell'email, oppure stringa vuota. Gravatar è una richiesta a un sito terzo che riceve l'IP del visitatore a
ogni pagina: con

```php
// config/local/<tenant>/xra.php
'gravatar' => false,
```

il metodo restituisce stringa vuota e le viste mostrano le **iniziali** (generate in Blade, nessuna
richiesta). LaravelPizza lo tiene spento perché la cookie policy promette zero richieste a terzi.
Il default resta `true` per non cambiare gli altri progetti.

`UserDropdown` (menu utente pubblico) non usa più l'immagine Gravatar "vuota" come ripiego: passa alla vista
`avatarUrl` (eventualmente vuoto) e `initials` (massimo due lettere).

## Profilo pubblico

La pagina `/{lingua}/profile/{id}` del tema mostra nome, biografia, data di iscrizione e lingua a tutti;
**email e indirizzo solo al titolare** del profilo. Il JSON-LD del profilo (`Modules/Cms` →
`BuildPageSchemaAction`) non contiene l'email. Un id che non corrisponde a nessun utente è un 404.

## Reset password

- Broker `users` in `config/local/<tenant>/auth.php`: tabella `password_resets` sulla connessione `user`
  (migrazione `2014_10_12_100002_create_password_resets_table`). Una connessione inesistente
  (prima: `liveuser_general`) fa fallire "password dimenticata" con un errore 500.
- `BuildPasswordResetUrlAction::execute($token, $email)`: radice da `app.url` (mai dall'header `Host`,
  SEC-007), percorso nella **lingua della richiesta** (le rotte Folio localizzate portano la prima lingua
  registrata) e `?email=` per precompilare il campo.
- La pagina "password dimenticata" risponde con lo stesso messaggio che l'email esista o no.
- Dopo il reset l'utente entra e va a `xra.post_login_path`.

Test: `Modules/Meetup/tests/Feature/FrontOfficePrivacyAndSeoTest.php` (flusso completo, lingua del link,
messaggio uguale per email sconosciute, profilo).

## Password lunghe salvate in chiaro (corretto il 12/11/2026)

`BaseUserMutators::setPasswordAttribute()` decideva se cifrare guardando la **lunghezza** (< 32 caratteri = cifra,
altrimenti salva com'è, pensando a un hash). Una password scelta di 32 o più caratteri finiva nel database in chiaro.
Ora il controllo è `Hash::info($value)['algo'] !== null`: si salva così com'è solo un hash bcrypt/argon vero.
Test: `Modules/Meetup/tests/Feature/ProfileEditPageTest.php` ("stored hashed, never in clear").
Chi ha un database esistente può trovare le righe interessate con
`SELECT id FROM users WHERE password NOT LIKE '$2y$%' AND password NOT LIKE '$argon%';` e chiedere a quegli utenti un reset.

## Modifica del profilo dal sito

La pagina `/{lingua}/profile/edit` (tema Meetup, `pages/profile/edit.json`) usa le Actions di
`Modules\Meetup\Actions\Profile`: dati (nome, cognome, biografia, lingua), foto (collezione media `avatar`, una sola
per volta) e cambio password (verifica della password attuale, chiusura delle altre sessioni). Il menu utente
(`UserDropdown`) si ridisegna con l'evento Livewire `profile-updated`.
