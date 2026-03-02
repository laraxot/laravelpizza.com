### Versione HEAD

# Configurazione OAuth con GitHub

## Prerequisiti

- Account GitHub attivo
- Applicazione Laravel con [Laravel Passport](../passport.md) configurato correttamente
- Modulo User installato e configurato

## Procedura di Configurazione

1. Accedere a [GitHub Developer Settings](https://github.com/settings/developers)
2. Fare clic su "New OAuth App"
3. Compilare i dettagli richiesti:
   - **Application Name**: Nome della tua applicazione
   - **Homepage URL**: URL della tua applicazione (es. `https://<nome progetto>.it`)
   - **Authorization callback URL**: URL di callback per GitHub (es. `https://<nome progetto>.it/{locale}/auth/callback/github`)
4. Fare clic su "Register Application"
5. Copiare il **Client ID** e il **Client Secret** generati

## Configurazione in Laravel

Aggiungere le seguenti variabili al file `.env`:

```
GITHUB_CLIENT_ID=il_tuo_client_id
GITHUB_CLIENT_SECRET=il_tuo_client_secret
GITHUB_REDIRECT_URI=https://<nome progetto>.it/{locale}/auth/callback/github
```

## Documentazione Correlata

- [Integrazione Laravel Passport](../passport.md) - Configurazione completa di OAuth2
- [Autenticazione Social](../socialite.txt) - Integrazione con altri provider OAuth

### Versione Incoming

Go to GitHub Developer Settings.(https://github.com/settings/developers)
Click on "New OAuth App".
Fill in the required details:
Application Name: Your app's name.
Homepage URL: Your app's URL.
Authorization callback URL: http://your-app-url.com/callback/github.

---
