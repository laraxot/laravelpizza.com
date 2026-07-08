---
title: Tutorial Admin — Configurare Google OAuth (GOOGLE_CLIENT_ID/SECRET)
type: tutorial
module: User
updated: 2026-04-20
---

# Tutorial: Configurare Google OAuth nel Backoffice

## Prerequisiti

1. Account Google Cloud Console con progetto creato
2. Accesso al backoffice Filament come admin
3. Accesso al file `.env` del server

---

## Step 1: Creare credenziali Google Cloud

1. Vai su [console.cloud.google.com](https://console.cloud.google.com)
2. Seleziona il progetto → **API e Servizi** → **Credenziali**
3. Clicca **+ Crea credenziali** → **ID client OAuth**
4. Tipo applicazione: **Applicazione web**
5. Nome: `Fixcity Production` (o simile)
6. URI di reindirizzamento autorizzati: aggiungi `https://tuodominio.it/auth/google/callback`
7. Clicca **Crea**
8. Copia **ID client** e **Segreto client**

---

## Step 2: Configurare le variabili d'ambiente

Nel file `.env` della applicazione:

```env
GOOGLE_CLIENT_ID=123456789-abcdefg.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=GOCSPX-xxxxxxxxxxxxxxxxx
```

Poi eseguire:
```bash
php artisan config:clear
php artisan cache:clear
php artisan optimize:clear
```

---

## Step 3: Attivare il provider nel backoffice

1. Login nel backoffice Filament: `/admin` (o il path configurato)
2. Nel menu laterale: **Socialite** → **Social Providers**
3. Trova il record **Google** nella lista
4. Clicca **Modifica** (matita)
5. Imposta:
   - `client_id`: opzionale (in produzione preferire sorgente `.env`)
   - `client_secret`: opzionale (in produzione preferire sorgente `.env`)
   - `active`: attiva il toggle ✅
   - `socialite`: deve essere attivo ✅
6. Salva

> **Nota**: `SocialProvider` è un modello Sushi (legge `config/social-providers.php`). Il `client_id`/`client_secret` vengono da `env()` nella config. In produzione il metodo preferito resta aggiornare `.env` e poi svuotare cache/config.

---

## Step 4: Verifica

1. Vai alla pagina di login: `/it/auth/login`
2. Dovrebbe apparire il pulsante **Continua con Google**
3. Clicca → redirect a Google → consenti → redirect al sito → login completato

In caso di errore:
- Verificare `GOOGLE_CLIENT_ID`/`GOOGLE_CLIENT_SECRET` in `.env`
- Verificare URI di redirect autorizzato in Google Cloud Console
- Controllare i log: `storage/logs/laravel.log`
- Verificare `active: true` in `SocialProviderResource`

---

## Architettura tecnica

```
config/social-providers.php
  └── google.client_id = env('GOOGLE_CLIENT_ID')
  └── google.active = false (default)

SocialProvider (Sushi) → legge config/social-providers.php
  └── SocialProviderResource (backoffice) → edit active/client_id

Login flow:
  RedirectToProviderController
    └── Socialite::driver('google')->redirect()
  ProcessCallbackController
    └── RetrieveOauthUserAction
    └── RetrieveSocialiteUserAction → SocialiteUser (tabella socialite_users)
    └── LoginUserAction / RegisterSocialiteUserAction
```

**Regola critica**: le connessioni OAuth vengono salvate in `socialite_users`, NON nella tabella `users`. Un utente può avere più provider collegati.

---

## Link correlati

- [Socialite Architecture](./socialite-architecture.md)
- [Google OAuth 2.0 docs](https://developers.google.com/identity/protocols/oauth2/web-server)
- [SocialProviderResource](../../../../../../laravel/Modules/User/app/Filament/Clusters/Socialite/Resources/SocialProviderResource.php)
