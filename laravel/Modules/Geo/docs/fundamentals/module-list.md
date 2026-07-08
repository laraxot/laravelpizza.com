# Complete Module Inventory

## 🏗️ Module Architecture Overview

The PTVX system consists of 35+ independent modules, each managing specific functional areas. Modules follow strict separation of concerns and can be developed, tested, and deployed independently.

## 🎯 Core Infrastructure Modules

### Xot (Framework Base)
- **Domain**: Core framework and shared functionality
- **Path**: `Modules/Xot/`
- **Purpose**: Base classes, service providers, common utilities
- **Dependencies**: None (base module)
- **Critical**: Yes - required by all other modules

### User (Authentication & Authorization)
- **Domain**: User management and access control
- **Path**: `Modules/User/`
- **Purpose**: Authentication, roles, permissions, user profiles
- **Dependencies**: Xot
- **Critical**: Yes

## 📊 Business Domain Modules

### Performance (HR Performance Management)
- **Domain**: Employee performance evaluation
- **Path**: `Modules/Performance/`
- **Purpose**: Performance tracking, evaluations, KPI management
- **Dependencies**: User, Xot
- **Critical**: Core HR functionality

### PresenzeAssenze (Attendance Management)
- **Domain**: Time tracking and attendance
- **Path**: `Modules/PresenzeAssenze/`
- **Purpose**: Clock-in/out, leave management, attendance reporting
- **Dependencies**: User, Xot
- **Critical**: Core HR functionality

### IndennitaResponsabilita (Responsibility Allowances)
- **Domain**: Compensation management
- **Path**: `Modules/IndennitaResponsabilita/`
- **Purpose**: Responsibility-based allowances calculation and management
- **Dependencies**: User, Performance, Xot
- **Critical**: Compensation system

### IndennitaCondizioniLavoro (Working Conditions)
- **Domain**: Employment conditions and benefits
- **Path**: `Modules/IndennitaCondizioniLavoro/`
- **Purpose**: Working condition allowances, benefits management
- **Dependencies**: User, Xot
- **Critical**: Compensation system

## 🔧 Compliance & Legal Modules

### Gdpr (Data Protection)
- **Domain**: GDPR compliance
- **Path**: `Modules/Gdpr/`
- **Purpose**: Data protection, consent management, privacy compliance
- **Dependencies**: User, Xot
- **Critical**: Legal requirement

### Legge104 (Disability Support)
- **Domain**: Disability accommodation law
- **Path**: `Modules/Legge104/`
- **Purpose**: Law 104 compliance, disability support management
- **Dependencies**: User, Xot
- **Critical**: Legal compliance

### Legge109 (Work-Life Balance)
- **Domain**: Work-life balance legislation
- **Path**: `Modules/Legge109/`
- **Purpose**: Law 109 compliance, parental leave management
- **Dependencies**: User, PresenzeAssenze, Xot
- **Critical**: Legal compliance

### Inail (Work Safety)
- **Domain**: Workplace safety
- **Path**: `Modules/Inail/`
- **Purpose**: INAIL compliance, accident reporting, safety management
- **Dependencies**: User, Xot
- **Critical**: Safety compliance

## 🌐 Integration & External Systems

### Ptv (Main Integration Platform)
- **Domain**: External system integration
- **Path**: `Modules/Ptv/`
- **Purpose**: Main integration with PTV systems and workflows
- **Dependencies**: Multiple modules
- **Critical**: System integration

### Pdnd (National Digital Platform)
- **Domain**: Government digital services
- **Path**: `Modules/Pdnd/`
- **Purpose**: Integration with national digital identity platform
- **Dependencies**: User, Gdpr, Xot
- **Critical**: Government integration

### Sigma (Data Integration)
- **Domain**: Enterprise data integration
- **Path**: `Modules/Sigma/`
- **Purpose**: Data synchronization, enterprise system integration
- **Dependencies**: Multiple data modules
- **Critical**: Data integration

### Europa (European Systems)
- **Domain**: EU platform integration
- **Path**: `Modules/Europa/`
- **Purpose**: European Union system integration and compliance
- **Dependencies**: User, Gdpr, Xot
- **Critical**: International compliance

## 🎨 Presentation Layer Modules

### UI (User Interface Components)
- **Domain**: Shared UI components
- **Path**: `Modules/UI/`
- **Purpose**: Reusable UI components, themes, styling
- **Dependencies**: Xot
- **Critical**: Presentation layer

### Lang (Internationalization)
- **Domain**: Multi-language support
- **Path**: `Modules/Lang/`
- **Purpose**: Translation management, localization
- **Dependencies**: Xot
- **Critical**: Internationalization

## 🛠️ Utility & Support Modules

### Activity (Audit Logging)
- **Domain**: System activity tracking
- **Path**: `Modules/Activity/`
- **Purpose**: Audit trails, activity logging, system monitoring
- **Dependencies**: User, Xot
- **Critical**: Audit compliance

### Media (File Management)
- **Domain**: File upload and management
- **Path**: `Modules/Media/`
- **Purpose**: File storage, image processing, document management
- **Dependencies**: User, Xot
- **Critical**: Content management

### Notify (Communication)
- **Domain**: Notification system
- **Path**: `Modules/Notify/`
- **Purpose**: Email, SMS, in-app notifications
- **Dependencies**: User, Xot
- **Critical**: Communication system

### Setting (Configuration)
- **Domain**: System configuration
- **Path**: `Modules/Setting/`
- **Purpose**: Dynamic configuration, system settings
- **Dependencies**: Xot
- **Critical**: System administration

## 📋 Module Status Summary

| Category | Count | Critical | Dependencies |
|----------|-------|----------|--------------|
| Core Infrastructure | 2 | 2 | None |
| Business Domain | 4 | 4 | Multiple |
| Compliance & Legal | 4 | 4 | User, Xot |
| Integration & External | 4 | 3 | Multiple |
| Presentation Layer | 2 | 1 | Xot |
| Utility & Support | 4 | 2 | User, Xot |
| **Total** | **20+** | **16** | **Varies** |

## 🔗 Module Relationships

```
Xot (Base)
├── User (Auth)
├── UI (Components)
├── Lang (i18n)
└── Activity (Audit)
    ├── Performance (HR)
    │   ├── IndennitaResponsabilita (Comp)
    │   └── IndennitaCondizioniLavoro (Benefits)
    ├── PresenzeAssenze (Time)
    │   ├── Legge104 (Disability)
    │   └── Legge109 (Leave)
    ├── Gdpr (Privacy)
    │   ├── Pdnd (Government)
    │   └── Europa (EU)
    └── Ptv (Integration)
        └── Sigma (Data)
```

## 📚 Documentation Links

- [Architecture Rules](architecture-rules.md) - Critical rules for all modules
- [Module Structure](module-structure.md) - How to structure new modules
- [Development Tasks](../development/tasks.md) - Common module development tasks

---

**Last Updated**: December 2025  
**Total Active Modules**: 20+  
**Critical Modules**: 16
