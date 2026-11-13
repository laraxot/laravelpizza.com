<<<<<<< .merge_file_XlClu8
# Activity — cosa migliorare (visione, non lamento)
=======
---
title: "Activity: cosa migliorare (visione, non lamento)"
type: note
status: draft
updated: 2026-10-07
tags: [docs, activity]
qmd: "activity   cosa migliorare (visione, non lamento) activity"
---
# Activity: cosa migliorare (visione, non lamento)
>>>>>>> .merge_file_yB1KvA

I numeri misurati (PHPStan, PHPMD, PHPInsights, coverage, casi di test) sono
in [`docs/cosa-migliorare.md`](cosa-migliorare.md), rilevati il 2026-09-01
da un altro agente dopo il ripristino di `vendor/`. Questo documento non li
ripete: li legge, e ci aggiunge quello che un grep sull'anagrafica del
modulo (composer.json, struttura `docs/`) fa emergere e che una tabella di
gate non cattura.

## Il vero bug non è nel codice, è nella cartella docs/

<<<<<<< .merge_file_XlClu8
`app/` è pulito: zero `TODO`, zero `FIXME`, zero `dddx(`/`dd(` residui —
=======
`app/` è pulito: zero `TODO`, zero `FIXME`, zero `dddx(`/`dd(` residui -
>>>>>>> .merge_file_yB1KvA
coerente col `TODO/FIXME/HACK: 0` già misurato in `cosa-migliorare.md`. Chi
ha scritto la logica di audit-trail e CQRS event sourcing di questo modulo
l'ha scritta bene e l'ha lasciata pulita (PHPMD: solo 2 rilievi su `app/`,
il più basso dei tre moduli che ho ispezionato oggi). Il problema è che
nessuno ha mai fatto la stessa cosa con `docs/`, che oggi conta **705 file
`.md`** per un modulo che fa, in sostanza, due cose: loggare attività e
fare event sourcing.

705 file per un modulo. Non è documentazione, è sedimento geologico. Ogni
strato racconta una sessione diversa che non ha letto lo strato sotto:

- 6 varianti di `phpstan-fixes*.md`, altre 6 di `phpstan-analysis*.md`
- 4 varianti di `business-logic-analysis*.md` (compreso uno SCREAMING_CASE)
- `roadmap.md`, `roadmap-.md`, `roadmap-2025.md`, `roadmap-and-issues.md`,
<<<<<<< .merge_file_XlClu8
  `roadmap-archive-1.md`, `roadmap-vision.md` — sei roadmap per un modulo,
  nessuna delle quali probabilmente letta prima di scriverne una nuova
- `README.md`, `readme.md`, `README.md.update`, `readme.md.update`,
  `readme_update.md`, `readme-update.md` — sei README, contando le
  differenze di case e underscore come se fossero contenuto
- `test02.md`, `test03.md`, `test04.md`, `test2222.md`, `test444.md` — file
  di prova mai ripuliti, ancora versionati
- 13 coppie di file duplicati per sola differenza di maiuscole/minuscole
  solo al primo livello di `docs/` (`00-index.md` / `00-INDEX.md` /
  `00-index-1.md` è un trio, non una coppia)
=======
  `roadmap-archive-1.md`, `roadmap-vision.md`: sei roadmap per un modulo,
  nessuna delle quali probabilmente letta prima di scriverne una nuova
- `README.md`, `readme.md`, `README.md.update`, `readme.md.update`,
  `readme_update.md`, `readme-update.md`: sei README, contando le
  differenze di case e underscore come se fossero contenuto
- `test02.md`, `test03.md`, `test04.md`, `test2222.md`, `test444.md`: file
  di prova mai ripuliti, ancora versionati
- 13 coppie di file duplicati per sola differenza di maiuscole/minuscole
  solo al primo livello di `docs/` (`00-index.md` / `00-INDEX.md` /
  `00-index-documentation.md` è un trio, non una coppia)
>>>>>>> .merge_file_yB1KvA

Questo non è un problema estetico. È un debito di fiducia: se il second
brain (qmd/graphify) indicizza 705 varianti quasi-identiche, ogni query
futura su "Activity" restituisce rumore invece di segnale, e il prossimo
<<<<<<< .merge_file_XlClu8
agente (io compreso, tra un'ora) rischia di leggere `phpstan-fixes-1.md`
invece di `phpstan-fixes.md` e agire su uno stato vecchio credendolo
attuale — esattamente il tipo di errore che [[feedback-verify-code-not-docs]]
esiste per prevenire.

**Cosa farei**: non una cancellazione di massa alla cieca (vedi
[[feedback-verify-before-deleting-a-copy]] — il 28% dei "duplicati" in un
audit passato esisteva solo lì). Un passaggio a coppie: per ogni cluster
case-insensitive o near-name, `diff` reale, tenere il contenuto più
recente/completo per `git log -S`, cancellare il resto con un commit che
dichiara esplicitamente cosa è sparito (mai "cleanup" generico — vedi
=======
agente (io compreso, tra un'ora) rischia di leggere `phpstan-fixes-correzioni-modulo-activity.md`
invece di `phpstan-fixes.md` e agire su uno stato vecchio credendolo
attuale: esattamente il tipo di errore che [[feedback-verify-code-not-docs]]
esiste per prevenire.

**Cosa farei**: non una cancellazione di massa alla cieca (vedi
[[feedback-verify-before-deleting-a-copy]]: il 28% dei "duplicati" in un
audit passato esisteva solo lì). Un passaggio a coppie: per ogni cluster
case-insensitive o near-name, `diff` reale, tenere il contenuto più
recente/completo per `git log -S`, cancellare il resto con un commit che
dichiara esplicitamente cosa è sparito (mai "cleanup" generico: vedi
>>>>>>> .merge_file_yB1KvA
[[feedback-commit-message-not-proof-of-scope]]). Target realistico: da 705
a qualche decina di file con un `index.md` vero in testa.

## composer.json: la parte tecnica è quasi pronta, manca un pezzo

<<<<<<< .merge_file_XlClu8
Il file è ordinato — `name`, `description`, `keywords` (nove, specifici:
=======
Il file è ordinato: `name`, `description`, `keywords` (nove, specifici:
>>>>>>> .merge_file_yB1KvA
`event-sourcing`, `cqrs`, `audit-trail`, non genericume), `extra.laravel`
con i due service provider giusti, script `analyse`/`test`/`lint` già
cablati su phpstan/pest/pint. Chi l'ha scritto sapeva cosa stava facendo.

Due cose saltano all'occhio:

<<<<<<< .merge_file_XlClu8
1. `"require-dev": {}` — vuoto. Gli script `composer.json` chiamano
=======
1. `"require-dev": {}`: vuoto. Gli script `composer.json` chiamano
>>>>>>> .merge_file_yB1KvA
   `vendor/bin/phpstan`, `vendor/bin/pest`, `vendor/bin/pint`, ma nessuno di
   questi pacchetti è dichiarato come dipendenza del modulo. Funziona solo
   perché il monorepo li fornisce a livello root. Se questo modulo dovesse
   mai essere installato standalone (è pubblicato su
   `github.com/laraxot/module_activity_fila5`, quindi in teoria sì), `composer
   install` seguito da `composer run analyse` fallisce con "command not
   found". Il fix è meccanico: allineare `require-dev` a quello di
   `Xot/composer.json` (larastan, pest, pest-plugin-laravel, pestphp
   type-coverage, laravel/pint).

<<<<<<< .merge_file_XlClu8
2. La chiave `"repositories_comment"` invece di `"repositories"` — qualcuno
=======
2. La chiave `"repositories_comment"` invece di `"repositories"`: qualcuno
>>>>>>> .merge_file_yB1KvA
   ha "disattivato" le path repositories verso `../Xot`, `../Tenant`,
   `../UI` rinominando la chiave così che Composer la ignori. Funziona (i
   `require` di questo modulo non citano quei pacchetti, quindi non
   servono), ma è un trucco silenzioso: chi legge il file crede che quelle
   repository esistano ancora. O si cancella la chiave del tutto, o si
   documenta perché è lì (compatibilità futura?).

## Una nota di visione, visto che me l'hai chiesta

Questo modulo ha già l'architettura giusta (event sourcing + audit log
separati, CQRS dichiarato nel `description`) e il codice applicativo per
dimostrarlo pulito. Il divario non è tecnico, è entropico: 705 file di
documentazione contro zero righe di debito nel codice è il segnale più
onesto che l'unica cosa fuori controllo qui è quanto testo produciamo
*parlando* del modulo invece di lasciarlo parlare da solo. Il modulo più
maturo del progetto non è quello con più `docs/`, è quello con l'`index.md`
più corto che resta vero per più tempo.
