---
id: dcp-204
title: "DCP-204: richieste dell'interessato, cancellazione dell'account, verifica email e consensi: cosa fare e cosa decidere"
type: story
epic: dc-parity-v2
status: ready-for-dev
priority: P0
owner: module:Gdpr
module: Gdpr
created: 2026-10-15
updated: 2026-10-15
qmd: "gdpr registro richieste interessato data_subject_requests cancellazione account anonimizzare revoca consenso verifica email minori password dodici caratteri consenso marketing"
related: [dcp-140, dcp-141, dcp-165, dcp-178, dcp-181, dcp-185, dcp-186, dcp-200]
tags: [gdpr, privacy, dpo, account]
---

# DCP-204: richieste dell'interessato, cancellazione dell'account, verifica email e consensi: cosa fare e cosa decidere

## Fase BMAD
Plan. Nulla qui si implementa prima della decisione corrispondente in DCP-200 (DEC-07..DEC-15); lo sviluppo prepara il codice che non dipende da una scelta del DPO. Piano del registro: `Modules/Gdpr/docs/blueprints/registro-richieste-interessato.md` (bozza, D1-D7).

## Stato misurato (2026-10-15)
- La registrazione salva ora la prova del consenso (DCP-178); il resto di DCP-178 aspetta il DPO.
- `DeleteAccountAction` e la rotta `account.delete` esistono (altra sessione); `RevokeGdprConsentsAction` **scrive ancora `revoked_user_agent`** (riga 36), colonna che la tabella `consents` **non ha** (ha `revoked_at` e `revoked_ip_address`): la revoca fallirebbe con `Unknown column`.
- `users.deleted_at` e `deleted_by` esistono ma `BaseUser` ha `// use SoftDeletes;` commentato: un utente «cancellato» potrebbe ancora accedere.
- La revoca filtra per `subject_id`/`subject_type` mentre la registrazione scrive `user_id`/`user_type`: i consensi della registrazione non verrebbero trovati.
- `tickets.owner_id` e' NOT NULL e senza chiave esterna: cancellare l'utente lascia ticket orfani o fallisce.
- Nessuna tabella per le richieste dell'interessato.

## Da fare, senza decisione (tecnico)
- [ ] Correggere `RevokeGdprConsentsAction`: colonne reali di `consents`, filtro per `user_id`/`user_type` coerente con `SaveGdprConsentsAction`; test su schema reale (database `user` e `gdpr`), non su doppioni.
- [ ] Fare una transazione che copra **entrambe** le connessioni, oppure ordinare le scritture in modo che un errore non lasci stati a meta'; test del rollback.
- [ ] Regola password: allineare il server a 12 caratteri (DEC-15, C6); test in 4 lingue.
- [ ] Pagina dei diritti nell'area personale che porti a una via reale per esercitarli (C13): per ora un recapito del DPO (DEC-06).
- [ ] Scrivere la migrazione di `data_subject_requests` **senza eseguirla sul database di sviluppo**, dopo l'approvazione di DEC-09.

## Da decidere (DCP-200)
| ID | Cosa | Proposta |
|---|---|---|
| DEC-07 | base giuridica | compito di interesse pubblico per la segnalazione, consenso solo per il facoltativo (DPO) |
| DEC-08 | consenso marketing e consenso diverso per lingua | togliere il marketing; un solo testo tradotto |
| DEC-09 | D1-D7 del registro e nuova tabella | accettare D1-D7 |
| DEC-10 | cancellazione: anonimizzare o cancellare; destino dei ticket | anonimizzare e tenere i ticket di interesse pubblico (DPO) |
| DEC-11 | verifica dell'email (oggi `email_verified_at = now()`) | obbligatoria per le notifiche, non per segnalare |
| DEC-12 | eta' minima e conservazione dei log | 14 anni; durata dal DPO |

## Criteri di accettazione
- [ ] Revoca e cancellazione provate su schema reale con test rosso prima; `ConsentRevocationTest` e `AccountDeletionTest` (nomi sul comportamento).
- [ ] Dopo la cancellazione l'utente non puo' piu' accedere (test di login) e i dati non necessari sono rimossi o anonimizzati come da DEC-10.
- [ ] Informativa aggiornata dall'ente con quanto sopra (DEC-02): senza questo la story non e' chiusa.
- [ ] PHPStan a zero; nessuna tabella creata senza approvazione.

## Non verificato
Parere del DPO e di un legale; invio reale della posta di verifica; comportamento su Firefox e Safari; lettore di schermo sul modulo di cancellazione.
