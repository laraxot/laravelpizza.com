---
id: dcp-141
title: "DCP-141: conservazione, log e minimizzazione tecnica (retention, EXIF, redazione)"
type: story
epic: dc-parity-v2
status: needs-decision
priority: P1
owner: module:Gdpr + module:Fixcity
module: Gdpr
created: 2026-10-13
updated: 2026-10-13
qmd: "retention conservazione log rotazione laravel.log email negli errori exif foto gps prune minimizzazione art 5 lettera e"
related: [dcp-112, dcp-140, dcp-142]
---

# DCP-141: quanto si conserva, per quanto, e che cosa finisce nei log

Nata da DCP-112 (matrice normativa N-07, N-08, N-18).

## Lacuna e prova (2026-10-13)
- `laravel/storage/logs/laravel.log`: 27 MB dal 2026-09-26, nessuna rotazione (`LOG_STACK` di default `single`, `config/logging.php`). Contiene indirizzi email in messaggi di errore SQL (3 righe, es. `Duplicate entry '<email>' for key 'users.users_email_unique'`) e 80 righe con IPv4 (tutte `127.0.0.1` in questo ambiente). Il livello in `.env` locale e' `error`.
- `routes/console.php` ha solo il comando `inspire`: nessun job di cancellazione o anonimizzazione (grep di `prune` in Fixcity, Gdpr, User).
- Le foto non vengono ricodificate: l'EXIF con GPS e modello del dispositivo resta nell'originale servito (DCP-49 SEC-05, non corretto).
- L'informativa non indica un termine di conservazione (DCP-130).

## Norma (testo letto, registro fonti 02)
GDPR art. 5 par. 1 lett. c) e e) (minimizzazione, limitazione della conservazione), art. 25 par. 2 (per impostazione predefinita solo i dati necessari); Garante provv. 15.5.2014 n. 243 (pertinenza e non eccedenza dei dati pubblicati online) e provv. 27.11.2008 (log degli accessi degli amministratori, non meno di sei mesi): efficaci «in quanto compatibili» (D.Lgs. 101/2018 art. 22 c. 4); quali parti restano applicabili e' una valutazione del DPO.

## Decisione richiesta al titolare
Periodi di conservazione di: ticket chiusi, ticket mai pubblicati, account inattivi, consensi, log applicativi e log di accesso degli amministratori.

## Requisiti
1. `LOG_STACK=daily` con `LOG_DAILY_DAYS` coerente con la decisione; in produzione livello `warning` (gia' nell'esempio).
2. Processore di log che sostituisce le email con un hash prima della scrittura (anche nei messaggi SQL).
3. Comandi di pulizia pianificati (`schedule`) per i dati con scadenza decisa, con dry-run e rapporto.
4. Rimozione dell'EXIF alla ricezione delle foto (conversione registrata nella libreria media), con test su un JPEG con GPS.
5. Strumento per l'operatore che segnala testo o foto con dati personali prima della pubblicazione (campo di revisione), se il DPO lo ritiene necessario.

## Criteri di accettazione
- [ ] `php artisan schedule:list` mostra i comandi di pulizia; il dry-run produce un rapporto.
- [ ] Un test scrive un log con una email e verifica che nel file compaia l'hash.
- [ ] Un test carica un JPEG con GPS: la copia servita non ha tag GPS (`exiftool` o libreria).
- [ ] `config/logging.php` effettivo: canale `daily` nel `.env.production.example`.

## Dipendenze e priorita'
Decisione del DPO sui termini; DCP-140, DCP-142. P1.
