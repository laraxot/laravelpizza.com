---
id: dcp-168
title: "DCP-168: monitoraggio del servizio con Web Analytics Italia e statistiche pubbliche aggregate"
type: story
epic: dc-parity-v2
status: needs-decision
priority: P2
owner: module:Gdpr
module: Gdpr
created: 2026-10-14
updated: 2026-10-14
qmd: "web analytics italia wai matomo monitoraggio statistiche pubbliche aggregate anonime cookie consenso garante 7.2 linee guida design 4.4.1 4.4.2 4.4.3 gdpr.config.cookie.extra"
related: [dcp-153, dcp-163, 6.5, 8.2]
---

# DCP-168: monitoraggio del servizio con Web Analytics Italia e statistiche pubbliche aggregate

## Lacuna e prova (2026-10-14)
Requisiti 4.4.1-4.4.3 (Linee guida di design della PA, capitolo 4 «Requisiti» (versione corrente, letto il 2026-10-14)): raccogliere traffico e comportamento (DEVONO), pubblicare le informazioni aggregate e anonime (DEVONO), adottare Web Analytics Italia (DOVREBBE). Oggi nessuno strumento di misura: coerente con i soli cookie tecnici, ma i requisiti non sono soddisfatti.

## Norma
Linee guida di design 4.4.1-4.4.3; Linee guida cookie del Garante 10.6.2021, par. 7.2: gli analytics sono equiparati ai cookie tecnici solo con minimizzazione (maschera dell'indirizzo IP, uso per statistiche aggregate, un solo sito, nessuna combinazione dei dati). Registro fonti 02. L'adesione a Web Analytics Italia e' una procedura dell'ente presso AgID: NON VERIFICATA qui.

## Requisiti
1. Decisione dell'ente: aderire a Web Analytics Italia (consigliato) oppure misurare in altro modo.
2. Se si misura: lo strumento va dichiarato in `gdpr.config.cookie.extra` (DCP-153), con il tipo (tecnico equiparato o analitico), e parte solo secondo l'esito del banner: ascolta `cookie-consent:changed` e legge `__cookie_consent`. Se e' equiparato ai tecnici (par. 7.2) la configurazione di minimizzazione e' verificata e scritta.
3. Pagina pubblica con statistiche aggregate e anonime (visite per pagina e periodo, segnalazioni per stato), senza dati personali; soglia minima per non identificare nessuno.
4. Nessun tag in `<head>` prima del consenso; test che lo provi.

## Criteri di accettazione
- [ ] Decisione scritta (strumento, base giuridica, minimizzazione).
- [ ] Test del browser: senza consenso nessuna richiesta all'host dello strumento; con consenso parte.
- [ ] La cookie policy elenca i cookie dello strumento; `GetCookieInventoryAction` li include.
- [ ] La pagina di statistiche mostra solo dati aggregati e rispetta la soglia.

## Dipendenze e priorita'
Decisione dell'ente (needs-decision). Dipende da DCP-153 (meccanismo del consenso, evento gia' disponibile) e 6.5. P2.
