---
id: dcp-140
title: "DCP-140: diritti dell'interessato: procedura e strumenti (artt. 15-22)"
type: story
epic: dc-parity-v2
status: ready-for-dev
priority: P1
owner: module:Gdpr + module:User
module: Gdpr
created: 2026-10-13
updated: 2026-10-13
qmd: "diritti interessato accesso rettifica cancellazione portabilita export dati account delete account area personale impostazioni privacy gdpr art 15 17 20"
related: [dcp-112, dcp-111, dcp-106, dcp-141]
---

# DCP-140: il cittadino puo' esercitare i propri diritti

Nata da DCP-112 (matrice normativa N-06). Si coordina con DCP-111 (pagine «Impostazioni e privacy»), che prevede «informazioni e canali per esercitare i diritti GDPR».

## Lacuna e prova (2026-10-13)
- Nessun canale nel front office: `/it/profile/edit` risponde 200 con `<main>` vuoto (DCP-106). Il widget `Modules/User/app/Filament/Widgets/Profile/DeleteAccountWidget.php` esiste ma non e' raggiunto da nessuna pagina servita.
- Nessun export dei dati dell'utente (grep di `export`/`portabil` in `Modules/User`, `Modules/Gdpr`, `Modules/Fixcity`: nessuna funzione per l'utente finale).
- L'informativa rinvia ai «recapiti pubblicati sul portale» (DCP-133: segnaposto).
- Non e' definito che cosa accade ai ticket pubblicati quando l'utente chiede la cancellazione (`tickets.owner_id` non nullo, DCP-42/D17).

## Norma (testo letto, registro fonti 02)
GDPR art. 12 par. 3 (risposta «al piu' tardi entro un mese dal ricevimento della richiesta»), art. 15 (accesso), art. 16 (rettifica), art. 17 (cancellazione, con eccezioni per obbligo giuridico e compito di interesse pubblico), art. 18, art. 20 (portabilita' in formato strutturato, di uso comune e leggibile da dispositivo automatico), art. 21 (opposizione).

## Requisiti
1. Nelle pagine «Impostazioni e privacy» (DCP-111): esportazione dei propri dati (profilo, ticket di cui e' proprietario, consensi) in JSON; modifica di nome ed email; richiesta di cancellazione o anonimizzazione con esito definito.
2. Regola scritta, con il DPO, sul destino dei ticket pubblicati (anonimizzare l'autore e conservare il contenuto di interesse pubblico, o cancellare): senza questa decisione la cancellazione non si implementa.
3. Registro delle richieste con data di ricezione e scadenza a un mese; canale di contatto del DPO (DCP-133) per chi non puo' usare l'area personale.
4. Autorizzazione: ogni export e cancellazione riguarda solo l'utente autenticato; test.

## Criteri di accettazione
- [ ] Un utente di prova scarica un JSON che contiene solo i propri dati (test con due utenti: l'altro non compare).
- [ ] La cancellazione lascia i ticket nello stato deciso e non lascia email in chiaro (verifica sul DB di test).
- [ ] La richiesta dell'interessato crea un record con scadenza `+1 mese`.
- [ ] La pagina e' raggiungibile dal menu utente (DCP-106) e dall'informativa.

## Dipendenze e priorita'
DCP-111, DCP-141 (conservazione), decisione del DPO. P1.

## Nota 2026-10-14 (DCP-176, dalla skill `compliance-check` del plugin legal)
Il registro delle richieste (requisito 3) deve avere anche: tipo di richiesta (accesso, rettifica, cancellazione, limitazione, portabilita', opposizione), esito della verifica dell'identita' del richiedente (proporzionata, senza documenti eccessivi), incaricato, e per ogni rifiuto la base giuridica e l'informazione sul diritto di reclamo al Garante. Termine: un mese, prorogabile di due con avviso motivato entro il primo mese (GDPR art. 12 par. 3). Le esenzioni (obbligo di legge, compito di interesse pubblico, difesa in giudizio) vanno annotate caso per caso. La skill cita anche CCPA e LGPD: non pertinenti a questo progetto.

## Nota 2026-10-14 (DCP-178)
La verifica della registrazione ha mostrato che oggi non esiste ne' cancellazione ne' revoca del consenso in autonomia: `DeleteAccountWidget` non e' raggiunto da nessuna pagina e `DeleteUserAction` lascia i ticket con `owner_id` orfano (NOT NULL, nessuna chiave esterna). La proposta di default e le decisioni aperte sono in `dcp-178-registrazione-e-disiscrizione-a-norma.story.md`. La regola sui ticket (requisito 2) resta il blocco per implementare la cancellazione.
