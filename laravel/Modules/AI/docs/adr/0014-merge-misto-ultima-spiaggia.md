---
status: accepted
date: 2026-11-24
decision-makers: project-owner
qmd: "merge misto unione take both ultima spiaggia conflitti git risoluzione intent-first"
---

# La risoluzione "mista" dei conflitti Git è l'ultima spiaggia, non la strategia

## Context and Problem Statement

I merge tra `dev` e `laraxot/dev` (e i merge-file automatici che li precedono) lasciano nel codice marker `<<<<<<<`, `=======`, `>>>>>>>` e varianti `.merge_file_*`. Esistono due modi di liberarli:

1. **Meccanico / misto**: pick del lato non vuoto, unione delle chiavi, "take both", superset, timestamp più recente. Deterministico, veloce, ripetibile.
2. **Intent-first**: leggere cosa il codice *doveva fare*, controllare import, usi e chiamanti, scegliere (o fondere) la variante che preserva il comportamento corretto.

La domanda decisionale: quando è lecito usare la strategia meccanica?

## Decision Drivers

- Un conflitto non è un problema di testo ma di *significato*: le due varianti spesso implementano la stessa funzione in modo diverso, e la fusione cieca produce duplicati, import morti o regressioni silenziose (es. `verify.resent` stringa vs array: un array renderizza "Array" nella vista).
- Il repo ha PHPStan level 10 e Pest come gate: una risoluzione sbagliata non fallisce subito, ma emerge come errore di tipo o test rosso a distanza.
- La strategia deterministica documentata in [git-conflict-resolution](../git-conflict-resolution.md) resta utile — ma solo come regressione/archivio, non come regola operativa.
- I marker sono stati trovati committati in massa (centinaia di file `.php`, `.blade.php`, `.md`): la velocità conta, ma non a scapito di correttezza.

## Considered Options

- **A. Semantica intent-first sempre**: ogni blocco si risolve capendo scopo, usi e tipi. Costoso su centinaia di file, ma corretto.
- **B. Mista ovunque**: regole deterministiche su tutto. Veloce, ma genera unioni semantiche rotte (chiavi duplicate, entrambi i rami di un if/else, docblock con tag contraddittori).
- **C. Ibrida a scala mobile**: intent-first per codice eseguibile (`.php`, `.blade.php`, `.js`, `.ts`); meccanico solo per documentazione pura dove il rischio è nullo o bassissimo.

## Decision Outcome

Scelta: **C**, perché il codice è il punto dove un merge sbagliato costa di più, mentre le `.md` sono il caso in cui la regola deterministica è quasi sempre innocua — a condizione che il file non sia a sua volta un contratto operativo.

### Regole operative

1. **Codice eseguibile** (`.php`, `.blade.php`, `.js`, `.ts`, `.vue`, `.json` di configurazione): si risolve SEMPRE intent-first. Obbligatorio verificare: import usati davvero, firme chiamate altrove, tipo di ritorno atteso dai chiamanti, convenzioni del modulo (XotBase, QueueableAction, belongsToManyX, `@see` docs). Unione/"take both" è ammessa solo quando i due lati aggiungono frammenti complementari e non sovrapposti (es. due docblock tag diversi).
2. **Documentazione e markdown**: la strategia deterministica (lato non vuoto → superset → metadata più recente → HEAD come spareggio) è ammessa, MA resta ultima spiaggia: se il file è un indice, un contratto o una pagina referenziata da `@see`, si preferisce la variante più completa e coerente col contenuto reale.
3. **Mai** risolvere un conflesso nel codice con "unisci entrambi" quando i due lati sono varianti della stessa riga/logica (scelta binaria): lì si decide quale comportamento è quello giusto.
4. Ogni risoluzione deve lasciare `php -l` pulito sui PHP e nessun marker residuo; PHPStan e Pest sono la conferma.

### Consequences

- Buono, perché: niente più "Array" a video, niente import morti, niente logica duplicata; le decisioni di merge diventano tracciabili e revisionabili.
- Cattivo, perché: la risoluzione intent-first richiede più tempo e più contesto per file; su migliaia di `.md` residui resta il compromesso della regola deterministica.

### Confirmation

- `grep -rln '^<<<<<<< ' Modules Themes` ritorna zero su file eseguibili dopo ogni ondata di risoluzione.
- `php -l` pulito su ogni `.php` toccato; `./vendor/bin/phpstan analyse Modules/<Modulo>` e Pest del modulo verde.
- Le `.md` risolte deterministicamente non devono contenere istruzioni operative contraddittorie: spot-check manuale sulle pagine linkate da `@see`.

<!-- Collegare la story BMAD owner-local del modulo Xot quando la ondata di risoluzione è completata; lock prima dell'edit; qmd update dopo. -->
