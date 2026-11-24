---
<<<<<<< HEAD
title: "Asset dei temi: symlink relativo public_html/themes/<Tema> → Themes/<Tema>/public"
=======
title: "Asset di temi e moduli nella document root: symlink relativi, mai copie, mai versionati"
>>>>>>> laraxot/dev
type: rule
module: Xot
status: active
created: 2026-11-11
<<<<<<< HEAD
updated: 2026-11-11
tags: [themes, vite, public_html, symlink, deploy, assets]
qmd: "public_html themes symlink ln -s relativo Themes public vite build manifest npm run copy obsoleto hot info.php"
=======
<<<<<<< HEAD
updated: 2026-11-19
tags: [themes, modules, vite, public_html, symlink, deploy, assets, gitignore]
qmd: "public_html themes assets symlink ln -s relativo Themes Modules public vite build manifest npm run copy obsoleto xot:theme-link xot:module-link gitignore hot info.php"
issues:
  - https://github.com/provtv/base_ptv_fila5/issues/264
=======
updated: 2026-11-11
tags: [themes, vite, public_html, symlink, deploy, assets]
qmd: "public_html themes symlink ln -s relativo Themes public vite build manifest npm run copy obsoleto hot info.php"
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
related:
  - ../../../../../../docs/wiki/concepts/public-path-public-html.md
  - ../../bmad/stories/5.302-release-readiness-asset-temi-document-root.story.md
---
<<<<<<< HEAD
=======
<<<<<<< HEAD
# Asset di temi e moduli: symlink relativi, mai copie

## Regola

| Link nella document root | Destinazione | Comando |
|---|---|---|
| `public_html/themes/<Tema>` | `../../laravel/Themes/<Tema>/public` | `php artisan xot:theme-link` |
| `public_html/assets/<modulo in minuscolo>` | `../../laravel/Modules/<Modulo>/public` | `php artisan xot:module-link` |

- Il link è **relativo**.
- Il link **non si versiona**: `public_html/themes/.gitignore` e
  `public_html/assets/.gitignore` elencano ogni nome con **due righe**:
  - `<nome>/` esclude una **cartella reale** (una copia, ad esempio un vecchio `npm run copy`);
  - `<nome>` esclude il **symlink**, che per git è un file, quindi `<nome>/` da solo non lo copre.
  I comandi aggiungono le righe da soli (`EnsureGitignoreEntriesAction`).
- I link si creano in **ogni installazione**: `composer` `post-autoload-dump` lancia
  entrambi i comandi, e `deploy.sh` li ripete e si ferma se trova una cartella reale.
- `npm run copy` **non esiste più**: dopo `npm run build` gli asset del tema sono già serviti.

## Perché

1. **La document root è `public_html/`** (`public_path()`): il web server serve solo lì.
   `@vite([...], 'themes/<Tema>')`, `asset(...)` e `AssetAction` risolvono lì dentro.
2. **Chi possiede gli asset.** Ogni modulo è un repo git indipendente, condiviso tra i
   progetti fila5: i suoi asset statici stanno nel suo `public/` e si versionano **solo** nel
   repo del modulo. Il build Vite di un tema finisce in `Themes/<Tema>/public`
   (`build.outDir: './public'`, `manifest.json`).
3. **Niente copie.** Il link espone l'originale: una sola copia, niente asset vecchi.
   Le copie committate nel repo base divergevano dai moduli: a novembre 2026 cinque
   screenshot UI e il logo Xot in `public_html/assets` erano **binari corrotti** da una
   conversione CRLF→LF, mentre gli originali nei moduli erano integri.
4. **Percorso relativo**: funziona ovunque sia clonato il progetto (locale, server, CI).
5. **Solo `/public`**: dal web non si raggiungono `app/`, `config/`, `resources/`,
   `node_modules/`, sorgenti.
6. **Nome del modulo in minuscolo** = formato dell'URL generato da `AssetAction`
   (`ptv::img/logo.png` → `assets/ptv/img/logo.png`). Su Linux `Ptv` e `ptv` sono cartelle
   diverse: serve un nome unico e prevedibile.
7. **Perché non versionare i link.** Il repo base è un modello per progetti con insiemi di
   moduli diversi: un link versionato a un modulo assente diventa un link rotto. Su
   Windows con `core.symlinks=false` un link versionato diventa un file di testo. Il
   comando invece crea i link dai moduli e dai temi realmente presenti.
8. **Apache** segue già i symlink: `mod_rewrite` richiede `FollowSymLinks` o
   `SymLinksIfOwnerMatch`. Dichiararlo in `.htaccess` senza `AllowOverride Options`
   darebbe errore 500.

## File che non devono mai stare in `public_html/`

- `public_html/hot`: lo crea `vite` in sviluppo; in produzione `@vite` caricherebbe
  CSS/JS da `http://127.0.0.1:5173`.
- `info.php` con `phpinfo()`: espone configurazione e segreti del server.

Entrambi sono nel `.gitignore` della root.

## Dopo un pull

```bash
cd laravel
php artisan xot:theme-link
php artisan xot:module-link
```

(Con `composer install` o `composer dump-autoload` succede da solo.) Se il comando
segnala una cartella reale al posto del link: `--force` la sposta in `<nome>.bak-<data>`.
Quella cartella è sotto la document root, quindi va spostata fuori da `public_html` o
cancellata dopo il controllo.
=======
>>>>>>> laraxot/dev
# Asset dei temi: symlink, mai copie

## Regola

Per ogni tema che ha una build Vite (`laravel/Themes/<Tema>/public`):

```bash
cd public_html/themes
ln -s ../../laravel/Themes/<Tema>/public <Tema>
```

- Il link è **relativo** ed è **versionato in git** (`.gitignore` ignora
  `public_html/themes/*` con eccezioni `!public_html/themes/<Tema>`).
- `npm run copy` **non esiste più**: dopo `npm run build` gli asset sono già
  serviti.
- Temi senza build propria (es. `One`, che riusa il build di `Zero` via
  `@vite([...], 'themes/Zero')`) possono avere il link se hanno `public/`.

## Perché

1. **Document root = `public_html/`** (`public_path()`): il web server serve solo
   lì. `@vite([...], 'themes/<Tema>')`, `asset('themes/<Tema>/…')` e
   `AssetAction` risolvono tutti dentro `public_html/themes/<Tema>`.
2. **Vite scrive in `laravel/Themes/<Tema>/public`** (`build.outDir: './public'`,
   `manifest.json`). Il symlink espone quell'output così com'è: **una sola
   copia**, niente asset vecchi, niente passo manuale dimenticato dopo il build.
3. **Relativo** → funziona ovunque sia clonato il progetto (`/var/www/_bases/…`,
   server, CI). Un path assoluto si rompe spostando la cartella.
4. **Solo `/public`**, non l'intero tema → dal web non sono raggiungibili
   `resources/`, `node_modules/`, `package.json`, sorgenti.
5. Apache segue già i symlink: `mod_rewrite` richiede `FollowSymLinks` (o
   `SymLinksIfOwnerMatch`) attivo, quindi non serve dichiararlo in `.htaccess`
   (farlo con `AllowOverride` senza `Options` darebbe 500).

## File che non devono mai stare in `public_html/`

- `public_html/hot`: lo crea `vite` in dev; se arriva in produzione `@vite`
  carica CSS/JS da `http://127.0.0.1:5173` e la pagina resta senza stile.
- `info.php` con `phpinfo()`: espone configurazione e segreti del server.

Entrambi sono in `.gitignore`.
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev

## Verifica

Test Pest: `laravel/Modules/Xot/tests/Unit/ThemePublicSymlinkTest.php`.

## Deploy su un server che ha ancora le copie

Se `public_html/themes/<Tema>` è una directory reale (vecchio `npm run copy`),
`git pull` non può sostituirla con il link: rimuovere la directory copiata e
rifare il pull (o creare il link con il comando sopra).
