# Build del tema Meetup

Gli asset del tema (CSS Tailwind, JS Alpine, font Inter) si compilano con Vite in `laravel/Themes/Meetup/public/`.

`public_html/themes/Meetup` **è un symlink** a `../../laravel/Themes/Meetup/public`, tracciato da git: il web server serve
niente `npm run copy`: `public_html/themes/<Tema>` è un symlink a `../../laravel/Themes/<Tema>/public`
promemoria che stampa un messaggio).

## Comandi

```bash
cd laravel/Themes/Meetup
npm ci          # dipendenze esatte del package-lock.json
npm run dev     # sviluppo con hot reload
npm run build   # produzione: public/manifest.json e public/assets/*
```

Dopo la build lo script `postbuild` (`scripts/clean-stale-assets.mjs`) toglie da `public/assets/` i file che il manifest non cita più (Vite scrive con `emptyOutDir: false` perché `public/` contiene anche favicon, `sw.js` e `site.webmanifest`). Poi commit di `public/manifest.json` e di `public/assets/` (`git add -A` registra anche le cancellazioni).

Ogni classe Tailwind nuova in una vista (anche dei moduli: `@source` in `resources/css/app.css`) arriva nel CSS solo dopo `npm run build`: senza build la pagina si vede senza quegli stili.

## Dettagli

- `vite.config.js` ha `base: '/themes/Meetup/'`: gli URL dentro il CSS (font, immagini) puntano a `/themes/Meetup/assets/…`.
- Il CSS importa gli stili di Filament da `laravel/vendor/filament/...`: prima della build serve `composer install` in `laravel/`.
- Il font Inter arriva da `@fontsource-variable/inter` ed è servito dal sito: nessuna richiesta a Google Fonts.

## Se il symlink non c'è (nuovo server o clone su Windows)

```bash
cd public_html/themes
rm -rf Meetup
ln -s ../../laravel/Themes/Meetup/public Meetup
```

Su Windows serve `git config core.symlinks true` prima del clone (o `mklink /D`).
