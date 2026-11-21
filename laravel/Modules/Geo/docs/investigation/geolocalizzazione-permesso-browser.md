---
type: investigation
title: "Geolocalizzazione — permesso browser e requisito HTTPS"
links: {github_issue: "#530"}
---

## Problema
Il pulsante "usa la posizione corrente" nel componente `geolocation.js` (Geo) non attiva la geolocalizzazione.

## Requisito HTTPS (`window.isSecureContext`)
L'API `navigator.geolocation` richiede un contesto sicuro. Se `window.isSecureContext` è `false` (app su HTTP, non HTTPS), il browser non permette la geolocalizzazione e il codice entra nel ramo `!window.isSecureContext` → `fallBackToApproximate(ctx, !auto)` senza prompt.

## Stato attuale dell'app
- `.env`: `APP_URL=http://fixcity.local` → HTTP, non sicuro per geolocation.
- `.env.production.example`: `APP_URL=https://fixcity.example.com`, `FORCE_HTTPS=true`, `SECURE_COOKIES=true`, `SESSION_SECURE_COOKIE=true`.
- Per attivare la geolocalizzazione in produzione è necessario passare a HTTPS e impostare `FORCE_HTTPS=true`.

## Permessi browser
Anche con HTTPS, il browser può negare il permesso (`navigator.permissions` o `getCurrentPosition` error con `PERMISSION_DENIED`). Il codice attuale gestisce il caso ma non mostra un invito esplicito all'utente: il messaggio resta neutro (`location_unavailable` / `no_position`).

## Fallback (`fallBackToApproximate`)
Il fallback è già implementato nel codice (`geolocation.js`) ed è attivato su:
- `!window.isSecureContext`
- `!navigator.geolocation`
- errore del sensore o permesso negato (`error()` callback)

Il parametro `explicitRequest` (`!auto`) determina se mostrare un errore esplicito (`_locationError`) o solo un invito neutro quando il campo è vuoto.

## Raccomandazioni
- In produzione: migrare su HTTPS (`APP_URL=https://...`, `FORCE_HTTPS=true`).
- Verificare che il componente UI mostri l'invito neutro quando il GPS non è disponibile, senza citare esplicitamente "HTTPS" o "permessi".
- Se il permesso viene negato, impostare sul contesto (`ctx`) un flag che permetta al componente di suggerire all'utente di controllare le impostazioni del browser.
