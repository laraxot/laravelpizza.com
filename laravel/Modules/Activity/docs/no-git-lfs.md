---
title: "Git LFS vietato: linea guida e blocco canonico .gitattributes"
type: guideline
module: Activity
updated: 2026-11-06
qmd: "git lfs vietato gitattributes prototipo binari blob normali activity puntatori immagini"
status: draft
tags: [docs, activity]
---

# Git LFS non si usa in questo progetto

Vale per il repo root, per `bashscripts/` e per ogni modulo e tema. Questo modulo non fa
eccezione.

## La regola

I binari: immagini, font, PDF, archivi: si versionano come **blob git normali**.

Vietato:

- aggiungere `filter=lfs diff=lfs merge=lfs` in un qualunque `.gitattributes`;
- eseguire `git lfs install` o `git lfs track` dentro questo repo;
- committare come contenuto di un file il testo `version https://git-lfs.github.com/spec/v1`.

## Perche'

Non e' una preferenza di stile, e' il risultato di incidenti ripetuti.

- **Gli asset sono piccoli.** Circa 10 MB in tutto il progetto: LFS non porta nessun
  beneficio e aggiunge un punto di rottura.
- **I puntatori orfani.** LFS ha prodotto piu' volte file il cui contenuto committato era
  il testo del puntatore invece del binario. Il push viene respinto con
  `GH008: unknown Git LFS objects`, e a runtime immagini e SVG sono rotti.
- **Il workflow multi-org lo rende irrecuperabile.** Questo progetto pubblica su due
  organizzazioni (`laraxot` e `provtv`). Gli oggetti LFS non erano presenti su entrambe:
  un puntatore che punta a un oggetto che nessun remote ha e' un file perduto.

## Il blocco canonico

Il prototipo `bashscripts/templates/gitattributes.module` e lo script `sync-gitattributes-modules.sh`
non esistono piu' (cancellati il 2026-10-23, vedi la regola): non vanno ricreati. La fonte di verita'
e' il blocco in `bashscripts/ai/wiki/rules/no-git-lfs.md`. Il `.gitattributes` di questo modulo ne e'
una copia con l'intestazione e **nessuna regola locale**: la storia del file non mostra righe specifiche
del modulo. Si modifica a mano, tenendolo uguale a quello di AI e Cms, e si verifica con
`bashscripts/tools/check-no-git-lfs.sh`.

Sui binari si usa solo `binary !filter`. Non vanno aggiunti `!merge`, `!diff`, `!text`: `binary` e' la
macro `-diff -merge -text`, e `!merge` riporta il driver a "non specificato", quindi Git fa un merge
testuale e per un SVG (testo, senza byte NUL) scrive i marker di conflitto dentro il file. Con
`binary !filter` un conflitto su un SVG resta un conflitto binario e non scrive nulla.

```gitattributes
# Git LFS vietato: tutti i binari restano blob Git normali.
# Canon: bashscripts/ai/wiki/rules/no-git-lfs.md
#
# Sui binari usare solo `binary !filter`. Non aggiungere !merge, !diff o !text:
# !merge riattiva il merge testuale e Git scrive i marker di conflitto dentro gli SVG.

* text=auto
*.css linguist-vendored
*.scss linguist-vendored
*.js linguist-vendored
CHANGELOG.md export-ignore

# Binary files: binary disables text normalization; !filter blocks inherited LFS.
*.png binary !filter
*.jpg binary !filter
*.jpeg binary !filter
*.gif binary !filter
*.webp binary !filter
*.ico binary !filter
*.svg binary !filter
*.psd binary !filter
*.pdf binary !filter
*.zip binary !filter
*.woff binary !filter
*.woff2 binary !filter
*.ttf binary !filter
*.eot binary !filter
*.otf binary !filter
*.phar binary !filter
*.db binary !filter
*.sqlite binary !filter
```

### Perche' `binary !filter` e non solo `binary`

`binary` disattiva diff e normalizzazione di fine riga, ma **non** impedisce a un filtro
LFS di intervenire. `!filter` annulla per path qualunque `filter.lfs` ereditato.

Serve davvero: su questa macchina `filter.lfs.*` e' installato a livello **system**
(`git config --system`) e serve ad altri progetti: `base_predict_fila5` ha 38 file
legittimamente in LFS. Non si disinstalla il pacchetto. Cio' che tiene questo monorepo
fuori da LFS non e' l'assenza del filtro, e' il `!filter` del blocco canonico.

### Una sola `.gitattributes` per modulo

Solo la root del modulo puo' averne una. Una `.gitattributes` in una sottocartella
sovrascrive la policy per i path che copre, ed e' il modo in cui LFS e' rientrato dalla
finestra le altre volte. Se ne trova una, va rimossa.

## Verifica

```bash
bash bashscripts/tools/check-no-git-lfs.sh
```

Esce 0 se pulito, 1 con l'elenco. Controlla sei cose: righe `filter=lfs` attive nei
`.gitattributes` (i commenti che citano la stringa sono esclusi), marker di conflitto negli
stessi file, puntatori LFS nei file committati, hook LFS in `.git/hooks/`, sezione `[lfs]`
nel config locale e attributi effettivi dei binari (`git check-attr`: `filter` non
specificato, `merge` disattivato) in ogni repo annidato.

Due trappole che quel controllo evita e che a mano si sbagliano:

1. **`grep filter=lfs` puo' dare risultati anche quando tutto e' pulito**, perche' i
   commenti di un `.gitattributes` possono citare la stringa. Va cercata la riga *attiva*:
   `grep "^[^#]*filter=lfs"`.
2. **Invocare `git lfs` ricrea cio' che si sta verificando.** Un `git lfs ls-files` di
   controllo riscrive `lfs.repositoryformatversion` nel config locale. Se la sezione
   `[lfs]` ricompare dopo un check, l'ha creata il check.

## Se LFS e' rientrato

Ripulire i `.gitattributes` non basta: `git lfs install` lascia hook e configurazione
dentro `.git/`, che nessuna ricerca sui file versionati trova. Il monorepo ha un repo per
la root, uno per `laravel/`, uno per `bashscripts/` e uno per ogni modulo e tema: la
bonifica va ripetuta su ognuno.

```bash
for d in . laravel bashscripts laravel/Modules/*/ laravel/Themes/*/; do
  [ -e "$d/.git" ] || continue
  (cd "$d" && git lfs uninstall --local)
  (cd "$d" && git config --local --remove-section lfs 2>/dev/null)
done
```

`--local` e' la parola chiave: agisce sul singolo repository e non tocca l'installazione
di sistema.

## Se un file e' diventato un puntatore

In un conflitto fra un lato puntatore e un lato con contenuto reale, si tiene **sempre il
contenuto reale**. Se entrambi i lati sono puntatori, si recupera dalla cache locale:

```bash
oid=$(sed -n 's|^oid sha256:||p' path/al/file.svg | head -1)
cp ".git/lfs/objects/${oid:0:2}/${oid:2:2}/$oid" path/al/file.svg
```

Il caso peggiore non e' il puntatore ma il **blob ibrido**: le tre righe del puntatore e,
subito sotto, il payload reale, nato da un merge risolto concatenando invece di scegliere.
`git lfs ls-files` non lo elenca perche' non e' un puntatore valido, il file si apre e
sembra pieno, ma nessun parser lo accetta. Si riconosce dalla dimensione: pesa esattamente
il payload piu' l'intestazione.

## Non tutto cio' che sembra rotto viene da LFS

Verificato su questo progetto il 1 settembre 2026: **1355 fra immagini e PDF esaminati per
magic number, zero puntatori**. Le 43 immagini con header non valido avevano due cause
diverse, nessuna delle due LFS:

- **39** erano placeholder da 3 byte con dentro la stringa `png`, artefatti di un test
  finiti committati;
- **4** erano stub markdown a cui era rimasta l'estensione `.png` / `.jpg`, prodotti da una
  de-duplicazione che aveva sostituito il binario con un rimando a un percorso canonico
  mai esistito. Recuperate dalla storia del modulo.

Prima di dare la colpa a LFS conviene guardare i primi byte del file: un puntatore comincia
con `version https://git-lfs.github.com/spec/v1`, e qualunque altra cosa e' un altro
problema.

## Canone

`bashscripts/ai/wiki/rules/no-git-lfs.md`: regola completa, storico degli incidenti e
procedura per gli oggetti mancanti in push.
