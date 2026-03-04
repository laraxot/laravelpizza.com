# Risoluzione del tema e workflow di build

La **separazione del tema** dal core è fondamentale: il tema pubblico (Meetup) è determinato dalla configurazione tenant, non hardcodato.

## Catena di risoluzione

1. **`.env`**  
   `APP_URL=http://laravelpizza.local` (o l’URL del progetto).

2. **Cartella di configurazione**  
   Il modulo Tenant ricava il nome tenant da `APP_URL` (es. host `laravelpizza.local` → parti invertite → `local/laravelpizza`).  
   Cartella di config del progetto: **`laravel/config/local/laravelpizza`**.

3. **`config/local/laravelpizza/xra.php`**  
   Contiene tra le altre la chiave **`pub_theme`** (es. `'pub_theme' => 'Meetup'`).

4. **Tema e percorso**  
   Nome tema: **Meetup**.  
   Percorso: **`laravel/Themes/Meetup`**.  
   Le view usano il namespace **`pub_theme::`** (risolto su questo tema).

Implementazione: `Modules\Tenant\Actions\GetTenantNameAction` (nome tenant da `config('app.url')`), `TenantService::getConfig('xra')` carica `xra.php` dalla cartella tenant; `XotData::make()->pub_theme` espone il tema attivo.

## Workflow obbligatorio (dalla cartella del tema)

Dalla cartella **`laravel/Themes/Meetup`**:

### Per modifiche CSS/JS standard (99% dei casi)
```bash
npm run build && npm run copy
```

### Per setup iniziale o modifiche PHP nel tema
```bash
composer update -W
npm install
npm run build
npm run copy
```

### Tabella comandi

| Comando | Scopo | Quando usarlo |
|--------|--------|---------------|
| `composer update -W` | Aggiorna dipendenze PHP del tema | Setup iniziale o modifiche PHP in `app/` |
| `npm install` | Installa dipendenze Node | Setup iniziale o modifiche a `package.json` |
| `npm run build` | Genera CSS e JS (Vite/Tailwind) | **SEMPRE** dopo modifiche CSS/JS |
| `npm run copy` | Pubblica asset in `public_html/themes/Meetup/` | **SEMPRE** dopo `npm run build` |

**NOTA CRITICA**: Per semplici modifiche a `resources/css/app.css` o `resources/js/app.js`, è sufficiente solo `npm run build && npm run copy`. Il workflow completo (composer + npm install) è ridondante e spreca tempo.

## Approccio critico

- Il tema **non** è “sempre Meetup”: è il valore di `pub_theme` nella config tenant. Cambiando tenant (o `APP_URL`) può cambiare tema.
- I path verso view e asset vanno derivati dal tema risolto (es. `Themes/`.config('xra.pub_theme')) o da `XotData::make()->pub_theme`, non hardcodati.
- La documentazione e gli agenti devono usare questa catena (env → config tenant → xra → pub_theme → percorso tema) per coerenza e manutenibilità.

## Riferimenti

- [theme](theme.md) – sintesi e comandi
- [development-workflow-css-js-changes](development-workflow-css-js-changes.md) – workflow CSS/JS
- Modulo Tenant: risoluzione nome tenant e caricamento config (es. `GetTenantNameAction`, `GetTenantConfigArrayAction`)
- Modulo Xot: `XotData::make()->pub_theme`, view `pub_theme::`
- Regola progetto: `.cursor/rules/theme-resolution-critical.md`
- Memoria: `.cursor/memories/theme-resolution.md`
