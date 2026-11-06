---
title: "Second brain: pilota di deduplica della wiki su rules/filament"
type: story
status: ready-for-dev
priority: P2
created: 2026-10-20
updated: 2026-10-20
module: Xot
epic: ../bmad/epic-code-quality-ratchet.md
depends_on: [docs-organization-xot]
related: [../../../../../bashscripts/docs/prompts/42-delete-obsolete-files-safely.md, ../../../../../bashscripts/docs/prompts/51-conflitti-git-current-change.md, ../../../../../bashscripts/ai/wiki/memories/docs-organizer-non-destructive-pilot.md]
tags: [second-brain, wiki, dedup, link-rotti, trigger-map, qmd, docs-organizer, ratchet-w5]
qmd: "second brain wiki deduplica rules filament 11-forms migrated-from-agents trigger map docs/wiki/rules mirror assente link rotti CLAUDE.md marker conflitto docs-organizer dups links"
---

# Second brain: pilota di deduplica della wiki su rules/filament

Fase BMAD: Plan (scheda di lavoro per domani). Scritta in sola lettura: nessun file della wiki e' stato toccato, nessun `qmd update` lanciato. Cifre del 2026-10-20 13:49-14:05 UTC; durante la misura 4 file della wiki erano in modifica da un'altra sessione (`git -C bashscripts status --short ai/wiki`).

## Richiesta
Ordine permanente dell'utente: migliorare la qualita' con BMAD + second brain + filament blueprint, andando alla sorgente e capendo lo scopo. Il second brain e' la memoria che gli agenti caricano on-demand: se contiene copie divergenti o rimandi morti, ogni sessione parte da regole sbagliate.

## Scopo
`bashscripts/ai/wiki/` e' la fonte unica delle regole (CLAUDE.md root: "Rules/skills live in wiki. Load on-demand via QMD"). Dovrebbe rispondere "quale regola vale?" con un solo file. Oggi lo stesso testo vive in piu' cartelle, i rimandi puntano a un mirror che non esiste, e un file di contesto (`bashscripts/ai/CLAUDE.md`) porta marker di conflitto. Cancellare a occhio le copie spezzerebbe i rimandi: il tool di riordino e' non distruttivo apposta (memoria `docs-organizer-non-destructive-pilot.md`). Questa story fa UN pilota piccolo e misurabile, non la bonifica.

## Stato misurato
- Dimensione: 13866 file (10567 `.md`, 3299 `.mdc`), 58.496.494 byte. `find bashscripts/ai/wiki -type f \( -name '*.md' -o -name '*.mdc' \) | wc -l`.
- Contenuto identico (sha256): 2208 gruppi, 5431 file, 3223 copie in eccesso, 15,8 MB. Dentro `rules/` (6117 file): 1677 gruppi, 2018 copie in eccesso, 3,9 MB. Un hash sul file intero sottostima: il tool confronta il corpo senza frontmatter.
- `rules/11-forms`: 1451 file, tutti con basename gia' in altre cartelle di `rules/`, 718 con copia identica. `rules/filament`: 159 file (ricorsivo), 139 con gemello identico fuori dalla cartella. `rules/misc`: 625, 621 con gemello. `rules/migrated-from-agents`: 999 file, 407 con basename altrove, solo 1 identico: DIVERGONO, non si accorpano a occhio.
- Tool in dry-run su `rules/`: `python3 -I bashscripts/tools/docs/docs-organizer.py dups bashscripts/ai/wiki/rules` produce 1440 `superseded-dry` e 445 `skip-no-frontmatter` (il tool vuole il frontmatter); su `rules/filament` 47 e 38. Il canonico lo sceglie per nome, non per riferimenti.
- Link relativi `.md/.mdc` rotti: 12172 su 17452 in 4684 file (`skills` 5457, `rules` 4996, `concepts` 873). Frontmatter assente: 5789 file. `links ... rules/filament --tail --report` (49 file): 66 rotti (26 `MOVED_MANY`, 38 `OUTSIDE_OWNER`, 2 `FIXABLE_BASIC`).
- Il mirror `docs/wiki/rules/` NON esiste (`ls docs/wiki/rules`), `docs/wiki/.gitignore:20` lo ignora, ma lo citano `CLAUDE.md` (2 volte), `.claude/CLAUDE.md` (2) e `bashscripts/ai/.agents/rules/*.md` (9). `bashscripts/ai/wiki/rules/00-TRIGGER_MAP.md` (812 righe) cita 283 percorsi del repo distinti: 265 non esistono dalla radice, 217 esisterebbero sostituendo `docs/wiki/` con `bashscripts/ai/wiki/`, 48 non esistono comunque (es. `bashscripts/ai/.agents/bmad-skills/*/CLAUDE.md`). Il Trigger Map dice "799 file e 362 basename duplicati" per `docs/wiki/rules/`: oggi `rules/` ha 6117 file.
- `bashscripts/ai/CLAUDE.md`: tracciato nel repo `bashscripts` (ignorato dal root, `.gitignore:111`), 3 blocchi di conflitto: `rg -cP '^(<{7}|>{7}) ' bashscripts/ai/CLAUDE.md` stampa 6 (righe 1, 25, 506, 510, 892, 895), piu' 3 righe `=======`. Nessun file della wiki contiene marker (`rg -lP '^(<{7}|>{7}) ' bashscripts/ai/wiki --no-ignore` vuoto).

## Lavoro
1. **Decidere il prefisso canonico** (`bashscripts/ai/wiki/` o `docs/wiki/`) prima di toccare le copie: serve a sapere come sono scritti i rimandi da riscrivere. Perche': senza, 217 rimandi su 265 del Trigger Map sono ambigui. Rischio basso, decisione 1.
2. **Mappa dei riferimenti in entrata** (sola lettura) per i 139 file di `rules/filament` con gemello: chi li cita (Trigger Map, `INDEX.md`, `.agents/rules`, prompts, `laravel/Modules/*/docs`) per nome e per percorso, con due metodi (`rg -P` e `/bin/grep -r`). Canonico = la copia piu' citata; a parita' quella fuori dalle sottocartelle.
3. **Dry-run del tool** su `rules/filament`: `dups`, poi `links ... --tail --report`. Salvare l'output in scratchpad e confrontare il canonico del tool con quello della mappa; dove differiscono, vince la mappa.
4. **Riscrivere i rimandi PRIMA** di segnare o eliminare un duplicato (prompt 42: zero riferimenti con due metodi). Le copie con rimandi in entrata si marcano `status: superseded` + `superseded_by`, non si cancellano; si cancellano solo quelle a zero rimandi, tracciate in git, con un file per volta.
5. **Pilota solo su `rules/filament`.** Contatore dei link rotti prima/dopo: non puo' salire (oggi 66 per la cartella e 265 percorsi mancanti nel Trigger Map). Un solo agente scrive nella wiki; reindex QMD (`bash bashscripts/docs/llm-wiki-qmd.sh update`) solo dal coordinatore, dopo.
6. **`bashscripts/ai/CLAUDE.md`**: leggere i due lati (prompt 51) e risolvere in avanti nei 3 blocchi. Blocco 2: HEAD ha l'esempio sbagliato corretto (`dry-kiss-analysis-modulo-job.md`), il lato `laraxot/dev` lo rende uguale all'esempio giusto, quindi tiene HEAD. Blocchi 1 e 3: decisione 2. Rischio basso, ma il file si carica nel contesto. Il file e' di un altro repo (`bashscripts`): chiedere conferma sul commit.
7. **Scrivere il bilancio del pilota** in questa story: copie marcate, cancellate, rimandi riscritti, link rotti prima/dopo. Poi, e solo poi, proporre `rules/misc` (621 su 625 con gemello) e `rules/11-forms`.

## Acceptance criteria
- [ ] `rg -cP '^(<{7}|>{7}) ' bashscripts/ai/CLAUDE.md` stampa 0 e `/bin/grep -cE '^(<{7}|>{7}) ' bashscripts/ai/CLAUDE.md` stampa 0 (secondo metodo, prompt 51).
- [ ] `python3 -I bashscripts/tools/docs/docs-organizer.py links bashscripts/ai/wiki/rules/filament --tail --report` ha `total` <= 66.
- [ ] Per ogni copia eliminata: `rg -F '<basename>' bashscripts docs laravel/Modules/*/docs .claude CLAUDE.md` non trova rimandi al percorso eliminato (secondo metodo: `/bin/grep -rF`).
- [ ] Il Trigger Map non ha piu' percorsi mancanti dei 265 di oggi (conteggio da script di sola lettura che estrae i percorsi in backtick).
- [ ] Nessuna cancellazione di massa: massimo i file di `rules/filament` con gemello, ognuno con rimandi riscritti.

## Verifica
Rimisurare con il blocco di "Stato misurato" (stessi comandi) e annotare le differenze. Controprova di ogni zero: lo stesso `rg` su un percorso noto che esiste (`bashscripts/ai/wiki/rules/INDEX.md` deve essere trovato) e su un rimando noto rotto (`docs/wiki/rules/` dal Trigger Map). Per i marker: creare in scratchpad un file con `printf '<%.0s' {1..7}` e verificare che entrambi i comandi lo trovino.

## Vincoli
- Nessun Pest/PHPUnit finche' la guardia DB non e' dentro e l'utente non ha confermato che i DB `*_test` sono usa-e-getta. PHPStan non serve (solo `.md`); se tocchi PHP, solo mirato in coda `flock` di `11-phpstan.md`; `laravel/phpstan.neon` immutabile.
- Un solo agente per modulo che edita PHP; un solo agente scrive nella wiki. Forward-only: niente checkout/reset/restore/stash. Niente cancellazione di massa senza riscrittura dei rimandi. Pest resta Pest.
- Niente nuovi `*Service`; logica in Spatie QueueableAction con `execute()`. Niente `mixed`, `@var`, ignore di comodo.
- Non lanciare `llm-wiki-qmd.sh update` (solo coordinatore). Le skill di terzi (`skills/`, 5031 file, 29,8 MB) restano fuori.

## Decisioni aperte
1. Prefisso canonico dei rimandi e destino del mirror `docs/wiki/rules/` (crearlo, o togliere i rimandi). 2. `bashscripts/ai/CLAUDE.md` blocchi 1 e 3: tenere l'intestazione ridotta di `laraxot/dev` ("Versione ridotta per contenere il contesto") sopra al file lungo, o uno dei due? 3. Copie con rimandi in entrata: sempre `superseded`, mai cancellate? 4. `rules/migrated-from-agents` (999 file divergenti): bonifica separata con confronto del contenuto, non per hash.

## Come ripartire
1. Rilancia i comandi di "Stato misurato", scrivi le differenze in una nota datata in fondo, e chiedi all'utente la decisione 1.
2. Costruisci in scratchpad la mappa dei rimandi in entrata per `rules/filament` (voce 2) e guardala insieme al dry-run del tool (voce 3); non scrivere nulla nella wiki.
3. Se la mappa e' coerente, risolvi `bashscripts/ai/CLAUDE.md` (voce 6, un file, rischio basso) come primo intervento reale.
