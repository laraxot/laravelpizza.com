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
