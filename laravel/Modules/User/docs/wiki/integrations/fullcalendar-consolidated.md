---
title: "fullcalendar: Consolidated Documentation"
module: user
type: integration
tags: [integrations, modules, user]
created: 2026-08-24
updated: 2026-08-24
status: draft
qmd: "fullcalendar   consolidated documentation user"
---

# fullcalendar: Consolidated Documentation

Consolidated from **13** individual files.

## Table of Contents

- [---](#fullcalendar-scheduler-documentation-summary-3)
- [---](#fullcalendar-scheduler-documentation-summary)
- [---](#fullcalendar-scheduler-license-key-invalid)
- [---](#fullcalendar-scheduler-license-troubleshooting)
- [---](#fullcalendar-scheduler-license)
- [---](#fullcalendar-scheduler-quick-reference-3)
- [---](#fullcalendar-scheduler-quick-reference)
- [---](#fullcalendar-schedulerocumentation)
- [FullCalendar Scheduler - Documentazione Completa](#fullcalendar_scheduler_documentation_summary)
- [FullCalendar Scheduler License Configuration](#fullcalendar_scheduler_license)
- [ ](#fullcalendar_scheduler_license_key_invalid)
- [FullCalendar Scheduler License - Troubleshooting e Configurazione Avanzata](#fullcalendar_scheduler_license_troubleshooting)
- [FullCalendar Scheduler - Riferimento Rapido](#fullcalendar_scheduler_quick_reference)

---

## fullcalendar-scheduler-documentation-summary-3

*Consolidated from: `fullcalendar-scheduler-documentation-summary.md`*
*Consolidated from: `fullcalendar-scheduler-documentation-summary-panoramica.md`*

title: "FullCalendar Scheduler - Documentazione Completa"
type: concept
tags: [fullcalendar, scheduler, documentation, summary]
created: 2026-07-14
updated: 2026-07-14
qmd: "fullcalendar-scheduler-documentation-summary-3 fullcalendar scheduler - documentazione completa"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# FullCalendar Scheduler - Documentazione Completa

## Panoramica

Questa documentazione fornisce una guida completa per la gestione delle licenze FullCalendar Scheduler nel progetto healthcare_app, basata sulla ricerca approfondita della documentazione ufficiale e dei problemi comuni riscontrati nella community.

## Documenti Disponibili

### 📚 Documentazione Principale

#### 1. [FullCalendar Scheduler Troubleshooting](./fullcalendar-scheduler-license-troubleshooting.md)
**Documento principale** - Guida completa e dettagliata che copre:
- Tipi di licenza disponibili (Commerciale, Non-Profit, GPLv3)
- Problemi comuni e soluzioni dettagliate
- Configurazione completa per Laravel/Filament
- Best practices per healthcare_app
- Testing e debugging avanzato
- Sicurezza e gestione ambienti

#### 2. [FullCalendar Quick Reference](./fullcalendar-scheduler-quick-reference.md)
**Riferimento rapido** - Soluzioni immediate per:
- Errori più comuni con fix immediati
- Checklist di verifica
- Configurazioni essenziali
- Comandi di debug

### 📖 Documentazione Esistente (Aggiornata)

#### 3. [FullCalendar Scheduler License](./fullcalendar-scheduler-license.md)
Documentazione base esistente per:
- Panoramica generale licenze
- Configurazione di base in healthcare_app
- Problemi comuni basilari

#### 4. [Scheduler License Key](./scheduler-license-key.md)
#### 4. [Scheduler License Key](../../scheduler-license-key-fullcalendar.md)
Guida rapida esistente per:
- Uso base delle chiavi licenza
- Problemi di formato chiavi
- Informazioni di supporto

## Problemi Risolti dalla Documentazione

### 🔍 Ricerca Effettuata

La documentazione è basata su ricerca approfondita di:
- **Documentazione ufficiale FullCalendar**: https://fullcalendar.io/docs/schedulerLicenseKey
- **GitHub Issues**: Analisi di 17+ issue relativi a problemi di licenza
- **Community feedback**: Problemi ricorrenti nelle versioni 5.x e 6.x
- **Best practices**: Configurazioni ottimali per ambienti di produzione

### 🐛 Bug Noti Documentati

1. **"Unknown option 'schedulerLicenseKey'" (v5.x-6.x)**
   - Causa: Plugin premium non importato
   - Workaround: Import esplicito plugin + BASE_OPTION_REFINERS

2. **TypeScript/Angular Issues**
   - Problema: Opzione non riconosciuta in strict mode
   - Soluzione: Cast `any` e `@ts-ignore`

3. **React/Vite Export Issues (v6.x)**
   - Problema: BASE_OPTION_DEFAULTS non esportato
   - Soluzione: Workaround con ignore directives

### 🎯 Soluzioni Specifiche healthcare_app

La documentazione include configurazioni specifiche per:
- **Multi-tenancy**: Isolamento dati per studio
- **Business hours sanitarie**: Lun-Sab 08:00-19:00
- **Validazioni mediche**: Slot 30 minuti, durate min/max
- **Sicurezza sanitaria**: Audit trail, privacy pazienti
- **Performance**: Caching, lazy loading, rate limiting

## Struttura Implementazione

### 🏗️ Architettura

```
healthcare_app FullCalendar Implementation
├── AdminPanelProvider.php (Configurazione centrale)
├── config/fullcalendar.php (Configurazioni avanzate)
├── .env (Variabili licenza)
└── Widgets/
    ├── PatientCalendarWidget.php
    ├── DoctorCalendarWidget.php
    └── AdminCalendarWidget.php
```

### 🔧 Configurazione Completa

La documentazione copre tutti i livelli:
1. **Ambiente** (.env variables)
2. **Configurazione** (config files)
3. **Provider** (AdminPanelProvider)
4. **Widget** (Calendar widgets)
5. **Frontend** (JavaScript callbacks)

## Utilizzo della Documentazione

### 🚀 Per Sviluppatori

1. **Primo setup**: Leggere [Quick Reference](./fullcalendar-scheduler-quick-reference.md)
2. **Problemi specifici**: Consultare [Troubleshooting](./fullcalendar-scheduler-license-troubleshooting.md)
3. **Configurazione avanzata**: Seguire esempi completi nel troubleshooting

### 🔧 Per Troubleshooting

1. **Errore immediato**: Usare Quick Reference per fix rapidi
2. **Problema persistente**: Seguire guida completa troubleshooting
3. **Debug avanzato**: Utilizzare comandi e tecniche documentate

### 📋 Per Deployment

1. **Checklist pre-produzione**: Seguire checklist nel Quick Reference
2. **Configurazione sicurezza**: Implementare best practices documentate
3. **Monitoring**: Utilizzare tecniche di logging documentate

## Aggiornamenti e Manutenzione

### 📅 Versioning

La documentazione è aggiornata per:
- **FullCalendar v6.1.17** (latest)
- **Filament v3.x**
- **Laravel 11.x/12.x**
- **healthcare_app current architecture**

### 🔄 Aggiornamenti Futuri

Quando aggiornare la documentazione:
- Nuove versioni FullCalendar con breaking changes
- Nuovi bug noti nella community
- Modifiche architettura healthcare_app
- Nuovi requisiti sanitari/legali

### 📝 Contributi

Per aggiornare la documentazione:
1. Verificare issue GitHub FullCalendar
2. Testare soluzioni in ambiente healthcare_app
3. Aggiornare documenti pertinenti
4. Aggiornare questo summary

## Risorse Esterne

### 🌐 Link Ufficiali
- [FullCalendar Docs](https://fullcalendar.io/docs/)
- [Scheduler License](https://fullcalendar.io/docs/schedulerLicenseKey)
- [Pricing](https://fullcalendar.io/pricing/)
- [Support](https://fullcalendar.io/support/)

### 🐛 Community
- [GitHub Issues](https://github.com/fullcalendar/fullcalendar/issues)
- [Stack Overflow](https://stackoverflow.com/questions/tagged/fullcalendar)

### 📧 Supporto Commerciale
- **Sales**: sales@fullcalendar.io
- **Technical**: Tramite GitHub Issues
- **License renewal**: Email notifications automatiche

## Conclusioni

Questa documentazione fornisce una copertura completa per tutti gli aspetti delle licenze FullCalendar Scheduler in healthcare_app, dalla configurazione iniziale al troubleshooting avanzato. La combinazione di guida dettagliata e riferimento rapido garantisce supporto sia per sviluppatori esperti che per nuovi team members.

**Documenti chiave da consultare:**
1. **Setup iniziale**: Quick Reference
2. **Problemi complessi**: Troubleshooting completo
3. **Riferimento quotidiano**: Quick Reference checklist
4. **Configurazione produzione**: Best practices nel troubleshooting

La documentazione è progettata per essere autosufficiente e ridurre la necessità di ricerche esterne, fornendo tutte le informazioni necessarie per una gestione efficace delle licenze FullCalendar Scheduler nel contesto sanitario di healthcare_app. 
---

## fullcalendar-scheduler-documentation-summary

*Consolidated from: `fullcalendar-scheduler-documentation-summary.md`*

title: "FullCalendar Scheduler - Documentazione Completa"
type: concept
tags: [fullcalendar, scheduler, documentation, summary]
created: 2026-07-14
updated: 2026-07-14
qmd: "fullcalendar-scheduler-documentation-summary fullcalendar scheduler - documentazione completa"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# FullCalendar Scheduler - Documentazione Completa

## Panoramica
Questa documentazione fornisce una guida completa per la gestione delle licenze FullCalendar Scheduler nel progetto , basata sulla ricerca approfondita della documentazione ufficiale e dei problemi comuni riscontrati nella community.
Questa documentazione fornisce una guida completa per la gestione delle licenze FullCalendar Scheduler nel progetto <nome progetto>, basata sulla ricerca approfondita della documentazione ufficiale e dei problemi comuni riscontrati nella community.
## Documenti Disponibili
### 📚 Documentazione Principale
#### 1. [FullCalendar Scheduler Troubleshooting](./fullcalendar-scheduler-license-troubleshooting.md)
**Documento principale** - Guida completa e dettagliata che copre:
- Tipi di licenza disponibili (Commerciale, Non-Profit, GPLv3)
- Problemi comuni e soluzioni dettagliate
- Configurazione completa per Laravel/Filament
- Best practices per
- Best practices per <nome progetto>
- Testing e debugging avanzato
- Sicurezza e gestione ambienti
#### 2. [FullCalendar Quick Reference](./fullcalendar-scheduler-quick-reference.md)
**Riferimento rapido** - Soluzioni immediate per:
- Errori più comuni con fix immediati
- Checklist di verifica
- Configurazioni essenziali
- Comandi di debug
### 📖 Documentazione Esistente (Aggiornata)
#### 3. [FullCalendar Scheduler License](./fullcalendar-scheduler-license.md)
Documentazione base esistente per:
- Panoramica generale licenze
- Configurazione di base in
- Configurazione di base in <nome progetto>
- Problemi comuni basilari
#### 4. [Scheduler License Key](./scheduler-license-key.md)
#### 4. [Scheduler License Key](../../scheduler-license-key-fullcalendar.md)
Guida rapida esistente per:
- Uso base delle chiavi licenza
- Problemi di formato chiavi
- Informazioni di supporto
## Problemi Risolti dalla Documentazione
### 🔍 Ricerca Effettuata
La documentazione è basata su ricerca approfondita di:
- **Documentazione ufficiale FullCalendar**: https://fullcalendar.io/project_docs/schedulerLicenseKey
- **Documentazione ufficiale FullCalendar**: https://fullcalendar.io/docs/schedulerLicenseKey
- **GitHub Issues**: Analisi di 17+ issue relativi a problemi di licenza
- **Community feedback**: Problemi ricorrenti nelle versioni 5.x e 6.x
- **Best practices**: Configurazioni ottimali per ambienti di produzione
### 🐛 Bug Noti Documentati
1. **"Unknown option 'schedulerLicenseKey'" (v5.x-6.x)**
   - Causa: Plugin premium non importato
   - Workaround: Import esplicito plugin + BASE_OPTION_REFINERS
2. **TypeScript/Angular Issues**
   - Problema: Opzione non riconosciuta in strict mode
   - Soluzione: Cast `any` e `@ts-ignore`
3. **React/Vite Export Issues (v6.x)**
   - Problema: BASE_OPTION_DEFAULTS non esportato
   - Soluzione: Workaround con ignore directives
### 🎯 Soluzioni Specifiche
### 🎯 Soluzioni Specifiche <nome progetto>
La documentazione include configurazioni specifiche per:
- **Multi-tenancy**: Isolamento dati per studio
- **Business hours sanitarie**: Lun-Sab 08:00-19:00
- **Validazioni mediche**: Slot 30 minuti, durate min/max
- **Sicurezza sanitaria**: Audit trail, privacy pazienti
- **Performance**: Caching, lazy loading, rate limiting
## Struttura Implementazione
### 🏗️ Architettura
```
 FullCalendar Implementation
<nome progetto> FullCalendar Implementation
├── AdminPanelProvider.php (Configurazione centrale)
├── config/fullcalendar.php (Configurazioni avanzate)
├── .env (Variabili licenza)
└── Widgets/
    ├── PatientCalendarWidget.php
    ├── DoctorCalendarWidget.php
    └── AdminCalendarWidget.php
### 🔧 Configurazione Completa
La documentazione copre tutti i livelli:
1. **Ambiente** (.env variables)
2. **Configurazione** (config files)
3. **Provider** (AdminPanelProvider)
4. **Widget** (Calendar widgets)
5. **Frontend** (JavaScript callbacks)
## Utilizzo della Documentazione
### 🚀 Per Sviluppatori
1. **Primo setup**: Leggere [Quick Reference](./fullcalendar-scheduler-quick-reference.md)
2. **Problemi specifici**: Consultare [Troubleshooting](./fullcalendar-scheduler-license-troubleshooting.md)
3. **Configurazione avanzata**: Seguire esempi completi nel troubleshooting
### 🔧 Per Troubleshooting
1. **Errore immediato**: Usare Quick Reference per fix rapidi
2. **Problema persistente**: Seguire guida completa troubleshooting
3. **Debug avanzato**: Utilizzare comandi e tecniche documentate
### 📋 Per Deployment
1. **Checklist pre-produzione**: Seguire checklist nel Quick Reference
2. **Configurazione sicurezza**: Implementare best practices documentate
3. **Monitoring**: Utilizzare tecniche di logging documentate
## Aggiornamenti e Manutenzione
### 📅 Versioning
La documentazione è aggiornata per:
- **FullCalendar v6.1.17** (latest)
- **Filament v3.x**
- **Laravel 11.x/12.x**
- ** current architecture**
- **<nome progetto> current architecture**
### 🔄 Aggiornamenti Futuri
Quando aggiornare la documentazione:
- Nuove versioni FullCalendar con breaking changes
- Nuovi bug noti nella community
- Modifiche architettura
- Modifiche architettura <nome progetto>
- Nuovi requisiti sanitari/legali
### 📝 Contributi
Per aggiornare la documentazione:
1. Verificare issue GitHub FullCalendar
2. Testare soluzioni in ambiente
2. Testare soluzioni in ambiente <nome progetto>
3. Aggiornare documenti pertinenti
4. Aggiornare questo summary
## Risorse Esterne
### 🌐 Link Ufficiali
- [FullCalendar Docs](https://fullcalendar.io/project_docs/)
- [Scheduler License](https://fullcalendar.io/project_docs/schedulerLicenseKey)
- [FullCalendar Docs](https://fullcalendar.io/docs/)
- [Scheduler License](https://fullcalendar.io/docs/schedulerLicenseKey)
- [Pricing](https://fullcalendar.io/pricing/)
- [Support](https://fullcalendar.io/support/)
### 🐛 Community
- [GitHub Issues](https://github.com/fullcalendar/fullcalendar/issues)
- [Stack Overflow](https://stackoverflow.com/questions/tagged/fullcalendar)
### 📧 Supporto Commerciale
- **Sales**: sales@fullcalendar.io
- **Technical**: Tramite GitHub Issues
- **License renewal**: Email notifications automatiche
## Conclusioni
Questa documentazione fornisce una copertura completa per tutti gli aspetti delle licenze FullCalendar Scheduler in , dalla configurazione iniziale al troubleshooting avanzato. La combinazione di guida dettagliata e riferimento rapido garantisce supporto sia per sviluppatori esperti che per nuovi team members.
Questa documentazione fornisce una copertura completa per tutti gli aspetti delle licenze FullCalendar Scheduler in <nome progetto>, dalla configurazione iniziale al troubleshooting avanzato. La combinazione di guida dettagliata e riferimento rapido garantisce supporto sia per sviluppatori esperti che per nuovi team members.
**Documenti chiave da consultare:**
1. **Setup iniziale**: Quick Reference
2. **Problemi complessi**: Troubleshooting completo
3. **Riferimento quotidiano**: Quick Reference checklist
4. **Configurazione produzione**: Best practices nel troubleshooting
La documentazione è progettata per essere autosufficiente e ridurre la necessità di ricerche esterne, fornendo tutte le informazioni necessarie per una gestione efficace delle licenze FullCalendar Scheduler nel contesto sanitario di .
La documentazione è progettata per essere autosufficiente e ridurre la necessità di ricerche esterne, fornendo tutte le informazioni necessarie per una gestione efficace delle licenze FullCalendar Scheduler nel contesto sanitario di <nome progetto>.
# FullCalendar Scheduler - Documentazione Completa

## Panoramica

Questa documentazione fornisce una guida completa per la gestione delle licenze FullCalendar Scheduler nel progetto <nome progetto>, basata sulla ricerca approfondita della documentazione ufficiale e dei problemi comuni riscontrati nella community.

## Documenti Disponibili

### 📚 Documentazione Principale

#### 1. [FullCalendar Scheduler Troubleshooting](./fullcalendar-scheduler-license-troubleshooting.md)
**Documento principale** - Guida completa e dettagliata che copre:
- Tipi di licenza disponibili (Commerciale, Non-Profit, GPLv3)
- Problemi comuni e soluzioni dettagliate
- Configurazione completa per Laravel/Filament
- Best practices per <nome progetto>
- Testing e debugging avanzato
- Sicurezza e gestione ambienti

#### 2. [FullCalendar Quick Reference](./fullcalendar-scheduler-quick-reference.md)
**Riferimento rapido** - Soluzioni immediate per:
- Errori più comuni con fix immediati
- Checklist di verifica
- Configurazioni essenziali
- Comandi di debug

### 📖 Documentazione Esistente (Aggiornata)

#### 3. [FullCalendar Scheduler License](./fullcalendar-scheduler-license.md)
Documentazione base esistente per:
- Panoramica generale licenze
- Configurazione di base in <nome progetto>
- Problemi comuni basilari

#### 4. [Scheduler License Key](./scheduler-license-key.md)
#### 4. [Scheduler License Key](./scheduler-license-key-fullcalendar.md)
Guida rapida esistente per:
- Uso base delle chiavi licenza
- Problemi di formato chiavi
- Informazioni di supporto

## Problemi Risolti dalla Documentazione

### 🔍 Ricerca Effettuata

La documentazione è basata su ricerca approfondita di:
- **Documentazione ufficiale FullCalendar**: https://fullcalendar.io/docs/schedulerLicenseKey
- **GitHub Issues**: Analisi di 17+ issue relativi a problemi di licenza
- **Community feedback**: Problemi ricorrenti nelle versioni 5.x e 6.x
- **Best practices**: Configurazioni ottimali per ambienti di produzione

### 🐛 Bug Noti Documentati

1. **"Unknown option 'schedulerLicenseKey'" (v5.x-6.x)**
   - Causa: Plugin premium non importato
   - Workaround: Import esplicito plugin + BASE_OPTION_REFINERS

2. **TypeScript/Angular Issues**
   - Problema: Opzione non riconosciuta in strict mode
   - Soluzione: Cast `any` e `@ts-ignore`

3. **React/Vite Export Issues (v6.x)**
   - Problema: BASE_OPTION_DEFAULTS non esportato
   - Soluzione: Workaround con ignore directives

### 🎯 Soluzioni Specifiche <nome progetto>

La documentazione include configurazioni specifiche per:
- **Multi-tenancy**: Isolamento dati per studio
- **Business hours sanitarie**: Lun-Sab 08:00-19:00
- **Validazioni mediche**: Slot 30 minuti, durate min/max
- **Sicurezza sanitaria**: Audit trail, privacy pazienti
- **Performance**: Caching, lazy loading, rate limiting

## Struttura Implementazione

### 🏗️ Architettura

```
<nome progetto> FullCalendar Implementation
├── AdminPanelProvider.php (Configurazione centrale)
├── config/fullcalendar.php (Configurazioni avanzate)
├── .env (Variabili licenza)
└── Widgets/
    ├── PatientCalendarWidget.php
    ├── DoctorCalendarWidget.php
    └── AdminCalendarWidget.php
```

### 🔧 Configurazione Completa

La documentazione copre tutti i livelli:
1. **Ambiente** (.env variables)
2. **Configurazione** (config files)
3. **Provider** (AdminPanelProvider)
4. **Widget** (Calendar widgets)
5. **Frontend** (JavaScript callbacks)

## Utilizzo della Documentazione

### 🚀 Per Sviluppatori

1. **Primo setup**: Leggere [Quick Reference](./fullcalendar-scheduler-quick-reference.md)
2. **Problemi specifici**: Consultare [Troubleshooting](./fullcalendar-scheduler-license-troubleshooting.md)
3. **Configurazione avanzata**: Seguire esempi completi nel troubleshooting

### 🔧 Per Troubleshooting

1. **Errore immediato**: Usare Quick Reference per fix rapidi
2. **Problema persistente**: Seguire guida completa troubleshooting
3. **Debug avanzato**: Utilizzare comandi e tecniche documentate

### 📋 Per Deployment

1. **Checklist pre-produzione**: Seguire checklist nel Quick Reference
2. **Configurazione sicurezza**: Implementare best practices documentate
3. **Monitoring**: Utilizzare tecniche di logging documentate

## Aggiornamenti e Manutenzione

### 📅 Versioning

La documentazione è aggiornata per:
- **FullCalendar v6.1.17** (latest)
- **Filament v3.x**
- **Laravel 11.x/12.x**
- **<nome progetto> current architecture**

### 🔄 Aggiornamenti Futuri

Quando aggiornare la documentazione:
- Nuove versioni FullCalendar con breaking changes
- Nuovi bug noti nella community
- Modifiche architettura <nome progetto>
- Nuovi requisiti sanitari/legali

### 📝 Contributi

Per aggiornare la documentazione:
1. Verificare issue GitHub FullCalendar
2. Testare soluzioni in ambiente <nome progetto>
3. Aggiornare documenti pertinenti
4. Aggiornare questo summary

## Risorse Esterne

### 🌐 Link Ufficiali
- [FullCalendar Docs](https://fullcalendar.io/docs/)
- [Scheduler License](https://fullcalendar.io/docs/schedulerLicenseKey)
- [Pricing](https://fullcalendar.io/pricing/)
- [Support](https://fullcalendar.io/support/)

### 🐛 Community
- [GitHub Issues](https://github.com/fullcalendar/fullcalendar/issues)
- [Stack Overflow](https://stackoverflow.com/questions/tagged/fullcalendar)

### 📧 Supporto Commerciale
- **Sales**: sales@fullcalendar.io
- **Technical**: Tramite GitHub Issues
- **License renewal**: Email notifications automatiche

## Conclusioni

Questa documentazione fornisce una copertura completa per tutti gli aspetti delle licenze FullCalendar Scheduler in <nome progetto>, dalla configurazione iniziale al troubleshooting avanzato. La combinazione di guida dettagliata e riferimento rapido garantisce supporto sia per sviluppatori esperti che per nuovi team members.

**Documenti chiave da consultare:**
1. **Setup iniziale**: Quick Reference
2. **Problemi complessi**: Troubleshooting completo
3. **Riferimento quotidiano**: Quick Reference checklist
4. **Configurazione produzione**: Best practices nel troubleshooting

La documentazione è progettata per essere autosufficiente e ridurre la necessità di ricerche esterne, fornendo tutte le informazioni necessarie per una gestione efficace delle licenze FullCalendar Scheduler nel contesto sanitario di <nome progetto>.

---

## fullcalendar-scheduler-license-key-invalid

*Consolidated from: `fullcalendar-scheduler-license-key-invalid.md`*

title: "Fullcalendar Scheduler License Key Invalid"
type: concept
tags: [fullcalendar, scheduler, license, key]
created: 2026-07-14
updated: 2026-07-14
qmd: "fullcalendar-scheduler-license-key-invalid fullcalendar scheduler license key invalid"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

 
 
---

## fullcalendar-scheduler-license-troubleshooting

*Consolidated from: `fullcalendar-scheduler-license-troubleshooting.md`*

title: "FullCalendar Scheduler License - Troubleshooting e Configurazione Avanzata"
type: concept
tags: [fullcalendar, scheduler, license, troubleshooting]
created: 2026-07-14
updated: 2026-07-14
qmd: "fullcalendar-scheduler-license-troubleshooting fullcalendar scheduler license - troubleshooting e configurazione avanzata"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# FullCalendar Scheduler License - Troubleshooting e Configurazione Avanzata

## Panoramica

Questa documentazione fornisce una guida completa per la risoluzione dei problemi relativi alle licenze FullCalendar Scheduler, basata sulla documentazione ufficiale e sui problemi comuni riscontrati nella community.

## Tipi di Licenza FullCalendar

### FullCalendar Standard (MIT License)
- **Gratuito** per uso commerciale e non commerciale
- Include i plugin base (dayGrid, timeGrid, list, interaction)
- **NON** include funzionalità premium come resource views e timeline

### FullCalendar Premium (Scheduler)
- **Richiede licenza commerciale** per uso in produzione
- Include resource views, timeline, e funzionalità avanzate
- Diversi tipi di licenza disponibili

## Tipi di Licenza Premium

### 1. Licenza Commerciale
```

```javascript
var calendar = new Calendar(calendarEl, {
  schedulerLicenseKey: 'XXXXXXXXXX-XXX-XXXXXXXXXX', // Formato tipico
  plugins: [resourceTimelinePlugin],
  initialView: 'resourceTimelineWeek'
});
```

**Caratteristiche:**
- Per aziende e uso commerciale
- Permette modifiche al codice sorgente
- NON permette redistribuzione delle modifiche
- Acquisto necessario da [FullCalendar Pricing](https://fullcalendar.io/pricing/)

### 2. Licenza Non-Commerciale
```javascript
var calendar = new Calendar(calendarEl, {
  schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
  plugins: [resourceTimelinePlugin],
  initialView: 'resourceTimelineWeek'
});
```

**Caratteristiche:**
- **Gratuita** per organizzazioni non-profit registrate
- NON copre enti governativi e università
- NON permette modifiche al codice sorgente

### 3. Licenza GPLv3 Open Source
```javascript
var calendar = new Calendar(calendarEl, {
  schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
  plugins: [resourceTimelinePlugin],
  initialView: 'resourceTimelineWeek'
});
```

**Caratteristiche:**
- **Gratuita** per progetti completamente GPLv3-compliant
- Richiede che tutto il progetto sia open source sotto GPLv3

## Problemi Comuni e Soluzioni

### 1. "Unknown option 'schedulerLicenseKey'" Error

**Problema:** L'opzione `schedulerLicenseKey` non viene riconosciuta.

**Cause Possibili:**
- Plugin premium non importato correttamente
- Versione FullCalendar incompatibile
- Bug noto nelle versioni 5.x e 6.x

**Soluzioni:**

#### Soluzione A: Verificare Import Plugin Premium
```javascript
// Assicurarsi di importare almeno un plugin premium
import resourceTimelinePlugin from '@fullcalendar/resource-timeline';
import resourceDayGridPlugin from '@fullcalendar/resource-daygrid';

var calendar = new Calendar(calendarEl, {
  schedulerLicenseKey: 'YOUR-LICENSE-KEY',
  plugins: [resourceTimelinePlugin, resourceDayGridPlugin], // Plugin premium richiesto
  initialView: 'resourceTimelineWeek'
});
```

#### Soluzione B: Workaround per TypeScript/Angular (v5.x-6.x)
```typescript
import { BASE_OPTION_REFINERS } from '@fullcalendar/core';

// Workaround per bug noto
(BASE_OPTION_REFINERS as any).schedulerLicenseKey = String;

// Poi configurare normalmente
const calendarOptions = {
  schedulerLicenseKey: 'YOUR-LICENSE-KEY',
  // altre opzioni...
};
```

#### Soluzione C: Per React/TypeScript (v6.x)
```typescript
// Se BASE_OPTION_DEFAULTS non è disponibile, usare ignore
/* @ts-ignore */
const calendarOptions = {
  schedulerLicenseKey: 'YOUR-LICENSE-KEY',
  plugins: [resourceTimelinePlugin],
  // altre opzioni...
};
```

### 2. "Invalid License String" Error

**Problema:** La chiave di licenza non viene riconosciuta come valida.

**Cause:**
- Chiave copiata incorrettamente
- Caratteri extra o mancanti
- Confusione con altri tipi di chiavi (customer key, support key)

**Soluzioni:**
1. **Verificare formato:** La chiave deve essere nel formato `XXXXXXXXXX-XXX-XXXXXXXXXX`
2. **Copiare esattamente:** Copiare la chiave esattamente come ricevuta via email
3. **Controllare spazi:** Rimuovere spazi iniziali/finali
4. **Verificare source:** Assicurarsi di usare la license key, non il customer number

### 3. "Evaluation Period Has Expired" Error

**Problema:** Il periodo di valutazione è scaduto.

**Soluzioni:**
1. **Acquistare licenza:** Visitare [FullCalendar Pricing](https://fullcalendar.io/pricing/)
2. **Contattare support:** Email a `sales@fullcalendar.io` per rinnovo
3. **Licenza offline:** Richiedere chiave offline se necessario

### 4. "Outdated License Key" Warning

**Problema:** Chiave valida ma obsoleta per la versione corrente.

**Cause:**
- Aggiornamento FullCalendar oltre il periodo di upgrade gratuito (1 anno)
- Licenza acquistata per versione precedente

**Soluzioni:**
1. **Downgrade:** Usare versione FullCalendar compatibile con la licenza
2. **Upgrade licenza:** Acquistare anno aggiuntivo di supporto
3. **Contattare sales:** Email a `sales@fullcalendar.io` per rinnovo

## Configurazione in Laravel/Filament

### 1. Variabili Ambiente (.env)
```env

# Licenza FullCalendar Scheduler
FULLCALENDAR_SCHEDULER_LICENSE_KEY=XXXXXXXXXX-XXX-XXXXXXXXXX

# Configurazioni aggiuntive
FULLCALENDAR_CACHE_TTL=300
FULLCALENDAR_MAX_EVENTS=100
```

### 2. Configurazione (config/fullcalendar.php)
```php
<?php

return [
    // Licenza Scheduler
    'scheduler_license_key' => env('FULLCALENDAR_SCHEDULER_LICENSE_KEY'),

    // Validazione licenza
    'validate_license' => env('APP_ENV') === 'production',

    // Fallback per sviluppo
    'development_mode' => env('APP_ENV') !== 'production',

    // Plugin premium abilitati
    'premium_plugins' => [
        'resource-timeline',
        'resource-daygrid',
        'resource-timegrid',
    ],
];
```

### 3. AdminPanelProvider (Filament)
```php
<?php

namespace Modules\<nome modulo>\app\Providers\Filament;
namespace Modules\<nome progetto>\app\Providers\Filament;

use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;

class AdminPanelProvider extends XotBasePanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->plugins([
                $this->getFullCalendarPlugin(),
                // altri plugin...
            ]);
    }

    private function getFullCalendarPlugin(): FilamentFullCalendarPlugin
    {
        $licenseKey = config('fullcalendar.scheduler_license_key');

        // Validazione licenza in produzione
        if (app()->environment('production') && empty($licenseKey)) {
            throw new \Exception('FullCalendar Scheduler license key required in production');
        }

        $plugin = FilamentFullCalendarPlugin::make()
            ->selectable()
            ->editable();

        // Applicare licenza solo se presente
        if (!empty($licenseKey)) {
            $plugin->schedulerLicenseKey($licenseKey);
        }

        return $plugin->config([
            'plugins' => [
                'dayGrid',
                'timeGrid',
                'list',
                'interaction',
                'multiMonth',
                'scrollGrid',
                // Plugin premium (richiedono licenza)
                'resourceTimeline',
                'resourceDayGrid',
                'resourceTimeGrid',
            ],

            // Configurazioni specifiche per
            // Configurazioni specifiche per <nome progetto>
            'locale' => 'it',
            'timezone' => 'Europe/Rome',
            'firstDay' => 1,

            // Business hours sanitarie
            'businessHours' => [
                'daysOfWeek' => [1, 2, 3, 4, 5, 6], // Lun-Sab
                'startTime' => '08:00',
                'endTime' => '19:00',
            ],

            // Validazioni
            'selectConstraint' => 'businessHours',
            'eventConstraint' => 'businessHours',

            // Performance
            'lazyFetching' => true,
            'eventLimit' => config('fullcalendar.max_events', 100),
        ]);
    }
}
```

## Testing e Debug

### 1. Verifica Configurazione
```bash

# Verificare variabili ambiente
php artisan config:show fullcalendar

# Test configurazione FullCalendar
php artisan tinker
>>> config('fullcalendar.scheduler_license_key')
```

### 2. Debug JavaScript Console
```javascript
// Verificare se plugin premium sono caricati
console.log(FullCalendar.globalPlugins);

// Verificare configurazione calendario
console.log(calendar.getOption('schedulerLicenseKey'));
```

### 3. Comandi Artisan Personalizzati
```php
<?php
// app/Console/Commands/FullCalendarDebug.php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FullCalendarDebug extends Command
{
    protected $signature = 'fullcalendar:debug';
    protected $description = 'Debug FullCalendar configuration';

    public function handle()
    {
        $licenseKey = config('fullcalendar.scheduler_license_key');

        $this->info('FullCalendar Configuration Debug');
        $this->line('================================');

        if (empty($licenseKey)) {
            $this->error('❌ No license key configured');
            $this->warn('Set FULLCALENDAR_SCHEDULER_LICENSE_KEY in .env');
        } else {
            $this->info('✅ License key configured');
            $this->line('Key: ' . substr($licenseKey, 0, 10) . '...');
        }

        $this->line('Environment: ' . app()->environment());
        $this->line('Premium plugins: ' . json_encode(config('fullcalendar.premium_plugins', [])));

        return 0;
    }
}
```

## Best Practices per
## Best Practices per <nome progetto>

### 1. Sicurezza Licenza
```php
// Non esporre mai la licenza nei log
Log::info('FullCalendar configured', [
    'has_license' => !empty(config('fullcalendar.scheduler_license_key')),
    'environment' => app()->environment(),
    // NON loggare la licenza effettiva
]);
```

### 2. Gestione Ambienti
```php
// Configurazione differenziata per ambiente
if (app()->environment('production')) {
    // Licenza obbligatoria in produzione
    $licenseKey = config('fullcalendar.scheduler_license_key');
    if (empty($licenseKey)) {
        throw new \Exception('Scheduler license required in production');
    }
} else {
    // Sviluppo: mostrare warning ma continuare
    if (empty(config('fullcalendar.scheduler_license_key'))) {
        logger()->warning('FullCalendar Scheduler running without license (development mode)');
    }
}
```

### 3. Monitoring Licenza
```php
// Monitoraggio scadenza licenza
class FullCalendarLicenseCheck
{
    public function checkLicenseValidity(): bool
    {
        $licenseKey = config('fullcalendar.scheduler_license_key');

        if (empty($licenseKey)) {
            return false;
        }

        // Implementare controllo validità se necessario
        // (FullCalendar non fornisce API per questo)

        return true;
    }
}
```

## Troubleshooting Avanzato

### 1. Problemi di Versioning
- **v5.x:** Bug noto con `schedulerLicenseKey`, usare workaround
- **v6.x:** Problemi con TypeScript exports, usare `@ts-ignore`
- **Aggiornamenti:** Verificare sempre compatibilità licenza

### 2. Problemi di Build
```javascript
// Webpack/Vite: assicurarsi che plugin premium siano inclusi
import '@fullcalendar/resource-timeline/index.css';
import resourceTimelinePlugin from '@fullcalendar/resource-timeline';
```

### 3. Problemi di Performance
```javascript
// Limitare eventi per evitare problemi di licenza
const calendarOptions = {
  schedulerLicenseKey: 'YOUR-KEY',
  eventSources: [{
    url: '/api/events',
    extraParams: {
      limit: 100 // Limitare numero eventi
    }
  }]
};
```

## Contatti e Supporto

### FullCalendar Support
- **Sales:** sales@fullcalendar.io
- **Support:** [FullCalendar Support](https://fullcalendar.io/support/)
- **Documentation:** [FullCalendar Docs](https://fullcalendar.io/project_docs/)
- **Documentation:** [FullCalendar Docs](https://fullcalendar.io/docs/)

### Risorse Utili
- [Pricing](https://fullcalendar.io/pricing/)
- [License FAQ](https://fullcalendar.io/license/faq/)
- [GitHub Issues](https://github.com/fullcalendar/fullcalendar/issues)
- [Changelog](https://fullcalendar.io/changelog/)

## Conclusioni

La gestione delle licenze FullCalendar Scheduler richiede attenzione particolare, specialmente in ambienti di produzione sanitari come . Seguire questa guida garantisce una configurazione corretta e la risoluzione dei problemi più comuni.
La gestione delle licenze FullCalendar Scheduler richiede attenzione particolare, specialmente in ambienti di produzione sanitari come <nome progetto>. Seguire questa guida garantisce una configurazione corretta e la risoluzione dei problemi più comuni.

**Punti Chiave:**
1. **Licenza obbligatoria** per uso commerciale in produzione
2. **Plugin premium richiesti** per `schedulerLicenseKey`
3. **Workaround disponibili** per bug noti nelle versioni 5.x-6.x
4. **Configurazione ambiente-specifica** per sviluppo vs produzione
5. **Monitoring e logging** per troubleshooting proattivo
# FullCalendar Scheduler License - Troubleshooting e Configurazione Avanzata

## Panoramica

Questa documentazione fornisce una guida completa per la risoluzione dei problemi relativi alle licenze FullCalendar Scheduler, basata sulla documentazione ufficiale e sui problemi comuni riscontrati nella community.

## Tipi di Licenza FullCalendar

### FullCalendar Standard (MIT License)
- **Gratuito** per uso commerciale e non commerciale
- Include i plugin base (dayGrid, timeGrid, list, interaction)
- **NON** include funzionalità premium come resource views e timeline

### FullCalendar Premium (Scheduler)
- **Richiede licenza commerciale** per uso in produzione
- Include resource views, timeline, e funzionalità avanzate
- Diversi tipi di licenza disponibili

## Tipi di Licenza Premium

### 1. Licenza Commerciale
```javascript
var calendar = new Calendar(calendarEl, {
  schedulerLicenseKey: 'XXXXXXXXXX-XXX-XXXXXXXXXX', // Formato tipico
  plugins: [resourceTimelinePlugin],
  initialView: 'resourceTimelineWeek'
});
```

**Caratteristiche:**
- Per aziende e uso commerciale
- Permette modifiche al codice sorgente
- NON permette redistribuzione delle modifiche
- Acquisto necessario da [FullCalendar Pricing](https://fullcalendar.io/pricing/)

### 2. Licenza Non-Commerciale
```javascript
var calendar = new Calendar(calendarEl, {
  schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
  plugins: [resourceTimelinePlugin],
  initialView: 'resourceTimelineWeek'
});
```

**Caratteristiche:**
- **Gratuita** per organizzazioni non-profit registrate
- NON copre enti governativi e università
- NON permette modifiche al codice sorgente

### 3. Licenza GPLv3 Open Source
```javascript
var calendar = new Calendar(calendarEl, {
  schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
  plugins: [resourceTimelinePlugin],
  initialView: 'resourceTimelineWeek'
});
```

**Caratteristiche:**
- **Gratuita** per progetti completamente GPLv3-compliant
- Richiede che tutto il progetto sia open source sotto GPLv3

## Problemi Comuni e Soluzioni

### 1. "Unknown option 'schedulerLicenseKey'" Error

**Problema:** L'opzione `schedulerLicenseKey` non viene riconosciuta.

**Cause Possibili:**
- Plugin premium non importato correttamente
- Versione FullCalendar incompatibile
- Bug noto nelle versioni 5.x e 6.x

**Soluzioni:**

#### Soluzione A: Verificare Import Plugin Premium
```javascript
// Assicurarsi di importare almeno un plugin premium
import resourceTimelinePlugin from '@fullcalendar/resource-timeline';
import resourceDayGridPlugin from '@fullcalendar/resource-daygrid';

var calendar = new Calendar(calendarEl, {
  schedulerLicenseKey: 'YOUR-LICENSE-KEY',
  plugins: [resourceTimelinePlugin, resourceDayGridPlugin], // Plugin premium richiesto
  initialView: 'resourceTimelineWeek'
});
```

#### Soluzione B: Workaround per TypeScript/Angular (v5.x-6.x)
```typescript
import { BASE_OPTION_REFINERS } from '@fullcalendar/core';

// Workaround per bug noto
(BASE_OPTION_REFINERS as any).schedulerLicenseKey = String;

// Poi configurare normalmente
const calendarOptions = {
  schedulerLicenseKey: 'YOUR-LICENSE-KEY',
  // altre opzioni...
};
```

#### Soluzione C: Per React/TypeScript (v6.x)
```typescript
// Se BASE_OPTION_DEFAULTS non è disponibile, usare ignore
/* @ts-ignore */
const calendarOptions = {
  schedulerLicenseKey: 'YOUR-LICENSE-KEY',
  plugins: [resourceTimelinePlugin],
  // altre opzioni...
};
```

### 2. "Invalid License String" Error

**Problema:** La chiave di licenza non viene riconosciuta come valida.

**Cause:**
- Chiave copiata incorrettamente
- Caratteri extra o mancanti
- Confusione con altri tipi di chiavi (customer key, support key)

**Soluzioni:**
1. **Verificare formato:** La chiave deve essere nel formato `XXXXXXXXXX-XXX-XXXXXXXXXX`
2. **Copiare esattamente:** Copiare la chiave esattamente come ricevuta via email
3. **Controllare spazi:** Rimuovere spazi iniziali/finali
4. **Verificare source:** Assicurarsi di usare la license key, non il customer number

### 3. "Evaluation Period Has Expired" Error

**Problema:** Il periodo di valutazione è scaduto.

**Soluzioni:**
1. **Acquistare licenza:** Visitare [FullCalendar Pricing](https://fullcalendar.io/pricing/)
2. **Contattare support:** Email a `sales@fullcalendar.io` per rinnovo
3. **Licenza offline:** Richiedere chiave offline se necessario

### 4. "Outdated License Key" Warning

**Problema:** Chiave valida ma obsoleta per la versione corrente.

**Cause:**
- Aggiornamento FullCalendar oltre il periodo di upgrade gratuito (1 anno)
- Licenza acquistata per versione precedente

**Soluzioni:**
1. **Downgrade:** Usare versione FullCalendar compatibile con la licenza
2. **Upgrade licenza:** Acquistare anno aggiuntivo di supporto
3. **Contattare sales:** Email a `sales@fullcalendar.io` per rinnovo

## Configurazione in Laravel/Filament

### 1. Variabili Ambiente (.env)
```env
# Licenza FullCalendar Scheduler
FULLCALENDAR_SCHEDULER_LICENSE_KEY=XXXXXXXXXX-XXX-XXXXXXXXXX

# Configurazioni aggiuntive
FULLCALENDAR_CACHE_TTL=300
FULLCALENDAR_MAX_EVENTS=100
```

### 2. Configurazione (config/fullcalendar.php)
```php
<?php

return [
    // Licenza Scheduler
    'scheduler_license_key' => env('FULLCALENDAR_SCHEDULER_LICENSE_KEY'),

    // Validazione licenza
    'validate_license' => env('APP_ENV') === 'production',

    // Fallback per sviluppo
    'development_mode' => env('APP_ENV') !== 'production',

    // Plugin premium abilitati
    'premium_plugins' => [
        'resource-timeline',
        'resource-daygrid',
        'resource-timegrid',
    ],
];
```

### 3. AdminPanelProvider (Filament)
```php
<?php

namespace Modules\<nome progetto>\app\Providers\Filament;

use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;

class AdminPanelProvider extends XotBasePanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->plugins([
                $this->getFullCalendarPlugin(),
                // altri plugin...
            ]);
    }

    private function getFullCalendarPlugin(): FilamentFullCalendarPlugin
    {
        $licenseKey = config('fullcalendar.scheduler_license_key');

        // Validazione licenza in produzione
        if (app()->environment('production') && empty($licenseKey)) {
            throw new \Exception('FullCalendar Scheduler license key required in production');
        }

        $plugin = FilamentFullCalendarPlugin::make()
            ->selectable()
            ->editable();

        // Applicare licenza solo se presente
        if (!empty($licenseKey)) {
            $plugin->schedulerLicenseKey($licenseKey);
        }

        return $plugin->config([
            'plugins' => [
                'dayGrid',
                'timeGrid',
                'list',
                'interaction',
                'multiMonth',
                'scrollGrid',
                // Plugin premium (richiedono licenza)
                'resourceTimeline',
                'resourceDayGrid',
                'resourceTimeGrid',
            ],

            // Configurazioni specifiche per <nome progetto>
            'locale' => 'it',
            'timezone' => 'Europe/Rome',
            'firstDay' => 1,

            // Business hours sanitarie
            'businessHours' => [
                'daysOfWeek' => [1, 2, 3, 4, 5, 6], // Lun-Sab
                'startTime' => '08:00',
                'endTime' => '19:00',
            ],

            // Validazioni
            'selectConstraint' => 'businessHours',
            'eventConstraint' => 'businessHours',

            // Performance
            'lazyFetching' => true,
            'eventLimit' => config('fullcalendar.max_events', 100),
        ]);
    }
}
```

## Testing e Debug

### 1. Verifica Configurazione
```bash
# Verificare variabili ambiente
php artisan config:show fullcalendar

# Test configurazione FullCalendar
php artisan tinker
>>> config('fullcalendar.scheduler_license_key')
```

### 2. Debug JavaScript Console
```javascript
// Verificare se plugin premium sono caricati
console.log(FullCalendar.globalPlugins);

// Verificare configurazione calendario
console.log(calendar.getOption('schedulerLicenseKey'));
```

### 3. Comandi Artisan Personalizzati
```php
<?php
// app/Console/Commands/FullCalendarDebug.php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FullCalendarDebug extends Command
{
    protected $signature = 'fullcalendar:debug';
    protected $description = 'Debug FullCalendar configuration';

    public function handle()
    {
        $licenseKey = config('fullcalendar.scheduler_license_key');

        $this->info('FullCalendar Configuration Debug');
        $this->line('================================');

        if (empty($licenseKey)) {
            $this->error('❌ No license key configured');
            $this->warn('Set FULLCALENDAR_SCHEDULER_LICENSE_KEY in .env');
        } else {
            $this->info('✅ License key configured');
            $this->line('Key: ' . substr($licenseKey, 0, 10) . '...');
        }

        $this->line('Environment: ' . app()->environment());
        $this->line('Premium plugins: ' . json_encode(config('fullcalendar.premium_plugins', [])));

        return 0;
    }
}
```

## Best Practices per <nome progetto>

### 1. Sicurezza Licenza
```php
// Non esporre mai la licenza nei log
Log::info('FullCalendar configured', [
    'has_license' => !empty(config('fullcalendar.scheduler_license_key')),
    'environment' => app()->environment(),
    // NON loggare la licenza effettiva
]);
```

### 2. Gestione Ambienti
```php
// Configurazione differenziata per ambiente
if (app()->environment('production')) {
    // Licenza obbligatoria in produzione
    $licenseKey = config('fullcalendar.scheduler_license_key');
    if (empty($licenseKey)) {
        throw new \Exception('Scheduler license required in production');
    }
} else {
    // Sviluppo: mostrare warning ma continuare
    if (empty(config('fullcalendar.scheduler_license_key'))) {
        logger()->warning('FullCalendar Scheduler running without license (development mode)');
    }
}
```

### 3. Monitoring Licenza
```php
// Monitoraggio scadenza licenza
class FullCalendarLicenseCheck
{
    public function checkLicenseValidity(): bool
    {
        $licenseKey = config('fullcalendar.scheduler_license_key');

        if (empty($licenseKey)) {
            return false;
        }

        // Implementare controllo validità se necessario
        // (FullCalendar non fornisce API per questo)

        return true;
    }
}
```

## Troubleshooting Avanzato

### 1. Problemi di Versioning
- **v5.x:** Bug noto con `schedulerLicenseKey`, usare workaround
- **v6.x:** Problemi con TypeScript exports, usare `@ts-ignore`
- **Aggiornamenti:** Verificare sempre compatibilità licenza

### 2. Problemi di Build
```javascript
// Webpack/Vite: assicurarsi che plugin premium siano inclusi
import '@fullcalendar/resource-timeline/index.css';
import resourceTimelinePlugin from '@fullcalendar/resource-timeline';
```

### 3. Problemi di Performance
```javascript
// Limitare eventi per evitare problemi di licenza
const calendarOptions = {
  schedulerLicenseKey: 'YOUR-KEY',
  eventSources: [{
    url: '/api/events',
    extraParams: {
      limit: 100 // Limitare numero eventi
    }
  }]
};
```

## Contatti e Supporto

### FullCalendar Support
- **Sales:** sales@fullcalendar.io
- **Support:** [FullCalendar Support](https://fullcalendar.io/support/)
- **Documentation:** [FullCalendar Docs](https://fullcalendar.io/docs/)

### Risorse Utili
- [Pricing](https://fullcalendar.io/pricing/)
- [License FAQ](https://fullcalendar.io/license/faq/)
- [GitHub Issues](https://github.com/fullcalendar/fullcalendar/issues)
- [Changelog](https://fullcalendar.io/changelog/)

## Conclusioni

La gestione delle licenze FullCalendar Scheduler richiede attenzione particolare, specialmente in ambienti di produzione sanitari come <nome progetto>. Seguire questa guida garantisce una configurazione corretta e la risoluzione dei problemi più comuni.

**Punti Chiave:**
1. **Licenza obbligatoria** per uso commerciale in produzione
2. **Plugin premium richiesti** per `schedulerLicenseKey`
3. **Workaround disponibili** per bug noti nelle versioni 5.x-6.x
4. **Configurazione ambiente-specifica** per sviluppo vs produzione
5. **Monitoring e logging** per troubleshooting proattivo

---

## fullcalendar-scheduler-license

*Consolidated from: `fullcalendar-scheduler-license.md`*

title: "FullCalendar Scheduler License Configuration"
type: concept
tags: [fullcalendar, scheduler, license]
created: 2026-07-14
updated: 2026-07-14
qmd: "fullcalendar-scheduler-license fullcalendar scheduler license configuration"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# FullCalendar Scheduler License Configuration

## License Key Overview
FullCalendar Scheduler requires a valid license key for use in production environments. The Scheduler is a premium add-on to FullCalendar that provides resource views and timeline functionality.
## License Types
1. **Development License**
   - Free for development and testing
   - Shows a red banner with "LICENSE NEEDED" message
   - Not suitable for production use
2. **Commercial License**
   - Required for production use
   - Removes the red banner
   - Available for purchase from [FullCalendar's pricing page](https://fullcalendar.io/pricing/)
## Configuration in
## Configuration in <nome progetto>
### Setting the License Key
1. **Environment Configuration**
   Add your license key to your `.env` file:
   ```
   FULLCALENDAR_SCHEDULER_LICENSE=your-license-key-here
2. **Publish Configuration**
   Publish the FullCalendar configuration file:
   ```bash
   php artisan vendor:publish --tag=fullcalendar-config
3. **Update Config**
   In `config/fullcalendar.php`:
   ```php
   'scheduler_license_key' => env('FULLCALENDAR_SCHEDULER_LICENSE'),
### Usage in Code
In your PanelProvider or where you configure FullCalendar:
```php
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;
// ...
$calendarPlugin = FilamentFullCalendarPlugin::make()
    ->schedulerLicenseKey(config('fullcalendar.scheduler_license_key'))
    // other configurations...
```
## Common Issues
### Invalid License Key
If you see a red banner with "LICENSE NEEDED", it means:
- No license key is set, or
- The provided license key is invalid
### Development Mode
In development, you can use the Scheduler without a license key, but you'll see a red banner. This is normal and expected behavior.
## Compliance
- Always ensure you have a valid license for production use
- Do not share or expose your license key in version control
- Purchase the appropriate license based on your deployment needs
## Support
For license-related issues, contact FullCalendar support:
- [FullCalendar Support](https://fullcalendar.io/support/)
- [License FAQ](https://fullcalendar.io/license/faq/)
## Version Compatibility
Ensure your license key is compatible with the version of FullCalendar Scheduler you're using. Check the [changelog](https://fullcalendar.io/changelog/) for version-specific requirements.
# FullCalendar Scheduler License Configuration

## License Key Overview

FullCalendar Scheduler requires a valid license key for use in production environments. The Scheduler is a premium add-on to FullCalendar that provides resource views and timeline functionality.

## License Types

1. **Development License**
   - Free for development and testing
   - Shows a red banner with "LICENSE NEEDED" message
   - Not suitable for production use

2. **Commercial License**
   - Required for production use
   - Removes the red banner
   - Available for purchase from [FullCalendar's pricing page](https://fullcalendar.io/pricing/)

## Configuration in <nome progetto>

### Setting the License Key

1. **Environment Configuration**
   Add your license key to your `.env` file:
   ```
   FULLCALENDAR_SCHEDULER_LICENSE=your-license-key-here
   ```

2. **Publish Configuration**
   Publish the FullCalendar configuration file:
   ```bash
   php artisan vendor:publish --tag=fullcalendar-config
   ```

3. **Update Config**
   In `config/fullcalendar.php`:
   ```php
   'scheduler_license_key' => env('FULLCALENDAR_SCHEDULER_LICENSE'),
   ```

### Usage in Code

In your PanelProvider or where you configure FullCalendar:

```php
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;

// ...

$calendarPlugin = FilamentFullCalendarPlugin::make()
    ->schedulerLicenseKey(config('fullcalendar.scheduler_license_key'))
    // other configurations...
```

## Common Issues

### Invalid License Key

If you see a red banner with "LICENSE NEEDED", it means:
- No license key is set, or
- The provided license key is invalid

### Development Mode

In development, you can use the Scheduler without a license key, but you'll see a red banner. This is normal and expected behavior.

## Compliance

- Always ensure you have a valid license for production use
- Do not share or expose your license key in version control
- Purchase the appropriate license based on your deployment needs

## Support

For license-related issues, contact FullCalendar support:
- [FullCalendar Support](https://fullcalendar.io/support/)
- [License FAQ](https://fullcalendar.io/license/faq/)

## Version Compatibility

Ensure your license key is compatible with the version of FullCalendar Scheduler you're using. Check the [changelog](https://fullcalendar.io/changelog/) for version-specific requirements.

---

## fullcalendar-scheduler-quick-reference-3

*Consolidated from: `fullcalendar-scheduler-quick-reference.md`*

title: "FullCalendar Scheduler - Riferimento Rapido"
type: concept
tags: [fullcalendar, scheduler, quick, reference]
created: 2026-07-14
updated: 2026-07-14
qmd: "fullcalendar-scheduler-quick-reference-3 fullcalendar scheduler - riferimento rapido"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# FullCalendar Scheduler - Riferimento Rapido

## 🚨 Problemi Comuni e Soluzioni Immediate

### ❌ "Unknown option 'schedulerLicenseKey'"

**Causa:** Plugin premium non importato
```javascript
// ✅ SOLUZIONE: Importare plugin premium
import resourceTimelinePlugin from '@fullcalendar/resource-timeline';

var calendar = new Calendar(calendarEl, {
  schedulerLicenseKey: 'YOUR-KEY',
  plugins: [resourceTimelinePlugin], // ← NECESSARIO
  initialView: 'resourceTimelineWeek'
});
```

**Workaround TypeScript/Angular:**
```typescript
import { BASE_OPTION_REFINERS } from '@fullcalendar/core';
(BASE_OPTION_REFINERS as any).schedulerLicenseKey = String;
```

### ❌ "Invalid License String"

**Causa:** Formato chiave errato
```javascript
// ❌ SBAGLIATO
schedulerLicenseKey: 'customer-12345'

// ✅ CORRETTO
schedulerLicenseKey: 'XXXXXXXXXX-XXX-XXXXXXXXXX'
```

### ❌ "Evaluation Period Has Expired"

**Soluzioni:**
1. Acquistare licenza: https://fullcalendar.io/pricing/
2. Email support: sales@fullcalendar.io
3. Downgrade versione FullCalendar

### ❌ Banner Rosso "LICENSE NEEDED"

**Causa:** Nessuna licenza configurata
```php
// ✅ SOLUZIONE Laravel
// .env
FULLCALENDAR_SCHEDULER_LICENSE_KEY=YOUR-KEY-HERE

// AdminPanelProvider.php
FilamentFullCalendarPlugin::make()
    ->schedulerLicenseKey(config('fullcalendar.scheduler_license_key'))
```

## 🔑 Tipi di Licenza

### Commerciale
```javascript
schedulerLicenseKey: 'XXXXXXXXXX-XXX-XXXXXXXXXX' // Acquistata
```

### Non-Profit (Gratuita)
```javascript
schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives'
```

### Open Source GPLv3 (Gratuita)
```javascript
schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source'
```

## ⚙️ Configurazione Laravel/Filament

### .env
```env
FULLCALENDAR_SCHEDULER_LICENSE_KEY=XXXXXXXXXX-XXX-XXXXXXXXXX
```

### config/fullcalendar.php
```php
return [
    'scheduler_license_key' => env('FULLCALENDAR_SCHEDULER_LICENSE_KEY'),
    'validate_license' => env('APP_ENV') === 'production',
];
```

### AdminPanelProvider.php
```php
private function getFullCalendarPlugin(): FilamentFullCalendarPlugin
{
    $licenseKey = config('fullcalendar.scheduler_license_key');
    
    $plugin = FilamentFullCalendarPlugin::make()
        ->selectable()
        ->editable();

    if (!empty($licenseKey)) {
        $plugin->schedulerLicenseKey($licenseKey);
    }

    return $plugin->config([
        'plugins' => [
            'dayGrid', 'timeGrid', 'list', 'interaction',
            'resourceTimeline', 'resourceDayGrid', // Premium
        ],
    ]);
}
```

## 🧪 Testing e Debug

### Verifica Configurazione
```bash
php artisan config:show fullcalendar
php artisan tinker
>>> config('fullcalendar.scheduler_license_key')
```

### Debug JavaScript
```javascript
console.log(FullCalendar.globalPlugins);
console.log(calendar.getOption('schedulerLicenseKey'));
```

### Comando Debug Personalizzato
```php
// app/Console/Commands/FullCalendarDebug.php
php artisan make:command FullCalendarDebug
php artisan fullcalendar:debug
```

## 🔒 Sicurezza

### ❌ NON FARE
```php
// Non loggare mai la licenza
Log::info('License: ' . $licenseKey); // ❌ PERICOLOSO
```

### ✅ FARE
```php
// Loggare solo presenza licenza
Log::info('FullCalendar configured', [
    'has_license' => !empty($licenseKey),
    'environment' => app()->environment(),
]);
```

## 🌍 Gestione Ambienti

### Produzione (Licenza Obbligatoria)
```php
if (app()->environment('production') && empty($licenseKey)) {
    throw new \Exception('Scheduler license required in production');
}
```

### Sviluppo (Warning)
```php
if (app()->environment('local') && empty($licenseKey)) {
    logger()->warning('FullCalendar running without license (dev mode)');
}
```

## 📞 Supporto

- **Sales:** sales@fullcalendar.io
- **Pricing:** https://fullcalendar.io/pricing/
- **Docs:** https://fullcalendar.io/docs/schedulerLicenseKey
- **GitHub:** https://github.com/fullcalendar/fullcalendar/issues

## 🎯 Checklist Rapida

- [ ] Plugin premium importato (`@fullcalendar/resource-timeline`)
- [ ] Licenza configurata in `.env`
- [ ] Formato licenza corretto (`XXXXXXXXXX-XXX-XXXXXXXXXX`)
- [ ] Plugin applicato in AdminPanelProvider
- [ ] Test in console JavaScript
- [ ] Verifica ambiente produzione vs sviluppo
- [ ] Banner rosso rimosso
- [ ] Funzionalità premium attive

## 🚀 healthcare_app Specifico

### Business Hours Sanitarie
```javascript
businessHours: {
  daysOfWeek: [1, 2, 3, 4, 5, 6], // Lun-Sab
  startTime: '08:00',
  endTime: '19:00',
}
```

### Configurazione Multi-Tenant
```php
// Isolamento per studio
$plugin->config([
    'eventSources' => [{
        'url' => '/api/appointments',
        'extraParams' => [
            'studio_id' => Filament::getTenant()->id,
        ]
    }]
]);
```

### Validazioni Sanitarie
```javascript
selectConstraint: 'businessHours',
eventConstraint: 'businessHours',
slotDuration: '00:30:00', // 30 min slots
``` 

---

## fullcalendar-scheduler-quick-reference

*Consolidated from: `fullcalendar-scheduler-quick-reference.md`*

title: "FullCalendar Scheduler - Riferimento Rapido"
type: concept
tags: [fullcalendar, scheduler, quick, reference]
created: 2026-07-14
updated: 2026-07-14
qmd: "fullcalendar-scheduler-quick-reference fullcalendar scheduler - riferimento rapido"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# FullCalendar Scheduler - Riferimento Rapido

## 🚨 Problemi Comuni e Soluzioni Immediate
### ❌ "Unknown option 'schedulerLicenseKey'"
**Causa:** Plugin premium non importato
```javascript
// ✅ SOLUZIONE: Importare plugin premium
import resourceTimelinePlugin from '@fullcalendar/resource-timeline';
var calendar = new Calendar(calendarEl, {
  schedulerLicenseKey: 'YOUR-KEY',
  plugins: [resourceTimelinePlugin], // ← NECESSARIO
  initialView: 'resourceTimelineWeek'
});
```
**Workaround TypeScript/Angular:**
```typescript
import { BASE_OPTION_REFINERS } from '@fullcalendar/core';
(BASE_OPTION_REFINERS as any).schedulerLicenseKey = String;
### ❌ "Invalid License String"
**Causa:** Formato chiave errato
// ❌ SBAGLIATO
schedulerLicenseKey: 'customer-12345'
// ✅ CORRETTO
schedulerLicenseKey: 'XXXXXXXXXX-XXX-XXXXXXXXXX'
### ❌ "Evaluation Period Has Expired"
**Soluzioni:**
1. Acquistare licenza: https://fullcalendar.io/pricing/
2. Email support: sales@fullcalendar.io
3. Downgrade versione FullCalendar
### ❌ Banner Rosso "LICENSE NEEDED"
**Causa:** Nessuna licenza configurata
```

```php
// ✅ SOLUZIONE Laravel
// .env
FULLCALENDAR_SCHEDULER_LICENSE_KEY=YOUR-KEY-HERE
// AdminPanelProvider.php
FilamentFullCalendarPlugin::make()
    ->schedulerLicenseKey(config('fullcalendar.scheduler_license_key'))
## 🔑 Tipi di Licenza
### Commerciale
schedulerLicenseKey: 'XXXXXXXXXX-XXX-XXXXXXXXXX' // Acquistata
### Non-Profit (Gratuita)
schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives'
### Open Source GPLv3 (Gratuita)
schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source'
## ⚙️ Configurazione Laravel/Filament
### .env
```

```env
FULLCALENDAR_SCHEDULER_LICENSE_KEY=XXXXXXXXXX-XXX-XXXXXXXXXX
### config/fullcalendar.php
return [
    'scheduler_license_key' => env('FULLCALENDAR_SCHEDULER_LICENSE_KEY'),
    'validate_license' => env('APP_ENV') === 'production',
];
### AdminPanelProvider.php
private function getFullCalendarPlugin(): FilamentFullCalendarPlugin
{
    $licenseKey = config('fullcalendar.scheduler_license_key');

    $plugin = FilamentFullCalendarPlugin::make()
        ->selectable()
        ->editable();
    if (!empty($licenseKey)) {
        $plugin->schedulerLicenseKey($licenseKey);
    }
    return $plugin->config([
        'plugins' => [
            'dayGrid', 'timeGrid', 'list', 'interaction',
            'resourceTimeline', 'resourceDayGrid', // Premium
        ],
    ]);
}
## 🧪 Testing e Debug
### Verifica Configurazione
```

```bash
php artisan config:show fullcalendar
php artisan tinker
>>> config('fullcalendar.scheduler_license_key')
### Debug JavaScript
console.log(FullCalendar.globalPlugins);
console.log(calendar.getOption('schedulerLicenseKey'));
### Comando Debug Personalizzato
// app/Console/Commands/FullCalendarDebug.php
php artisan make:command FullCalendarDebug
php artisan fullcalendar:debug
## 🔒 Sicurezza
### ❌ NON FARE
// Non loggare mai la licenza
Log::info('License: ' . $licenseKey); // ❌ PERICOLOSO
### ✅ FARE
// Loggare solo presenza licenza
Log::info('FullCalendar configured', [
    'has_license' => !empty($licenseKey),
    'environment' => app()->environment(),
]);
## 🌍 Gestione Ambienti
### Produzione (Licenza Obbligatoria)
if (app()->environment('production') && empty($licenseKey)) {
    throw new \Exception('Scheduler license required in production');
### Sviluppo (Warning)
if (app()->environment('local') && empty($licenseKey)) {
    logger()->warning('FullCalendar running without license (dev mode)');
## 📞 Supporto
- **Sales:** sales@fullcalendar.io
- **Pricing:** https://fullcalendar.io/pricing/
- **Docs:** https://fullcalendar.io/project_docs/schedulerLicenseKey
- **Docs:** https://fullcalendar.io/docs/schedulerLicenseKey
- **GitHub:** https://github.com/fullcalendar/fullcalendar/issues
## 🎯 Checklist Rapida
- [ ] Plugin premium importato (`@fullcalendar/resource-timeline`)
- [ ] Licenza configurata in `.env`
- [ ] Formato licenza corretto (`XXXXXXXXXX-XXX-XXXXXXXXXX`)
- [ ] Plugin applicato in AdminPanelProvider
- [ ] Test in console JavaScript
- [ ] Verifica ambiente produzione vs sviluppo
- [ ] Banner rosso rimosso
- [ ] Funzionalità premium attive
## 🚀  Specifico
## 🚀 <nome progetto> Specifico
### Business Hours Sanitarie
businessHours: {
  daysOfWeek: [1, 2, 3, 4, 5, 6], // Lun-Sab
  startTime: '08:00',
  endTime: '19:00',
### Configurazione Multi-Tenant
// Isolamento per studio
$plugin->config([
    'eventSources' => [{
        'url' => '/api/appointments',
        'extraParams' => [
            'studio_id' => Filament::getTenant()->id,
        ]
    }]
### Validazioni Sanitarie
selectConstraint: 'businessHours',
eventConstraint: 'businessHours',
slotDuration: '00:30:00', // 30 min slots
```
# FullCalendar Scheduler - Riferimento Rapido

## 🚨 Problemi Comuni e Soluzioni Immediate

### ❌ "Unknown option 'schedulerLicenseKey'"

**Causa:** Plugin premium non importato
```javascript
// ✅ SOLUZIONE: Importare plugin premium
import resourceTimelinePlugin from '@fullcalendar/resource-timeline';

var calendar = new Calendar(calendarEl, {
  schedulerLicenseKey: 'YOUR-KEY',
  plugins: [resourceTimelinePlugin], // ← NECESSARIO
  initialView: 'resourceTimelineWeek'
});
```

**Workaround TypeScript/Angular:**
```typescript
import { BASE_OPTION_REFINERS } from '@fullcalendar/core';
(BASE_OPTION_REFINERS as any).schedulerLicenseKey = String;
```

### ❌ "Invalid License String"

**Causa:** Formato chiave errato
```javascript
// ❌ SBAGLIATO
schedulerLicenseKey: 'customer-12345'

// ✅ CORRETTO
schedulerLicenseKey: 'XXXXXXXXXX-XXX-XXXXXXXXXX'
```

### ❌ "Evaluation Period Has Expired"

**Soluzioni:**
1. Acquistare licenza: https://fullcalendar.io/pricing/
2. Email support: sales@fullcalendar.io
3. Downgrade versione FullCalendar

### ❌ Banner Rosso "LICENSE NEEDED"

**Causa:** Nessuna licenza configurata
```php
// ✅ SOLUZIONE Laravel
// .env
FULLCALENDAR_SCHEDULER_LICENSE_KEY=YOUR-KEY-HERE

// AdminPanelProvider.php
FilamentFullCalendarPlugin::make()
    ->schedulerLicenseKey(config('fullcalendar.scheduler_license_key'))
```

## 🔑 Tipi di Licenza

### Commerciale
```javascript
schedulerLicenseKey: 'XXXXXXXXXX-XXX-XXXXXXXXXX' // Acquistata
```

### Non-Profit (Gratuita)
```javascript
schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives'
```

### Open Source GPLv3 (Gratuita)
```javascript
schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source'
```

## ⚙️ Configurazione Laravel/Filament

### .env
```env
FULLCALENDAR_SCHEDULER_LICENSE_KEY=XXXXXXXXXX-XXX-XXXXXXXXXX
```

### config/fullcalendar.php
```php
return [
    'scheduler_license_key' => env('FULLCALENDAR_SCHEDULER_LICENSE_KEY'),
    'validate_license' => env('APP_ENV') === 'production',
];
```

### AdminPanelProvider.php
```php
private function getFullCalendarPlugin(): FilamentFullCalendarPlugin
{
    $licenseKey = config('fullcalendar.scheduler_license_key');

    $plugin = FilamentFullCalendarPlugin::make()
        ->selectable()
        ->editable();

    if (!empty($licenseKey)) {
        $plugin->schedulerLicenseKey($licenseKey);
    }

    return $plugin->config([
        'plugins' => [
            'dayGrid', 'timeGrid', 'list', 'interaction',
            'resourceTimeline', 'resourceDayGrid', // Premium
        ],
    ]);
}
```

## 🧪 Testing e Debug

### Verifica Configurazione
```bash
php artisan config:show fullcalendar
php artisan tinker
>>> config('fullcalendar.scheduler_license_key')
```

### Debug JavaScript
```javascript
console.log(FullCalendar.globalPlugins);
console.log(calendar.getOption('schedulerLicenseKey'));
```

### Comando Debug Personalizzato
```php
// app/Console/Commands/FullCalendarDebug.php
php artisan make:command FullCalendarDebug
php artisan fullcalendar:debug
```

## 🔒 Sicurezza

### ❌ NON FARE
```php
// Non loggare mai la licenza
Log::info('License: ' . $licenseKey); // ❌ PERICOLOSO
```

### ✅ FARE
```php
// Loggare solo presenza licenza
Log::info('FullCalendar configured', [
    'has_license' => !empty($licenseKey),
    'environment' => app()->environment(),
]);
```

## 🌍 Gestione Ambienti

### Produzione (Licenza Obbligatoria)
```php
if (app()->environment('production') && empty($licenseKey)) {
    throw new \Exception('Scheduler license required in production');
}
```

### Sviluppo (Warning)
```php
if (app()->environment('local') && empty($licenseKey)) {
    logger()->warning('FullCalendar running without license (dev mode)');
}
```

## 📞 Supporto

- **Sales:** sales@fullcalendar.io
- **Pricing:** https://fullcalendar.io/pricing/
- **Docs:** https://fullcalendar.io/docs/schedulerLicenseKey
- **GitHub:** https://github.com/fullcalendar/fullcalendar/issues

## 🎯 Checklist Rapida

- [ ] Plugin premium importato (`@fullcalendar/resource-timeline`)
- [ ] Licenza configurata in `.env`
- [ ] Formato licenza corretto (`XXXXXXXXXX-XXX-XXXXXXXXXX`)
- [ ] Plugin applicato in AdminPanelProvider
- [ ] Test in console JavaScript
- [ ] Verifica ambiente produzione vs sviluppo
- [ ] Banner rosso rimosso
- [ ] Funzionalità premium attive

## 🚀 <nome progetto> Specifico

### Business Hours Sanitarie
```javascript
businessHours: {
  daysOfWeek: [1, 2, 3, 4, 5, 6], // Lun-Sab
  startTime: '08:00',
  endTime: '19:00',
}
```

### Configurazione Multi-Tenant
```php
// Isolamento per studio
$plugin->config([
    'eventSources' => [{
        'url' => '/api/appointments',
        'extraParams' => [
            'studio_id' => Filament::getTenant()->id,
        ]
    }]
]);
```

### Validazioni Sanitarie
```javascript
selectConstraint: 'businessHours',
eventConstraint: 'businessHours',
slotDuration: '00:30:00', // 30 min slots
```

---

## fullcalendar-schedulerocumentation

*Consolidated from: `fullcalendar-schedulerocumentation.md`*

title: "FullCalendar Scheduler - Documentazione Completa"
type: concept
tags: [fullcalendar, schedulerocumentation]
created: 2026-07-14
updated: 2026-07-14
qmd: "fullcalendar-schedulerocumentation fullcalendar scheduler - documentazione completa"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# FullCalendar Scheduler - Documentazione Completa

## Panoramica
Questa documentazione fornisce una guida completa per la gestione delle licenze FullCalendar Scheduler nel progetto , basata sulla ricerca approfondita della documentazione ufficiale e dei problemi comuni riscontrati nella community.
Questa documentazione fornisce una guida completa per la gestione delle licenze FullCalendar Scheduler nel progetto <nome progetto>, basata sulla ricerca approfondita della documentazione ufficiale e dei problemi comuni riscontrati nella community.
## Documenti Disponibili
### 📚 Documentazione Principale
#### 1. [FullCalendar Scheduler Troubleshooting](./fullcalendar-scheduler-license-troubleshooting.md)
**Documento principale** - Guida completa e dettagliata che copre:
- Tipi di licenza disponibili (Commerciale, Non-Profit, GPLv3)
- Problemi comuni e soluzioni dettagliate
- Configurazione completa per Laravel/Filament
- Best practices per
- Best practices per <nome progetto>
- Testing e debugging avanzato
- Sicurezza e gestione ambienti
#### 2. [FullCalendar Quick Reference](./fullcalendar-scheduler-quick-reference.md)
**Riferimento rapido** - Soluzioni immediate per:
- Errori più comuni con fix immediati
- Checklist di verifica
- Configurazioni essenziali
- Comandi di debug
### 📖 Documentazione Esistente (Aggiornata)
#### 3. [FullCalendar Scheduler License](./fullcalendar-scheduler-license.md)
Documentazione base esistente per:
- Panoramica generale licenze
- Configurazione di base in
- Configurazione di base in <nome progetto>
- Problemi comuni basilari
#### 4. [Scheduler License Key](./scheduler-license-key.md)
#### 4. [Scheduler License Key](../../scheduler-license-key-fullcalendar.md)
Guida rapida esistente per:
- Uso base delle chiavi licenza
- Problemi di formato chiavi
- Informazioni di supporto
## Problemi Risolti dalla Documentazione
### 🔍 Ricerca Effettuata
La documentazione è basata su ricerca approfondita di:
- **Documentazione ufficiale FullCalendar**: https://fullcalendar.io/project_docs/schedulerLicenseKey
- **Documentazione ufficiale FullCalendar**: https://fullcalendar.io/docs/schedulerLicenseKey
- **GitHub Issues**: Analisi di 17+ issue relativi a problemi di licenza
- **Community feedback**: Problemi ricorrenti nelle versioni 5.x e 6.x
- **Best practices**: Configurazioni ottimali per ambienti di produzione
### 🐛 Bug Noti Documentati
1. **"Unknown option 'schedulerLicenseKey'" (v5.x-6.x)**
   - Causa: Plugin premium non importato
   - Workaround: Import esplicito plugin + BASE_OPTION_REFINERS
2. **TypeScript/Angular Issues**
   - Problema: Opzione non riconosciuta in strict mode
   - Soluzione: Cast `any` e `@ts-ignore`
3. **React/Vite Export Issues (v6.x)**
   - Problema: BASE_OPTION_DEFAULTS non esportato
   - Soluzione: Workaround con ignore directives
### 🎯 Soluzioni Specifiche
### 🎯 Soluzioni Specifiche <nome progetto>
La documentazione include configurazioni specifiche per:
- **Multi-tenancy**: Isolamento dati per studio
- **Business hours sanitarie**: Lun-Sab 08:00-19:00
- **Validazioni mediche**: Slot 30 minuti, durate min/max
- **Sicurezza sanitaria**: Audit trail, privacy pazienti
- **Performance**: Caching, lazy loading, rate limiting
## Struttura Implementazione
### 🏗️ Architettura
```
 FullCalendar Implementation
<nome progetto> FullCalendar Implementation
├── AdminPanelProvider.php (Configurazione centrale)
├── config/fullcalendar.php (Configurazioni avanzate)
├── .env (Variabili licenza)
└── Widgets/
    ├── PatientCalendarWidget.php
    ├── DoctorCalendarWidget.php
    └── AdminCalendarWidget.php
### 🔧 Configurazione Completa
La documentazione copre tutti i livelli:
1. **Ambiente** (.env variables)
2. **Configurazione** (config files)
3. **Provider** (AdminPanelProvider)
4. **Widget** (Calendar widgets)
5. **Frontend** (JavaScript callbacks)
## Utilizzo della Documentazione
### 🚀 Per Sviluppatori
1. **Primo setup**: Leggere [Quick Reference](./fullcalendar-scheduler-quick-reference.md)
2. **Problemi specifici**: Consultare [Troubleshooting](./fullcalendar-scheduler-license-troubleshooting.md)
3. **Configurazione avanzata**: Seguire esempi completi nel troubleshooting
### 🔧 Per Troubleshooting
1. **Errore immediato**: Usare Quick Reference per fix rapidi
2. **Problema persistente**: Seguire guida completa troubleshooting
3. **Debug avanzato**: Utilizzare comandi e tecniche documentate
### 📋 Per Deployment
1. **Checklist pre-produzione**: Seguire checklist nel Quick Reference
2. **Configurazione sicurezza**: Implementare best practices documentate
3. **Monitoring**: Utilizzare tecniche di logging documentate
## Aggiornamenti e Manutenzione
### 📅 Versioning
La documentazione è aggiornata per:
- **FullCalendar v6.1.17** (latest)
- **Filament v3.x**
- **Laravel 11.x/12.x**
- ** current architecture**
- **<nome progetto> current architecture**
### 🔄 Aggiornamenti Futuri
Quando aggiornare la documentazione:
- Nuove versioni FullCalendar con breaking changes
- Nuovi bug noti nella community
- Modifiche architettura
- Modifiche architettura <nome progetto>
- Nuovi requisiti sanitari/legali
### 📝 Contributi
Per aggiornare la documentazione:
1. Verificare issue GitHub FullCalendar
2. Testare soluzioni in ambiente
2. Testare soluzioni in ambiente <nome progetto>
3. Aggiornare documenti pertinenti
4. Aggiornare questo summary
## Risorse Esterne
### 🌐 Link Ufficiali
- [FullCalendar Docs](https://fullcalendar.io/project_docs/)
- [Scheduler License](https://fullcalendar.io/project_docs/schedulerLicenseKey)
- [FullCalendar Docs](https://fullcalendar.io/docs/)
- [Scheduler License](https://fullcalendar.io/docs/schedulerLicenseKey)
- [Pricing](https://fullcalendar.io/pricing/)
- [Support](https://fullcalendar.io/support/)
### 🐛 Community
- [GitHub Issues](https://github.com/fullcalendar/fullcalendar/issues)
- [Stack Overflow](https://stackoverflow.com/questions/tagged/fullcalendar)
### 📧 Supporto Commerciale
- **Sales**: sales@fullcalendar.io
- **Technical**: Tramite GitHub Issues
- **License renewal**: Email notifications automatiche
## Conclusioni
Questa documentazione fornisce una copertura completa per tutti gli aspetti delle licenze FullCalendar Scheduler in , dalla configurazione iniziale al troubleshooting avanzato. La combinazione di guida dettagliata e riferimento rapido garantisce supporto sia per sviluppatori esperti che per nuovi team members.
Questa documentazione fornisce una copertura completa per tutti gli aspetti delle licenze FullCalendar Scheduler in <nome progetto>, dalla configurazione iniziale al troubleshooting avanzato. La combinazione di guida dettagliata e riferimento rapido garantisce supporto sia per sviluppatori esperti che per nuovi team members.
**Documenti chiave da consultare:**
1. **Setup iniziale**: Quick Reference
2. **Problemi complessi**: Troubleshooting completo
3. **Riferimento quotidiano**: Quick Reference checklist
4. **Configurazione produzione**: Best practices nel troubleshooting
La documentazione è progettata per essere autosufficiente e ridurre la necessità di ricerche esterne, fornendo tutte le informazioni necessarie per una gestione efficace delle licenze FullCalendar Scheduler nel contesto sanitario di .
La documentazione è progettata per essere autosufficiente e ridurre la necessità di ricerche esterne, fornendo tutte le informazioni necessarie per una gestione efficace delle licenze FullCalendar Scheduler nel contesto sanitario di <nome progetto>.
# FullCalendar Scheduler - Documentazione Completa

## Panoramica

Questa documentazione fornisce una guida completa per la gestione delle licenze FullCalendar Scheduler nel progetto <nome progetto>, basata sulla ricerca approfondita della documentazione ufficiale e dei problemi comuni riscontrati nella community.

## Documenti Disponibili

### 📚 Documentazione Principale

#### 1. [FullCalendar Scheduler Troubleshooting](./fullcalendar-scheduler-license-troubleshooting.md)
**Documento principale** - Guida completa e dettagliata che copre:
- Tipi di licenza disponibili (Commerciale, Non-Profit, GPLv3)
- Problemi comuni e soluzioni dettagliate
- Configurazione completa per Laravel/Filament
- Best practices per <nome progetto>
- Testing e debugging avanzato
- Sicurezza e gestione ambienti

#### 2. [FullCalendar Quick Reference](./fullcalendar-scheduler-quick-reference.md)
**Riferimento rapido** - Soluzioni immediate per:
- Errori più comuni con fix immediati
- Checklist di verifica
- Configurazioni essenziali
- Comandi di debug

### 📖 Documentazione Esistente (Aggiornata)

#### 3. [FullCalendar Scheduler License](./fullcalendar-scheduler-license.md)
Documentazione base esistente per:
- Panoramica generale licenze
- Configurazione di base in <nome progetto>
- Problemi comuni basilari

#### 4. [Scheduler License Key](./scheduler-license-key.md)
#### 4. [Scheduler License Key](../../scheduler-license-key-fullcalendar.md)
Guida rapida esistente per:
- Uso base delle chiavi licenza
- Problemi di formato chiavi
- Informazioni di supporto

## Problemi Risolti dalla Documentazione

### 🔍 Ricerca Effettuata

La documentazione è basata su ricerca approfondita di:
- **Documentazione ufficiale FullCalendar**: https://fullcalendar.io/docs/schedulerLicenseKey
- **GitHub Issues**: Analisi di 17+ issue relativi a problemi di licenza
- **Community feedback**: Problemi ricorrenti nelle versioni 5.x e 6.x
- **Best practices**: Configurazioni ottimali per ambienti di produzione

### 🐛 Bug Noti Documentati

1. **"Unknown option 'schedulerLicenseKey'" (v5.x-6.x)**
   - Causa: Plugin premium non importato
   - Workaround: Import esplicito plugin + BASE_OPTION_REFINERS

2. **TypeScript/Angular Issues**
   - Problema: Opzione non riconosciuta in strict mode
   - Soluzione: Cast `any` e `@ts-ignore`

3. **React/Vite Export Issues (v6.x)**
   - Problema: BASE_OPTION_DEFAULTS non esportato
   - Soluzione: Workaround con ignore directives

### 🎯 Soluzioni Specifiche <nome progetto>

La documentazione include configurazioni specifiche per:
- **Multi-tenancy**: Isolamento dati per studio
- **Business hours sanitarie**: Lun-Sab 08:00-19:00
- **Validazioni mediche**: Slot 30 minuti, durate min/max
- **Sicurezza sanitaria**: Audit trail, privacy pazienti
- **Performance**: Caching, lazy loading, rate limiting

## Struttura Implementazione

### 🏗️ Architettura

```
<nome progetto> FullCalendar Implementation
├── AdminPanelProvider.php (Configurazione centrale)
├── config/fullcalendar.php (Configurazioni avanzate)
├── .env (Variabili licenza)
└── Widgets/
    ├── PatientCalendarWidget.php
    ├── DoctorCalendarWidget.php
    └── AdminCalendarWidget.php
```

### 🔧 Configurazione Completa

La documentazione copre tutti i livelli:
1. **Ambiente** (.env variables)
2. **Configurazione** (config files)
3. **Provider** (AdminPanelProvider)
4. **Widget** (Calendar widgets)
5. **Frontend** (JavaScript callbacks)

## Utilizzo della Documentazione

### 🚀 Per Sviluppatori

1. **Primo setup**: Leggere [Quick Reference](./fullcalendar-scheduler-quick-reference.md)
2. **Problemi specifici**: Consultare [Troubleshooting](./fullcalendar-scheduler-license-troubleshooting.md)
3. **Configurazione avanzata**: Seguire esempi completi nel troubleshooting

### 🔧 Per Troubleshooting

1. **Errore immediato**: Usare Quick Reference per fix rapidi
2. **Problema persistente**: Seguire guida completa troubleshooting
3. **Debug avanzato**: Utilizzare comandi e tecniche documentate

### 📋 Per Deployment

1. **Checklist pre-produzione**: Seguire checklist nel Quick Reference
2. **Configurazione sicurezza**: Implementare best practices documentate
3. **Monitoring**: Utilizzare tecniche di logging documentate

## Aggiornamenti e Manutenzione

### 📅 Versioning

La documentazione è aggiornata per:
- **FullCalendar v6.1.17** (latest)
- **Filament v3.x**
- **Laravel 11.x/12.x**
- **<nome progetto> current architecture**

### 🔄 Aggiornamenti Futuri

Quando aggiornare la documentazione:
- Nuove versioni FullCalendar con breaking changes
- Nuovi bug noti nella community
- Modifiche architettura <nome progetto>
- Nuovi requisiti sanitari/legali

### 📝 Contributi

Per aggiornare la documentazione:
1. Verificare issue GitHub FullCalendar
2. Testare soluzioni in ambiente <nome progetto>
3. Aggiornare documenti pertinenti
4. Aggiornare questo summary

## Risorse Esterne

### 🌐 Link Ufficiali
- [FullCalendar Docs](https://fullcalendar.io/docs/)
- [Scheduler License](https://fullcalendar.io/docs/schedulerLicenseKey)
- [Pricing](https://fullcalendar.io/pricing/)
- [Support](https://fullcalendar.io/support/)

### 🐛 Community
- [GitHub Issues](https://github.com/fullcalendar/fullcalendar/issues)
- [Stack Overflow](https://stackoverflow.com/questions/tagged/fullcalendar)

### 📧 Supporto Commerciale
- **Sales**: sales@fullcalendar.io
- **Technical**: Tramite GitHub Issues
- **License renewal**: Email notifications automatiche

## Conclusioni

Questa documentazione fornisce una copertura completa per tutti gli aspetti delle licenze FullCalendar Scheduler in <nome progetto>, dalla configurazione iniziale al troubleshooting avanzato. La combinazione di guida dettagliata e riferimento rapido garantisce supporto sia per sviluppatori esperti che per nuovi team members.

**Documenti chiave da consultare:**
1. **Setup iniziale**: Quick Reference
2. **Problemi complessi**: Troubleshooting completo
3. **Riferimento quotidiano**: Quick Reference checklist
4. **Configurazione produzione**: Best practices nel troubleshooting

La documentazione è progettata per essere autosufficiente e ridurre la necessità di ricerche esterne, fornendo tutte le informazioni necessarie per una gestione efficace delle licenze FullCalendar Scheduler nel contesto sanitario di <nome progetto>.

---

## fullcalendar_scheduler_documentation_summary

*Consolidated from: `fullcalendar_scheduler_documentation_summary.md`*


## Panoramica

Questa documentazione fornisce una guida completa per la gestione delle licenze FullCalendar Scheduler nel progetto SaluteOra, basata sulla ricerca approfondita della documentazione ufficiale e dei problemi comuni riscontrati nella community.

## Documenti Disponibili

### 📚 Documentazione Principale

#### 1. [FullCalendar Scheduler Troubleshooting](./fullcalendar-scheduler-license-troubleshooting.md)
**Documento principale** - Guida completa e dettagliata che copre:
- Tipi di licenza disponibili (Commerciale, Non-Profit, GPLv3)
- Problemi comuni e soluzioni dettagliate
- Configurazione completa per Laravel/Filament
- Best practices per SaluteOra
- Testing e debugging avanzato
- Sicurezza e gestione ambienti

#### 2. [FullCalendar Quick Reference](./fullcalendar-scheduler-quick-reference.md)
**Riferimento rapido** - Soluzioni immediate per:
- Errori più comuni con fix immediati
- Checklist di verifica
- Configurazioni essenziali
- Comandi di debug

### 📖 Documentazione Esistente (Aggiornata)

#### 3. [FullCalendar Scheduler License](./fullcalendar-scheduler-license.md)
Documentazione base esistente per:
- Panoramica generale licenze
- Configurazione di base in SaluteOra
- Problemi comuni basilari

#### 4. [Scheduler License Key](./scheduler_license_key.md)
Guida rapida esistente per:
- Uso base delle chiavi licenza
- Problemi di formato chiavi
- Informazioni di supporto

## Problemi Risolti dalla Documentazione

### 🔍 Ricerca Effettuata

La documentazione è basata su ricerca approfondita di:
- **Documentazione ufficiale FullCalendar**: https://fullcalendar.io/docs/schedulerLicenseKey
- **GitHub Issues**: Analisi di 17+ issue relativi a problemi di licenza
- **Community feedback**: Problemi ricorrenti nelle versioni 5.x e 6.x
- **Best practices**: Configurazioni ottimali per ambienti di produzione

### 🐛 Bug Noti Documentati

1. **"Unknown option 'schedulerLicenseKey'" (v5.x-6.x)**
   - Causa: Plugin premium non importato
   - Workaround: Import esplicito plugin + BASE_OPTION_REFINERS

2. **TypeScript/Angular Issues**
   - Problema: Opzione non riconosciuta in strict mode
   - Soluzione: Cast `any` e `@ts-ignore`

3. **React/Vite Export Issues (v6.x)**
   - Problema: BASE_OPTION_DEFAULTS non esportato
   - Soluzione: Workaround con ignore directives

### 🎯 Soluzioni Specifiche SaluteOra

La documentazione include configurazioni specifiche per:
- **Multi-tenancy**: Isolamento dati per studio
- **Business hours sanitarie**: Lun-Sab 08:00-19:00
- **Validazioni mediche**: Slot 30 minuti, durate min/max
- **Sicurezza sanitaria**: Audit trail, privacy pazienti
- **Performance**: Caching, lazy loading, rate limiting

## Struttura Implementazione

### 🏗️ Architettura

```
SaluteOra FullCalendar Implementation
├── AdminPanelProvider.php (Configurazione centrale)
├── config/fullcalendar.php (Configurazioni avanzate)
├── .env (Variabili licenza)
└── Widgets/
    ├── PatientCalendarWidget.php
    ├── DoctorCalendarWidget.php
    └── AdminCalendarWidget.php
```

### 🔧 Configurazione Completa

La documentazione copre tutti i livelli:
1. **Ambiente** (.env variables)
2. **Configurazione** (config files)
3. **Provider** (AdminPanelProvider)
4. **Widget** (Calendar widgets)
5. **Frontend** (JavaScript callbacks)

## Utilizzo della Documentazione

### 🚀 Per Sviluppatori

1. **Primo setup**: Leggere [Quick Reference](./fullcalendar-scheduler-quick-reference.md)
2. **Problemi specifici**: Consultare [Troubleshooting](./fullcalendar-scheduler-license-troubleshooting.md)
3. **Configurazione avanzata**: Seguire esempi completi nel troubleshooting

### 🔧 Per Troubleshooting

1. **Errore immediato**: Usare Quick Reference per fix rapidi
2. **Problema persistente**: Seguire guida completa troubleshooting
3. **Debug avanzato**: Utilizzare comandi e tecniche documentate

### 📋 Per Deployment

1. **Checklist pre-produzione**: Seguire checklist nel Quick Reference
2. **Configurazione sicurezza**: Implementare best practices documentate
3. **Monitoring**: Utilizzare tecniche di logging documentate

## Aggiornamenti e Manutenzione

### 📅 Versioning

La documentazione è aggiornata per:
- **FullCalendar v6.1.17** (latest)
- **Filament v3.x**
- **Laravel 11.x/12.x**
- **SaluteOra current architecture**

### 🔄 Aggiornamenti Futuri

Quando aggiornare la documentazione:
- Nuove versioni FullCalendar con breaking changes
- Nuovi bug noti nella community
- Modifiche architettura SaluteOra
- Nuovi requisiti sanitari/legali

### 📝 Contributi

Per aggiornare la documentazione:
1. Verificare issue GitHub FullCalendar
2. Testare soluzioni in ambiente SaluteOra
3. Aggiornare documenti pertinenti
4. Aggiornare questo summary

## Risorse Esterne

### 🌐 Link Ufficiali
- [FullCalendar Docs](https://fullcalendar.io/docs/)
- [Scheduler License](https://fullcalendar.io/docs/schedulerLicenseKey)
- [Pricing](https://fullcalendar.io/pricing/)
- [Support](https://fullcalendar.io/support/)

### 🐛 Community
- [GitHub Issues](https://github.com/fullcalendar/fullcalendar/issues)
- [Stack Overflow](https://stackoverflow.com/questions/tagged/fullcalendar)

### 📧 Supporto Commerciale
- **Sales**: sales@fullcalendar.io
- **Technical**: Tramite GitHub Issues
- **License renewal**: Email notifications automatiche

## Conclusioni

Questa documentazione fornisce una copertura completa per tutti gli aspetti delle licenze FullCalendar Scheduler in SaluteOra, dalla configurazione iniziale al troubleshooting avanzato. La combinazione di guida dettagliata e riferimento rapido garantisce supporto sia per sviluppatori esperti che per nuovi team members.

**Documenti chiave da consultare:**
1. **Setup iniziale**: Quick Reference
2. **Problemi complessi**: Troubleshooting completo
3. **Riferimento quotidiano**: Quick Reference checklist
4. **Configurazione produzione**: Best practices nel troubleshooting

La documentazione è progettata per essere autosufficiente e ridurre la necessità di ricerche esterne, fornendo tutte le informazioni necessarie per una gestione efficace delle licenze FullCalendar Scheduler nel contesto sanitario di SaluteOra. 

---

## fullcalendar_scheduler_license

*Consolidated from: `fullcalendar_scheduler_license.md`*


## License Key Overview

FullCalendar Scheduler requires a valid license key for use in production environments. The Scheduler is a premium add-on to FullCalendar that provides resource views and timeline functionality.

## License Types

1. **Development License**
   - Free for development and testing
   - Shows a red banner with "LICENSE NEEDED" message
   - Not suitable for production use

2. **Commercial License**
   - Required for production use
   - Removes the red banner
   - Available for purchase from [FullCalendar's pricing page](https://fullcalendar.io/pricing/)

## Configuration in SaluteOra

### Setting the License Key

1. **Environment Configuration**
   Add your license key to your `.env` file:
   ```
   FULLCALENDAR_SCHEDULER_LICENSE=your-license-key-here
   ```

2. **Publish Configuration**
   Publish the FullCalendar configuration file:
   ```bash
   php artisan vendor:publish --tag=fullcalendar-config
   ```

3. **Update Config**
   In `config/fullcalendar.php`:
   ```php
   'scheduler_license_key' => env('FULLCALENDAR_SCHEDULER_LICENSE'),
   ```

### Usage in Code

In your PanelProvider or where you configure FullCalendar:

```

```php
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;

// ...

$calendarPlugin = FilamentFullCalendarPlugin::make()
    ->schedulerLicenseKey(config('fullcalendar.scheduler_license_key'))
    // other configurations...
```

## Common Issues

### Invalid License Key

If you see a red banner with "LICENSE NEEDED", it means:
- No license key is set, or
- The provided license key is invalid

### Development Mode

In development, you can use the Scheduler without a license key, but you'll see a red banner. This is normal and expected behavior.

## Compliance

- Always ensure you have a valid license for production use
- Do not share or expose your license key in version control
- Purchase the appropriate license based on your deployment needs

## Support

For license-related issues, contact FullCalendar support:
- [FullCalendar Support](https://fullcalendar.io/support/)
- [License FAQ](https://fullcalendar.io/license/faq/)

## Version Compatibility

Ensure your license key is compatible with the version of FullCalendar Scheduler you're using. Check the [changelog](https://fullcalendar.io/changelog/) for version-specific requirements.

---

## fullcalendar_scheduler_license_key_invalid

*Consolidated from: `fullcalendar_scheduler_license_key_invalid.md`*


---

## fullcalendar_scheduler_license_troubleshooting

*Consolidated from: `fullcalendar_scheduler_license_troubleshooting.md`*


## Panoramica

Questa documentazione fornisce una guida completa per la risoluzione dei problemi relativi alle licenze FullCalendar Scheduler, basata sulla documentazione ufficiale e sui problemi comuni riscontrati nella community.

## Tipi di Licenza FullCalendar

### FullCalendar Standard (MIT License)
- **Gratuito** per uso commerciale e non commerciale
- Include i plugin base (dayGrid, timeGrid, list, interaction)
- **NON** include funzionalità premium come resource views e timeline

### FullCalendar Premium (Scheduler)
- **Richiede licenza commerciale** per uso in produzione
- Include resource views, timeline, e funzionalità avanzate
- Diversi tipi di licenza disponibili

## Tipi di Licenza Premium

### 1. Licenza Commerciale
```javascript
var calendar = new Calendar(calendarEl, {
  schedulerLicenseKey: 'XXXXXXXXXX-XXX-XXXXXXXXXX', // Formato tipico
  plugins: [resourceTimelinePlugin],
  initialView: 'resourceTimelineWeek'
});
```

**Caratteristiche:**
- Per aziende e uso commerciale
- Permette modifiche al codice sorgente
- NON permette redistribuzione delle modifiche
- Acquisto necessario da [FullCalendar Pricing](https://fullcalendar.io/pricing/)

### 2. Licenza Non-Commerciale
```javascript
var calendar = new Calendar(calendarEl, {
  schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
  plugins: [resourceTimelinePlugin],
  initialView: 'resourceTimelineWeek'
});
```

**Caratteristiche:**
- **Gratuita** per organizzazioni non-profit registrate
- NON copre enti governativi e università
- NON permette modifiche al codice sorgente

### 3. Licenza GPLv3 Open Source
```javascript
var calendar = new Calendar(calendarEl, {
  schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
  plugins: [resourceTimelinePlugin],
  initialView: 'resourceTimelineWeek'
});
```

**Caratteristiche:**
- **Gratuita** per progetti completamente GPLv3-compliant
- Richiede che tutto il progetto sia open source sotto GPLv3

## Problemi Comuni e Soluzioni

### 1. "Unknown option 'schedulerLicenseKey'" Error

**Problema:** L'opzione `schedulerLicenseKey` non viene riconosciuta.

**Cause Possibili:**
- Plugin premium non importato correttamente
- Versione FullCalendar incompatibile
- Bug noto nelle versioni 5.x e 6.x

**Soluzioni:**

#### Soluzione A: Verificare Import Plugin Premium
```javascript
// Assicurarsi di importare almeno un plugin premium
import resourceTimelinePlugin from '@fullcalendar/resource-timeline';
import resourceDayGridPlugin from '@fullcalendar/resource-daygrid';

var calendar = new Calendar(calendarEl, {
  schedulerLicenseKey: 'YOUR-LICENSE-KEY',
  plugins: [resourceTimelinePlugin, resourceDayGridPlugin], // Plugin premium richiesto
  initialView: 'resourceTimelineWeek'
});
```

#### Soluzione B: Workaround per TypeScript/Angular (v5.x-6.x)
```typescript
import { BASE_OPTION_REFINERS } from '@fullcalendar/core';

// Workaround per bug noto
(BASE_OPTION_REFINERS as any).schedulerLicenseKey = String;

// Poi configurare normalmente
const calendarOptions = {
  schedulerLicenseKey: 'YOUR-LICENSE-KEY',
  // altre opzioni...
};
```

#### Soluzione C: Per React/TypeScript (v6.x)
```typescript
// Se BASE_OPTION_DEFAULTS non è disponibile, usare ignore
/* @ts-ignore */
const calendarOptions = {
  schedulerLicenseKey: 'YOUR-LICENSE-KEY',
  plugins: [resourceTimelinePlugin],
  // altre opzioni...
};
```

### 2. "Invalid License String" Error

**Problema:** La chiave di licenza non viene riconosciuta come valida.

**Cause:**
- Chiave copiata incorrettamente
- Caratteri extra o mancanti
- Confusione con altri tipi di chiavi (customer key, support key)

**Soluzioni:**
1. **Verificare formato:** La chiave deve essere nel formato `XXXXXXXXXX-XXX-XXXXXXXXXX`
2. **Copiare esattamente:** Copiare la chiave esattamente come ricevuta via email
3. **Controllare spazi:** Rimuovere spazi iniziali/finali
4. **Verificare source:** Assicurarsi di usare la license key, non il customer number

### 3. "Evaluation Period Has Expired" Error

**Problema:** Il periodo di valutazione è scaduto.

**Soluzioni:**
1. **Acquistare licenza:** Visitare [FullCalendar Pricing](https://fullcalendar.io/pricing/)
2. **Contattare support:** Email a `sales@fullcalendar.io` per rinnovo
3. **Licenza offline:** Richiedere chiave offline se necessario

### 4. "Outdated License Key" Warning

**Problema:** Chiave valida ma obsoleta per la versione corrente.

**Cause:**
- Aggiornamento FullCalendar oltre il periodo di upgrade gratuito (1 anno)
- Licenza acquistata per versione precedente

**Soluzioni:**
1. **Downgrade:** Usare versione FullCalendar compatibile con la licenza
2. **Upgrade licenza:** Acquistare anno aggiuntivo di supporto
3. **Contattare sales:** Email a `sales@fullcalendar.io` per rinnovo

## Configurazione in Laravel/Filament

### 1. Variabili Ambiente (.env)
```env
# Licenza FullCalendar Scheduler
FULLCALENDAR_SCHEDULER_LICENSE_KEY=XXXXXXXXXX-XXX-XXXXXXXXXX

# Configurazioni aggiuntive
FULLCALENDAR_CACHE_TTL=300
FULLCALENDAR_MAX_EVENTS=100
```

### 2. Configurazione (config/fullcalendar.php)
```php
<?php

return [
    // Licenza Scheduler
    'scheduler_license_key' => env('FULLCALENDAR_SCHEDULER_LICENSE_KEY'),
    
    // Validazione licenza
    'validate_license' => env('APP_ENV') === 'production',
    
    // Fallback per sviluppo
    'development_mode' => env('APP_ENV') !== 'production',
    
    // Plugin premium abilitati
    'premium_plugins' => [
        'resource-timeline',
        'resource-daygrid',
        'resource-timegrid',
    ],
];
```

### 3. AdminPanelProvider (Filament)
```php
<?php

namespace Modules\SaluteOra\app\Providers\Filament;

use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;

class AdminPanelProvider extends XotBasePanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->plugins([
                $this->getFullCalendarPlugin(),
                // altri plugin...
            ]);
    }

    private function getFullCalendarPlugin(): FilamentFullCalendarPlugin
    {
        $licenseKey = config('fullcalendar.scheduler_license_key');
        
        // Validazione licenza in produzione
        if (app()->environment('production') && empty($licenseKey)) {
            throw new \Exception('FullCalendar Scheduler license key required in production');
        }

        $plugin = FilamentFullCalendarPlugin::make()
            ->selectable()
            ->editable();

        // Applicare licenza solo se presente
        if (!empty($licenseKey)) {
            $plugin->schedulerLicenseKey($licenseKey);
        }

        return $plugin->config([
            'plugins' => [
                'dayGrid',
                'timeGrid',
                'list',
                'interaction',
                'multiMonth',
                'scrollGrid',
                // Plugin premium (richiedono licenza)
                'resourceTimeline',
                'resourceDayGrid',
                'resourceTimeGrid',
            ],
            
            // Configurazioni specifiche per SaluteOra
            'locale' => 'it',
            'timezone' => 'Europe/Rome',
            'firstDay' => 1,
            
            // Business hours sanitarie
            'businessHours' => [
                'daysOfWeek' => [1, 2, 3, 4, 5, 6], // Lun-Sab
                'startTime' => '08:00',
                'endTime' => '19:00',
            ],
            
            // Validazioni
            'selectConstraint' => 'businessHours',
            'eventConstraint' => 'businessHours',
            
            // Performance
            'lazyFetching' => true,
            'eventLimit' => config('fullcalendar.max_events', 100),
        ]);
    }
}
```

## Testing e Debug

### 1. Verifica Configurazione
```bash
# Verificare variabili ambiente
php artisan config:show fullcalendar

# Test configurazione FullCalendar
php artisan tinker
>>> config('fullcalendar.scheduler_license_key')
```

### 2. Debug JavaScript Console
```javascript
// Verificare se plugin premium sono caricati
console.log(FullCalendar.globalPlugins);

// Verificare configurazione calendario
console.log(calendar.getOption('schedulerLicenseKey'));
```

### 3. Comandi Artisan Personalizzati
```php
<?php
// app/Console/Commands/FullCalendarDebug.php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FullCalendarDebug extends Command
{
    protected $signature = 'fullcalendar:debug';
    protected $description = 'Debug FullCalendar configuration';

    public function handle()
    {
        $licenseKey = config('fullcalendar.scheduler_license_key');
        
        $this->info('FullCalendar Configuration Debug');
        $this->line('================================');
        
        if (empty($licenseKey)) {
            $this->error('❌ No license key configured');
            $this->warn('Set FULLCALENDAR_SCHEDULER_LICENSE_KEY in .env');
        } else {
            $this->info('✅ License key configured');
            $this->line('Key: ' . substr($licenseKey, 0, 10) . '...');
        }
        
        $this->line('Environment: ' . app()->environment());
        $this->line('Premium plugins: ' . json_encode(config('fullcalendar.premium_plugins', [])));
        
        return 0;
    }
}
```

## Best Practices per SaluteOra

### 1. Sicurezza Licenza
```php
// Non esporre mai la licenza nei log
Log::info('FullCalendar configured', [
    'has_license' => !empty(config('fullcalendar.scheduler_license_key')),
    'environment' => app()->environment(),
    // NON loggare la licenza effettiva
]);
```

### 2. Gestione Ambienti
```php
// Configurazione differenziata per ambiente
if (app()->environment('production')) {
    // Licenza obbligatoria in produzione
    $licenseKey = config('fullcalendar.scheduler_license_key');
    if (empty($licenseKey)) {
        throw new \Exception('Scheduler license required in production');
    }
} else {
    // Sviluppo: mostrare warning ma continuare
    if (empty(config('fullcalendar.scheduler_license_key'))) {
        logger()->warning('FullCalendar Scheduler running without license (development mode)');
    }
}
```

### 3. Monitoring Licenza
```php
// Monitoraggio scadenza licenza
class FullCalendarLicenseCheck
{
    public function checkLicenseValidity(): bool
    {
        $licenseKey = config('fullcalendar.scheduler_license_key');
        
        if (empty($licenseKey)) {
            return false;
        }
        
        // Implementare controllo validità se necessario
        // (FullCalendar non fornisce API per questo)
        
        return true;
    }
}
```

## Troubleshooting Avanzato

### 1. Problemi di Versioning
- **v5.x:** Bug noto con `schedulerLicenseKey`, usare workaround
- **v6.x:** Problemi con TypeScript exports, usare `@ts-ignore`
- **Aggiornamenti:** Verificare sempre compatibilità licenza

### 2. Problemi di Build
```javascript
// Webpack/Vite: assicurarsi che plugin premium siano inclusi
import '@fullcalendar/resource-timeline/index.css';
import resourceTimelinePlugin from '@fullcalendar/resource-timeline';
```

### 3. Problemi di Performance
```javascript
// Limitare eventi per evitare problemi di licenza
const calendarOptions = {
  schedulerLicenseKey: 'YOUR-KEY',
  eventSources: [{
    url: '/api/events',
    extraParams: {
      limit: 100 // Limitare numero eventi
    }
  }]
};
```

## Contatti e Supporto

### FullCalendar Support
- **Sales:** sales@fullcalendar.io
- **Support:** [FullCalendar Support](https://fullcalendar.io/support/)
- **Documentation:** [FullCalendar Docs](https://fullcalendar.io/docs/)

### Risorse Utili
- [Pricing](https://fullcalendar.io/pricing/)
- [License FAQ](https://fullcalendar.io/license/faq/)
- [GitHub Issues](https://github.com/fullcalendar/fullcalendar/issues)
- [Changelog](https://fullcalendar.io/changelog/)

## Conclusioni

La gestione delle licenze FullCalendar Scheduler richiede attenzione particolare, specialmente in ambienti di produzione sanitari come SaluteOra. Seguire questa guida garantisce una configurazione corretta e la risoluzione dei problemi più comuni.

**Punti Chiave:**
1. **Licenza obbligatoria** per uso commerciale in produzione
2. **Plugin premium richiesti** per `schedulerLicenseKey`
3. **Workaround disponibili** per bug noti nelle versioni 5.x-6.x
4. **Configurazione ambiente-specifica** per sviluppo vs produzione
5. **Monitoring e logging** per troubleshooting proattivo 

---

## fullcalendar_scheduler_quick_reference

*Consolidated from: `fullcalendar_scheduler_quick_reference.md`*


## 🚨 Problemi Comuni e Soluzioni Immediate

### ❌ "Unknown option 'schedulerLicenseKey'"

**Causa:** Plugin premium non importato
```javascript
// ✅ SOLUZIONE: Importare plugin premium
import resourceTimelinePlugin from '@fullcalendar/resource-timeline';

var calendar = new Calendar(calendarEl, {
  schedulerLicenseKey: 'YOUR-KEY',
  plugins: [resourceTimelinePlugin], // ← NECESSARIO
  initialView: 'resourceTimelineWeek'
});
```

**Workaround TypeScript/Angular:**
```typescript
import { BASE_OPTION_REFINERS } from '@fullcalendar/core';
(BASE_OPTION_REFINERS as any).schedulerLicenseKey = String;
```

### ❌ "Invalid License String"

**Causa:** Formato chiave errato
```javascript
// ❌ SBAGLIATO
schedulerLicenseKey: 'customer-12345'

// ✅ CORRETTO
schedulerLicenseKey: 'XXXXXXXXXX-XXX-XXXXXXXXXX'
```

### ❌ "Evaluation Period Has Expired"

**Soluzioni:**
1. Acquistare licenza: https://fullcalendar.io/pricing/
2. Email support: sales@fullcalendar.io
3. Downgrade versione FullCalendar

### ❌ Banner Rosso "LICENSE NEEDED"

**Causa:** Nessuna licenza configurata
```php
// ✅ SOLUZIONE Laravel
// .env
FULLCALENDAR_SCHEDULER_LICENSE_KEY=YOUR-KEY-HERE

// AdminPanelProvider.php
FilamentFullCalendarPlugin::make()
    ->schedulerLicenseKey(config('fullcalendar.scheduler_license_key'))
```

## 🔑 Tipi di Licenza

### Commerciale
```javascript
schedulerLicenseKey: 'XXXXXXXXXX-XXX-XXXXXXXXXX' // Acquistata
```

### Non-Profit (Gratuita)
```javascript
schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives'
```

### Open Source GPLv3 (Gratuita)
```javascript
schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source'
```

## ⚙️ Configurazione Laravel/Filament

### .env
```env
FULLCALENDAR_SCHEDULER_LICENSE_KEY=XXXXXXXXXX-XXX-XXXXXXXXXX
```

### config/fullcalendar.php
```php
return [
    'scheduler_license_key' => env('FULLCALENDAR_SCHEDULER_LICENSE_KEY'),
    'validate_license' => env('APP_ENV') === 'production',
];
```

### AdminPanelProvider.php
```php
private function getFullCalendarPlugin(): FilamentFullCalendarPlugin
{
    $licenseKey = config('fullcalendar.scheduler_license_key');
    
    $plugin = FilamentFullCalendarPlugin::make()
        ->selectable()
        ->editable();

    if (!empty($licenseKey)) {
        $plugin->schedulerLicenseKey($licenseKey);
    }

    return $plugin->config([
        'plugins' => [
            'dayGrid', 'timeGrid', 'list', 'interaction',
            'resourceTimeline', 'resourceDayGrid', // Premium
        ],
    ]);
}
```

## 🧪 Testing e Debug

### Verifica Configurazione
```bash
php artisan config:show fullcalendar
php artisan tinker
>>> config('fullcalendar.scheduler_license_key')
```

### Debug JavaScript
```javascript
console.log(FullCalendar.globalPlugins);
console.log(calendar.getOption('schedulerLicenseKey'));
```

### Comando Debug Personalizzato
```php
// app/Console/Commands/FullCalendarDebug.php
php artisan make:command FullCalendarDebug
php artisan fullcalendar:debug
```

## 🔒 Sicurezza

### ❌ NON FARE
```php
// Non loggare mai la licenza
Log::info('License: ' . $licenseKey); // ❌ PERICOLOSO
```

### ✅ FARE
```php
// Loggare solo presenza licenza
Log::info('FullCalendar configured', [
    'has_license' => !empty($licenseKey),
    'environment' => app()->environment(),
]);
```

## 🌍 Gestione Ambienti

### Produzione (Licenza Obbligatoria)
```php
if (app()->environment('production') && empty($licenseKey)) {
    throw new \Exception('Scheduler license required in production');
}
```

### Sviluppo (Warning)
```php
if (app()->environment('local') && empty($licenseKey)) {
    logger()->warning('FullCalendar running without license (dev mode)');
}
```

## 📞 Supporto

- **Sales:** sales@fullcalendar.io
- **Pricing:** https://fullcalendar.io/pricing/
- **Docs:** https://fullcalendar.io/docs/schedulerLicenseKey
- **GitHub:** https://github.com/fullcalendar/fullcalendar/issues

## 🎯 Checklist Rapida

- [ ] Plugin premium importato (`@fullcalendar/resource-timeline`)
- [ ] Licenza configurata in `.env`
- [ ] Formato licenza corretto (`XXXXXXXXXX-XXX-XXXXXXXXXX`)
- [ ] Plugin applicato in AdminPanelProvider
- [ ] Test in console JavaScript
- [ ] Verifica ambiente produzione vs sviluppo
- [ ] Banner rosso rimosso
- [ ] Funzionalità premium attive

## 🚀 SaluteOra Specifico

### Business Hours Sanitarie
```javascript
businessHours: {
  daysOfWeek: [1, 2, 3, 4, 5, 6], // Lun-Sab
  startTime: '08:00',
  endTime: '19:00',
}
```

### Configurazione Multi-Tenant
```php
// Isolamento per studio
$plugin->config([
    'eventSources' => [{
        'url' => '/api/appointments',
        'extraParams' => [
            'studio_id' => Filament::getTenant()->id,
        ]
    }]
]);
```

### Validazioni Sanitarie
```javascript
selectConstraint: 'businessHours',
eventConstraint: 'businessHours',
slotDuration: '00:30:00', // 30 min slots
``` 

---

**Consolidated by:** Phase 2f intelligent merging
**Date:** 2026-08-04
