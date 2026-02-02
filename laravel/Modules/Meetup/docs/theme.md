# Theme Infrastructure & Knowledge Base

Questa documentazione definisce la struttura fondamentale e il workflow operativo per la gestione del tema nel progetto.

## 🔍 Logica di Scoperta del Tema (Theme Discovery)

Il sistema identifica il tema attivo attraverso una catena di configurazione gerarchica:

1.  **Identificazione Ambiente**: Si legge il file `.env` per trovare `APP_URL`.
    - Esempio: `APP_URL=http://laravelpizza.local`
2.  **Percorso di Configurazione**: In base all'host, la cartella di configurazione dedicata è:
    - Path: `laravel/config/local/laravelpizza`
3.  **Configurazione Active Theme**: All'interno della cartella precedente, si legge `xra.php`:
    - Chiave: `'pub_theme' => 'Meetup'`
4.  **Localizzazione Tema**: Il tema `Meetup` si trova fisicamente in:
    - Path: `laravel/Themes/Meetup`

## 🚀 Workflow di Sviluppo e Deployment

La separazione tra codice sorgente del tema e asset pubblici è fondamentale. Seguire rigorosamente questi passaggi per ogni modifica:

### 1. Preparazione Ambiente (Una tantum o aggiornamenti)
Dalla cartella del tema (`laravel/Themes/Meetup`):
```bash
composer update -W
npm install
```

### 2. Generazione Asset
Dopo aver modificato file in `resources/css` o `resources/js`:
```bash
npm run build
```
Questo comando compila gli asset tramite Vite nella cartella locale del tema.

### 3. Pubblicazione (Sync con public_html)
Per rendere le modifiche visibili sul sito (che serve i file da `public_html`):
```bash
npm run copy
```
*Tip: È possibile concatenare i comandi: `npm run build && npm run copy`.*

## 🧠 Approccio Laraxot: Filosofia della Separazione

La separazione del tema dai moduli è un pilastro dell'architettura Laraxot. 
- **Moduli**: Contengono la logica di business, i modelli e le action (il "Cosa").
- **Temi**: Contengono l'estetica, il layout e l'interazione front-end (il "Come").

**Regola d'oro per gli Agenti AI**:
Prima di procedere con qualsiasi modifica UI/UX, analizzare sempre la struttura `docs` all'interno del modulo e del tema interessato. Studiare il "perché" filosofico prima del "come" tecnico. Aggiornare costantemente la documentazione interna per mantenere la memoria collettiva del progetto.

## Riferimenti risoluzione tema e regole agenti

- **Risoluzione tema e workflow**: `laravel/Themes/Meetup/docs/theme-resolution-and-workflow.md` (catena env → config tenant → xra → pub_theme, build e copy).
- **Regola critica per agenti**: `.cursor/rules/theme-resolution-critical.md`.
- **Memoria progetto**: `.cursor/memories/theme-resolution.md`.
- **Modulo Tenant**: risoluzione nome tenant da `APP_URL` (es. `GetTenantNameAction`), caricamento config (es. `xra.php`) dalla cartella `config/<tenant_name>/`.

## Confronto grafica e logo footer

- **Footer logo confronto**: `laravel/Themes/Meetup/docs/footer-logo-confronto.md` – confronto logo footer con laravelpizza.com, screenshot in `docs/screenshots/footer-logo-confronto/`, roadmap allineamento.
