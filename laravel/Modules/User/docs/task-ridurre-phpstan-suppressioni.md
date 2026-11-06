---
title: "Task: Ridurre Suppressioni PHPStan Inline - User"
type: concept
tags: [task, ridurre, phpstan, suppressioni]
created: 2026-07-14
updated: 2026-07-14
qmd: "task-ridurre-phpstan-suppressioni task: ridurre suppressioni phpstan inline - user"
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

# Task: Ridurre Suppressioni PHPStan Inline - User

**Modulo**: User
**Priorita'**: Alta
**Completamento**: 0%

---

## Descrizione

39 suppressioni `@phpstan-ignore` inline nel codice app/. Le principali aree:

## File Coinvolti

| File | Suppressioni | Tipo |
|------|-------------|------|
| `app/Models/BaseUser.php` | 6 | mixed type su relazioni Eloquent |
| `app/Models/Traits/IsProfileTrait.php` | 4 | collection type covariance |
| `app/Filament/Widgets/UserTypeRegistrationsChartWidget.php` | 2 | return type |
| `app/Filament/Widgets/RegistrationWidget.php` | 2 | return type |
| `app/Filament/Widgets/LogoutWidget.php` | 2 | return type |
| `app/Filament/Widgets/Auth/*` | 6 | return type su widget auth |
| `app/Http/Controllers/Socialite/RedirectToProviderController.php` | 3 | provider type |
| `app/Filament/Resources/UserResource/Pages/*` | 5 | list/edit type |
| `app/Providers/PassportServiceProvider.php` | 1 | config type |

## Criteri di Completamento

- [ ] Analizzate tutte le 39 suppressioni
- [ ] Almeno 25 risolte senza suppress
- [ ] PHPStan 0 errori mantenuto
- [ ] Test esistenti ancora passanti
