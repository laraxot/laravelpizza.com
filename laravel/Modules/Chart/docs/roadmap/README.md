# Roadmap Progetto il progetto (Aggiornata)

## Stato Attuale del Progetto (Aprile 2024)

### Attività Completate ✅
- [x] Definizione dei requisiti di sistema
- [x] Documentazione della struttura modulare
- [x] Analisi dei moduli necessari per il progetto
- [x] Documentazione sui pacchetti utilizzati
- [x] Documentazione sulla configurazione dei moduli
- [x] Documentazione sulla creazione di moduli custom
- [x] Integrazione dei moduli Laraxot core (Xot, Lang, Tenant, User)
- [x] Integrazione dei moduli frontend (UI, ThemeOne)
- [x] Integrazione dei moduli funzionali (Media, Activity, Gdpr, Notify, Cms, Job)
- [x] Integrazione dei moduli specifici (Patient, Chart)
- [x] Analisi dei problemi tecnici di integrazione
- [x] Documentazione dello stato del repository git
- [x] Analisi dei flussi di dati personali
- [x] Studio della privacy by design e privacy by default
- [x] Bozza iniziale DPIA (Valutazione d'Impatto sulla Protezione dei Dati)
- [x] Integrazione degli script Bash per l'automazione (`git subtree add -P bashscripts git@github.com:laraxot/bashscripts_fila3.git dev --squash`)
- [x] Creazione script per la correzione dei namespace (`/var/www/html/<nome progetto>/laravel/bashscripts/fix-namespace.sh`)
- [x] Creazione script per la correzione della posizione del tema (`/var/www/html/<nome progetto>/laravel/bashscripts/fix-theme-location.sh`)

### Problemi Tecnici Risolti ✅
- [x] Duplicazione del modulo CMS/Cms
- [x] Struttura base delle directory dei moduli
- [x] Registrazione dei provider di base 
- [x] Identificato problema critico di autoloading in composer.json (`"Modules\\": "Modules/"` in conflitto con nwidart/laravel-modules)
- [x] Identificato problema di stabilità dei pacchetti (`"minimum-stability": "stable"` impedisce l'utilizzo di moduli Laraxot in sviluppo)
- [x] Identificata discrepanza tra namespace e struttura directory (namespace `Modules\Chart\App\Providers` vs configurazione autoload `"Modules\\Chart\\": "app/"`)
- [x] Risolto problema critico nel file config/app.php (configurazione errata dei service provider)
- [x] Risolto il posizionamento errato del tema One (spostato da `Modules/ThemeOne` a `Themes/One`)

### Problemi Tecnici Identificati 🚧
1. **Conflitti di classe**: Alcune classi sono definite più volte in moduli diversi, in particolare tra i moduli GDPR e UI.
2. **Problemi di autoloading**: Alcune classi non rispettano lo standard PSR-4 per l'autoloading automatico.
3. **Namespace non conformi**: I namespace nei file PHP non corrispondono alla configurazione di autoloading nei file composer.json dei moduli.
4. **Dipendenze mancanti**: La classe `Filament\PanelProvider` è necessaria ma non presente nel sistema.
5. **Problemi di compatibilità con Filament**: Incompatibilità di versione tra i moduli e Filament.

### Attività in Corso 🔄
- [ ] Risoluzione dei conflitti di classe tra moduli (in corso, 50% completato)
- [ ] Aggiornamento delle dipendenze mancanti in composer.json (in corso, 75% completato)
- [ ] Standardizzazione dei namespace nei file PHP (in corso, 10% completato)
- [ ] Configurazione corretta dei service provider nei moduli (in corso, 60% completato)
- [ ] Configurazione database e migrazioni (in corso, 40% completato)
- [ ] Implementazione modelli e relazioni per pazienti (in corso, 25% completato)
- [ ] Verifica dei namespace nel tema One (in corso, 50% completato)

## Documentazione Aggiornata

Per supportare lo sviluppo del progetto, sono stati creati i seguenti documenti dettagliati:

### Documentazione Tecnica
- [Stato Attuale del Progetto](01-stato-attuale-aggiornato.md) - Panoramica completa delle attività completate e in corso
- [Risoluzione Problemi di Autoloading](02-risoluzione-problemi-autoloading.md) - Guida dettagliata per risolvere i problemi di autoloading
- [Problema di Autoloading in Composer.json](02-risoluzione-problemi-autoloading-update.md) - Analisi specifica del problema con "Modules\\": "Modules/"
- [Discrepanza tra Namespace e Directory](/var/www/html/<nome progetto>/docs/namespace-structure.md) - Analisi del disallineamento tra namespace e struttura directory
- [Configurazione del file app.php](/var/www/html/<nome progetto>/docs/app-php-configuration.md) - Analisi del ruolo cruciale del file app.php nell'autoloading
- [Struttura dei Temi](/var/www/html/<nome progetto>/docs/themes-structure.md) - Documentazione sulla corretta struttura dei temi
- [Gestione Temi nel Modulo Cms](/var/www/html/<nome progetto>/docs/tecnico/09-gestione-temi-modulo-cms.md) - Spiegazione di come il modulo Cms gestisce i temi
- [Gestione Migrazioni nei Moduli](/var/www/html/<nome progetto>/docs/tecnico/10-gestione-migrazioni-moduli.md) - Documentazione sulla gestione delle migrazioni nei moduli Laraxot
- [Configurazione Filament](03-configurazione-filament.md) - Implementazione del pannello amministrativo con Filament 4.x
- [Modulo Patient](04-modulo-patient.md) - Implementazione dettagliata del modulo per la gestione pazienti
- [Scripts Bash](/var/www/html/<nome progetto>/docs/bashscripts.md) - Documentazione sugli script Bash per l'automazione
- [Minimum Stability](/var/www/html/<nome progetto>/docs/minimum-stability.md) - Analisi dell'importanza di usare "minimum-stability": "dev"

### Documenti Originali
- [Architettura e Moduli](02-architettura-moduli.md) - Descrizione dell'architettura modulare
- [Implementazione Backend](03-implementazione-backend.md) - Piano per il backend
- [Implementazione Frontend](04-implementazione-frontend.md) - Piano per il frontend
- [Flussi Utente](05-flussi-utente.md) - Flussi di interazione utente
- [Sicurezza e GDPR](06-sicurezza-gdpr.md) - Misure di sicurezza e conformità
- [Tempistiche e Priorità](07-tempistiche-priorita.md) - Pianificazione temporale

## Piano di Implementazione Aggiornato

### Fase 1: Risoluzione dei Problemi di Integrazione (Aprile-Maggio 2024)
1. **Risoluzione dei problemi di namespace e autoloading**
   - Correzione del file config/app.php con i service provider nell'ordine corretto
   - Rimozione della configurazione problematica da composer.json (`"Modules\\": "Modules/"`)
   - Modifica di "minimum-stability" da "stable" a "dev"
   - Correzione dei namespace non conformi nei file PHP (`Modules\Chart\App\Providers` → `Modules\Chart\Providers`)
   - Implementazione del piano dettagliato in [02-risoluzione-problemi-autoloading.md](02-risoluzione-problemi-autoloading.md)
   - Standardizzazione namespace e strutture directory
   - Risoluzione conflitti tra moduli GDPR e UI
   - Utilizzo degli script bash per automatizzare il processo di fix
   - Esecuzione di `fix-namespace.sh` per correggere automaticamente i namespace errati

2. **Verifica della struttura dei temi**
   - ✅ Tema già correttamente posizionato in `Themes/One`
   - Verifica dei namespace nel tema (da `Modules\ThemeOne` a `Themes\One`)
   - Aggiornamento dei riferimenti al tema nel codice
   - ✅ Nota: Non è necessaria la registrazione di un service provider dedicato per i temi, poiché questa funzionalità è già gestita dal modulo Cms

3. **Aggiornamento delle dipendenze e configurazione**
   - Aggiornamento di composer.json con dipendenze Filament 4.x
   - Installazione e configurazione di livewire e altre librerie necessarie
   - Configurazione del sistema multi-tenant

4. **Implementazione corretta dei service provider**
   - Registrazione in ordine corretto
   - Risoluzione delle dipendenze circolari
   - Pubblicazione delle configurazioni

### Fase 2: Implementazione del Modulo Patient (Maggio 2024)
1. **Implementazione dei modelli e migrazioni**
   - Creazione secondo il piano dettagliato in [04-modulo-patient.md](04-modulo-patient.md)
   - Definizione delle relazioni tra entità
   - Implementazione dei trait per GDPR e multi-tenancy

2. **Sviluppo della logica di business**
   - Implementazione del servizio di verifica eleggibilità
   - Gestione documenti e upload file
   - Implementazione della gestione appuntamenti

3. **Creazione delle risorse Filament**
   - Form per la gestione dei pazienti
   - Dashboard per amministratori
   - Pannelli per odontoiatri

### Fase 3: Implementazione dell'Interfaccia Utente (Maggio-Giugno 2024)
1. **Pannello amministrativo**
   - Dashboard con statistiche
   - Gestione utenti e permessi
   - Reportistica

2. **Pannello odontoiatri**
   - Calendario appuntamenti
   - Gestione pazienti
   - Sistema di refertazione

3. **Portale pazienti**
   - Registrazione e verifica
   - Prenotazione appuntamenti
   - Gestione consensi

### Fase 4: Testing e Deployment (Giugno 2024)
1. **Testing completo**
   - Test unitari per tutti i moduli
   - Test di integrazione
   - Test di sicurezza e GDPR
   - Utilizzo degli script bash per automatizzare l'esecuzione dei test

2. **Deployment**
   - Setup ambiente di produzione
   - Migrazione database
   - Monitoraggio e ottimizzazione
   - Utilizzo degli script bash per automatizzare il deployment

## Moduli Principali e Stato Implementazione

1. **Core (Xot)** ✅ - Completato
   - Gestione base del sistema
   - Configurazioni
   - Utility comuni

2. **Patient** 🔄 - In corso (25%)
   - Gestione pazienti
   - Gestione ISEE
   - Anamnesi e documenti

3. **Dental** ⏱️ - Da iniziare
   - Gestione visite
   - Gestione trattamenti
   - Scheda clinica

4. **Reporting** ⏱️ - Da iniziare
   - Reportistica
   - Statistiche
   - Analisi dati

5. **UI** ✅ - Completato (da aggiornare a Filament 4.x)
   - Componenti interfaccia
   - Layout responsive
   - Temi

6. **User** ✅ - Completato
   - Gestione utenti
   - Permessi (Spatie)
   - Ruoli

7. **Tenant** ✅ - Completato
   - Gestione multi-tenant
   - Configurazioni tenant
   - Isolamento dati

8. **GDPR** ✅ - Completato
   - Gestione consensi
   - Esportazione dati
   - Cancellazione dati
   
9. **Bashscripts** ✅ - Integrato
   - Automazione dei processi
   - Gestione dei moduli
   - Utility per il deployment

10. **Theme One** ✅ - Correttamente posizionato in Themes/One
    - Frontend principale
    - Layout responsivo
    - Componenti UI

## Prossimi Passi Immediati

1. **Verificare e correggere il file config/app.php**
   ```bash
   # Verificare che i service provider siano configurati correttamente
   nano /var/www/html/<nome progetto>/laravel/config/app.php
   
   # Assicurarsi che i service provider siano registrati nell'ordine corretto
   # 1. Provider di Laravel
   # 2. Provider di nwidart/laravel-modules
   # 3. Provider di Wikimedia Composer Merge Plugin
   # 4. Provider dei moduli Laraxot, in ordine di dipendenza
   ```

2. **Verificare i namespace nel tema One**
   ```bash
   # Verificare i namespace nei file PHP
   grep -r "namespace Modules\\\\ThemeOne" /var/www/html/<nome progetto>/laravel/Themes/One
   
   # Se necessario, aggiornare i namespace
   find /var/www/html/<nome progetto>/laravel/Themes/One -type f -name "*.php" | xargs sed -i 's/namespace Modules\\ThemeOne/namespace Themes\\One/g'
   
   # Verificare i riferimenti al tema
   grep -r "Modules\\\\ThemeOne" /var/www/html/<nome progetto>/laravel --include="*.php" --exclude-dir="/var/www/html/<nome progetto>/laravel/Themes/One"
   ```

3. **Correggere il problema di autoloading in composer.json**
   ```bash
   # Rimuovere la riga problematica "Modules\\": "Modules/"
   # e modificare "minimum-stability" da "stable" a "dev"
   # Modificare il file composer.json

   # Rigenerare l'autoloader
   composer dump-autoload -o
   
   # Utilizzare gli script bash per automatizzare il fix
   ./bashscripts/fix-autoloading.sh
   ```

4. **Correggere i namespace non conformi nei file PHP**
   ```bash
   # Utilizzare lo script di automazione per correggere i namespace
   cd /var/www/html/<nome progetto>/laravel
   ./bashscripts/fix-namespace.sh
   
   # Per correggere un singolo modulo
   ./bashscripts/fix-namespace.sh Chart
   
   # Rigenerare l'autoloader dopo le modifiche
   composer dump-autoload -o
   ```

5. **Completare la risoluzione dei conflitti di classe**
   ```bash
   # Analizzare classi duplicate
   find /var/www/html/<nome progetto>/laravel/Modules -type f -name "*.php" | xargs grep -l "class " | sort > classi_totali.txt
   
   # Standardizzare namespace
   # Esempio: rinominare classi in conflitto tra UI e GDPR
   ```

6. **Aggiornare le dipendenze di Filament**
   ```bash
   # Aggiornare composer.json
   composer require filament/filament:^3.1 filament/forms:^3.1 filament/tables:^3.1
   
   # Installare altre dipendenze necessarie
   composer update --with-dependencies
   ```

## Requisiti per il Completamento

Per considerare il progetto completato, i seguenti elementi devono essere funzionanti:

1. **Sistema multi-tenant** con separazione dei dati tra diversi studi odontoiatrici
2. **Gestione pazienti** con verifica ISEE e stato di gravidanza
3. **Gestione appuntamenti** e visita odontoiatrica
4. **Pannelli amministrativi** per amministratori, odontoiatri e pazienti
5. **Conformità GDPR** per la gestione di dati sanitari e personali
6. **Reportistica** per monitoraggio e analisi
7. **Automazione dei processi** tramite scripts bash
8. **Temi correttamente implementati** nella directory appropriata con namespaces corretti

## Percentuale di Completamento Globale

- **Fase 1**: Setup ambiente e architettura (100%)
- **Fase 2**: Implementazione moduli core (90%)
- **Fase 3**: Risoluzione problemi di namespace e autoloading (50%)
- **Fase 4**: Correzione struttura temi (80%)
- **Fase 5**: Implementazione backend (35%)
- **Fase 6**: Implementazione frontend (15%)
- **Fase 7**: Integrazione flussi utente (5%)
- **Fase 8**: Implementazione GDPR (30%)
- **Fase 9**: Automazione con bashscripts (60%)
- **Fase 10**: Ottimizzazione e deployment (0%)

**Stato complessivo del progetto: 42% completato** 

## Avanzamento Maggio 2025
- ✅ Moderazione centralizzata e neutra tramite risorse Filament
- ✅ Checklist operative e pre-commit integrate
- ✅ Regole di qualità automatizzate tramite file `.mdc`
- ✅ Documentazione tecnica aggiornata e linkata

### Stato avanzamento
- Moderazione e automazione: **completate**
- Documentazione tecnica: **completata**

## Collegamenti tra versioni di README.md
* [README.md](bashscripts/docs/README.md)
* [README.md](bashscripts/docs/it/README.md)
* [README.md](docs/laravel-app/phpstan/README.md)
* [README.md](docs/laravel-app/README.md)
* [README.md](docs/moduli/struttura/README.md)
* [README.md](docs/moduli/README.md)
* [README.md](docs/moduli/manutenzione/README.md)
* [README.md](docs/moduli/core/README.md)
* [README.md](docs/moduli/installati/README.md)
* [README.md](docs/moduli/comandi/README.md)
* [README.md](docs/phpstan/README.md)
* [README.md](docs/README.md)
* [README.md](docs/module-links/README.md)
* [README.md](docs/troubleshooting/git-conflicts/README.md)
* [README.md](docs/tecnico/laraxot/README.md)
* [README.md](docs/modules/README.md)
* [README.md](docs/conventions/README.md)
* [README.md](docs/amministrazione/backup/README.md)
* [README.md](docs/amministrazione/monitoraggio/README.md)
* [README.md](docs/amministrazione/deployment/README.md)
* [README.md](docs/translations/README.md)
* [README.md](docs/roadmap/README.md)
* [README.md](docs/ide/cursor/README.md)
* [README.md](docs/implementazione/api/README.md)
* [README.md](docs/implementazione/testing/README.md)
* [README.md](docs/implementazione/pazienti/README.md)
* [README.md](docs/implementazione/ui/README.md)
* [README.md](docs/implementazione/dental/README.md)
* [README.md](docs/implementazione/core/README.md)
* [README.md](docs/implementazione/reporting/README.md)
* [README.md](docs/implementazione/isee/README.md)
* [README.md](docs/it/README.md)
* [README.md](laravel/vendor/mockery/mockery/docs/README.md)
* [README.md](laravel/Modules/Chart/docs/README.md)
* [README.md](laravel/Modules/Reporting/docs/README.md)
* [README.md](laravel/Modules/Gdpr/docs/phpstan/README.md)
* [README.md](laravel/Modules/Gdpr/docs/README.md)
* [README.md](laravel/Modules/Notify/docs/phpstan/README.md)
* [README.md](laravel/Modules/Notify/docs/README.md)
* [README.md](laravel/Modules/Xot/docs/filament/README.md)
* [README.md](laravel/Modules/Xot/docs/phpstan/README.md)
* [README.md](laravel/Modules/Xot/docs/exceptions/README.md)
* [README.md](laravel/Modules/Xot/docs/README.md)
* [README.md](laravel/Modules/Xot/docs/standards/README.md)
* [README.md](laravel/Modules/Xot/docs/conventions/README.md)
* [README.md](laravel/Modules/Xot/docs/development/README.md)
* [README.md](laravel/Modules/Dental/docs/README.md)
* [README.md](laravel/Modules/User/docs/phpstan/README.md)
* [README.md](laravel/Modules/User/docs/README.md)
* [README.md](laravel/Modules/User/resources/views/docs/README.md)
* [README.md](laravel/Modules/UI/docs/phpstan/README.md)
* [README.md](laravel/Modules/UI/docs/README.md)
* [README.md](laravel/Modules/UI/docs/standards/README.md)
* [README.md](laravel/Modules/UI/docs/themes/README.md)
* [README.md](laravel/Modules/UI/docs/components/README.md)
* [README.md](laravel/Modules/Lang/docs/phpstan/README.md)
* [README.md](laravel/Modules/Lang/docs/README.md)
* [README.md](laravel/Modules/Job/docs/phpstan/README.md)
* [README.md](laravel/Modules/Job/docs/README.md)
* [README.md](laravel/Modules/Media/docs/phpstan/README.md)
* [README.md](laravel/Modules/Media/docs/README.md)
* [README.md](laravel/Modules/Tenant/docs/phpstan/README.md)
* [README.md](laravel/Modules/Tenant/docs/README.md)
* [README.md](laravel/Modules/Activity/docs/phpstan/README.md)
* [README.md](laravel/Modules/Activity/docs/README.md)
* [README.md](laravel/Modules/Patient/docs/README.md)
* [README.md](laravel/Modules/Patient/docs/standards/README.md)
* [README.md](laravel/Modules/Patient/docs/value-objects/README.md)
* [README.md](laravel/Modules/Cms/docs/blocks/README.md)
* [README.md](laravel/Modules/Cms/docs/README.md)
* [README.md](laravel/Modules/Cms/docs/standards/README.md)
* [README.md](laravel/Modules/Cms/docs/content/README.md)
* [README.md](laravel/Modules/Cms/docs/frontoffice/README.md)
* [README.md](laravel/Modules/Cms/docs/components/README.md)
* [README.md](laravel/Themes/Two/docs/README.md)
* [README.md](laravel/Themes/One/docs/README.md)

