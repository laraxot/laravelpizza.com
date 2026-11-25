---
title: "Cms: temi, risoluzione del tema pubblico, build e asset"
type: concept
module: Cms
status: active
qmd: "cms tema pub_theme vite build manifest symlink public_html themes npm run copy obsoleto create theme vite errors ThemeComposer"
---

# Temi e asset

## Come si sceglie il tema pubblico

Il tema non e' scritto nel codice: dipende dal tenant.

1. `APP_URL` (`.env`) -> il modulo Tenant ricava il nome del tenant -> cartella `laravel/config/local/<tenant>/`.
2. `config/local/<tenant>/xra.php`, chiave `pub_theme` (es. `'Meetup'`) -> `laravel/Themes/<Tema>`.
3. Namespace Blade `pub_theme::` (viste del tema); `XotData::getPubThemeViewPath('pages')` e' la cartella Folio
   che `FolioVoltServiceProvider` monta per ogni lingua ([architecture.md](architecture.md)).

`SettingPage` (pannello) elenca solo i temi esistenti (`ListInstalledThemesAction`): un `pub_theme` inventato fa fallire il boot.

## Cosa deve avere un tema

```
Themes/<Tema>/
├── resources/views/
│   ├── pages/                      rotte Folio (shell sottili che invocano <x-page>)
│   ├── components/blocks/<cat>/    view dei blocchi (pub_theme::components.blocks.<cat>.<nome>)
│   ├── components/sections/<slug>/ template di sezione (<tpl>.blade.php, default v1)
│   └── layouts/{main,app,guest}    shell HTML / layout pubblico / pagine di accesso
├── resources/{css,js}, vite.config.js, package.json, tailwind.config.*
├── public/                         output di `npm run build` (manifest.json compreso)
└── theme.json
```

Regole: il tema non contiene logica di business ne' query; e' indipendente dal progetto (configurabile, percorsi non
cablati); non sceglie layout o metadati per pagina (lo fa il Cms: [components.md](components.md)); un tema nuovo non
richiede script di copia. Un tema e' riusabile solo se le sue Blade restano indipendenti dal nome del tema
(`<x-page>`, non `<x-<nome-tema>::page>`).

## Build e pubblicazione degli asset

- `npm install` e `npm run build` nella cartella del tema: basta questo.
- **`npm run copy` non esiste piu'** (2026-11-11). `public_html/themes/<Tema>` e' un symlink relativo a
  `../../laravel/Themes/<Tema>/public`, tracciato da git: il web server serve esattamente l'output del build, la document
  root non espone sorgenti ne' `node_modules`, e un tema nuovo si pubblica con un solo link. Stato verificato:
  `public_html/themes/Meetup -> ../../laravel/Themes/Meetup/public`.
- Stessa regola per gli asset dei moduli: `public_html/assets/<modulo-minuscolo> -> ../../laravel/Modules/<Modulo>/public`,
  con riga `<modulo>/` in `public_html/assets/.gitignore` (ignora solo una cartella vera con quel nome, cioe' le copie
  generate da `vendor:publish`).
- Una Blade con `@vite([...], 'themes/<Tema>')` non usa `public/build/manifest.json` ma
  `public_html/themes/<Tema>/manifest.json`.
- Il modulo Cms ha un `vite.config.js` e un `package.json` ereditati (laravel-mix 6, Tailwind 3, uscita
  `public/build-user`): non sono il percorso usato dal front office; gli asset del front office sono del tema.

## Errori Vite piu' comuni

| Sintomo | Causa | Rimedio |
|---|---|---|
| `Unable to locate file in Vite manifest: resources/css/app.css` | manifest assente o chiave diversa | `npm run build` nel tema; controllare che il symlink `public_html/themes/<Tema>` esista e che `manifest.json` contenga la chiave |
| pagina senza CSS/JS o con asset doppi | `@vite` fuori posto o direttive Filament duplicate in `head`/`foot` | rispettare il contratto di [components.md](components.md) |
| asset vecchi dopo una modifica | build non rieseguito (o copia dimenticata in un clone antico) | rieseguire il build; non esistono copie da aggiornare |
| 404 su `/themes/<Tema>/...` | symlink sostituito da una cartella vera | ripristinare il symlink relativo |
| `pub_theme view not found` | `pub_theme` non corrisponde a una cartella di `Themes/` o la view non esiste | `config/local/<tenant>/xra.php`, nome del tema, percorso della view |

## Dal `ThemeComposer` ai componenti

Il vecchio rendering via `$_theme->showPageContent()` e' stato sostituito dal componente `<x-page>` (logica nel PHP,
Blade minima). `app/View/Composers/ThemeComposer.php` esiste ancora nel modulo; le pagine nuove usano `<x-page>` e
`<x-section>`. Per le regole attuali vedere [components.md](components.md).

## Creare un tema (checklist)

1. Cartella `Themes/<Tema>` con `theme.json`, `resources/views/{pages,components,layouts}`.
2. Vite + Tailwind; `npm run build`.
3. `ln -s ../../laravel/Themes/<Tema>/public public_html/themes/<Tema>` (relativo, versionato).
4. `pub_theme` nel `xra.php` del tenant.
5. Un test che apre `/it` e `/en` del tema e controlla il manifest.
