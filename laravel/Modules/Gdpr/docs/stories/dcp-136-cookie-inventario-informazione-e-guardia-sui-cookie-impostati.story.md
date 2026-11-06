---
id: dcp-136
title: "DCP-136: cookie: inventario, informazione e guardia sui cookie impostati"
type: story
epic: dc-parity-v2
status: ready-for-dev
priority: P1
owner: module:Gdpr
module: Gdpr
created: 2026-10-13
updated: 2026-10-13
qmd: "cookie tecnici inventario informativa cookie banner garante linee guida 2021 statikbe cookie-consent middleware allowlist XSRF session debugbar"
related: [dcp-112, dcp-130, dcp-137]
---

# DCP-136: i cookie sono pochi, noti e dichiarati

Nata da DCP-112 (matrice normativa N-16; matrice interfaccia I-20).

## Lacuna e prova (2026-10-13)
- Playwright su 10 pagine pubbliche (`/it`, `/en`, `/de`, `/es`, `/it/tickets`, `/it/tickets/track`, `/it/auth/login`, `/it/auth/register`, `/it/domande-frequenti`, `/it/mappa-sito`): cookie impostati `XSRF-TOKEN` (7200 s, non httpOnly), `fixcity_session` (7200 s, httpOnly, SameSite lax) e `PHPDEBUGBAR_STACK_DATA` (solo locale). Nessun cookie di profilazione ne' script di analytics.
- Nessun banner e nessuna informazione sui cookie in alcuna pagina.
- Codice morto o ambiguo: `Statikbe\CookieConsent\CookieConsentMiddleware` e' registrato (`Themes/Sixteen/app/bootstrap/app.php:21`, `Modules/Gdpr/app/Providers/GdprServiceProvider.php:41`) e ogni pagina carica `/vendor/cookie-consent/css/cookie-consent.css`, ma non esce alcun banner; `Themes/Sixteen/resources/js/cookie-consent.js` ha categorie funzionalita', analytics e marketing con `enabled: true` e non e' importato dal bundle. Se qualcuno lo attivasse cosi' com'e' violerebbe il principio di preimpostazione a diniego (par. 7.1).

## Norma (testo letto, registro fonti 02)
D.Lgs. 196/2003 art. 122 c. 1; Garante, Linee guida cookie e altri strumenti di tracciamento, provv. 10.6.2021 n. 231 (GU n. 163 del 9.7.2021): par. 4-5 (per i cookie tecnici basta l'informativa), par. 7.1 (con la sola presenza di cookie tecnici basta darne informazione in homepage o nell'informativa; senza banner; nessun cookie non tecnico al primo accesso), par. 7.2 (analytics assimilati solo con minimizzazione), par. 8 (informativa conforme agli artt. 12 e 13).

## Requisiti
1. Inventario in `Modules/Gdpr/docs/` (nome, finalita', durata, tecnico si/no) e testo informativo nella pagina privacy o in una pagina cookie, in 4 lingue.
2. Decisione scritta: soli cookie tecnici, nessun banner. Se in futuro si aggiunge un tracciatore non tecnico, serve banner conforme (par. 7.1) prima di attivarlo.
3. Togliere o isolare il pacchetto banner inutilizzato (middleware e CSS) e il file JS con categorie preattivate, o documentarne lo stato "non attivo".
4. Guardia automatica: un test di integrazione chiede le pagine pubbliche da ospite e confronta i nomi dei cookie con una lista consentita (`XSRF-TOKEN`, `fixcity_session`); ogni nome nuovo fallisce.
5. Verificare in produzione che `PHPDEBUGBAR_STACK_DATA` non sia impostato (`DEBUGBAR_ENABLED=false`).

## Criteri di accettazione
- [ ] Documento di inventario e paragrafo informativo pubblicati in it, en, de, es.
- [ ] Test lista consentita verde; con un cookie aggiunto di prova il test fallisce.
- [ ] `curl -s http://.../it | grep -c cookie-consent` = 0 se il banner non e' usato.
- [ ] Nessuna richiesta di rete a domini di tracciamento (rimando alla verifica di DCP-137).

## Dipendenze e priorita'
DCP-130 (dove scrivere l'informazione), DCP-137 (risorse di terze parti). P1.
