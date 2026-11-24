---
tags: [documentation]
qmd: "git push lfs incident"
issues: []
discussions: []
title: "Git push bloccato da oggetto Git LFS mancante"
type: incident
created: 2026-07-28
updated: 2026-07-28
---

# Git push bloccato da oggetto Git LFS mancante

## Sintomo

```
$ git push
remote: error: GH008: Your push referenced at least 16 unknown Git LFS objects:
remote:     6126375ccbb3811d335007914fb1b2f90bf1ab199054855f602ad3de3d1121a1
remote:     ...
remote: Try to push them with 'git lfs push --all'.
 ! [remote rejected] dev -> dev (pre-receive hook declined)
```

Il push su `provtv` (remote di tracking del branch `dev`) veniva rifiutato dal
pre-receive hook di GitHub per Git LFS, non da un errore di codice.

## Studio delle vecchie versioni (nessun checkout/reset/revert)

Per ciascuno dei 16 oggetti LFS "unknown", ho ricostruito la storia del path
corrispondente con `git log --all`, `git rev-list --objects`, `git cat-file -p`
e `git show HEAD:<path> | sha256sum`, senza mai spostare `HEAD` né toccare la
working tree con `checkout`/`reset`/`restore`.

**Causa radice**: in un momento imprecisato della storia, 16 file binari
(`resources/img/*.png|jpg`, `resources/svg/*.svg`, 1 file
`docs/screenshots/*.backup-copilot`) sono stati tracciati con Git LFS e
committati come *pointer file* (testo tipo `version https://git-lfs...\noid
sha256:...\nsize ...`), ma il contenuto binario reale non fu mai caricato con
`git lfs push` in quel momento. Il repository locale non aveva quindi in
`.git/lfs/objects/` il blob referenziato da quei pointer storici, e nemmeno il
remote lo aveva mai ricevuto — da qui il rifiuto.

## Diagnosi per singolo oggetto

Per 15/16 oggetti, il contenuto reale esiste tuttora in `HEAD` con lo **stesso
percorso** (i file furono in seguito ri-committati come blob binari normali,
non più come pointer LFS). Verifica: `git show HEAD:<path> | sha256sum` produce
esattamente l'OID richiesto da GitHub per ciascuno di questi 15 file — quindi
il contenuto non era perso, solo mai "registrato" nella cache locale di
Git LFS (`.git/lfs/objects/`) né caricato sul remote.

Il 16° oggetto (`docs/screenshots/event-detail-page.png.backup-copilot`,
oid `5e077f4fd10aa1bb7b4eeaa5d4673f7148ecc63ac66c4d1e14001088ee7753e1`,
size 121507) è diverso: l'unico blob mai esistito in tutta la storia per quel
path (`1e9e4c479f9e9778eb0dd5b3fe4e6ac0c7ffde6a`) è **esso stesso** il pointer
LFS di 131 byte — il contenuto binario reale non fu **mai** committato in
nessuna forma in questo repository. Verificato anche che non è presente né
nello store LFS di `provtv` né in quello di `laraxot` (query dirette alla
Git LFS Batch API, HTTP 404 "Object does not exist on the server" su
entrambi). È una perdita di dati storica, non recuperabile via studio della
storia: SHA-256 è una funzione crittografica one-way, non è possibile
costruire un file diverso che produca lo stesso hash.

## Fix applicato (solo in avanti, nessuna riscrittura di storia)

1. Per i 15 oggetti recuperabili: estratto il contenuto reale da
   `git show HEAD:<path>`, scritto manualmente in
   `.git/lfs/objects/<oid:0:2>/<oid:2:4>/<oid>` (stessa struttura a cui Git LFS
   si aspetta gli oggetti), poi `git lfs push --all provtv dev` → upload
   riuscito per tutti e 15 (verificato con `git lfs fsck` = OK e output
   `Uploading LFS objects: 94% (15/16)`).
2. Per il 16° oggetto irrecuperabile: impostato
   `git config lfs.allowincompletepush true` (permette al client di procedere
   anche con oggetti LFS mancanti). **Non è sufficiente**: il pre-receive hook
   di GitHub lato server continua a rifiutare l'intero push perché quel
   pointer fa parte della cronologia che verrebbe estesa.
3. Verificato che il remote `laraxot` (secondo remote configurato sullo stesso
   modulo) ha **già** l'intera cronologia in questione, commit incluso quello
   con il pointer rotto (`git fetch laraxot dev` → `laraxot/dev` combacia
   esattamente con `HEAD` locale). Questo conferma che i commit in sé sono
   validi e già stati accettati con successo altrove — il blocco è specifico
   del pre-receive hook di `provtv` in questo momento (probabilmente perché è
   il primo push che gli richiede di validare l'intera ancestry a partire dal
   punto in cui fu introdotto il pointer rotto).

## Stato attuale / cosa resta da decidere

- `git push` verso `laraxot` → **funziona** (già aggiornato).
- `git push` verso `provtv` (remote di default per il branch `dev`) →
  **bloccato**, unico oggetto irrisolvibile: il file di backup
  `event-detail-page.png.backup-copilot`. Non esiste una soluzione "in avanti"
  che non richieda una di queste due strade, entrambe fuori dal perimetro di
  questo intervento:
  - riscrivere quella specifica cronologia (proibito: "si va solo in avanti");
  - recuperare il contenuto binario reale da una fonte esterna al repository
    (nessuna trovata: né store LFS di `provtv` né di `laraxot`).
- Il file perso è un backup ridondante (`event-detail-page.png` — la versione
  "non backup" — esiste tuttora regolarmente in `docs/screenshots/`), quindi
  la perdita non ha impatto funzionale sul modulo.

**Raccomandazione**: valutare con l'owner del repo se pushare "solo" verso
`laraxot` (già sincronizzato) sia sufficiente, oppure se serva un intervento
manuale autorizzato (es. history rewrite mirato solo su quel commit, eseguito
consapevolmente dal proprietario del repository) per sbloccare anche `provtv`.

## Verifica qualità (post-fix)

Vedi `docs/quality-gates.md` per l'esito di PHPStan, PHPMD e
PHP Insights sull'intera cartella `laravel/Modules/Tenant`.
