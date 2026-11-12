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
