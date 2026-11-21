---
title: "Bonifica .gitattributes .gitignore composer.json senza Git LFS"
module: Xot
bmad: true
status: done
owner: Modules/Xot (policy git meta di moduli e temi)
qmd: "gitattributes gitignore composer collisioni no-git-lfs binary filter sync prototipo"
related:
  - ./gitattributes-svg-merge-markers.story.md
  - ../../../../../bashscripts/ai/wiki/rules/no-git-lfs.md
  - ../../../../../bashscripts/templates/gitattributes.module
---

# Bonifica .gitattributes / .gitignore / composer.json (no LFS)

- Fase BMAD: Quick Flow + ECC verification-loop (check-attr + check-no-git-lfs)
- Branch: `dev`
- Richiesta utente: sistemare e migliorare tutti i `.gitattributes`, `.gitignore` e
  `composer.json` con collisioni git; progetto **senza Git LFS**.

## Scopo / perche'

I meta-file git sono la prima superficie che un merge multi-org sporca. Marker in
`.gitignore`/`composer.json` rompono tooling; su `.gitattributes` un `!merge` sui binari
fa scrivere `<<<<<<<` dentro SVG. LFS e' vietato (puntatori orfani cross-org).

## Causa radice (verificata)

1. Prototipo `bashscripts/templates/gitattributes.module` aveva **righe binary duplicate**
   (`*.png`/`*.svg`/… due volte): sync propagava il drift a 11 moduli/temi.
2. Wiki `no-git-lfs.md` contraddiceva se stessa (prototipo "cancellato" vs path attivi).
3. Marker in `Activity/.gitignore`, `Notify/.gitignore`, `Notify/composer.json`: gia'
   ripuliti nel working tree prima di questo passaggio (0 marker WT/HEAD nested).

## Lavoro svolto

1. Lock: `gitattributes-gitignore-composer`.
2. Prototipo riscritto: blocco unico `binary !filter`, anti-`!merge`/`!diff`/`!text`,
   include `*.mp4`, **zero duplicati**.
3. Sync: `bash bashscripts/templates/sync-gitattributes-modules.sh` → 22 target
   (18 moduli + 3 temi + coolsam/panel-modules).
4. Wiki second brain: paragrafo "prototipo cancellato" sostituito con stato 2026-11-16.
5. Verifica:
   - audit Python: 0 LFS / 0 BAD_BINARY / 0 DUPS; tutti i target == prototipo
   - `git check-attr` su logo SVG: `filter=unspecified`, `merge/diff/text=unset`
   - `bash bashscripts/tools/check-no-git-lfs.sh` → exit 0
   - tutti i `composer.json` moduli/temi: JSON parse OK, 0 marker
   - tutti i `.gitignore` moduli/temi: 0 marker

## Fuori scope / skipped

- Commit nei repo nested (utente non ha chiesto commit).
- Riscrivere le N copie `docs/no-git-lfs.md` per modulo (SSoT = wiki + prototipo).
- Cartella `.git/lfs` residua in alcuni nested: non e' tracking attivo; check script pulito.

## Acceptance

- [x] Nessun `filter=lfs` / `!merge`/`!diff`/`!text` su righe binary
- [x] Prototipo senza duplicati + sync allineato
- [x] Marker assenti in `.gitattributes` / `.gitignore` / `composer.json`
- [x] `check-no-git-lfs.sh` verde
- [x] Story + wiki aggiornati


## Diario User/Zero

### Dedup .gitignore User + Zero + User/docs (2026-11-16 16:06 UTC)

Scope disgiunto `gitignore-user-zero` (lock 40):

| File | Righe | Dup occurrences (sum v se v>1) | Extra oltre 1ª | Dopo |
|------|-------|--------------------------------|----------------|------|
| `laravel/Modules/User/.gitignore` | 512→327 | 222→0 | 137→0 | 157 regole uniche |
| `laravel/Themes/Zero/.gitignore` | 230→205 | 50→0 | 25→0 | 125 regole uniche |
| `laravel/Modules/User/docs/.gitignore` | 10→9 | 2→0 (`---` spurio) | 1→0 | 8 regole uniche |

Metodo: skip regola già vista (non-vuota, non `#`); commenti/blank conservati; max 2 blank consecutivi. Verifica `Counter` = 0 dups. Nessun tocco a `.gitattributes` / `composer.json` / LFS.

## Diario 2026-11-16 (seconda passata coordinatore)

Verifica codice (non solo story precedente):

- Marker `<<<<<<<` su `.gitattributes`/`.gitignore`/`composer.json`: **0**
- `check-no-git-lfs.sh`: verde; `git check-attr` su logo SVG: filter unspecified, merge/diff/text unset
- Sync prototipo: 22 `.gitattributes` moduli/temi allineati
- Fix: `public_html/noconsole/.gitattributes` — rimosse righe binary duplicate (merge residue)
- Fix: `bashscripts/.gitattributes` — aggiunto `* text=auto` + `*.mp4 binary !filter`
- Fix: rimosso `laravel/Modules/User/resources/views/composer.json` (copia spurio Theme One; SSoT = `Themes/One/composer.json`)
- `public_html/noconsole/composer.json` = `{}` placeholder legittimo (documentato)
- Swarm parallelo: dedupe `.gitignore` User/Zero + root/Job/Media/… in corso

Policy: **no Git LFS**; binari solo `binary !filter`.


### Dedup .gitignore root-job-media + scope (2026-11-16)

Scope disgiunto `gitignore-root-job-media` (lock 40):

| File | Righe prima→dopo | Rule extra (v-1, non-comment) | Dopo |
|------|------------------|-------------------------------|------|
| `.gitignore` (root) | 668→628 | 40→0 | 403 regole uniche |
| `laravel/.gitignore` | 51→50 | 1→0 (`/tools/phpinsights/vendor`) | 41 regole uniche |
| `laravel/Modules/Job/.gitignore` | 258→253 | 5→0 | 157 regole uniche |
| `laravel/Modules/Media/.gitignore` | 227→225 | 2→0 | 148 regole uniche |
| `laravel/Modules/Tenant/.gitignore` | 181→179 | 2→0 | 103 regole uniche |
| `laravel/Modules/Rating/.gitignore` | 94→93 | 1→0 (`*.lock`) | 78 regole uniche |
| `laravel/Modules/Xot/.gitignore` | 201→200 | 1→0 (`tests/coverage-xot.xml`) | 170 regole uniche |
| `bashscripts/.gitignore` | 208→203 | 5→0 | 170 regole uniche |
| `laravel/Modules/Lang/docs/.gitignore` | 55→43 | 12→0 | 22 regole uniche |
| `Job/docs/.gitignore` | invariato | `---` = frontmatter YAML (non spurio) | 0 rule dups |
| `Xot/docs/.gitignore` | invariato | `---` = frontmatter YAML (non spurio) | 0 rule dups |

Metodo: prima occorrenza vince sulle **regole** (righe non-vuote non-`#`); commenti conservati anche se ripetuti; max 2 blank consecutivi. Verifica `Counter` rule_extra = 0 su tutti i target. Nessun tocco a `.gitattributes` / `composer.json` / LFS. Unlock `gitignore-root-job-media`.
