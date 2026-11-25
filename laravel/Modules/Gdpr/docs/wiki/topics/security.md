---
title: "Topic security"
type: digest
status: active
qmd: "digest ceiling 100 security"
---

# Topic security

Sintesi automatica di 3 documenti (chiave `security`).

## Configurazione della Sicurezza

_Fonte: `html2pdf/security.md`_

# Configurazione della Sicurezza

A partire dalla versione 5.3, `Html2Pdf` ha introdotto un `Security Service` per controllare l'accesso a risorse esterne (immagini, fogli di stile, etc.) e prevenire vulnerabilità.

**Menu di Navigazione:**
*   [Panoramica e Installazione](./index.md)
*   [Utilizzo Base e Layout](./usage.md)
*   [Guida agli Stili](./styling.md)
*   [Funzionalità Avanzate](./advanced.md)
*   [Integrazione con Laravel e Best Practices](./laravel.md)

---

title: "security"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "security"
issues: []
discussions: []
## 🛡️ Security Service

Il servizio di sicurezza permette di definire policy per validare gli URI delle risorse esterne.

### Implementazione di una Policy di Sicurezza Personalizzata
È possibile creare una classe che implementa `Spipu\Html2Pdf\Security\SecurityInterface` per definire la propria logica di validazione.

```php

## security

_Fonte: `packages/security.md`_

See canonical documentation: ../../../../Themes/docs/shared-components/.gitkeep

## security

_Fonte: `security.md`_

See canonical documentation: ../../../Themes/docs/shared-components/.gitkeep
