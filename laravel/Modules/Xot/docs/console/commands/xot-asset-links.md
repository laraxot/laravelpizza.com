---
title: "xot:module-link e xot:theme-link"
type: reference
module: Xot
status: active
created: 2026-11-18
updated: 2026-11-18
tags: [console, artisan, symlink, public_html, assets, temi, moduli]
qmd: "xot:module-link xot:theme-link symlink public_html assets themes comando artisan"
related:
  - ../../wiki/concepts/public-html-symlink-assets.md
  - ../../theme-assets-workflow.md
---

# `xot:module-link` e `xot:theme-link`

Creano i symlink relativi con cui la document root vede gli asset di moduli e temi. La regola e i motivi sono in
[public-html-symlink-assets.md](../../wiki/concepts/public-html-symlink-assets.md).

| Comando | Crea | Salta |
|---|---|---|
| `php artisan xot:module-link` | `public_html/assets/<modulo minuscolo>` → `../../laravel/Modules/<Modulo>/public` | moduli senza `public/` |
| `php artisan xot:theme-link` | `public_html/themes/<Tema>` → `../../laravel/Themes/<Tema>/public` | temi senza `public/` |

Opzioni comuni:

- `--module=<Nome>` / `--theme=<Nome>`: solo quel modulo o tema;
- `--dry-run`: mostra cosa farebbe, senza toccare nulla;
- `--force`: sostituisce un link che punta altrove o una cartella vera (spostata in `<nome>.bak-<data>`).

Comportamento:

- un link già corretto viene lasciato; uno con lo stesso bersaglio ma percorso assoluto viene riscritto relativo;
- senza `--force` una cartella vera al posto del link non viene toccata (avviso);
- prima di creare il link aggiunge al `.gitignore` della cartella le righe `<nome>/` e `<nome>`
  (`EnsureGitignoreEntriesAction`), solo se mancano.

In `deploy.sh` lo stesso lavoro è fatto in bash (passo «Symlink nella document root»), perché gira prima di
`composer install`, quando `artisan` potrebbe non partire.

Verifica:

```bash
cd laravel
php artisan xot:module-link --dry-run   # atteso: «link gia' corretto» per ogni modulo con public/
php artisan xot:theme-link --dry-run
./vendor/bin/pest Modules/Xot/tests/Unit/PublicAssetsAreSymlinkedTest.php
```
