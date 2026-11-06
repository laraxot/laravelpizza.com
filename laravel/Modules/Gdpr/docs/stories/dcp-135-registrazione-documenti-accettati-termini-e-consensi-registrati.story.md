---
id: dcp-135
title: "DCP-135: registrazione: documenti accettati apribili, termini reali, consensi registrati"
type: story
epic: dc-parity-v2
status: ready-for-dev
priority: P1
owner: module:Gdpr
module: Gdpr
created: 2026-10-13
updated: 2026-10-13
qmd: "registrazione consensi treatment consent termini condizioni informativa link checkbox saveGdprConsentsAction marketing facoltativo"
related: [dcp-112, dcp-130, dcp-134, dcp-124]
---

# DCP-135: la registrazione fa accettare solo cio' che si puo' leggere e lascia traccia

Nata da DCP-112 (matrice normativa N-02, N-04).

## Lacuna e prova (2026-10-13)
- `/it/auth/register`: «Ho letto e accetto l'Informativa Privacy» e «Ho letto e accetto i Termini e Condizioni» sono testo semplice, senza link (DOM). Le caselle sono tre e separate; quella di marketing e' facoltativa, non spuntata e con un refuso («(facoltativo]»). Questo e' corretto.
- `config/local/fixcity/terms.md` e `lang/{it,en}/terms.md` sono ancora «Edit this file to define the terms of service for your application.» (88 byte): si chiede di accettare un testo che non esiste.
- `SaveGdprConsentsAction::execute()` crea un `Consent` solo se trova la riga `Treatment` (`privacy_policy`, `terms_conditions`, `marketing_consent`); `Modules\Gdpr\Models\Treatment::count()` = 0 e `Consent::count()` = 0 (tinker): oggi nessuna registrazione lascia traccia del consenso. Il `Consent` non porta la versione dell'informativa.
- `Modules/Gdpr/app/Filament/Widgets/Auth/RegisterWidget.php` contiene marcatori di merge irrisolti (`<<<<<<< HEAD`, `>>>>>>> 12e4ae8`) in un docblock: segnale di un merge non ripulito, non un errore funzionale.

## Norma
GDPR art. 7 par. 1 (onere di dimostrare) e art. 7 par. 4 (consenso separato e non condizione): testo nel registro fonti 02; art. 13 e art. 12 par. 1 per la raggiungibilita' dell'informativa (vedi DCP-130).

## Requisiti
1. Link «Informativa Privacy» e «Termini» nelle etichette, con nome accessibile e indicazione se si apre in una nuova scheda; usano le pagine di DCP-130 e una pagina Termini reale, oppure la casella dei termini viene tolta finche' non esistono.
2. Dati iniziali dei `Treatment` (privacy, termini, marketing) come seeder/migrazione di dati, forward-only, approvati prima dell'esecuzione.
3. Il `Consent` registra anche l'identificativo della versione del testo accettato (campo `metadata` esistente).
4. Correggere il refuso e rimuovere i marcatori di merge.

## Criteri di accettazione
- [ ] DOM della registrazione: due `<a href>` che rispondono 200; la casella marketing resta facoltativa e non spuntata.
- [ ] Test (DB isolato): registrare un utente crea 3 `Consent` (marketing con `accepted_at` nullo se rifiutato) con `ip_address` e versione.
- [ ] `grep -n '<<<<<<<\|>>>>>>>' laravel/Modules/Gdpr/app/Filament/Widgets/Auth/RegisterWidget.php` vuoto.
- [ ] `terms.md` del tenant non contiene la frase segnaposto, oppure la casella e' assente.

## Dipendenze e priorita'
DCP-130, DCP-134 (se la base cambia, cambiano anche i testi). P1.