---
title: "Diritti dell'interessato, conservazione e accountability: cosa esiste e cosa manca"
type: status
module: Gdpr
updated: 2026-11-25
related:
  - stories/dcp-140-diritti-dellinteressato-procedura-e-strumenti.story.md
  - stories/dcp-141-conservazione-log-e-minimizzazione-tecnica.story.md
  - stories/dcp-142-accountability-registro-trattamenti-dpia-dpa-e-violazioni.story.md
---

# Diritti dell'interessato, conservazione e accountability

Stato verificato sul codice il 2026-11-25. Il modulo da' gli **strumenti** (tabelle, Action, campi di configurazione); le
decisioni (periodi di conservazione, destino dei contenuti pubblicati, nomina del DPO) sono del titolare e le story
`DCP-140/141/142` le tengono aperte come `needs-decision` / `needs-data`.

## Matrice per diritto

| Diritto | Stato | Dove |
|---|---|---|
| Informativa (artt. 12-14) | pagina del progetto ospite; il modulo fornisce solo i link nei consensi | [registration.md](registration.md) |
| Consenso e prova (art. 7) | **fatto** | [consents.md](consents.md) |
| Revoca (art. 7 par. 3, art. 21) | **fatto**, tutti i consensi insieme; nessuna revoca per singolo trattamento | `RevokeGdprConsentsAction`, `HasGdpr::revokeConsent` |
| Cancellazione (art. 17) | **parziale**: disattiva e revoca, non anonimizza | [account-deletion.md](account-deletion.md) |
| Accesso (art. 15) e portabilita' (art. 20) | **non c'e'**: nessun export per l'utente finale (la dipendenza `spatie/laravel-personal-data-export` e' dichiarata dal modulo User ma nessun codice la usa) | [roadmap.md](roadmap.md) |
| Rettifica (art. 16) | non e' del modulo (modifica del profilo nel progetto ospite) | |
| Registro delle richieste con scadenza a un mese (art. 12 par. 3) | **non c'e'** | |
| Registro dei trattamenti (art. 30) | solo la tabella `treatments` (elenco dei trattamenti **con consenso**), vuota finche' non la si popola; il blocco `processing_register` di `config/config.php` e' un esempio non letto da codice | |
| DPIA (art. 35), responsabili (art. 28), violazioni (artt. 33-34) | **non ci sono** strumenti nel modulo: sono documenti e procedure del titolare | |
| DPO (art. 37) | solo i campi `dpo.name/email/phone` di `config/config.php`, vuoti | |

## Configurazione che non e' ancora applicata dal codice

`config/config.php` (chiave `gdpr.config.*`) contiene `retention` (anni per dati personali, log, documenti, e blocchi di un
settore specifico), `data_subject_rights.request_types` (accesso, rettifica, cancellazione, portabilita', 30 giorni),
`security_measures` (cifratura, blocco accessi, eventi da loggare), `insurance_consents` e `privacy_documents` (testi e PDF
di un settore). **Nessuna riga di `app/` legge queste chiavi** (grep del 2026-11-25): sono valori di esempio da sovrascrivere nel
config del tenant, non comportamenti. Non citarli in un'informativa come se fossero garantiti dal software.

## Cosa serve per chiudere i buchi (dalle story)

- **Esportazione e richiesta di cancellazione/anonimizzazione** nelle pagine "Impostazioni e privacy" del progetto (JSON con
  profilo, contenuti di cui l'utente e' proprietario e consensi; autorizzazione: solo l'utente autenticato, test con due utenti),
  registro delle richieste con scadenza `+1 mese`. Prerequisito: regola scritta con il DPO sul destino dei contenuti pubblicati
  (DCP-140).
- **Conservazione e log** (DCP-141): decisione del titolare sui termini (contenuti chiusi, mai pubblicati, account inattivi,
  consensi, log applicativi e di accesso degli amministratori); `LOG_STACK=daily`; processore di log che sostituisce le email con
  un hash; comandi di pulizia pianificati con dry-run; rimozione dell'EXIF alla ricezione delle foto.
- **Accountability** (DCP-142): registro dei trattamenti del servizio come righe `Treatment` e documento esportabile, screening
  DPIA, elenco dei responsabili con stato della nomina, procedura di violazione a 72 ore, contatto del DPO nel config del tenant.
  Si chiude con il DPO: il software fornisce solo i campi.

## Buone pratiche che il codice gia' segue

Privacy by default nel form di registrazione (consenso marketing facoltativo e non spuntato, consensi separati), IP e payload
degli eventi cifrati, hash dell'email nei log di registrazione, cookie non tecnici solo dopo scelta, nessuna terza parte dal
browser prima della scelta ([cookie-banner.md](cookie-banner.md)).
