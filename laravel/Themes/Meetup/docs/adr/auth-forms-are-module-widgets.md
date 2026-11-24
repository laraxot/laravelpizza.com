---
title: "ADR — Login e registrazione di Meetup sono widget Filament dei moduli, non componenti Livewire del tema"
type: decision
status: accepted
theme: Meetup
created: 2026-11-24
updated: 2026-11-24
related:
  - ../filament-widgets-not-livewire-critical-rule.md
---

# ADR: i form con logica sono widget Filament dei moduli

## Contesto

- La regola [filament-widgets-not-livewire-critical-rule](../filament-widgets-not-livewire-critical-rule.md) vieta
  componenti Livewire puri e Volt per form complessi: validazione, sicurezza e traduzioni dei form vivono gia' nei widget
  dei moduli.
- La registrazione deve raccogliere i consensi privacy: il widget che lo fa e' del modulo Gdpr.
- Domanda: il tema implementa i propri form di login e registrazione?

## Decisione

- `pages/auth/login.blade.php` rende `@livewire(\Modules\User\Filament\Widgets\Auth\LoginWidget::class)`.
- `pages/auth/register.blade.php` rende `@livewire(\Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget::class)`, cosi' i
  consensi si registrano con le regole del modulo Gdpr.
- L'header usa `Modules\User\Filament\Widgets\UserDropdown`; il blocco `blocks/forms/login-card` riceve il widget da
  rendere come parametro.
- Il tema fornisce layout e grafica attorno al widget, mai la logica del form.

## Alternative scartate

- **Form Volt/Livewire nel tema**: duplica validazione, rate limit e consensi; diverge dal modulo a ogni modifica.
- **Redirect al pannello Filament**: l'utente esce dalla grafica del sito.

## Conseguenze

- Pro: un solo punto per sicurezza e consensi; il tema resta sostituibile.
- Contro: lo stile dei widget dipende dal CSS di Filament, da allineare alla grafica del tema.
- Le pagine di reset password (`pages/auth/password/*`) sono ancora componenti Volt del tema: da valutare se portarle a
  widget del modulo User.

## Verifica

`Themes/Meetup/tests/Unit/PagesAndAuthFormsContractTest.php` (senza app) fallisce se login o registrazione smettono di
usare i widget `LoginWidget` (User) e `RegisterWidget` (Gdpr).
