# Google OAuth front-office setup

## Stato

Il flusso Google usa il pulsante condiviso del modulo User, l'entrypoint Socialite locale e una pagina callback Folio+Volt del tema Sixteen. La pagina è solo un guscio HTTP: la policy OAuth resta in `ProcessCallbackAction`, riusabile e testabile.

Le rotte operative sono:

```text
/{lang}/auth/login/google
/{lang}/auth/login/google/callback
```

Il callback configurato in Laravel è unico (`GOOGLE_REDIRECT_URI`). La lingua di ingresso viene salvata in sessione, così `/en/auth/login/google` può usare il callback `/it/.../callback` autorizzato da Google e tornare comunque alla pagina inglese. Non esiste una route callback classica in `routes/socialite.php` e `web.php` non viene toccato.

## Configurazione

Le credenziali non devono essere committate. Impostare nell’ambiente di deploy:

```dotenv
GOOGLE_CLIENT_ID=...
GOOGLE_CLIENT_SECRET=...
GOOGLE_REDIRECT_URI=https://www.fixcity.eu/it/auth/login/google/callback
```

In Google Cloud Console autorizzare entrambi i callback richiesti dal progetto (`/it/.../callback` e `/en/.../callback`) e le origini `https://www.fixcity.eu` e `https://fixcity.eu`. Il runtime usa il primo come callback effettivo e conserva la lingua iniziale in sessione.

### Host canonico e `www`

nginx reindirizza `www.fixcity.eu` su `fixcity.eu` (301, query string conservata). `GOOGLE_REDIRECT_URI` deve essere **identico** a un URI registrato in Google: oggi sono registrati solo quelli con `www`, quindi il valore corretto e' `https://www.fixcity.eu/it/...`. Il valore `https://fixcity.eu/...` produce `redirect_uri_mismatch` finche' non viene aggiunto anche in Google Cloud Console. Il cookie di sessione e' host-only su `fixcity.eu`, e dopo il 301 il callback rientra li': il controllo `state` passa.

Controllo rapido dopo ogni modifica:

```bash
curl -s -o /dev/null -w '%{redirect_url}\n' https://fixcity.eu/it/auth/login/google
# atteso: accounts.google.com/o/oauth2/auth?client_id=...&redirect_uri=https%3A%2F%2Fwww.fixcity.eu%2F...
```

Storia dell'attivazione: [stories/google-oauth-production-activation.story.md](stories/google-oauth-production-activation.story.md).

Dopo la modifica dell’ambiente:

```bash
cd laravel
php artisan config:clear
php artisan optimize:clear
```

## Sicurezza

Il client secret fornito durante questa sessione è da considerarsi esposto: revocarlo/rigenerarlo in Google Cloud Console prima della produzione e sostituirlo solo nel secret store o nel `.env` non versionato del server.

Non inserire secret in JSON CMS, Blade, Filament resource, log, screenshot o documentazione.

## Verifica

- senza le tre chiavi il pulsante resta nascosto e il route entrypoint torna al login;
- con le chiavi il pulsante usa `/{lang}/auth/login/google`;
- il redirect Google contiene il callback configurato;
- il callback rifiutato torna alla stessa lingua;
- `route('oauth.callback', ['lang' => 'it', 'provider' => 'google'])` risolve la pagina Folio del tema;
- eseguire i test `Modules/User/tests/Feature/Socialite/*` e `Modules/Fixcity/tests/Feature/Auth/AuthGoogleButtonTest.php` dalla directory `laravel`.