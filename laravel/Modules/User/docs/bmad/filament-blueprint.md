---
title: "Filament Blueprint: User"
type: filament-blueprint
status: active
module: User
created: 2026-10-16
updated: 2026-10-20
tags: [bmad, filament, blueprint, user]
qmd: "filament blueprint user xotbase resource widget"
related:
  - ../bmad-planning.md
  - ../bmad-brainstorming.md
---

# Scopo

Contratto Filament del modulo **User**: chrome BO e/o widget FO senza violare
i confini di dominio.

## Regole non negoziabili

1. Estendere solo `XotBaseResource` / `XotBaseWidget` / basi Xot: mai classi Filament dirette.
2. Nessun `->label()` hardcoded: chiavi in `lang/<locale>/` del modulo.
3. Business logic nelle Actions del modulo, non nei form hooks grassi.
4. FO: widget montati esplicitamente; non abusare `discoverWidgets` per chrome.
5. `resources/views/pages/auth/register.blade.php` tiene solo il nome rotta `register`
   e include il componente civico del tema. Il guscio visuale e il widget consensi
   non sono di User.
6. Il nome `@volt` di una pagina FO è univoco. Il fragment è `md5(nome)` ed è
   condiviso da ogni blade che lo ripete: un prototipo non può chiamarsi
   `auth.login` o `auth.register`. Vedi [volt-errors.md](../volt-errors.md).

## Resource / widget

- `BaseUserResource`
- `BaseProfileResource`
- `AuthenticationLogResource`

## Form / Table / Infolist

Preferire triad schema dedicati (`*Form`, `*Table`, `*Infolist`) quando la Resource
cresce oltre pochi campi. Enum tipizzati al posto di option array.

`is_active` e `users.type` sono colonne di `UserData`. La Resource le legge dal modello.
Un campo non nasce da una migration `*_column`.

La colonna `users.type` è il discriminante Parental dichiarato in `UserData`.
In tabella si mostra con la chiave di traduzione del modulo, non con una label
nel form. La registrazione del cittadino persiste `customer_user`.

«Ricordami» è `Checkbox::make('remember')` nello stesso schema: il controllo è
`input.fi-checkbox-input` di Filament, non un checkbox scritto nel tema.

La password del login è `TextInput::password()->revealable()` in
`Widgets/Auth/Schemas/UserForm::getLoginFormSchema()`. Mostra e nascondi sono
le suffix action di Filament (`showPassword`, `hidePassword`), non un toggle
scritto nel tema. Contratto: [revealable password inputs](https://filamentphp.com/docs/5.x/forms/text-input#revealable-password-inputs).

«Ricordami» è `Checkbox::make('remember')` nello stesso schema
([Filament Checkbox](https://filamentphp.com/docs/5.x/forms/checkbox)). Il tema
Sixteen deve solo ripristinare `appearance` sotto `data-dc` (D26); non sostituire
il campo con markup custom.

OAuth FO: URL con `route('oauth.redirect', ['provider' => $driver, 'lang' => $locale])`
perché la rotta è `{lang}/auth/login/{provider}` (`routes/socialite.php`).
Il bottone Google del tema e `SocialLoginWidget::getRedirectUrl()` rispettano
questo contratto; vedi [google-auth-login.md](./google-auth-login.md).

La callback FO non è una Resource, una Page Filament o un widget duplicato:
`Themes/Sixteen/resources/views/pages/auth/login/[provider]/callback.blade.php`
è la pagina Folio+Volt e delega a `ProcessCallbackAction`. User possiede la policy
OAuth; non aggiungere una callback controller-based o una seconda implementazione
in Filament/Livewire.

La migration `create_users_table` non dichiara `$model_class`. Il modello della
Resource e quello della migration sono la stessa classe ricavata dal nome file.

## Policy e tenant

Ogni query Filament rispetta tenant + policy del modello owner. Nessun elenco
cross-tenant per comodita admin.

## PHPStan

Widget auth/OAuth e Resource User condividono **`laravel/phpstan.neon` solo** (agenti: mai altri `.neon`, ignore o baseline). Gate: `cd laravel && ./vendor/bin/phpstan analyse Modules` a **zero** senza conferma.

Prima del fix: leggere questo blueprint (scopo UI) e il contratto del widget/Resource; poi tipizzare alla **sorgente**: **mai zittire** (`@phpstan-ignore`, baseline, exclude).

Track: [phpstan-modules-zero-standing-order](../../../Xot/docs/wiki/memories/phpstan-modules-zero-standing-order.md), [00-start.md](../../../../../bashscripts/docs/prompts/00-start.md#ordine-permanente-dellutente), [11-phpstan.md](../../../../../bashscripts/docs/prompts/11-phpstan.md). Ratchet basi Filament: [NeverExtendFilamentDirectlyTest.php](../../../Xot/tests/Unit/Filament/NeverExtendFilamentDirectlyTest.php). Glob `*Service.php` non confonde Livewire (`TermsOfService.php`). `graphify-out/`: [graphify-out-gitignore](../../../Xot/docs/bmad/graphify-out-gitignore.md).

## Related

- Planning: [bmad-planning.md](../bmad-planning.md)
- Brainstorming: [bmad-brainstorming.md](../bmad-brainstorming.md)
- Decision log: [decision-log.md](./decision-log.md)