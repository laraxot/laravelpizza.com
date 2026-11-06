---
title: "Valutare e documentare la completezza del progetto PTVX"
type: story
module: Xot
epic: quality
status: in-progress
created: 2026-10-28
updated: 2026-10-28
tags: [project-readiness, modules, themes, bmad, documentation]
related:
  - ./project-quality-audit.story.md
  - ./5.249-bmad-docs-fleet-completion.story.md
qmd: "PTVX project completion readiness moduli temi sprint backlog completion criteria"
---

# Completezza del progetto PTVX

## Obiettivo

Stabilire cosa serve per dichiarare completato il progetto, basandosi su requisiti
approvati, stato reale di moduli e temi, verifiche tecniche e storie BMAD esistenti.
Documentare i residui nella cartella `docs/` del rispettivo owner. Non inventare uno
scope di rilascio e non duplicare storie già tracciate.

## Criteri di accettazione

- [ ] Verificare se esiste una definizione approvata di scope, requisiti e Definition
  of Done; rendere esplicite le decisioni mancanti.
- [ ] Inventariare i 18 moduli e i 3 temi reali e collegare per owner le storie aperte,
  i gate non verificati e i blocchi.
- [ ] Ogni modulo e tema ha in `docs/` un backlog di completamento specifico,
  verificabile e con frontmatter YAML valido, `qmd` e filename stabile senza date.
- [ ] Ogni owner con lavoro non già tracciato ha una story BMAD locale con AC, scope,
  task, verifiche e riferimenti; riusare le story esistenti quando coprono già il lavoro.
- [ ] Le affermazioni derivano da codice, test, documenti e stato Git attuali; memorie
  storiche e report di completamento non sono trattati come prova da soli.
- [ ] Identificare e correggere le incoerenze di `docs/sprint-status.yaml` prima di
  usarlo come inventario autorevole.
- [ ] Registrare in questa story conteggi finali, blocchi reali e verifica QMD.

## Ambito e vincoli

- Owner attuali: `laravel/Modules/*` e `laravel/Themes/*`; non creare documenti
  SSoT di completamento in root `docs/`.
- Nessun test eseguito su `10.100.200.15`; non eseguire migrazioni distruttive.
- Gli stati `backlog` possono rappresentare funzionalità future non incluse nel
  rilascio: non equivalgono automaticamente a un blocker di consegna.
- Nuove storie e documenti seguono kebab-case stabile, frontmatter YAML valido e
  chiave `qmd`; le date restano solo nei metadati, mai nei nomi file.
- Prima di modificare un file acquisire il lock sul path preciso. Non sovrascrivere
  il lock attivo di `docs/sprint-status.yaml`; riportare il conflitto e proseguire
  sugli owner indipendenti.

## Baseline iniziale

La ricognizione statica rileva 18 moduli, 3 temi, `completion-backlog.md` in 10
moduli, assente in 8 moduli e in tutti i 3 temi. Una scansione testuale trova 455
voci di stato nel file sprint: 237 `done`, 96 `backlog`, 53 `ready-for-dev`, 28
`in-progress`, 21 `review`, 15 `analysis-and-design`, 5 `blocked`. Questi numeri
sono provvisori: PyYAML rifiuta il file perché il blocco `development_status` ha
indentazione incoerente; il file è inoltre locked da un task concorrente.

La memoria storica `product-documentation.md` contiene owner non presenti nel
checkout (ad esempio Predict e AI); per questo audit la lista filesystem corrente
ha precedenza. Il documento `Modules/UI/docs/completion-backlog.md` esiste già ma
non vale come prova dello stato degli altri owner.

La stessa scansione per owner mostra i maggiori accumuli provvisori in User (75
stati aperti, soprattutto backlog), Xot (37), IndennitaResponsabilita (35), Rating
(24), Progressioni (10) e Ptv (8). I tre temi non hanno voci riconoscibili nel ledger
sprint. Gli altri owner hanno da zero a tre voci aperte, ma l'assenza di voci non
dimostra completezza: manca il ledger valido e una Definition of Done approvata.

## Piano

1. Definire criteri di prontezza e fonti di verità, distinguendo rilascio e backlog
   futuro.
2. Suddividere moduli e temi in gruppi disgiunti; ogni owner documenta il proprio
   stato e crea una story locale solo per lavoro scoperto senza story esistente.
3. Ricontrollare i riferimenti incrociati, la qualità dei Markdown e l'allineamento
   con gli stati BMAD quando il lock dello sprint è libero.
4. Aggiornare QMD e chiudere con un verdetto motivato e l'elenco dei blocker.

## Claim e handoff

Questa story coordina l'audit. Le assegnazioni e gli esiti dei gruppi verranno
registrati qui; ciascun worker possiede solo le cartelle docs degli owner assegnati.

Assegnazioni iniziali, con file disgiunti:

- Worker A: Activity, Incentivi, IndennitaCondizioniLavoro,
  IndennitaResponsabilita, Job.
- Worker B: Lang, Media, Notify, Pdnd, Performance, Progressioni.
- Worker C: Ptv, Rating, Sigma, Tenant, UI, User.
- Coordinatore: Xot, consolidamento, controllo del ledger sprint e revisione finale.
- Worker temi: One, Three, Zero.

Il lock root dello sprint è già occupato dalla story collisioni Bashscripts; finché
resta attivo, nessun worker lo modifica. Il gruppo Xot è completato dal coordinatore
dopo che un worker libera uno slot.
