# Moduli Laraxot per il progetto

## Moduli Frontend

### 1. `module_ui_fila3`
- **Scopo**: Gestione dell'interfaccia utente base
- **Funzionalità**:
  - Layout e componenti base
  - Stili e temi
  - Componenti Blade riutilizzabili
- **Perché necessario**: Fornisce la base per l'interfaccia utente di il progetto

### 2. `theme_one_fila3`
- **Scopo**: Tema base per Filament 4
- **Funzionalità**:
  - Tema predefinito
  - Personalizzazione del look & feel
  - Responsive design
- **Perché necessario**: Fornisce il tema base per l'interfaccia amministrativa

## Moduli Core

### 1. `module_xot_fila3`
- **Scopo**: Modulo base per Filament 4
- **Funzionalità**:
  - Classi base per Resources
  - Trait e interfacce comuni
  - Utility per Filament
- **Perché necessario**: Fondamentale per l'integrazione con Filament

### 2. `module_lang_fila3`
- **Scopo**: Gestione multilingua
- **Funzionalità**:
  - Traduzioni
  - Localizzazione
  - Gestione lingue
- **Perché necessario**: Per il supporto multilingua (IT/EN)

### 3. `module_tenant_fila3`
- **Scopo**: Supporto multi-tenant
- **Funzionalità**:
  - Gestione tenant
  - Isolamento dati
  - Configurazione per tenant
- **Perché necessario**: Per il supporto multi-tenant

### 4. `module_user_fila3`
- **Scopo**: Gestione utenti e autenticazione
- **Funzionalità**:
  - Gestione utenti
  - Ruoli e permessi
  - Autenticazione
- **Perché necessario**: Per la gestione degli utenti del sistema

### 5. `module_media_fila3`
- **Scopo**: Gestione media e file
- **Funzionalità**:
  - Upload file
  - Gestione immagini
  - Storage manager
- **Perché necessario**: Per la gestione di file e media

### 6. `module_activity_fila3`
- **Scopo**: Logging e monitoraggio attività
- **Funzionalità**:
  - Log attività utente
  - Monitoraggio sistema
  - Audit trail
- **Perché necessario**: Per il tracciamento delle attività

### 7. `module_gdpr_fila3`
- **Scopo**: Gestione della privacy e GDPR
- **Funzionalità**:
  - Gestione consensi
  - Esportazione dati personali
  - Cancellazione dati
  - Registro dei trattamenti
- **Perché necessario**: Per la conformità GDPR e la gestione dei dati personali dei pazienti

## Moduli Funzionali

### 1. `module_notify_fila3`
- **Scopo**: Sistema di notifiche
- **Funzionalità**:
  - Notifiche in-app
  - Notifiche email
  - Notifiche push
- **Perché necessario**: Per le notifiche ai pazienti e al personale

### 2. `module_cms_fila3`
- **Scopo**: Gestione contenuti
- **Funzionalità**:
  - Pagine statiche
  - Blog
  - FAQ
- **Perché necessario**: Per la gestione dei contenuti informativi

## Moduli Utilità

### 1. `module_job_fila3`
- **Scopo**: Gestione job in background
- **Funzionalità**:
  - Code di lavoro
  - Job scheduling
  - Monitoraggio job
- **Perché necessario**: Per le operazioni asincrone

### 2. `module_chart_fila3`
- **Scopo**: Visualizzazione dati
- **Funzionalità**:
  - Grafici e statistiche
  - Dashboard
  - Report
- **Perché necessario**: Per la visualizzazione delle statistiche

## Moduli Non Necessari

I seguenti moduli non sono necessari per il progetto:
- `module_git`: Gestione Git non richiesta
- `module_blog_old`: Sistema blog legacy non necessario
- `module_theme`: Versione vecchia del tema

## Installazione con Git Subtree

```bash

# Moduli Frontend
git subtree add --prefix laravel/Modules/UI git@github.com:laraxot/module_ui_fila3.git dev
git subtree add --prefix laravel/Themes/One git@github.com:laraxot/theme_one_fila3.git dev

# Moduli Core
git subtree add --prefix laravel/Modules/Xot git@github.com:laraxot/module_xot_fila3.git dev
git subtree add --prefix laravel/Modules/Lang git@github.com:laraxot/module_lang_fila3.git dev
git subtree add --prefix laravel/Modules/Tenant git@github.com:laraxot/module_tenant_fila3.git dev
git subtree add --prefix laravel/Modules/User git@github.com:laraxot/module_user_fila3.git dev
git subtree add --prefix laravel/Modules/Media git@github.com:laraxot/module_media_fila3.git dev
git subtree add --prefix laravel/Modules/Activity git@github.com:laraxot/module_activity_fila3.git dev
git subtree add --prefix laravel/Modules/Gdpr git@github.com:laraxot/module_gdpr_fila3.git dev

# Moduli Funzionali
git subtree add --prefix laravel/Modules/Notify git@github.com:laraxot/module_notify_fila3.git dev
git subtree add --prefix laravel/Modules/Cms git@github.com:laraxot/module_cms_fila3.git dev

# Moduli Utilità
git subtree add --prefix laravel/Modules/Job git@github.com:laraxot/module_job_fila3.git dev
git subtree add --prefix laravel/Modules/Chart git@github.com:laraxot/module_chart_fila3.git dev
```

### Aggiornamento dei Moduli

Per aggiornare un modulo specifico:
```bash
git subtree pull --prefix laravel/Modules/[NomeModulo] git@github.com:laraxot/module_[nome]_fila3.git dev
```

Per aggiornare tutti i moduli:
```bash

# Aggiorna tutti i moduli
for dir in laravel/Modules/*/; do
    if [ -d "$dir/.git" ]; then
        module_name=$(basename "$dir")
        git subtree pull --prefix "laravel/Modules/$module_name" "git@github.com:laraxot/module_${module_name,,}_fila3.git" dev
    fi
done
```

### Note su Git Subtree

1. **Vantaggi**:
   - Controllo completo del codice
   - Possibilità di modificare i moduli localmente
   - Migliore gestione delle versioni
   - Facile aggiornamento dei moduli

2. **Best Practices**:
   - Mantenere i moduli in `laravel/Modules/`
   - Rispettare la convenzione PascalCase per i nomi delle cartelle
   - Documentare le modifiche locali
   - Testare dopo ogni aggiornamento
   - Verificare la compatibilità tra moduli

3. **Risoluzione Conflitti**:
   ```bash
   # Se ci sono conflitti durante il pull
   git subtree pull --prefix laravel/Modules/[NomeModulo] git@github.com:laraxot/module_[nome]_fila3.git dev --squash
   ```

4. **Rimozione Modulo**:
   ```bash
   git subtree remove --prefix laravel/Modules/[NomeModulo] git@github.com:laraxot/module_[nome]_fila3.git dev
   ```

## Configurazione

Ogni modulo è configurato attraverso il proprio file `module.json` nella directory del modulo. Ad esempio:

```json
// laravel/Modules/UI/module.json
{
    "name": "UI",
    "providers": [
        "Modules\\UI\\Providers\\UIServiceProvider"
    ],
    "aliases": {},
    "files": [],
    "requires": []
}
```

```json
// laravel/Modules/Xot/module.json
{
    "name": "Xot",
    "providers": [
        "Modules\\Xot\\Providers\\XotServiceProvider"
    ],
    "aliases": {},
    "files": [],
    "requires": []
}
```

### Note sulla Configurazione

1. **Struttura del module.json**:
   - `name`: Nome del modulo in PascalCase
   - `providers`: Array dei service providers
   - `aliases`: Alias per facades e altri componenti
   - `files`: File da caricare automaticamente
   - `requires`: Dipendenze da altri moduli

2. **Best Practices**:
   - Mantenere il nome del modulo coerente con la directory
   - Verificare le dipendenze tra moduli
   - Documentare eventuali personalizzazioni

## Note di Implementazione

1. **Ordine di Installazione**
   - Prima installare i moduli core
   - Poi i moduli frontend
   - Infine i moduli funzionali e utilità

2. **Dipendenze**
   - Verificare le compatibilità tra moduli
   - Controllare le versioni di Laravel e Filament

3. **Personalizzazione**
   - Ogni modulo può essere personalizzato
   - Mantenere la compatibilità con le future versioni

4. **Testing**
   - Testare ogni modulo dopo l'installazione
   - Verificare le integrazioni tra moduli 

## Collegamenti tra versioni di modules.md
* [modules.md](docs/tecnico/laraxot/modules.md)
* [modules.md](docs/architecture/modules.md)
* [modules.md](laravel/Modules/Xot/docs/filament/modules.md)
* [modules.md](laravel/Modules/Xot/docs/config/modules.md)

