---
tags: [module-root, hygiene, workspace, bmad, guard]
created: 2026-09-29
updated: 2026-10-27
issues: []
discussions: []
title: "Igiene della root dei moduli: cartelle, tooling, workspace, md"
type: story
module: Xot
status: in-progress
track: docs-hygiene
qmd: "module root hygiene code-workspace remote fila5 cartelle maiuscole tooling vietato readme changelog max sei md github skills gitignore docs archive"
related:
  - ./docs-modules-themes-continuous-reorg.story.md
  - ./5.158-module-root-md-cap-five.story.md
  - ../../../tests/Unit/ModuleRootHygieneTest.php
  - ../../../../../../docs/sprint-status.yaml
---

# Igiene della root dei moduli

## Perche'

Direttiva utente (2026-09-29) sulle root di `laravel/Modules/<Mod>/`. La guardia
Pest `Modules/Xot/tests/Unit/ModuleRootHygieneTest.php` rende le regole osservabili:
una regola senza test regredisce.

## Regole

1. Nessuna cartella con lettere maiuscole in root.
2. Cartelle vietate (cancellare e mettere nel `.gitignore` di root modulo):
   `bashscripts`, `graphify-out`, `tools`, `scripts`, `.agents`, `.claude-audit`,
   `.vscode`, `build`, `.claude`, `.codex`, `.opencode`, `tests/graphify-out`.
3. Un solo `*.code-workspace`, chiamato `_module_<nome>_fila5.code-workspace`.
   `<nome>` viene dal remote git (`<Mod>/.git/config`), preferendo il remote
   `laraxot`: `git@github.com:laraxot/module_activity_fila5.git` ->
   `_module_activity_fila5.code-workspace`. Il nome e' minuscolo, senza separatori
   aggiunti (`module_indennitacondizionilavoro_fila5`).
4. `README.md` e `CHANGELOG.md` sempre presenti, al massimo 6 `.md` totali in root.
5. `.github/skills` assente in root modulo e ignorato: riga `/.github/skills/` nel
   `.gitignore` del modulo (vedi sezione dedicata sotto).

## Misura di partenza (2026-09-29, find/ls reali sui 19 moduli con .git)

- Cartelle con maiuscole: Job (`Config`), Ptv (`Filament`).
- Cartelle vietate: `graphify-out` in 9 moduli (Incentivi, IndennitaCondizioniLavoro,
  IndennitaResponsabilita, Job, Media, Pdnd, Performance, Progressioni, Ptv);
  `scripts` in Job, Media, Tenant; `bashscripts` in Job, Media; `.opencode` in Job.
- Workspace: OK solo dove gia' `_module_<nome>_fila5` unico (Activity, Lang, Notify,
  Rating, UI, User, Xot). Nomi senza `_fila5` (Incentivi, IndennitaResponsabilita,
  Pdnd, Performance, Progressioni, Ptv, Sigma); duplicati in IndennitaCondizioniLavoro (3),
  Job (2), Media (3), Tenant (2).
- Md: Progressioni senza `CHANGELOG.md`; Notify e UI a 6 (al limite); nessuno oltre.
- Remote: quasi tutti hanno `provtv` e `laraxot`; IndennitaResponsabilita, Notify, Pdnd,
  Rating, Xot solo `laraxot`. `Modules/docs` non e' un modulo (senza `.git`).

## Lotti

- Lotto A: cartelle vietate (rm + `.gitignore`), 5 agenti in parallelo per modulo.
- Lotto B: cartelle maiuscole (Job/Config, Ptv/Filament: verificare se sono
  dati reali, spostare sotto `config/` o `app/` prima di cancellare).
- Lotto C: workspace (rinominare con `git mv`, cancellare i duplicati).
- Lotto D: md (CHANGELOG di Progressioni, tetto 6).
- Lotto E: guardia verde + `qmd update`.

## Regola 5: `.github/skills` (richiesta utente 2026-09-29)

Richiesta: "la cartella .github/skills va messa negli .gitignore di ogni root di ogni
modulo poi cancellata".

Stato misurato (~10:55, sui 18 moduli con `.git`: Activity, Incentivi,
IndennitaCondizioniLavoro, IndennitaResponsabilita, Job, Lang, Media, Notify, Pdnd,
Performance, Progressioni, Ptv, Rating, Sigma, Tenant, UI, User, Xot):

- `/.github/skills/` gia' presente nel `.gitignore` di tutti e 18 (modifica non
  committata di un'altra sessione; ricontrollato con `grep -cxF`, 1 riga per modulo).
- `.github/skills` assente su disco in tutti; mai tracciata (non in indice, non in
  HEAD, non su branch remoti, `git log --diff-filter=D` vuoto). Quindi niente
  `git rm --cached` e niente da cancellare: un merge non puo' resuscitarla.

Guardia aggiunta in `ModuleRootHygieneTest.php`:

- `.github/skills` aggiunta all'elenco di `root modulo senza cartelle di tooling
  vietate` (fallisce se la directory ricompare);
- nuovo caso `root modulo con /.github/skills/ nel .gitignore` (fallisce se un modulo
  con `.git` perde la riga), dataset `module_roots`.

Nello stesso passaggio `Safe\file`, `Safe\glob`, `Safe\preg_match` e `@var list<string>`
sul file intero: PHPStan passa da 11 (poi 14) errori a 0.

Esito reale (2026-09-29, ~11:30, load average ~53 per altre 6 sessioni Pest):

- `./vendor/bin/pest Modules/Xot/tests/Unit/ModuleRootHygieneTest.php --no-coverage`:
  `Tests: 1 failed, 90 passed (163 assertions)`, 966.61s. I due casi toccati sono verdi
  18/18 ciascuno (`.gitignore` e tooling vietato). L'unico rosso e' preesistente e non
  dipende da questa regola: `Job: cartelle con maiuscole in root: Config` (Lotto B, dir
  tracciata `Job/Config/{.gitkeep,config.php}` accanto a `Job/config/`).
- `./vendor/bin/phpstan analyse Modules/Xot/tests/Unit/ModuleRootHygieneTest.php`:
  `[OK] No errors`.
- Nessun file cancellato: non c'era niente da cancellare.

## Regola 6: `docs/graphify` (richiesta utente 2026-09-29)

Richiesta: "la cartella docs/graphify deve essere messa dentro i .gitignore nelle root dei
moduli e poi cancellate le cartelle".

Stato misurato (~12:12): riga `docs/graphify` gia' presente nel `.gitignore` dei 18 moduli
(modifica in blocco di un'altra sessione alle 12:10:21, verificata con `git check-ignore`);
cartella gia' assente dal disco ovunque; ancora tracciata in 5 moduli (IndennitaResponsabilita 1,
Job 5, Lang 5, Rating 2, UI 652 file). Fatto: `git rm -r --cached -- docs/graphify` limitato a quel
path nei repo di IndennitaResponsabilita, Job, Lang, UI (Rating era gia' a 0). Nessun commit.
Esito: 18 moduli + 3 temi con cartella assente, indice vuoto, path ignorato.

## Regola 7: `resources/lang` solo nei moduli (richiesta utente 2026-09-29)

Richiesta: "la cartella resources/lang va messa nei .gitignore delle root dei moduli, poi
cancella anche la cartella".

Verificato prima di cancellare: i moduli traducono da `lang/` (config
`modules.paths.generator.lang = lang`; a runtime il namespace `user` punta a `Modules/User/lang`,
`__('user::user.fields.email.label')` = "Email"). `resources/lang` aveva 0 file e 0 tracciati in
tutti i 18 moduli; riga gia' nei `.gitignore` (altra sessione, 12:20:59). **I temi no**:
`XotBaseThemeServiceProvider` carica le traduzioni da `resources/lang`, quindi la regola non va
estesa a `Themes/*`.

## Regola 8: in `Modules/` solo moduli (richiesta utente 2026-09-29)

Richiesta: "laravel/Modules/test/ non deve esistere, capisci da solo il perche'".

Perche': ogni cartella in `Modules/` e' trattata come modulo da nwidart, dal merge dei
`composer.json`, da PHPStan (`paths: Modules/`) e da ogni script `for m in Modules/*`. La causa:
`IndennitaResponsabilita\Actions\UpdateModuleDocumentation` faceva `mkdir` ricorsivo su qualunque
nome, e gli sweep di copertura la chiamavano con `'test'` (file `Modules/test/docs/changelog.md`,
gia' committato nel repo root il 2026-09-02, `107f5184fc`). Fix di un'altra sessione (12:28):
`resolveModulePath()` accetta solo nome alfanumerico con `module.json`; test
`UpdateModuleDocumentationValidationTest` 4 passed (6 assertions).

Guardia aggiunta: caso `in Modules ci sono solo moduli: ogni cartella ha module.json` in
`ModuleRootHygieneTest` (il dataset esistente salta le cartelle senza `.git` e da solo non le
vede). Verde sullo stato attuale; rosso con una cartella di prova `Modules/zzprobe`
("cartelle in Modules che non sono moduli: zzprobe"). Casi 6-8: `Tests: 37 passed`,
PHPStan `[OK] No errors`, PHPMD 0.

## Regola 9: `docs/archive/` nei `.gitignore` (richiesta utente 2026-10-27)

Richiesta: "la cartella docs/archive/ deve essere messa in tutti i .gitignore delle root
dei moduli e dei temi".

Perche': ogni `Modules/<Mod>` e `Themes/<T>` e' un repo Git separato, quindi l'ignore del
monorepo non lo copre. `docs/archive/` e' tassonomia parallela vietata dalla wiki
(`docs/wiki/concepts/no-docs-archive-rule.md`): se resta tracciata, ogni merge/sync tra
basi diverse la riporta e sporca la storia.

Misura (2026-10-27, 20 cartelle modulo e 4 temi, tutti con `.gitignore` in root):

- gia' coperti con pattern equivalente: 19/20 moduli (`docs/archive`, `/docs/archive`,
  `docs/**/archive/`, `docs/archive/**`) e 4/4 temi;
- **Fixcity**: riga corrotta `docs/archive/agentdb.rvf` (concat di due pattern) che
  ignora un file dentro `docs/archive/`, non la cartella, e non ignora `agentdb.rvf`
  in root. Corretta in due righe: `docs/archive/` + `agentdb.rvf`;
- mancanti: `laravel/Modules/.gitignore`, `laravel/Themes/.gitignore` e
  `laravel/Modules/.gitignore_template` (futuri moduli). Aggiunta la riga.

Nessun `git rm --cached` eseguito in questa sessione: shell non disponibile
(`DAYTONA_API_KEY` assente), quindi lo stato dell'indice non e' stato verificato.
Se qualche repo ha gia' `docs/archive/` tracciata, va sbloccata con
`git -C Modules/<Mod> rm -r --cached -- docs/archive` (solo quel path).

## Regola 10: `*.lock` nei `.gitignore` (richiesta utente 2026-11-04)

Richiesta: "in ogni modulo nel file .gitignore deve esserci che ignoriamo *.lock".

Perche': i lock degli agenti (`bashscripts/lock/lock.sh`) sono file `<path>.lock` accanto al file
bloccato. Ogni modulo e' un repo a se', quindi l'ignore del monorepo (riga 22 del `.gitignore` di
root) non li copre. Un lock committato resta li' quando l'agente sparisce e `claims-open.py` lo
mostra come claim vivo per settimane.

Misura (2026-11-04, 14 moduli con `.git`): 13 avevano gia' `*.lock`; **Notify** no, e aveva
**5 lock tracciati** (2 di `opencode` del 5 ottobre, 3 di `notify`/`codex` del 28 ottobre).
`Themes/Four` aveva la riga; `Themes/public` non e' un repo (lo copre il root).

Fatto:

- riga `*.lock` nel `.gitignore` di Notify (task `module-lock-ignore` di codex);
- 5 lock tolti dall'indice con `git rm --cached` sui soli 5 path, nel solo repo Notify (commit
  `4fa75386b`); i file restano su disco, quindi chi li tiene non perde il claim;
- guardia: in `ModuleRootHygieneTest` il caso `modulo con *.lock nel .gitignore e nessun *.lock
  tracciato`. Controlla la riga e `git ls-files '*.lock'` per modulo. RED vista su Notify (5 file
  tracciati), poi verde.

`AI/.gitignore` ripete `*.lock` tre volte (righe 21, 27, 99): innocuo, da ripulire quando si tocca
quel file. `composer.lock` e `yarn.lock` erano gia' ignorati nei moduli, quindi la regola non cambia
niente per loro.

Stato della guardia intera dopo la regola 10: 85 verdi, 29 rossi. I 29 sono **debito delle regole
1-7, preesistente e non toccato qui**: workspace con nome diverso da
`_module_<nome>_fila5.code-workspace` (AI, Cms, Gdpr, Job, Lang, Media, Notify, UI), riga
`/.github/skills/` mancante (AI, Cms, Gdpr, Trade), `resources/lang` ancora presente (Gdpr, Lang,
Notify, Trade), `docs/graphify` ancora presente (Lang, Notify, UI), cartelle vietate (Activity
`tools`, Notify `bashscripts` e `.github/skills`), `CHANGELOG.md` mancante in Trade. Cancellare
cartelle richiede di guardare dentro prima: `resources/lang` puo' contenere traduzioni vere.

## Verifica finale

`vendor/bin/pest Modules/Xot/tests/Unit/ModuleRootHygieneTest.php` verde (mai su
10.100.200.15: li' solo `php -l` + audit shell) e nessun ripristino da peer dopo 1 ora.

## Rischi

- Peer `opencode` che ripristina file o ricrea `.opencode`: dopo ogni lotto rileggere
  `git status` nel repo del modulo e verificare che la cartella non sia tornata.
- Repo annidati: ogni `Modules/<Mod>` ha un `.git` proprio; commit e verifica dal
  contesto del modulo, non dalla root. Controllare `.git/rebase-merge` prima di editare.
- Il `.gitignore` non copre i file gia' tracciati: serve `git rm -r --cached`, ma **solo
  sul path appena aggiunto al `.gitignore`**, nel repo del modulo, uno alla volta. Mai
  `git rm -r --cached .` sull'intero repo e mai su `laravel/config/local/` (config per
  tenant, versionata apposta). Conseguenza della ricetta applicata a tutto: il commit root
  `8b3b7cbea3` (2026-09-29) ha untracciato ~1261 file ignorati, fra cui i 90 della config
  per tenant, e un pull li avrebbe cancellati dai checkout. Story
  `laravel/Modules/Tenant/docs/bmad/stories/tenant-config-untracked-by-gitignore.story.md`.
- `bashscripts/tools/audit-module-root-hygiene.sh` contiene marker di conflitto
  (soglia 5 vs 6) e non e' allineato a queste regole: da riconciliare, non duplicare.
- `bashscripts/ai/wiki/memories/workspace-naming.md` descriveva `_<nome>.code-workspace`:
  superata da questa story.
- Lock (`bashscripts/lock/`) prima di ogni edit.
