# 📋 STRUTTURA COMPLETA MODULO INCENTIVI - LARAVEL

## 1️⃣ STRUTTURA DELLE CARTELLE

```
laravel/Modules/Incentivi/
├── app/                          # Codice dell'applicazione
│   ├── Actions/                  # Azioni di business logic
│   ├── Console/Commands/         # Comandi CLI
│   ├── Enums/                    # Enumerazioni
│   ├── Events/                   # Event listeners
│   ├── Filament/                 # Interfaccia Filament
│   │   ├── Actions/              # Azioni Filament
│   │   ├── Pages/                # Pagine custom
│   │   ├── Resources/            # Risorse Filament (10 risorse)
│   │   └── Widgets/              # Widget
│   ├── Http/
│   │   ├── Controllers/          # Controllori
│   │   ├── Livewire/             # Componenti Livewire
│   │   ├── Middleware/           # Middleware
│   │   └── Requests/             # Form Requests
│   ├── Models/                   # Modelli Eloquent (13 modelli)
│   │   └── Policies/             # Policies di autorizzazione (13 policies)
│   ├── Projectors/               # Event sourcing projectors
│   ├── Providers/                # Service Providers
│   │   └── Filament/             # Filament Providers
│   ├── Rules/                    # Custom validation rules
│   └── View/Components/          # Componenti View
│
├── config/                       # File di configurazione
├── database/
│   ├── factories/                # Model factories per testing
│   ├── migrations/               # Migrazioni del database
│   └── seeders/                  # Database seeders
│
├── docs/                         # Documentazione tecnica
│   ├── actions/                  # Documentazione azioni
│   ├── architettura/             # Architettura del modulo
│   ├── models/                   # Documentazione modelli
│   ├── html2pdf/                 # Guida HTML to PDF
│   ├── README.md
│   ├── CHANGELOG.md
│   ├── prd.md                    # Product Requirements Document
│   ├── roadmap.md
│   ├── test-plan.md
│   └── [altri file doc]
│
├── lang/                         # Traduzioni internazionali
│   ├── en/                       # English (3 file)
│   │   ├── manage_project_activities.php
│   │   ├── manage_project_employees.php
│   │   └── manage_project_phases.php
│   │
│   └── it/                       # Italian (54 file)
│       ├── activity.php
│       ├── attivita.php
│       ├── capital_percentage.php
│       ├── create_*.php
│       ├── edit_*.php
│       ├── filament.php
│       ├── [e altri...]
│
├── resources/
│   ├── assets/
│   │   ├── js/
│   │   └── sass/
│   ├── svg/                      # Icon SVG
│   └── views/
│       ├── components/
│       ├── filament/
│       │   ├── pages/
│       │   ├── pdf/
│       │   └── widgets/
│       └── layouts/
│
├── routes/                       # Route definitions
├── tests/                        # Test suite
│   ├── Feature/                  # Feature tests
│   ├── Unit/                     # Unit tests
│   ├── Pest.php
│   └── TestCase.php
│
├── .github/
│   └── workflows/                # GitHub Actions
│
├── composer.json                 # Dipendenze PHP
├── module.json                   # Configurazione modulo
├── phpunit.xml.dist              # PHPUnit configuration
└── README.md

```

---

## 2️⃣ MODELLI (Models)

**Ubicazione:** `/laravel/Modules/Incentivi/app/Models/`

### Modelli Principali:
| Modello | File | Descrizione |
|---------|------|-------------|
| **Activity** | Activity.php | Attività di progetto |
| **ActivityEmployee** | ActivityEmployee.php | Relazione attività-dipendente |
| **CapitalPercentage** | CapitalPercentage.php | Percentuali di capitale |
| **DefaultActivity** | DefaultActivity.php | Attività predefinite |
| **Employee** | Employee.php | Dipendenti |
| **EmployeeProject** | EmployeeProject.php | Relazione dipendente-progetto |
| **EmployeeWorkgroup** | EmployeeWorkgroup.php | Relazione dipendente-gruppo lavoro |
| **Phase** | Phase.php | Fasi di progetto |
| **Project** | Project.php | Progetti |
| **Settlement** | Settlement.php | Liquidazioni |
| **StabiDirigente** | StabiDirigente.php | Dirigenti stabili |
| **Workgroup** | Workgroup.php | Gruppi di lavoro |
| **BaseModel** | BaseModel.php | Classe base per modelli |
| **BasePivot** | BasePivot.php | Classe base per pivot tables |

**Totale Modelli:** 13

---

## 3️⃣ POLICIES (Autorizzazione)

**Ubicazione:** `/laravel/Modules/Incentivi/app/Models/Policies/`

**13 Policies implementate:**

| Policy | Modello |
|--------|---------|
| ActivityEmployeePolicy | ActivityEmployee |
| ActivityPolicy | Activity |
| CapitalPercentagePolicy | CapitalPercentage |
| DefaultActivityPolicy | DefaultActivity |
| EmployeePolicy | Employee |
| EmployeeProjectPolicy | EmployeeProject |
| EmployeeWorkgroupPolicy | EmployeeWorkgroup |
| IncentiviBasePolicy | Base class |
| PhasePolicy | Phase |
| ProjectPolicy | Project |
| SettlementPolicy | Settlement |
| StabiDirigentePolicy | StabiDirigente |
| WorkgroupPolicy | Workgroup |

**Caratteristiche:**
- ✅ Autorizzazioni specifiche per stati progetto
- ✅ Ruoli: Admin, HR, Finance, Responsabili Workgroup
- ✅ Controlli per workgroup e assegnazioni
- ✅ Logica di business completa

---

## 4️⃣ AZIONI (Actions)

**Ubicazione:** `/laravel/Modules/Incentivi/app/Actions/`

| Azione | File | Descrizione |
|--------|------|-------------|
| SpareImportoTotaleAction | SpareImportoTotaleAction.php | Calcolo importo totale |
| UpdateActivitiesEmployeesAction | UpdateActivitiesEmployeesAction.php | Aggiorna attività dipendenti |
| UpdateProjectActivitiesAction | UpdateProjectActivitiesAction.php | Aggiorna attività progetto |

**Totale Azioni:** 3

---

## 5️⃣ RISORSE FILAMENT

**Ubicazione:** `/laravel/Modules/Incentivi/app/Filament/Resources/`

### 10 Risorse Filament Implementate:

#### 1. **ActivityResource**
   - Pages: Create, Edit, List, View
   - Actions: Custom actions
   - RelationManagers: Gestione relazioni

#### 2. **CapitalPercentageResource**
   - Pages: Create, Edit, List, View
   - Actions: Custom actions

#### 3. **DefaultActivityResource**
   - Pages: Create, Edit, List, View
   - Actions: Custom actions

#### 4. **EmployeeResource**
   - Pages: Create, Edit, List, View
   - Actions: Custom actions

#### 5. **PhaseResource**
   - Pages: Create, Edit, List, View

#### 6. **ProjectResource** ⭐ (Risorsa principale)
   - Pages: Create, Edit, List, View
   - Actions: Nested resources
   - Table Actions: Azioni in tabella

#### 7. **SettlementResource**
   - Pages: Create, Edit, List, View

#### 8. **StabiDirigenteResource**
   - Pages: Create, Edit, List, View

#### 9. **WorkgroupResource**
   - Pages: Create, Edit, List, View
   - Actions: Custom actions
   - RelationManagers: Gestione relazioni

#### 10. **Pagine Filament Custom**
   - Custom pages per gestione progetti
   - Pagine specifiche per PDF e report

---

## 6️⃣ TEST

**Ubicazione:** `/laravel/Modules/Incentivi/tests/`

### Test Esistenti:

| File | Tipo | Descrizione |
|------|------|-------------|
| **Unit/ProjectTest.php** | Unit | Test unitari per Project |
| **TestCase.php** | Base | Classe base per test |
| **Pest.php** | Config | Configurazione Pest PHP |

**Totale Test:** 1 test file attivo

**Framework:** Pest PHP

---

## 7️⃣ DOCUMENTAZIONE (docs/)

**Ubicazione:** `/laravel/Modules/Incentivi/docs/`

### Documenti Disponibili:

#### 📚 Principale:
- **README.md** - Documentazione principale
- **CHANGELOG.md** - Cronologia versioni
- **prd.md** / **product-requirements.md** - Requisiti prodotto
- **roadmap.md** - Piano di sviluppo
- **test-plan.md** - Piano test

#### 🏗️ Architettura:
- **architettura-modulo.md** - Struttura complessiva
- **architettura/overview.md** - Visione d'insieme
- **architecture-rules.md** - Regole architetturali

#### 📋 Analisi Tecnica:
- **analysis.md** - Analisi del modulo
- **models/domain-model.md** - Domain model diagram
- **conflicts.md** - Conflitti noti
- **phpstan-report.md** - Rapporto PHPStan (level 9)
- **phpmd-report.txt** - Rapporto PHPMD

#### 🛠️ Documentazione Specifiche:
- **actions/** - Documentazione azioni (6 file)
  - spare-importo-totale-action.md
  - update-activities-employees-action.md
  - update-project-activities-action.md

- **html2pdf/** - Guida HTML to PDF (6 file)
  - index.md
  - usage.md
  - laravel.md
  - advanced.md
  - styling.md
  - security.md

#### 📝 Altre Documentazioni:
- **module-icons.md** - Icone del modulo
- **manage-related-records-translations.md** - Gestione traduzioni
- **troubleshooting.md** - Guida troubleshooting

**Totale file documentazione:** 33 file

---

## 8️⃣ TRADUZIONI (lang/)

**Ubicazione:** `/laravel/Modules/Incentivi/lang/`

### Lingue Supportate:

#### 🇮🇹 **ITALIANO (54 file)**
```
├── activity.php
├── attivita.php
├── add_group.php
├── attach_activity_employee.php
├── attach_esterno.php
├── attach_group.php
├── attach_single_employee.php
├── attivita_predefinita.php
├── capital_percentage.php
├── capital_percentage_seeder.php
├── create_activity.php
├── create_phase.php
├── create_project.php
├── create_settlement.php
├── create_workgroup.php
├── default_activities_seeder.php
├── default_activity.php
├── dipendente.php
├── edit_activity.php
├── edit_phase.php
├── edit_project.php
├── edit_settlement.php
├── edit_workgroup.php
├── employee.php
├── employees.php
├── filament.php                      ⭐ Traduzioni Filament
├── generate_p_d_f_project_report.php
├── generate_p_d_f_project_report_action_spatie.php
├── incentivi.php                     ⭐ Traduzioni principali
├── latest_projects.php
├── manage_project_activities.php
├── manage_project_employees.php
├── manage_project_phases.php
├── modifica_attivita.php
├── modifica_gruppo_lavoro.php
├── modifica_progetto.php
├── percentuale_capitale.php
├── phase.php
├── project.php
├── project_activities.php
├── project_employees.php
├── project_phases.php
├── project_settlements.php
├── settlement.php
├── stabi_dirigente.php
├── upload_empoyees.php
├── workgroup.php
├── workgroup_seeder.php
└── .php (file vuoto)
```

#### 🇬🇧 **ENGLISH (3 file)**
```
├── manage_project_activities.php
├── manage_project_employees.php
└── manage_project_phases.php
```

### Copertura Lingue:
- ✅ **Italiano:** Completamente tradotto (54 file)
- ✅ **English:** Parzialmente (3 file)
- ❌ **Deutsch:** Non presente

---

## 9️⃣ COMPOSER.JSON

**Ubicazione:** `/laravel/Modules/Incentivi/composer.json`

```json
{
  "name": "provtv/module_incentivi_fila5",
  "description": "Employee incentives and bonuses module for the Laraxot ecosystem: performance bonuses, productivity rewards, and PDF reports.",
  
  "keywords": [
    "laraxot", "laravel", "filament", "module_incentivi",
    "incentives", "bonuses", "performance-rewards",
    "pdf-reports", "hr"
  ],
  
  "authors": [
    {
      "name": "Nicola Storgato",
      "email": "storgatonicola@provincia.treviso.it"
    }
  ],
  
  "extra": {
    "laravel": {
      "providers": [
        "Modules\\Incentivi\\Providers\\IncentiviServiceProvider",
        "Modules\\Incentivi\\Providers\\Filament\\AdminPanelProvider"
      ],
      "aliases": {}
    }
  },
  
  "autoload": {
    "psr-4": {
      "Modules\\Incentivi\\": "app/",
      "Modules\\Incentivi\\Database\\Factories\\": "database/factories/",
      "Modules\\Incentivi\\Database\\Seeders\\": "database/seeders/"
    }
  },
  
  "require": {
    "spatie/laravel-pdf": "^1.5"
  },
  
  "autoload-dev": {
    "psr-4": {
      "Modules\\Incentivi\\Tests\\": "tests/"
    }
  },
  
  "minimum-stability": "dev",
  "prefer-stable": true
}
```

### Dipendenze Principali:
- **spatie/laravel-pdf** (^1.5) - Generazione PDF

### Commenti Repository:
- provtv/filament-nested-resources (non attualmente in use)

---

## 🔟 COMPONENTI AGGIUNTIVI

### Console Commands
```
app/Console/Commands/
├── [Comandi custom]
```

### Enums
```
app/Enums/
├── [Enumerazioni dominio]
```

### Events
```
app/Events/
├── [Event listeners]
```

### Widgets Filament
```
app/Filament/Widgets/
├── [Widget custom]
```

### Controllers HTTP
```
app/Http/Controllers/
├── [Controller REST API]
```

### Livewire Components
```
app/Http/Livewire/
├── [Componenti interattivi]
```

### Validation Rules
```
app/Rules/
├── [Regole validazione custom]
```

### Service Providers
```
app/Providers/
├── IncentiviServiceProvider.php
└── Filament/AdminPanelProvider.php
```

---

## 📊 STATISTICHE RIEPILOGATIVE

| Categoria | Quantità | Note |
|-----------|----------|-------|
| **Modelli** | 13 | Activity, Employee, Project, Workgroup, Phase, Settlement, etc. |
| **Policies** | 13 | Authorization logic complete |
| **Filament Resources** | 10 | ActivityResource, ProjectResource, EmployeeResource, etc. |
| **Azioni** | 3 | SpareImportoTotale, UpdateActivities, UpdateProjectActivities |
| **Test Files** | 1 | Unit test per Project |
| **Doc Files** | 33 | Architettura, API, troubleshooting, etc. |
| **Linguaggi** | 2 | Italiano (54), English (3) |
| **DB Migrations** | ? | database/migrations/ |
| **Factories** | ? | database/factories/ |
| **Seeders** | ? | database/seeders/ |

---

## 🚀 PROVIDER REGISTRATION

```php
// Providers registrati in composer.json:
- Modules\Incentivi\Providers\IncentiviServiceProvider
- Modules\Incentivi\Providers\Filament\AdminPanelProvider
```

---

## 📝 NOTE IMPORTANTI

1. ✅ **Modulo completamente strutturato** con architettura modulare
2. ✅ **13 Policies complete** per controllo accesso granulare
3. ✅ **10 Risorse Filament** per gestione completa dati
4. ⚠️ **Lingue:** Italiano completo, English parziale, Deutsch non presente
5. 📚 **Documentazione estesa** con piani tecnici e PRD
6. 🧪 **Test suite** con Pest PHP (estensibile)
7. 📄 **PDF support** via Spatie Laravel PDF per report e liquidazioni

---

**Ultimo aggiornamento:** 9 Marzo 2025
**Autore:** Nicola Storgato
**Repository:** provtv/module_incentivi_fila5

