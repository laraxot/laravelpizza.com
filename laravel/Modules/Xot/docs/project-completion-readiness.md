---
title: "Readiness e lacune per completare PTVX"
type: audit
status: open
created: 2026-10-28
updated: 2026-10-28
tags: [project-readiness, audit, bmad]
qmd: "PTVX progetto completamento readiness lacune moduli temi story gate test deploy integrazione"
related:
  - ./project-completion-gaps.md
  - ./bmad/stories/docs-modules-themes-continuous-reorg.story.md
  - ./bmad/stories/project-completion-readiness.story.md
---

# Readiness e lacune per completare PTVX

## Esito attuale

**Il progetto non è certificabile come completo con le evidenze disponibili.** Questo è
un audit di readiness basato su `docs/sprint-status.yaml`, sulle story BMAD presenti e
sul censimento delle cartelle `docs/`; non sostituisce una verifica funzionale end-to-end
né afferma che ogni backlog aperto sia un bug.

Sono stati censiti **18 moduli e 3 temi** con `docs/`. In tutti i 21 owner è stata
creata una scheda locale `docs/project-completion-gaps.md`; ciascuna riporta conteggi e
criteri ancora da dimostrare. Le story non concluse e le decisioni aperte sono il primo
piano di lavoro, non vanno chiuse in massa senza prove.

## Evidenze aggregate delle docs

| Owner | Markdown | Story | Frontmatter iniziale | README/purpose mancanti |
|---|---:|---:|---:|---|
| Modules/Activity | 737 | 39 | 720/737 |: |
| Modules/Incentivi | 150 | 21 | 112/150 | README.md |
| Modules/IndennitaCondizioniLavoro | 212 | 59 | 167/212 |: |
| Modules/IndennitaResponsabilita | 476 | 157 | 439/476 |: |
| Modules/Job | 459 | 32 | 459/459 |: |
| Modules/Lang | 1003 | 37 | 1002/1003 |: |
| Modules/Media | 542 | 36 | 542/542 |: |
| Modules/Notify | 3671 | 48 | 3652/3671 |: |
| Modules/Pdnd | 139 | 17 | 110/139 |: |
| Modules/Performance | 104 | 28 | 83/104 |: |
| Modules/Progressioni | 206 | 54 | 150/206 |: |
| Modules/Ptv | 461 | 132 | 425/461 | purpose.md |
| Modules/Rating | 567 | 149 | 563/567 |: |
| Modules/Sigma | 353 | 57 | 313/353 |: |
| Modules/Tenant | 529 | 28 | 528/529 |: |
| Modules/UI | 444 | 22 | 444/444 |: |
| Modules/User | 2195 | 155 | 2034/2195 |: |
| Modules/Xot | 1556 | 151 | 1552/1556 |: |
| Themes/One | 113 | 6 | 113/113 | purpose.md |
| Themes/Three | 58 | 2 | 58/58 | purpose.md |
| Themes/Zero | 221 | 10 | 221/221 | purpose.md |

Il controllo frontmatter ha verificato la presenza del delimitatore iniziale `---`, non
la validità di ogni campo YAML. Le date qui sopra appartengono al frontmatter; i nomi
file creati sono stabili e non contengono date o timestamp.

## Blocchi e debiti verificabili nello stato corrente

- **Progressioni**: l'audit di modulo è ancora `in-progress`; risultano aperte le story
  su mutazione `ha_diritto` nel rendering, filtro booleano, persistenza di `form_data`,
  conformità Filament Blueprint e caller cross-modulo. Il gate di chiusura modulo non è
  attestato da questa passata.
- **Rating**: `5.240` è in-progress e registra due errori PHPStan reali in
  `HasRatingsTrait.php`; non va dichiarato verde finché non si rilancia PHPStan con cache
  pulita e si chiude la story.
- **Tenant**: `7.1-7.2` è marcata blocked per divergenza tra una vecchia affermazione di
  diagnostiche e la verifica PHPStan documentata. Serve riconciliare la story e la prova
  attuale, senza ripristini distruttivi.
- **Sigma**: una story review registra blocchi funzionali e di sicurezza della console
  WebService (configurazione incoerente, credenziali tracciate da ruotare, import con
  truncate/INSERT senza transazione e test fallenti). Richiede decisioni e remediation
  prima di dichiarare pronto quel flusso.
- **Xot / quality gates**: il full-tree PHPStan risulta ancora aperto in sprint status;
  sono documentati problemi noti in tooling e storie di completamento. Gli esiti storici
  vanno riferiti ai rispettivi commit/snapshot, non assunti come stato HEAD.
- **Integrazione Git**: nello stato ereditato da questa sessione esistono divergenze tra
  repo locali e remote e residui di merge da trattare con la procedura safe. Nessun
  push, rebase o cleanup distruttivo è incluso in questo audit.
- **Docs**: `purpose.md` manca in Ptv e nei tre temi; `README.md` manca in Incentivi.
  Sono presenti Markdown senza frontmatter iniziale: vedi conteggi sopra e schede owner.
  Il corpus è ampio (da 103 a 3.670 file per owner); serve consolidare senza cancellare
  contenuti né rinumerare story.
- **ECC harness**: l'audit ECC precedente è 34/39; memoria persistente è 0/10 e
  integrazione GitHub 7/10. Bridge QMD, policy aggiornamenti dipendenze e CODEOWNERS
  sono tracciati in story Xot, non ancora comprovati come completati.

## Cosa manca per dichiarare completato il progetto

1. **Prodotto e requisiti**: inventario approvato dei flussi HR e valutazione; ogni
   requisito deve avere acceptance criteria, owner modulo/tema, priorità e test/prova.
2. **Correttezza funzionale**: chiudere i finding e le decisioni bloccanti (in
   particolare i punti citati sopra) e verificare casi limite, autorizzazioni e dati.
3. **Integrazione**: provare i flussi cross-module completi (Progressioni/Ptv/
   Performance/Rating/Indennità/Identity/Tenant), inclusi export, notifiche, job e
   configurazioni tenant, dove applicabili.
4. **Qualità**: rilanciare su HEAD i gate di modulo: Pest, PHPStan, Pint e gli altri
   controlli richiesti dal modulo; conservare comando, exit code, conteggi e ambiente.
   Non si riportano qui test eseguiti: questa passata è documentale.
5. **Sicurezza e dati**: chiudere le story security, verificare permessi/tenant, rotazione
   di eventuali segreti già committati e assenza di segreti attivi. Mai eseguire comandi
   DB distruttivi; nessuna migrazione è stata lanciata.
6. **Consegna**: definire runbook di deploy/rollback forward-only, configurazioni/secret
   necessari, queue/scheduler, backup e osservabilità; validare un rilascio reale prima
   di segnare il progetto pronto.
7. **Documentazione**: completare le schede owner, riparare frontmatter/naming/indici,
   aggiornare QMD e chiudere i riferimenti obsoleti. Restano da validare i contenuti
   architetturali nei 21 owner, non solo i conteggi.
8. **Governance Git**: riconciliare le divergenze dei repository con fetch e piano
   esplicito, preservando modifiche concorrenti; niente force-push o merge automatico
   rischioso.

## Limiti e tracciamento

- Questo è il primo censimento documentale; non ha eseguito Pest, PHPStan, browser/E2E,
  deployment o query al database.
- La story BMAD `docs-modules-themes-continuous-reorg` è il registro della bonifica
  documentale. La story `project-completion-readiness` è attualmente sotto lock da un
  altro writer; il suo aggiornamento e l'allineamento di `docs/sprint-status.yaml`
  restano da fare quando il lock viene rilasciato.
- Le schede per owner sono il dettaglio locale. Aggiornare lo stato solo dopo evidenza,
  mantenere i nomi `.md` senza date/timestamp e reindicizzare con `qmd update`.

## Story BMAD aperte per owner

Conteggi ricavati dallo stato frontmatter delle story locali al momento della scansione; le categorie sono eterogenee e vanno riconciliate con lo sprint status canonico.

| Owner | Story nel corpus | Non terminali o senza stato conclusivo |
|---|---:|---:|
| Modules/Activity | 39 | 33 |
| Modules/Incentivi | 21 | 10 |
| Modules/IndennitaCondizioniLavoro | 59 | 36 |
| Modules/IndennitaResponsabilita | 157 | 88 |
| Modules/Job | 32 | 15 |
| Modules/Lang | 37 | 23 |
| Modules/Media | 36 | 17 |
| Modules/Notify | 48 | 33 |
| Modules/Pdnd | 17 | 11 |
| Modules/Performance | 28 | 19 |
| Modules/Progressioni | 54 | 36 |
| Modules/Ptv | 132 | 50 |
| Modules/Rating | 149 | 89 |
| Modules/Sigma | 57 | 42 |
| Modules/Tenant | 28 | 19 |
| Modules/UI | 22 | 13 |
| Modules/User | 155 | 104 |
| Modules/Xot | 151 | 115 |
| Themes/One | 6 | 4 |
| Themes/Three | 2 | 1 |
| Themes/Zero | 10 | 1 |

Il numero di story aperte comprende anche `ready`, `review`, `backlog`, `draft` e frontmatter senza stato. Questi stati sono backlog o debito di governance, non necessariamente difetti runtime. Le story `in-progress`/`blocked` vanno controllate prima di assegnare lavoro per non collidere con altri writer.
