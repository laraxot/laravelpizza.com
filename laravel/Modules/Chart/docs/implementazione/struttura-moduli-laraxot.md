# Struttura dei Moduli Laraxot

## Organizzazione Base
Ogni modulo deve essere contenuto all'interno della cartella `/var/www/html/<nome progetto>/laravel/Modules` e seguire la seguente struttura:

```
Modules/
├── ModuleName/
│   ├── app/                    # Logica applicativa
│   │   ├── Models/            # Modelli del modulo
│   │   ├── Http/              # Controllers e middleware
│   │   ├── Services/          # Logica di business
│   │   ├── Events/            # Eventi del sistema
│   │   ├── Listeners/         # Gestori eventi
│   │   ├── Notifications/     # Notifiche
│   │   ├── Providers/         # Service providers
│   │   ├── Console/           # Comandi Artisan
│   │   └── Filament/          # Risorse Filament
│   ├── config/                # Configurazioni
│   ├── database/              # Migrations e seeders
│   ├── resources/             # Views e assets
│   ├── routes/                # Definizione route
│   ├── tests/                 # Test del modulo
│   ├── View/                  # Componenti Blade
│   ├── docs/                  # Documentazione
│   ├── lang/                  # Traduzioni
│   ├── _docs/                 # Documentazione interna
│   ├── .github/               # Configurazioni GitHub
│   ├── .vscode/               # Configurazioni VSCode
│   ├── bashscripts/           # Script bash
│   ├── workbench/             # Ambiente di sviluppo
│   ├── composer.json          # Dipendenze PHP
│   ├── package.json           # Dipendenze JS
│   ├── module.json            # Configurazione modulo
│   ├── phpunit.xml            # Configurazione test
│   ├── vite.config.js         # Configurazione Vite
│   ├── webpack.mix.js         # Configurazione Mix
│   ├── tailwind.config.js     # Configurazione Tailwind
│   ├── postcss.config.js      # Configurazione PostCSS
│   ├── .php-cs-fixer.dist.php # Configurazione PHP CS Fixer
│   ├── .editorconfig          # Configurazione Editor
│   ├── .gitignore             # Ignore Git
│   ├── .gitattributes         # Attributi Git
│   ├── LICENSE                # Licenza
│   ├── README.md              # Documentazione principale
│   └── CHANGELOG.md           # Log delle modifiche
```

## Regole di Implementazione

1. **Namespace**: Ogni modulo deve utilizzare il namespace `Modules\{ModuleName}`
2. **Configurazione**: Le configurazioni devono essere in `Modules/{ModuleName}/config/`
3. **Modelli**: I modelli devono essere in `Modules/{ModuleName}/app/Models/`
4. **Risorse Filament**: Le risorse Filament devono essere in `Modules/{ModuleName}/app/Filament/`
5. **Viste**: Le viste devono essere in `Modules/{ModuleName}/resources/views/`
6. **Traduzioni**: Le traduzioni devono essere in `Modules/{ModuleName}/lang/`
7. **Route**: Le route devono essere definite in `Modules/{ModuleName}/routes/`
8. **Test**: I test devono essere in `Modules/{ModuleName}/tests/`
9. **Eventi e Listener**: Gli eventi e i listener devono essere in `Modules/{ModuleName}/app/Events/` e `Modules/{ModuleName}/app/Listeners/`
10. **Jobs**: I job devono essere in `Modules/{ModuleName}/app/Jobs/`
11. **Services**: I servizi devono essere in `Modules/{ModuleName}/app/Services/`
12. **Documentazione**: La documentazione deve essere in `Modules/{ModuleName}/docs/` e `Modules/{ModuleName}/_docs/`

## Dipendenze tra Moduli
- **Core**:
  - User: Gestione utenti e permessi
  - Tenant: Gestione multi-tenant
  - Activity: Logging attività
  - Media: Gestione file
  - UI: Componenti base

- **Business**:
  - Patient: Dipende da Core
  - Dental: Dipende da Patient
  - Reporting: Dipende da Patient e Dental

- **Support**:
  - Job: Gestione code
  - Lang: Traduzioni
  - Gdpr: Privacy
  - Notify: Notifiche
  - Chart: Grafici
  - Cms: Contenuti

## Best Practices
1. **Sviluppo**:
   - Seguire PSR-12 per lo stile del codice
   - Documentare il codice con PHPDoc
   - Testare completamente ogni funzionalità
   - Versionare correttamente il codice

2. **Sicurezza**:
   - Validare tutti gli input
   - Proteggere i dati sensibili
   - Implementare logging completo
   - Garantire conformità normativa

3. **Performance**:
   - Ottimizzare le query
   - Implementare caching strategico
   - Gestire efficientemente le risorse
   - Monitorare le performance

4. **Integrazione**:
   - Utilizzare eventi e listeners per il decoupling
   - Implementare service providers per la registrazione
   - Definire contracts per le interfacce
   - Utilizzare facades quando appropriato

5. **Testing**:
   - Unit tests per i modelli
   - Feature tests per i controllers
   - Integration tests per le funzionalità
   - Performance tests per i colli di bottiglia

6. **Deployment**:
   - Aggiornare le dipendenze
   - Eseguire le migrazioni
   - Aggiornare gli assets
   - Pulire la cache
   - Verificare i test

7. **Manutenzione**:
   - Monitorare gli errori
   - Aggiornare la sicurezza
   - Ottimizzare le performance
   - Eseguire backup regolari 