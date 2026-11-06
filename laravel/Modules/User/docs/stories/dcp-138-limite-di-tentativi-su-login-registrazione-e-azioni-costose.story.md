---
id: dcp-138
title: "DCP-138: limite di tentativi che funzioni davvero su login, registrazione e azioni costose"
type: story
epic: dc-parity-v2
status: ready-for-dev
priority: P1
owner: module:User + module:Fixcity
module: User
created: 2026-10-13
updated: 2026-10-13
qmd: "rate limit throttle login brute force livewire loginwidget throttleauthentication security.php ticket save geocoding 429"
related: [dcp-112, dcp-102, dcp-139]
---

# DCP-138: il login e le azioni costose hanno un tetto

Nata da DCP-112 (matrice normativa N-13).

## Lacuna e prova (2026-10-13)
- Alle 17:08, Playwright su `/it/auth/login`: 9 tentativi consecutivi con una email inesistente, nessun blocco. `Modules/User/app/Filament/Widgets/Auth/LoginWidget.php::login()` non aveva `RateLimiter`; `App\Http\Middleware\ThrottleAuthentication` esiste ma nessun codice lo registra (grep su `laravel/` esclusi vendor e docs), legge `auth.rate_limit.*` (chiave non definita in `config/auth.php`) e la sezione `rate_limit` di `config/security.php` non e' letta da alcun codice.
- Alle 17:28 un'altra sessione (G-07 di DCP-54) ha aggiunto in `LoginWidget::login()` un `RateLimiter` (5 tentativi in 60 s, chiave email+IP, messaggio `user::login.actions.login.throttle`) con `Modules/Fixcity/tests/Feature/Pages/LoginThrottleTest.php` (non rieseguito qui).
- **Rimisurato alle 18:07 sul server di sviluppo: il blocco non scatta.** 8 tentativi consecutivi con un'altra email inesistente, nessun messaggio «Troppi tentativi di accesso»; da `php artisan tinker` `RateLimiter::attempts(<chiave>)` = 0. Causa probabile: `bootstrap/cache/config.php` (12:42) ha `cache.default = 'array'` (il `.env` ha `CACHE_DRIVER=file`), e uno store `array` non conserva i contatori tra una richiesta e l'altra. Non confermato (richiede `config:clear`, non eseguito).
- Il salvataggio del ticket e i metodi di geocoding non hanno tetto (DCP-49 SEC-07). Il tracciamento per codice e' coperto da DCP-102 (14 richieste di prova, 14 risposte 200).

## Norma
GDPR art. 32 (misure adeguate al rischio, riservatezza); Garante provv. 7.12.2023 n. 594 sulle password (registro fonti 02). La misura concreta e' una scelta tecnica, il rischio e' l'accesso abusivo agli account dei cittadini.

## Requisiti
1. Far funzionare davvero il limite gia' scritto nel widget (verifica sul server, non solo in Pest): store di cache persistente per il `RateLimiter` anche con la config in cache, e prova end-to-end. Estendere lo stesso approccio a registrazione e reset password; valori da una chiave di configurazione unica (oggi `LoginWidget::MAX_ATTEMPTS` e `DECAY_SECONDS`, e una chiave `rate_limit` inutilizzata in `config/security.php`).
2. Limite per utente sul salvataggio del ticket e per sessione sui metodi `searchAddress` e `reverseGeocode`.
3. I valori restano configurabili; nessun dato personale nei log del limitatore (email in hash).
4. Non toccare il tracciamento: e' DCP-102.

## Criteri di accettazione
- [ ] Playwright sul server di sviluppo con la config in cache: al sesto tentativo errato entro la finestra la pagina mostra il messaggio di attesa e non `Credenziali non valide`; `RateLimiter::attempts(<chiave>)` da tinker e' maggiore di 0; dopo la finestra il login torna possibile.
- [ ] `php artisan tinker --execute='echo config("cache.default");'` restituisce uno store persistente (`file`, `database` o `redis`).
- [ ] Test Pest su `LoginWidget` con `RateLimiter` pulito per test.
- [ ] Test sul ticket: l'undicesimo salvataggio al minuto dello stesso utente e' rifiutato (soglia da decidere).
- [ ] `grep -rn 'ThrottleAuthentication' laravel/app laravel/bootstrap laravel/Modules/*/app` mostra un uso reale oppure il file e' archiviato con nota.

## Dipendenze e priorita'
DCP-102 (tracciamento), DCP-139 (intestazioni). P1: da chiudere prima della produzione.
