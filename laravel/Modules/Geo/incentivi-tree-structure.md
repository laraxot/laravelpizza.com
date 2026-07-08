# 🌳 ALBERO DETTAGLIATO MODULO INCENTIVI

## 📂 STRUTTURA COMPLETA A PROFONDITÀ 4

```
laravel/Modules/Incentivi/
│
├── 📁 app/
│   ├── 📁 Actions/
│   │   ├── 📄 SpareImportoTotaleAction.php
│   │   ├── 📄 UpdateActivitiesEmployeesAction.php
│   │   └── 📄 UpdateProjectActivitiesAction.php
│   │
│   ├── 📁 Console/
│   │   └── 📁 Commands/
│   │       └── [Comandi artisan custom]
│   │
│   ├── 📁 Enums/
│   │   └── [Enumerazioni del dominio]
│   │
│   ├── 📁 Events/
│   │   └── [Event listeners]
│   │
│   ├── 📁 Filament/
│   │   ├── 📁 Actions/
│   │   │   └── [Azioni Filament custom]
│   │   │
│   │   ├── 📁 Pages/
│   │   │   └── [Pagine Filament custom]
│   │   │
│   │   ├── 📁 Resources/
│   │   │   ├── 📁 ActivityResource/
│   │   │   │   ├── 📄 ActivityResource.php
│   │   │   │   ├── 📁 Actions/
│   │   │   │   │   └── [Custom actions]
│   │   │   │   ├── 📁 Pages/
│   │   │   │   │   ├── 📄 CreateActivity.php
│   │   │   │   │   ├── 📄 EditActivity.php
│   │   │   │   │   ├── 📄 ListActivities.php
│   │   │   │   │   └── 📄 ViewActivity.php
│   │   │   │   └── 📁 RelationManagers/
│   │   │   │       └── [Gestione relazioni]
│   │   │   │
│   │   │   ├── 📁 CapitalPercentageResource/
│   │   │   │   ├── 📄 CapitalPercentageResource.php
│   │   │   │   ├── 📁 Actions/
│   │   │   │   └── 📁 Pages/
│   │   │   │       ├── 📄 CreateCapitalPercentage.php
│   │   │   │       ├── 📄 EditCapitalPercentage.php
│   │   │   │       ├── 📄 ListCapitalPercentages.php
│   │   │   │       └── 📄 ViewCapitalPercentage.php
│   │   │   │
│   │   │   ├── 📁 DefaultActivityResource/
│   │   │   │   ├── 📄 DefaultActivityResource.php
│   │   │   │   ├── 📁 Actions/
│   │   │   │   └── 📁 Pages/
│   │   │   │       ├── 📄 CreateDefaultActivity.php
│   │   │   │       ├── 📄 EditDefaultActivity.php
│   │   │   │       └── 📄 ListDefaultActivities.php
│   │   │   │
│   │   │   ├── 📁 EmployeeResource/
│   │   │   │   ├── 📄 EmployeeResource.php
│   │   │   │   ├── 📁 Actions/
│   │   │   │   └── 📁 Pages/
│   │   │   │       ├── 📄 CreateEmployee.php
│   │   │   │       ├── 📄 EditEmployee.php
│   │   │   │       ├── 📄 ListEmployees.php
│   │   │   │       └── 📄 ViewEmployee.php
│   │   │   │
│   │   │   ├── 📁 PhaseResource/
│   │   │   │   ├── 📄 PhaseResource.php
│   │   │   │   └── 📁 Pages/
│   │   │   │       ├── 📄 CreatePhase.php
│   │   │   │       ├── 📄 EditPhase.php
│   │   │   │       ├── 📄 ListPhases.php
│   │   │   │       └── 📄 ViewPhase.php
│   │   │   │
│   │   │   ├── 📁 ProjectResource/ ⭐ MAIN RESOURCE
│   │   │   │   ├── 📄 ProjectResource.php
│   │   │   │   ├── 📁 Actions/
│   │   │   │   │   ├── [Custom actions]
│   │   │   │   │   └── 📁 Table/
│   │   │   │   │       └── [Table actions]
│   │   │   │   └── 📁 Pages/
│   │   │   │       ├── 📄 CreateProject.php
│   │   │   │       ├── 📄 EditProject.php
│   │   │   │       ├── 📄 ListProjects.php
│   │   │   │       └── 📄 ViewProject.php
│   │   │   │
│   │   │   ├── 📁 SettlementResource/
│   │   │   │   ├── 📄 SettlementResource.php
│   │   │   │   └── 📁 Pages/
│   │   │   │       ├── 📄 CreateSettlement.php
│   │   │   │       ├── 📄 EditSettlement.php
│   │   │   │       ├── 📄 ListSettlements.php
│   │   │   │       └── 📄 ViewSettlement.php
│   │   │   │
│   │   │   ├── 📁 StabiDirigenteResource/
│   │   │   │   ├── 📄 StabiDirigenteResource.php
│   │   │   │   └── 📁 Pages/
│   │   │   │       ├── 📄 CreateStabiDirigente.php
│   │   │   │       ├── 📄 EditStabiDirigente.php
│   │   │   │       ├── 📄 ListStabiDirigentes.php
│   │   │   │       └── 📄 ViewStabiDirigente.php
│   │   │   │
│   │   │   └── 📁 WorkgroupResource/
│   │   │       ├── 📄 WorkgroupResource.php
│   │   │       ├── 📁 Actions/
│   │   │       │   └── [Custom actions]
│   │   │       ├── 📁 Pages/
│   │   │       │   ├── 📄 CreateWorkgroup.php
│   │   │       │   ├── 📄 EditWorkgroup.php
│   │   │       │   ├── 📄 ListWorkgroups.php
│   │   │       │   └── 📄 ViewWorkgroup.php
│   │   │       └── 📁 RelationManagers/
│   │   │           └── [Gestione relazioni]
│   │   │
│   │   └── 📁 Widgets/
│   │       └── [Widget custom per dashboard]
│   │
│   ├── 📁 Http/
│   │   ├── 📁 Controllers/
│   │   │   └── [REST API Controllers]
│   │   │
│   │   ├── 📁 Livewire/
│   │   │   └── [Componenti Livewire interattivi]
│   │   │
│   │   ├── 📁 Middleware/
│   │   │   └── [Middleware custom]
│   │   │
│   │   └── 📁 Requests/
│   │       └── [Form Request validation]
│   │
│   ├── 📁 Models/
│   │   ├── 📄 Activity.php
│   │   ├── 📄 ActivityEmployee.php
│   │   ├── 📄 BaseModel.php
│   │   ├── 📄 BasePivot.php
│   │   ├── 📄 CapitalPercentage.php
│   │   ├── 📄 DefaultActivity.php
│   │   ├── 📄 Employee.php
│   │   ├── 📄 EmployeeProject.php
│   │   ├── 📄 EmployeeWorkgroup.php
│   │   ├── 📄 Phase.php
│   │   ├── 📄 Project.php
│   │   ├── 📄 Settlement.php
│   │   ├── 📄 StabiDirigente.php
│   │   ├── 📄 Workgroup.php
│   │   │
│   │   └── 📁 Policies/ ⭐ AUTHORIZATION LAYER
│   │       ├── 📄 IncentiviBasePolicy.php (Base class)
│   │       ├── 📄 ActivityEmployeePolicy.php
│   │       ├── 📄 ActivityPolicy.php
│   │       ├── 📄 CapitalPercentagePolicy.php
│   │       ├── 📄 DefaultActivityPolicy.php
│   │       ├── 📄 EmployeePolicy.php
│   │       ├── 📄 EmployeeProjectPolicy.php
│   │       ├── 📄 EmployeeWorkgroupPolicy.php
│   │       ├── 📄 PhasePolicy.php
│   │       ├── 📄 ProjectPolicy.php
│   │       ├── 📄 SettlementPolicy.php
│   │       ├── 📄 StabiDirigentePolicy.php
│   │       └── 📄 WorkgroupPolicy.php
│   │
│   ├── 📁 Projectors/
│   │   └── [Event sourcing projectors]
│   │
│   ├── 📁 Providers/
│   │   ├── 📄 IncentiviServiceProvider.php
│   │   └── 📁 Filament/
│   │       └── 📄 AdminPanelProvider.php
│   │
│   ├── 📁 Rules/
│   │   └── [Regole di validazione custom]
│   │
│   └── 📁 View/
│       └── 📁 Components/
│           └── [Componenti Blade reusabili]
│
├── 📁 config/
│   └── [File configurazione modulo]
│
├── 📁 database/
│   ├── �� factories/
│   │   └── [Model factories per test]
│   │
│   ├── 📁 migrations/
│   │   └── [Migration script di database]
│   │
│   └── 📁 seeders/
│       └── [Database seeders]
│
├── 📁 docs/
│   ├── 📄 README.md
│   ├── 📄 CHANGELOG.md
│   ├── 📄 prd.md (Product Requirements Document)
│   ├── 📄 product-requirements.md
│   ├── 📄 roadmap.md
│   ├── 📄 test-plan.md
│   ├── 📄 analysis.md
│   ├── 📄 architecture-rules.md
│   ├── 📄 architettura-modulo.md
│   ├── 📄 conflicts.md
│   ├── 📄 troubleshooting.md
│   ├── 📄 module-icons.md
│   ├── 📄 manage-related-records-translations.md
│   ├── 📄 phpstan-report.md
│   ├── 📄 phpstan-report.txt
│   ├── 📄 phpmd-report.txt
│   ├── 📄 phpstan_report.txt
│   │
│   ├── 📁 actions/
│   │   ├── 📄 spare-importo-totale-action.md
│   │   ├── 📄 spareimportototaleaction.md
│   │   ├── 📄 update-activities-employees-action.md
│   │   ├── 📄 updateactivitiesemployeesaction.md
│   │   ├── 📄 update-project-activities-action.md
│   │   └── 📄 updateprojectactivitiesaction.md
│   │
│   ├── 📁 architettura/
│   │   └── 📄 overview.md
│   │
│   ├── 📁 html2pdf/
│   │   ├── 📄 index.md
│   │   ├── 📄 usage.md
│   │   ├── 📄 laravel.md
│   │   ├── 📄 advanced.md
│   │   ├── 📄 styling.md
│   │   └── 📄 security.md
│   │
│   └── 📁 models/
│       └── 📄 domain-model.md
│
├── 📁 lang/
│   ├── 📁 en/ (English - 3 files)
│   │   ├── 📄 manage_project_activities.php
│   │   ├── 📄 manage_project_employees.php
│   │   └── 📄 manage_project_phases.php
│   │
│   └── 📁 it/ (Italian - 54 files) ⭐ COMPLETE
│       ├── 📄 .php
│       ├── 📄 activity.php
│       ├── 📄 add_group.php
│       ├── 📄 attach_activity_employee.php
│       ├── 📄 attach_esterno.php
│       ├── 📄 attach_group.php
│       ├── 📄 attach_single_employee.php
│       ├── 📄 attivita.php
│       ├── 📄 attivita_predefinita.php
│       ├── 📄 capital_percentage.php
│       ├── 📄 capital_percentage_seeder.php
│       ├── 📄 create_activity.php
│       ├── 📄 create_phase.php
│       ├── 📄 create_project.php
│       ├── 📄 create_settlement.php
│       ├── 📄 create_workgroup.php
│       ├── 📄 default_activities_seeder.php
│       ├── 📄 default_activity.php
│       ├── 📄 dipendente.php
│       ├── 📄 edit_activity.php
│       ├── 📄 edit_phase.php
│       ├── 📄 edit_project.php
│       ├── 📄 edit_settlement.php
│       ├── 📄 edit_workgroup.php
│       ├── 📄 employee.php
│       ├── 📄 employees.php
│       ├── 📄 filament.php
│       ├── 📄 generate_p_d_f_project_report.php
│       ├── 📄 generate_p_d_f_project_report_action_spatie.php
│       ├── 📄 incentivi.php
│       ├── 📄 latest_projects.php
│       ├── 📄 manage_project_activities.php
│       ├── 📄 manage_project_employees.php
│       ├── 📄 manage_project_phases.php
│       ├── 📄 modifica_attivita.php
│       ├── 📄 modifica_gruppo_lavoro.php
│       ├── 📄 modifica_progetto.php
│       ├── 📄 percentuale_capitale.php
│       ├── �� phase.php
│       ├── 📄 project.php
│       ├── 📄 project_activities.php
│       ├── 📄 project_employees.php
│       ├── 📄 project_phases.php
│       ├── 📄 project_settlements.php
│       ├── 📄 settlement.php
│       ├── 📄 stabi_dirigente.php
│       ├── 📄 upload_empoyees.php
│       └── 📄 workgroup.php
│
├── 📁 resources/
│   ├── 📁 assets/
│   │   ├── 📁 js/
│   │   │   └── [JavaScript assets]
│   │   └── 📁 sass/
│   │       └── [SASS/CSS assets]
│   │
│   ├── 📁 svg/
│   │   └── [SVG icons]
│   │
│   └── 📁 views/
│       ├── 📁 components/
│       │   └── [Blade components]
│       │
│       ├── 📁 filament/
│       │   ├── 📁 actions/
│       │   ├── 📁 pages/
│       │   │   └── 📁 projects/
│       │   ├── 📁 pdf/
│       │   │   ├── 📁 old/
│       │   │   ├── 📁 report/
│       │   │   └── 📁 workgroup/
│       │   └── 📁 widgets/
│       │
│       └── 📁 layouts/
│           └── [Layout templates]
│
├── 📁 routes/
│   └── [Route definitions - API/Web]
│
├── 📁 tests/
│   ├── 📄 Pest.php
│   ├── 📄 TestCase.php
│   │
│   ├── 📁 Feature/
│   │   └── [Feature tests]
│   │
│   └── 📁 Unit/
│       └── 📄 ProjectTest.php
│
├── 📁 .github/
│   ├── pull_request_template.md
│   └── 📁 workflows/
│       └── [GitHub Actions workflows]
│
├── .gitignore
├── .gitconfig
├── .editorconfig
├── .releaserc.json
├── 📄 composer.json ⭐ PACKAGE CONFIG
├── 📄 module.json
├── 📄 phpunit.xml.dist
├── 📄 README.md
├── _incentivi.code-workspace
└── [altri file di configurazione]
```

---

## 📊 CONTEGGIO FILE PER CATEGORIA

| Categoria | Quantità | Tipo |
|-----------|----------|------|
| **Models** | 13 | PHP |
| **Policies** | 13 | PHP |
| **Filament Resources** | 10 | PHP |
| **Resource Pages** | ~40 | PHP |
| **Resource Actions** | ~20 | PHP |
| **Actions (Business Logic)** | 3 | PHP |
| **Controllers** | ? | PHP |
| **Livewire Components** | ? | PHP |
| **Lang Files (IT)** | 54 | PHP |
| **Lang Files (EN)** | 3 | PHP |
| **Doc Files** | 33 | MD |
| **Views** | ? | Blade |
| **Tests** | 1 | PHP |
| **Migrations** | ? | PHP |
| **Seeders** | ? | PHP |
| **Factories** | ? | PHP |

---

## 🎯 ENTRY POINTS

### Service Providers
```
- Modules\Incentivi\Providers\IncentiviServiceProvider
- Modules\Incentivi\Providers\Filament\AdminPanelProvider
```

### Main Routes
```
routes/[web.php|api.php]
```

### Configuration
```
config/incentivi.php
module.json
composer.json
```

---

**Data generazione:** 9 Marzo 2025
**Autore:** Nicola Storgato
**Modulo:** provtv/module_incentivi_fila5

