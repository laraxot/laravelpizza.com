---
title: "Asset di moduli e temi in public_html: symlink, non copie"
type: concept
module: Xot
status: active
created: 2026-11-12
updated: 2026-11-18
tags: [public_html, symlink, assets, temi, moduli, gitignore, deploy, AssetAction]
qmd: "public_html assets modulo symlink gitignore temi themes copia AssetAction deploy"
related:
  - ../../theme-assets-workflow.md
  - ../../console/commands/xot-asset-links.md
  - ../../../../../Themes/Two/docs/wiki/concepts/public-asset-deployment.md
  - ../../../../../../docs/audit/RELEASE.md
---

# Asset di moduli e temi in `public_html`: symlink, non copie

## La regola

`public_html` è la document root e non si cancella. Gli asset di temi e moduli ci arrivano **solo con symlink
relativi**:

| In `public_html` | Comando (da dentro la cartella padre) | Comando artisan |
|---|---|---|
| `themes/<Tema>` | `ln -s ../../laravel/Themes/<Tema>/public <Tema>` | `php artisan xot:theme-link` |
| `assets/<modulo in minuscolo>` | `ln -s ../../laravel/Modules/<Modulo>/public <modulo>` | `php artisan xot:module-link` |

Accanto a ciascuna cartella c'è un `.gitignore` con due righe per nome, come le scrive
`EnsureGitignoreEntriesAction` (usata dai due comandi):

```gitignore
# public_html/assets/.gitignore
geo/
geo
# ... due righe per ogni modulo
```

## Perché

- **Una sola copia.** Il file sta nel modulo (o nel tema) e solo lì. Prima si copiava (`npm run copy`,
  `vendor:publish`, `AssetAction`) e le copie si disallineavano: `laravel/public` aveva 50 file vecchi mai serviti,
  `public_html/themes/Two` era rimasta indietro rispetto alla build.
- **Versionato con il codice che lo usa.** Il modulo porta con sé i suoi asset: chi aggiorna il modulo aggiorna
  anche quelli, nello stesso commit.
- **Build visibile subito.** `npm run build` scrive in `<Modulo|Tema>/public` (per Geo: `outDir: './public'`); il sito
  la vede senza altri passi e l'URL resta `/assets/<modulo>/...` o `/themes/<Tema>/...`.
- **Relativo, quindi portabile.** `../../laravel/...` funziona in qualsiasi cartella venga clonato il progetto
  (locale, staging, produzione), senza percorsi assoluti.

### Perché il `.gitignore` con la barra finale

Per git un symlink è un file, non una cartella. Il pattern `geo/` vale solo per le cartelle, quindi:

- una **cartella vera** con quel nome (copia lasciata da `vendor:publish`, `npm run copy`, una vecchia installazione)
  corrisponde al pattern ed è **ignorata**: non può finire nel repo per sbaglio e non sporca `git status`;
- il **symlink** `public_html/assets/geo` non corrisponde a `geo/`. In questo repository i link esistenti sono
  **tracciati** (`git add -f`): chi clona trova già i link e il sito funziona senza comandi. La seconda riga (`geo`,
  senza barra) non tocca i file già tracciati; serve a che `xot:module-link` / `xot:theme-link` trovino il
  `.gitignore` già completo e non lo modifichino sul server, dove una modifica locale bloccherebbe il `git pull`
  del rilascio.

## Cosa fa il codice

- `XotBaseServiceProvider::registerPublicAssets()` non registra `vendor:publish` se `assets/<modulo>` è già un symlink
  (copiare ogni file su se stesso lo troncherebbe).
- `AssetAction` (`modulo::img/logo.png`) **non copia più nulla** (dal 2026-11-17): restituisce l'URL
  `/assets/<modulo minuscolo>/img/logo.png`, servito dal symlink. Il file deve quindi stare in
  `Modules/<Modulo>/public/`, non solo in `resources/`. Prima la copia a ogni richiesta scriveva attraverso il symlink:
  modificava file versionati del modulo e falliva («Failed to open stream») se il link mancava.
- `Modules/Xot/tests/Unit/PublicAssetsAreSymlinkedTest.php` controlla la regola senza avviare l'applicazione:
  symlink e voce nel `.gitignore` per ogni modulo con `public/` e per ogni tema con una build, voce nel `.gitignore`
  anche per i moduli senza `public/`.
- `deploy.sh`, passo «Symlink nella document root»: crea i symlink mancanti, corregge quelli che puntano altrove e
  sposta in `storage/backups` (non cancella) una vecchia cartella trovata al posto del link.

## Aggiungere un modulo con asset pubblici

```bash
cd laravel && php artisan xot:module-link --module=NuovoModulo   # crea il link e le due righe nel .gitignore
cd ../public_html/assets && git add -f nuovomodulo .gitignore     # il link si versiona: un clone funziona subito
```

Verifica: `git ls-files -s public_html/assets/nuovomodulo` mostra modo `120000` (symlink).
