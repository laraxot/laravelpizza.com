---
title: "Asset dei temi: symlink relativo public_html/themes/<Tema> → Themes/<Tema>/public"
type: rule
module: Xot
status: active
created: 2026-11-11
updated: 2026-11-11
tags: [themes, vite, public_html, symlink, deploy, assets]
qmd: "public_html themes symlink ln -s relativo Themes public vite build manifest npm run copy obsoleto hot info.php"
related:
  - ../../../../../../docs/wiki/concepts/public-path-public-html.md
  - ../../bmad/stories/5.302-release-readiness-asset-temi-document-root.story.md
---
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

## Verifica

Test Pest: `laravel/Modules/Xot/tests/Unit/ThemePublicSymlinkTest.php`.

## Deploy su un server che ha ancora le copie

Se `public_html/themes/<Tema>` è una directory reale (vecchio `npm run copy`),
`git pull` non può sostituirla con il link: rimuovere la directory copiata e
rifare il pull (o creare il link con il comando sopra).
