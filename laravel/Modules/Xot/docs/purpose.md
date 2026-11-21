---
title: "Xot: scopo del modulo e confini"
type: concept
status: active
updated: 2026-11-16
module: Xot
qmd: "scopo confini modulo Xot business logic"
---

# Xot: scopo del modulo

## Lo scopo in una frase **Xot è il fondamento architetturale dell'intera piattaforma: fornisce classi base (`XotBaseModel`, `XotBaseResource`, `XotBasePage`), contract per la type-safety, e pattern riutilizzabili che tutti gli altri 17 moduli estendono.** Nessun modulo estende Filament direttamente. Si estende `XotBaseResource`, `XotBaseListRecords`, `XotBaseWidget`, `XotBaseServiceProvider`, `XotBaseMigration`. Questa è **la** regola fondamentale del progetto, e Xot è il posto dove vive.

## Confini

Verificare sul codice: dipendenze verso Xot/User/Ptv/Sigma secondo la regola
«i verticali dipendono da base e framework, la base non dipende dai verticali».

## Riferimenti

- [Audit BMAD](./bmad/audit.md)
- [Piano di miglioramento](./bmad/piano-miglioramento.md)
- [ECC](./ecc/xot-ecc-audit.md)
