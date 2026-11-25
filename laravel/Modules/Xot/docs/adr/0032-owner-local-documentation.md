---title: "Le decisioni vivono nella documentazione dell'owner"
type: decision
status: superseded by 0005-owner-local-documentation.md
created: 2026-11-23
updated: 2026-11-24
decision-makers: [team Laraxot]
issues: []
qmd: "owner local decisioni vivono nella dellowner"
---

Superseded da [0005-owner-local-documentation.md](0005-owner-local-documentation.md).


# Le decisioni vivono nella documentazione dell'owner

## Contesto

Moduli e temi sono pacchetti autonomi e possono essere sincronizzati
indipendentemente. Un ADR o un manuale scritto in una cartella globale perde il
rapporto con il codice che deve rispettarlo e può essere sovrascritto da un
mirror.

## Driver della decisione

- ownership chiara;
- documentazione recuperabile insieme al pacchetto;
- aggiornamento coordinato con codice, test e contratti;
- niente duplicazione fra root, moduli e temi.

## Alternative scartate

- conservare le decisioni soltanto in `bmad-output/`;
- mettere un unico manuale globale al posto dei manuali owner;
- copiare lo stesso ADR in ogni modulo senza adattarlo al codice reale.

## Decisione

Ogni modulo e tema mantiene `docs/adr/`, `docs/contracts/`, `docs/stories/`
e i manuali operativi pertinenti. Un ADR descrive una decisione del proprio
owner; le regole condivise vengono referenziate da Xot e applicate localmente
solo quando sono dimostrate dal codice e dai test.

## Conseguenze

- Buono: una modifica al pacchetto porta con sé il perché e il contratto.
- Buono: i link owner riducono la documentazione generica e obsoleta.
- Cattivo: una decisione trasversale richiede aggiornare più owner, senza duplicarne il testo integralmente.

## Conferma

- il test documentale verifica cartelle e ADR sostanziali per ogni pacchetto;
- i nuovi documenti usano nomi senza date o timestamp;
- il lavoro BMAD resta nella story del modulo/tema owner.

## Verifica

- `cd laravel && vendor/bin/pest Modules/Xot/tests/Unit/Docs/PackagesHaveContractsAndAdrTest.php` fallisce se un modulo
  o tema non ha `docs/adr/` e `docs/contracts/` con README, se un ADR ha data o numero nel nome, se manca una sezione, o
  se un README non elenca un file della propria cartella; verifica anche che ogni pacchetto abbia almeno un ADR
  sostanziale (`Modules/Xot/tests/Unit/Docs/PackagesHaveContractsAndAdrTest.php`).
- Il fatto che una decisione stia nel pacchetto giusto, e non in una cartella globale, lo controlla la revisione.
