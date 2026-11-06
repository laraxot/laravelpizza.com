---
id: dcp-142
title: "DCP-142: accountability: registro dei trattamenti, DPIA, nomine, procedura violazioni"
type: story
epic: dc-parity-v2
status: needs-data
priority: P1
owner: module:Gdpr (con il DPO dell'ente)
module: Gdpr
created: 2026-10-13
updated: 2026-10-13
qmd: "registro trattamenti art 30 dpia art 35 dpa art 28 data breach 72 ore dpo art 37 treatment seeder accountability"
related: [dcp-112, dcp-130, dcp-141]
---

# DCP-142: l'ente puo' dimostrare cio' che fa

Nata da DCP-112 (matrice normativa N-05, N-09, N-10, N-11, N-12, N-19).

## Lacuna e prova (2026-10-13)
- Il modello `Modules\Gdpr\Models\Treatment` esiste e la tabella ha 0 righe (tinker); nessun registro in `docs/`.
- Nessuna procedura operativa per le violazioni: solo `Modules/Fixcity/docs/DEEP-DIVE-006-security-gdpr.md` (bozza tecnica del 2026-06-17) e `Modules/Gdpr/docs/best-practices.md`.
- Nessuna DPIA, nessun elenco dei responsabili del trattamento, nessun contatto del DPO nel repo (`grep` vuoto).

## Norma (testo letto, registro fonti 02)
GDPR art. 24 par. 1 (il titolare mette in atto e «e' in grado di dimostrare»), art. 28 (nomina dei responsabili), art. 30 (registro), art. 33 (notifica entro 72 ore) e 34, art. 35 (DPIA se rischio elevato), art. 37 e 38 (DPO). Garante provv. 11.10.2018 n. 467 (elenco dei trattamenti con DPIA obbligatoria): da esaminare voce per voce.

## Requisiti
1. Compilare il registro dei trattamenti del servizio (segnalazioni, account, notifiche, log, mappe) come righe `Treatment` e come documento esportabile; i valori vengono dal titolare.
2. Scheda di screening DPIA con esito motivato rispetto all'elenco n. 467/2018 (geolocalizzazione, foto, utenti vulnerabili).
3. Elenco dei responsabili del trattamento (hosting, posta, monitoraggio, fornitori di mappe) con stato dell'atto di nomina e dei trasferimenti.
4. Procedura di violazione: ruoli, modulo di rilevazione, tempistica a 72 ore, modello di comunicazione agli interessati; prova di simulazione (tabletop) annotata.
5. Contatto del DPO nei file di configurazione del tenant, letto dall'informativa (DCP-130).

## Criteri di accettazione
- [ ] `Treatment::count()` maggiore di 0 nel DB di staging, con righe corrispondenti al documento.
- [ ] I quattro documenti esistono in `Modules/Gdpr/docs/` e sono linkati dalla matrice (righe N-09..N-12, N-19) con data e firmatario.
- [ ] Il contatto del DPO compare nell'informativa; `grep -rniE 'dpo' laravel/config/local/fixcity` lo trova.

## Dipendenze e priorita'
Dati e firme dell'ente (`needs-data`); DCP-130. P1: si chiude con il DPO, il software fornisce solo i campi.
