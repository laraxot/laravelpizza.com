# Struttura Modulare <nome progetto>

## Struttura Generale dei Moduli

- Ogni modulo è un'unità coerente con proprio `composer.json` per namespace e autoload
- Classi in namespace `Modules\NomeModulo\` invece di `Modules\NomeModulo\app\`
- Directory minuscole (resources, config, database, app) seguono PSR-4
- `Resources` maiuscolo solo per classi PHP Resource
- Template Blade sempre in `resources/views/`

## Organizzazione Standard dei Moduli

```
Modules/NomeModulo/
├── app/                               # Directory principale del codice (minuscola)
│   ├── Actions/                       # Azioni (Queueable Actions)
│   ├── Console/                       # Comandi console
│   ├── Contracts/                     # Interfacce
│   ├── Datas/                         # Data Transfer Objects
│   ├── Filament/                      # Componenti Filament
│   │   ├── Pages/                     # Pagine Filament
│   │   ├── Resources/                 # Risorse Filament
│   │   └── Widgets/                   # Widget Filament
│   ├── Http/                          # Controllers e Middleware
│   │   ├── Controllers/               # Controllers HTTP
│   │   ├── Livewire/                  # Componenti Livewire
│   │   └── Middleware/                # Middleware HTTP
│   ├── Models/                        # Modelli Eloquent
│   └── Providers/                     # Service Providers
├── config/                            # Configurazioni
├── database/                          # Migrazioni e Seeders
│   ├── migrations/                    # Migrazioni database
│   └── seeders/                       # Seeders database
├── docs/                              # Documentazione tecnica del modulo
├── lang/                              # Traduzioni (obsoleto, usare Modules/Lang)
├── resources/                         # Risorse (viste, assets)
│   ├── js/                            # JavaScript
│   ├── sass/                          # SASS
│   └── views/                         # Viste Blade
├── routes/                            # Definizioni rotte (da evitare, usare Filament/Folio)
└── composer.json                      # Configurazione composer del modulo
```

## Namespace e Autoloading

Nel `composer.json` di ogni modulo:

```json
"autoload": {
    "psr-4": {
        "Modules\\NomeModulo\\": "app/"
    }
}
```

Questo definisce il mapping tra namespace e directory fisica, spiegando perché:
1. Il namespace è `Modules\NomeModulo\` (senza il segmento `app`)
2. La directory fisica è `app/` (in minuscolo)

## Distribuzione della Responsabilità tra Moduli

- **Xot**: Framework e funzionalità di base
- **Cms**: Frontend e visualizzazione contenuti
- **UI**: Componenti d'interfaccia utente
- **User**: Gestione utenti e autenticazione
- **Lang**: Sistema di traduzioni
- **Tenant**: Multitenant
- **Media**: Gestione file/media
- **Notify**: Sistema notifiche (email, SMS, ecc.)
- **Reporting**: Reportistica e statistiche
- **Dental**: Gestione studio dentistico
- **Patient**: Gestione pazienti
- **Gdpr**: Conformità GDPR
- **Job**: Gestione lavori in background
- **Chart**: Grafici e visualizzazioni dati

## Convenzioni Filament

- Rimuovere se restituiscono solo azioni standard, altrimenti includere `...parent::getTableActions()`
- MAI usare `->label('')` ma usare traduzioni in `lang/{locale}`
- Non estendere direttamente classi Filament ma usare `XotBase` in Xot
- Azioni form in array associativi

## Frontend

- Frontoffice con Folio+Volt+Livewire+Widget
- Niente rotte in `web.php`
- Blade in `Themes/{ThemeName}/resources/views/pages/`
- Form complessi con `@livewire(\Modules\{Module}\Filament\Widgets)`
- Widget estendono `XotBaseWidget` con `HasForms`
- Campi in `getFormSchema()`

## Documentazione Correlata

- [Architettura Modulare](../architecture/modules.md)
- [Pattern XotBase](../conventions/xotbase.md)
- [Filament in <nome progetto>](../filament/overview.md)
