---
title: "Regole per i Namespace Filament"
type: rule
tags: [filament, namespace, rules]
created: 2026-07-14
updated: 2026-07-14
qmd: "filament-namespace-rules regole per i namespace filament"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./auth-components-best-practices.md"
  - "./auth-widget-rules.md"
  - "./auth-widget.md"
  - "./case-sensitivity-rules.md"
  - "./case-sensitivity.md"
  - "./component-verification-rules.md"
  - "./component-verification.md"
  - "./dependency-rules.md"
status: draft
---

# Regole per i Namespace Filament

## Regola 1: Namespace Modulare
- Il namespace dei componenti Filament deve sempre essere `Modules\{ModuleName}\Filament`
- NON includere mai `App` nel namespace, anche se i file sono fisicamente in `app/Filament`
- Esempio corretto: `namespace Modules\User\Filament\Widgets\Auth;`
- Esempio errato: `namespace Modules\User\App\Filament\Widgets\Auth;`
## Regola 2: Struttura Directory
- I file possono essere fisicamente in `app/Filament`
- Ma il namespace deve sempre essere `Modules\{ModuleName}\Filament`
- Questo mantiene la coerenza con l'architettura modulare
## Regola 3: Convenzioni di Naming
- I namespace devono seguire la struttura delle directory
- Ma devono sempre iniziare con `Modules\{ModuleName}\Filament`
- Non devono mai includere `App` nel percorso
## Regola 4: Best Practices
- Consultare sempre la documentazione del modulo per le convenzioni specifiche
- Verificare i namespace esistenti nel modulo
- Mantenere la coerenza con gli altri moduli
## Regola 5: Autoloading
- I namespace devono corrispondere alla struttura PSR-4
- Ma devono sempre seguire la convenzione modulare
## Esempi Pratici
### Widget di Autenticazione
```php
// ✅ CORRETTO
namespace Modules\User\Filament\Widgets\Auth;
class LoginWidget extends Widget
{
    // ...
}
```
### Resource Utente
namespace Modules\User\Filament\Resources;
class UserResource extends Resource
### Page Filament
namespace Modules\User\Filament\Pages;
class Dashboard extends Page
## Collegamenti
- [Convenzioni Namespace Filament](../../cms/project_docs/convenzioni-namespace-filament.md)
- [Regole Generali Xot](../../xot/project_docs/readme.md)
- [Best Practices Filament](../../cms/project_docs/best-practices/filament.md) 
- [Convenzioni Namespace Filament](../../../Cms/docs/convenzioni-namespace-filament.md)
- [Regole Generali Xot](../../../Xot/docs/README.md)
- [Convenzioni Namespace Filament](../../../Cms/docs/convenzioni-namespace-filament.md)
- [Regole Generali Xot](../../../Xot/docs/README.md)
- [Best Practices Filament](../../cms/docs/best-practices/filament.md) 
