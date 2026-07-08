# Module List

## 🏗️ Complete Module Overview

This project uses a modular architecture with 35+ independent modules managing various functional areas of the organization.

### Core Modules

#### Xot (Core Framework)
- **Purpose**: Base framework and core functionality
- **Location**: `Modules/Xot/`
- **Key Features**: Base classes, service providers, migrations

#### User (User Management)
- **Purpose**: Authentication, roles, permissions
- **Location**: `Modules/User/`
- **Key Features**: User management, authentication, authorization

#### Performance (Performance Evaluations)
- **Purpose**: Performance evaluations and management
- **Location**: `Modules/Performance/`
- **Key Features**: Performance tracking, evaluation forms

#### PresenzeAssenze (Attendance)
- **Purpose**: Attendance tracking and management
- **Location**: `Modules/PresenzeAssenze/`
- **Key Features**: Time tracking, attendance records

#### Gdpr (GDPR Compliance)
- **Purpose**: GDPR compliance and privacy management
- **Location**: `Modules/Gdpr/`
- **Key Features**: Data protection, consent management

#### Activity (Activity Logging)
- **Purpose**: Activity tracking and logging
- **Location**: `Modules/Activity/`
- **Key Features**: Audit trails, activity monitoring

### Administration Modules

#### IndennitaCondizioniLavoro
- **Purpose**: Allowances and working conditions
- **Location**: `Modules/IndennitaCondizioniLavoro/`

#### IndennitaResponsabilita
- **Purpose**: Responsibility allowances
- **Location**: `Modules/IndennitaResponsabilita/`

#### Legge104
- **Purpose**: Law 104 compliance (disability support)
- **Location**: `Modules/Legge104/`

#### Legge109
- **Purpose**: Law 109 compliance
- **Location**: `Modules/Legge109/`

#### Mensa
- **Purpose**: Cafeteria management
- **Location**: `Modules/Mensa/`

#### MobilitaVolontaria
- **Purpose**: Voluntary mobility management
- **Location**: `Modules/MobilitaVolontaria/`

#### Inail
- **Purpose**: INAIL compliance (worker safety)
- **Location**: `Modules/Inail/`

### External Integration Modules

#### Ptv (Main Integration)
- **Purpose**: Main PTV integration platform
- **Location**: `Modules/Ptv/`

#### Pdnd (Digital National Platform)
- **Purpose**: Integration with national digital platform
- **Location**: `Modules/Pdnd/`

#### Sigma (Data Integration)
- **Purpose**: Data integration and management
- **Location**: `Modules/Sigma/`

#### Europa (European Integration)
- **Purpose**: European platform integration
- **Location**: `Modules/Europa/`

### UI and Language Modules

#### UI (User Interface)
- **Purpose**: Shared UI components
- **Location**: `Modules/UI/`

#### Lang (Translations)
- **Purpose**: Multi-language support
- **Location**: `Modules/Lang/`

### Additional Modules

#### Blog
- **Purpose**: Content management and blogging
- **Location**: `Modules/Blog/`

#### Cms
- **Purpose**: Content management system
- **Location**: `Modules/Cms/`

#### ContoAnnuale
- **Purpose**: Annual accounting management
- **Location**: `Modules/ContoAnnuale/`

#### Dashboard
- **Purpose**: Dashboard and reporting system
- **Location**: `Modules/Dashboard/`

#### Europa
- **Purpose**: European integration platform
- **Location**: `Modules/Europa/`

#### Fatturazione
- **Purpose**: Invoicing and billing
- **Location**: `Modules/Fatturazione/`

#### Filemanager
- **Purpose**: File management system
- **Location**: `Modules/Filemanager/`

#### FormX
- **Purpose**: Form management system
- **Location**: `Modules/FormX/`

#### Geo
- **Purpose**: Geographic information system
- **Location**: `Modules/Geo/`

#### GeoMappa
- **Purpose**: Geographic mapping system
- **Location**: `Modules/GeoMappa/`

#### Health
- **Purpose**: Health monitoring system
- **Location**: `Modules/Health/`

#### Lfm
- **Purpose**: File manager integration
- **Location**: `Modules/Lfm/`

#### Notify
- **Purpose**: Notification system
- **Location**: `Modules/Notify/`

#### Settings
- **Purpose**: Application settings management
- **Location**: `Modules/Settings/`

#### Socialite
- **Purpose**: Social authentication
- **Location**: `Modules/Socialite/`

#### Tutorials
- **Purpose**: User tutorials and guides
- **Location**: `Modules/Tutorials/`

## 📋 Module Structure

Each module follows the same structure:

```
Modules/{ModuleName}/
├── app/{Actions,Models,Filament,Http}/
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── docs/README.md
├── resources/
│   ├── lang/
│   ├── views/
│   └── assets/
├── routes/
└── tests/
```

## 🚀 Key Development Principles

1. **Modular Isolation**: Each module should have minimal dependencies on other modules
2. **Consistent Architecture**: All modules follow the same architectural patterns
3. **Shared Base Classes**: Use Xot base classes for consistency
4. **Documentation**: Each module should have documentation in its `docs/` directory

---

**Version**: 2.0 (Refactor DRY + KISS)  
**File**: module-list.md - Complete module overview