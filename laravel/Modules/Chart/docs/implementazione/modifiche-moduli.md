# Modifiche Necessarie per i Moduli

## Modulo Patient
1. **Riorganizzazione Struttura**:
   - Spostare i file da `Entities/` a `app/Models/`
   - Spostare i file da `Http/` a `app/Http/`
   - Spostare i file da `Services/` a `app/Services/`
   - Spostare i file da `Jobs/` a `app/Jobs/`
   - Spostare i file da `Filament/` a `app/Filament/`
   - Spostare i file da `Console/` a `app/Console/`
   - Spostare i file da `Providers/` a `app/Providers/`
   - Spostare i file da `Resources/views/` a `resources/views/`
   - Spostare i file da `Routes/` a `routes/`
   - Spostare i file da `Config/` a `config/`
   - Spostare i file da `Database/` a `database/`
   - Spostare i file da `Tests/` a `tests/`

2. **Aggiunta Directory Mancanti**:
   - Creare `app/Events/`
   - Creare `app/Listeners/`
   - Creare `app/Notifications/`
   - Creare `View/`
   - Creare `docs/`
   - Creare `lang/`
   - Creare `_docs/`
   - Creare `.github/`
   - Creare `.vscode/`
   - Creare `bashscripts/`
   - Creare `workbench/`

3. **Aggiornamento Namespace**:
   - Aggiornare tutti i namespace da `Modules\Patient` a `Modules\Patient\App`

## Modulo Dental
1. **Riorganizzazione Struttura**:
   - Spostare i file da `app/Http/Controllers/` a `app/Http/Controllers/`
   - Spostare i file da `app/Providers/` a `app/Providers/`
   - Spostare i file da `resources/views/` a `resources/views/`
   - Spostare i file da `routes/` a `routes/`
   - Spostare i file da `config/` a `config/`
   - Spostare i file da `database/` a `database/`

2. **Aggiunta Directory Necessarie**:
   - Creare `app/Models/`
   - Creare `app/Services/`
   - Creare `app/Jobs/`
   - Creare `app/Filament/`
   - Creare `app/Console/`
   - Creare `app/Events/`
   - Creare `app/Listeners/`
   - Creare `app/Notifications/`
   - Creare `View/`
   - Creare `docs/`
   - Creare `lang/`
   - Creare `_docs/`
   - Creare `.github/`
   - Creare `.vscode/`
   - Creare `bashscripts/`
   - Creare `workbench/`

3. **Aggiornamento Namespace**:
   - Aggiornare tutti i namespace da `Modules\Dental` a `Modules\Dental\App`

## Modulo Reporting
1. **Riorganizzazione Struttura**:
   - Spostare i file da `app/Http/Controllers/` a `app/Http/Controllers/`
   - Spostare i file da `app/Providers/` a `app/Providers/`
   - Spostare i file da `resources/views/` a `resources/views/`
   - Spostare i file da `routes/` a `routes/`
   - Spostare i file da `config/` a `config/`
   - Spostare i file da `database/` a `database/`

2. **Aggiunta Directory Necessarie**:
   - Creare `app/Models/`
   - Creare `app/Services/`
   - Creare `app/Jobs/`
   - Creare `app/Filament/`
   - Creare `app/Console/`
   - Creare `app/Events/`
   - Creare `app/Listeners/`
   - Creare `app/Notifications/`
   - Creare `View/`
   - Creare `docs/`
   - Creare `lang/`
   - Creare `_docs/`
   - Creare `.github/`
   - Creare `.vscode/`
   - Creare `bashscripts/`
   - Creare `workbench/`

3. **Aggiornamento Namespace**:
   - Aggiornare tutti i namespace da `Modules\Reporting` a `Modules\Reporting\App`

## Dipendenze tra Moduli
1. **Patient**:
   - Dipende da: Core (User, Tenant, Activity, Media, UI)
   - Fornisce: Dati pazienti per Dental e Reporting

2. **Dental**:
   - Dipende da: Patient
   - Fornisce: Dati visite e trattamenti per Reporting

3. **Reporting**:
   - Dipende da: Patient, Dental
   - Fornisce: Report e statistiche

## Comandi per la Riorganizzazione
```bash

# Per ogni modulo (Patient, Dental, Reporting)
cd /var/www/html/<nome progetto>/laravel/Modules/[ModuleName]

# Creare le directory necessarie
mkdir -p app/{Models,Http,Services,Jobs,Filament,Console,Events,Listeners,Notifications}
mkdir -p View docs lang _docs .github .vscode bashscripts workbench

# Spostare i file nelle nuove posizioni
mv Entities/* app/Models/
mv Http/* app/Http/
mv Services/* app/Services/
mv Jobs/* app/Jobs/
mv Filament/* app/Filament/
mv Console/* app/Console/
mv Providers/* app/Providers/
mv Resources/views/* resources/views/
mv Routes/* routes/
mv Config/* config/
mv Database/* database/
mv Tests/* tests/

# Aggiornare i namespace nei file
find . -type f -name "*.php" -exec sed -i 's/Modules\\[ModuleName]/Modules\\[ModuleName]\\App/g' {} +
