---
id: dcp-144
title: "DCP-144: accesso del cittadino con SPID/CIE, o decisione motivata di non applicabilita'"
type: story
epic: dc-parity-v2
status: needs-decision
priority: P1
owner: module:User
module: User
created: 2026-10-13
updated: 2026-10-13
qmd: "spid cie identificazione informatica cad art 64 comma 2-quater 3-bis art 65 istanze decreto 76 2020 login cittadino oidc eidas"
related: [dcp-112, dcp-42, dcp-48]
---

# DCP-144: come si identifica il cittadino che segnala

Nata da DCP-112 (matrice normativa N-24, N-25, N-26, N-31).

## Lacuna e prova (2026-10-13)
- Il login e la registrazione sono con email e password (`Modules/User/app/Filament/Widgets/Auth/LoginWidget.php`, `Modules/Gdpr/.../RegisterWidget.php`). Nessuna traccia di SPID o CIE: `grep -riE 'spid|cie|agid|saml|oidc'` su `Modules/*/app` e `config` trova solo i tipi generici del form `SsoProviderResource` (DCP-48); `sso_providers` e `socialite_users` hanno 0 righe.
- La creazione della segnalazione richiede il login (DCP-42, D17), quindi il servizio richiede identificazione.

## Norma (testo vigente letto su Normattiva, registro fonti 03)
CAD art. 64 c. 2-quater: «L'accesso ai servizi in rete erogati dalle pubbliche amministrazioni che richiedono identificazione informatica avviene tramite SPID, nonche' tramite la carta di identita' elettronica.» c. 3-bis: i soggetti di cui all'art. 2 c. 2 lett. a) «utilizzano esclusivamente le identita' digitali SPID e la carta di identita' elettronica ai fini dell'identificazione dei cittadini che accedono ai propri servizi in rete» (salvo la CNS, c. 2-nonies). CAD art. 65 c. 1: le istanze presentate per via telematica sono valide, tra l'altro, quando l'istante e' identificato attraverso SPID, CIE o CNS. D.L. 76/2020 art. 24 c. 1 lett. e) e c. 4 (conv. L. 120/2020): «a decorrere dal 28 febbraio 2021» le PA «utilizzano esclusivamente» SPID e CIE; dal 28.2.2021 «e' fatto divieto» di rilasciare nuove credenziali diverse da SPID, CIE o CNS, e quelle gia' rilasciate restano utilizzabili non oltre il 30.9.2021. Il testo vigente dell'art. 64 c. 3-bis non riporta piu' la data e il c. 4 usa «SPID, CIE o CNS» mentre il c. 3-bis dice «SPID e CIE»: dubbio per il legale (registro fonti 03, sezioni 1 e 18). CAD art. 64-bis: servizi fruibili dal punto di accesso telematico; Reg. (UE) 2024/1183 art. 5 septies: il settore pubblico che richiede identificazione elettronica accetta anche i portafogli europei (termine di 24 mesi dagli atti di esecuzione, derivato 24.12.2026 e PARZIALE).

## Decisione richiesta al Comune (e al RTD)
A) Adottare SPID e CIE come accesso del cittadino (anche tramite un intermediario del Comune o della Regione); l'account locale resta solo se la norma lo consente per quel servizio.
B) Motivare per iscritto che il login di FixCity non e' «identificazione informatica» ai sensi dell'art. 64 (per esempio perche' la segnalazione non e' un'istanza di procedimento e l'account serve solo a ricevere notifiche), con firma del RTD. Questa e' una qualificazione giuridica: NON VERIFICATO fino alla firma.

## Requisiti (se A)
1. Provider OIDC SPID/CIE sul modulo User (il pacchetto Socialite e le tabelle `sso_providers` esistono); creazione dell'utente dai soli attributi necessari (il codice fiscale non si conserva salvo decisione di DCP-48).
2. Test sul validatore SPID/CIE di un ambiente di prova; stato `intended` conservato (DCP-124).
3. Informativa aggiornata con il fornitore di identita' come destinatario.
4. Decisione sul punto di accesso telematico (CAD art. 64-bis) e sul portafoglio europeo (eIDAS 2): inserire il servizio nel punto di accesso del Comune o motivare perche' no; predisporre l'accettazione del portafoglio alla scadenza confermata.

## Criteri di accettazione
- [ ] Decisione A o B registrata e firmata nel decision log.
- [ ] Se A: login con un'identita' di prova, ritorno alla pagina richiesta (`/it/tickets/create`), nessun dato oltre il necessario salvato.
- [ ] Se B: documento firmato linkato dalla matrice (riga N-24).

## Dipendenze e priorita'
Decisione del Comune e dell'RTD; DCP-42, DCP-48, DCP-124. P1 (alto rischio ma bloccato da una decisione, non da codice).
