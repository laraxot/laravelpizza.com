---
title: "Filament 5 Panel Governance Rule"
type: rule
tags: [filament, panel, governance, rule]
created: 2026-07-14
updated: 2026-07-14
qmd: "filament-5-panel-governance-rule filament 5 panel governance rule"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
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
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
status: draft
---

# Filament 5 Panel Governance Rule

## Fonte

Studio basato su:

- repository ufficiale `filamentphp/filament` ramo `5.x`
- plugin ufficiale `filamentphp/spatie-laravel-google-fonts-plugin`

## Regole operative

### 1. Panel provider come punto di governo

Config di panel, plugin, branding, font, auth e navigation devono restare nel `PanelProvider`.

### 2. Form, Table, Action, Schema nei contratti Filament

Se una schermata admin appartiene al panel, va espressa tramite i costrutti Filament previsti dal framework, non con soluzioni parallele improvvisate.

### 3. Plugin Google Fonts

Il plugin Google Fonts appartiene al panel Filament.

Uso corretto:

- configurazione tipografica admin;
- coerenza visuale del panel;
- nessuna duplicazione casuale nel frontoffice theme.

### 4. Boundary con il tema pubblico

Il tema pubblico non deve dipendere da plugin panel-specifici per risolvere typography o assets del frontoffice.
