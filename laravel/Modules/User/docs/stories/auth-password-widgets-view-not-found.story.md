---
id: story-2026-10-13-auth-password-widgets-view-not-found
slug: 2026-10-13-auth-password-widgets-view-not-found
title: "[STORY] ForgotPasswordWidget e ResetPasswordWidget dichiaravano una vista che non esiste"
description: "PHPStan segnalava property.defaultValue su $view (view-string) nei due widget. Non era un falso positivo: la vista non esisteva e i widget sollevavano View not found. Tolto $view, blade portati al percorso convenzionale e corretti dove usavano una variabile inesistente."
type: story
document_type: story
category: bmad
status: review
priority: high
module: User
scope: module:User
created: '2026-10-13'
updated: '2026-10-13'
tags: [user, auth, widget, view, phpstan, view-string, pub_theme]
github:
  repository: https://github.com/laraxot/module_user_fila5
  issues: https://github.com/laraxot/module_user_fila5/issues/18
  issue_status: "chiusa il 2026-05-27, stesso errore su LoginWidget"
related:
  - ./13.4.login-logout-widget-duplication.story.md
  - ./10.3.retire-auth-livewire-twins.story.md
  - ../auth-widgets-view-namespaces-namespace-widget.md
  - ../wiki/log.md
  - ../../../../../bashscripts/ai/wiki/rules/filament-template-as-dress.md
  - ../../../../../bashscripts/ai/wiki/rules/filament-auth-widgets-rule.md
  - ../../../../../bashscripts/ai/wiki/memories/feedback_no_protected_view_xot_basewizard.md
  - ../../../../../bashscripts/ai/wiki/rules/post-edit-quality-gate.md
  - ../../../../../docs/chat/user-auth-widgets-view-convention.md
---

# [STORY] ForgotPasswordWidget e ResetPasswordWidget dichiaravano una vista che non esiste

Fase BMAD: implementazione chiusa, in attesa di revisione. Story scritta prima del codice e aggiornata con l'esito.

## In breve

- **Sintomo.** `./vendor/bin/phpstan analyse Modules` chiudeva con 2 errori `property.defaultValue`, uno per widget.
- **Causa.** I due widget dichiaravano `$view = 'pub_theme::filament.widgets.auth.*-widget'`, una vista che non esiste in nessun tema ne' nel modulo.
- **Portata reale.** Non era un problema di tipi: istanziare uno dei due widget sollevava `View not found`.
- **Secondo difetto, trovato dal test.** I due blade usavano `$getForm()`, variabile che nelle viste dei widget non esiste: anche con il nome giusto non si sarebbero renderizzati.
- **Correzione.** Tolto `$view`, blade portati al percorso convenzionale, `$getForm()` sostituito con `{{ $this->form }}`.
- **Esito.** `phpstan analyse Modules` senza errori. I due widget risolvono la vista e si renderizzano.

## Richiesta

L'utente ha rilanciato PHPStan dopo il fix dei fatal in Quaeris e ha chiesto di risolvere i 2 errori rimasti seguendo prima linee guida, documentazione, story, issue e discussion. Davanti a due strade ha risposto: seguire sempre cio' che dice la convenzione.

```text
User/app/Filament/Widgets/Auth/ForgotPasswordWidget.php:21
  Property ...ForgotPasswordWidget::$view (view-string) does not accept default value of type string.
User/app/Filament/Widgets/Auth/ResetPasswordWidget.php:27
  Property ...ResetPasswordWidget::$view (view-string) does not accept default value of type string.
```

## Che cosa dice la documentazione

| Fonte | Che cosa stabilisce |
|---|---|
| `bashscripts/ai/wiki/rules/filament-template-as-dress.md` (trigger map, riga "Filament Widget + template Blade") | Un widget che estende `XotBaseWidget` non dichiara `protected string $view` se segue la convenzione. La vista la risolve `XotBaseWidget::resolveView()` con `GetViewByClassAction`: prima `pub_theme::...`, poi `modulo::...`. Il blade mostra il form con `{{ $this->form }}`. |
| `bashscripts/ai/wiki/memories/feedback_no_protected_view_xot_basewizard.md` | Un `$view` scritto a mano non e' innocuo: scavalca la risoluzione automatica e puo' bloccare l'override del tema. |
| Trigger map, riga "XotBaseWidget: no `$view` sul dominio (`GetViewByClassAction`)" | Stessa regola. La pagina di concetto che cita non esiste in questo repository. |
| `laravel/Modules/User/docs/auth-widgets-view-namespaces-namespace-widget.md` | Le viste dei widget di autenticazione devono poter essere personalizzate dal tema (`pub_theme::`). |
| `bashscripts/ai/wiki/rules/filament-auth-widgets-rule.md` | I form di autenticazione sono widget Filament del modulo User, non Blade o Volt scritti a mano. |
| Issue [module_user_fila5#18](https://github.com/laraxot/module_user_fila5/issues/18), chiusa | Stesso errore su `LoginWidget`. Avverte: se il file blade non esiste, il valore e' sbagliato a prescindere da PHPStan. |
| Issue [module_user_fila5#25](https://github.com/laraxot/module_user_fila5/issues/25) e discussion [#26](https://github.com/laraxot/module_user_fila5/discussions/26), aperte | Migrazione dei 6 widget auth a `formClass()` e `schemaMethod()`. Non trattano le viste. |
| `bashscripts/ai/wiki/rules/post-edit-quality-gate.md` e istruzioni di PHPStan | Vietati `@phpstan-ignore`, `@var` inline e cast messi solo per zittire l'errore. |

Prima di iniziare: nessun lock sui file, nessun claim in `docs/chat/`, repository `module_user_fila5` e `theme_zero_fila5` allineati ai remoti.

## Analisi

### Quando e' nato l'errore

Commit `c79b3e996` del modulo User, 2026-10-11:

```diff
-    protected string $view = 'user::widgets.auth.forgot-password-widget';
+    protected string $view = 'pub_theme::filament.widgets.auth.forgot-password-widget';
-    protected string $view = 'user::widgets.auth.reset-password-widget';
+    protected string $view = 'pub_theme::filament.widgets.auth.reset-password-widget';
```

L'intento coincide con la documentazione: viste sotto `filament/widgets/auth`, sovrascrivibili dal tema. I file blade pero' non erano stati creati.

### Che cosa esisteva

```text
$ find Themes Modules -name '*forgot-password*.blade.php' -o -name '*reset-password*.blade.php'
Modules/User/resources/views/widgets/auth/forgot-password-widget.blade.php
Modules/User/resources/views/widgets/auth/reset-password-widget.blade.php

$ php artisan tinker
pub_theme::filament.widgets.auth.forgot-password-widget => NON esiste
pub_theme::filament.widgets.auth.reset-password-widget  => NON esiste
user::widgets.auth.forgot-password-widget               => esiste
user::widgets.auth.reset-password-widget                => esiste
```

Vista con cui ogni widget si ritrovava dopo il costruttore, prima della correzione:

```text
LoginWidget          => pub_theme::filament.widgets.auth.login
RegisterWidget       => xot::filament.widgets.base
ForgotPasswordWidget => ECCEZIONE: View not found: pub_theme::filament.widgets.auth.forgot-password, user::filament.widgets.auth.forgot-password
ResetPasswordWidget  => ECCEZIONE: View not found: pub_theme::filament.widgets.auth.reset-password, user::filament.widgets.auth.reset-password
```

`LoginWidget` e' il modello che funziona: nessun `$view`, blade a `filament/widgets/auth/login.blade.php`.

### Perche' PHPStan aveva ragione

Larastan accetta una stringa come `view-string` solo se la vista esiste. Aggiungere `/** @var view-string */`, come proponeva l'opzione A della issue 18, avrebbe fatto sparire l'errore e lasciato il difetto.

### Il secondo difetto

Con la vista finalmente trovata, il test di rendering ha fallito cosi':

```text
ViewException
Undefined variable $getForm (View: .../Modules/User/resources/views/filament/widgets/auth/forgot-password.blade.php)
```

I due blade cominciavano con `$form = $getForm();`. `$getForm` e' una variabile delle viste dei campi Filament, non di un widget Livewire. Nessun altro blade del progetto la usa. Quei due file non potevano renderizzarsi nemmeno prima dell'11 ottobre.

## Modifiche

Codice:

- `app/Filament/Widgets/Auth/ForgotPasswordWidget.php` e `ResetPasswordWidget.php`: tolta la riga `protected string $view`. Nient'altro.
- Blade spostati al percorso che `GetViewByClassAction` calcola:

| Da | A | Nome della vista |
|---|---|---|
| `resources/views/widgets/auth/forgot-password-widget.blade.php` | `resources/views/filament/widgets/auth/forgot-password.blade.php` | `user::filament.widgets.auth.forgot-password` |
| `resources/views/widgets/auth/reset-password-widget.blade.php` | `resources/views/filament/widgets/auth/reset-password.blade.php` | `user::filament.widgets.auth.reset-password` |

- Nei due blade: tolto il blocco `@php $form = $getForm(); @endphp` e sostituito `{{ $form }}` con `{{ $this->form }}`. Il resto e' identico.

Test:

- `tests/Unit/Filament/Widgets/Auth/AuthWidgetsResolveConventionalViewTest.php` (nuovo).

File di traduzione: `lang/it/user_form.php` ha due chiavi in piu', `fields.token.label` e `fields.token.placeholder`. Le ha scritte il meccanismo di etichette del progetto quando il test ha renderizzato il form di reset. Nessuna chiave tolta o cambiata.

Il tema puo' ora sovrascrivere le due viste creando `filament/widgets/auth/forgot-password.blade.php` e `reset-password.blade.php`, senza toccare il PHP.

## RegisterWidget: non toccato, e perche'

In fase di analisi avevo scritto che `RegisterWidget` aveva lo stesso difetto e si correggeva spostando il suo blade. Era sbagliato, e l'ho visto solo aprendo il file:

- `resources/views/widgets/auth/register-widget.blade.php` contiene soltanto un `</div>`. Non e' una vista, e' un resto.
- La vista su cui `RegisterWidget` ripiega oggi, `xot::filament.widgets.base`, e' un segnaposto con un avviso, non un form.

Il blade era gia' stato spostato: l'ho rimesso al suo posto prima di qualunque verifica. `RegisterWidget` resta com'era. Gli serve una vista vera, che va scritta: e' un lavoro a parte.

## Verifica

Test scritto prima della correzione. Rosso, 8 falliti su 9:

```text
$ ./vendor/bin/pest --no-coverage Modules/User/tests/Unit/Filament/Widgets/Auth/AuthWidgetsResolveConventionalViewTest.php
  Manca la vista user::filament.widgets.auth.forgot-password per Modules\User\Filament\Widgets\Auth\ForgotPasswordWidget
  Exception  View not found: pub_theme::filament.widgets.auth.forgot-password, user::filament.widgets.auth.forgot-password
exit=2
```

Dopo la correzione (2026-10-13, 12:33 CEST):

```text
$ bash ../bashscripts/quality-gates/class-load-fatals/find-class-load-fatals.sh
files=3453 problems=0

$ ./vendor/bin/phpstan analyse --no-progress --memory-limit=-1 <i 2 widget e il test>
 [OK] No errors

$ ./vendor/bin/pint --test <gli stessi 3 file>
{"tool":"pint","result":"passed"}

$ ./vendor/bin/pest --no-coverage Modules/User/tests/Unit/Filament/Widgets/Auth/AuthWidgetsResolveConventionalViewTest.php
  ✓ il widget auth non dichiara $view                                  (forgot password, reset password)
  ✓ il modulo fornisce la vista convenzionale del widget auth          (forgot password, reset password)
  ✓ il widget auth risolve la vista convenzionale                      (forgot password, reset password)
  ✓ il widget auth si renderizza con il form della sua vista           (forgot password, reset password)
  Tests:    8 passed (18 assertions)
```

L'ultimo test monta il widget con Livewire e controlla che nell'HTML ci sia `wire:submit="sendResetLink"` o `wire:submit="resetPassword"`.

PHPStan su tutto `Modules`, lo stesso comando dell'utente, finito alle 12:34 CEST: `exit=0`, nessun errore.

PHPMD: il modulo User non ha un ruleset. Con quello di Quaeris escono due note, entrambe in metodi non toccati e gia' presenti in `HEAD`:

```text
ForgotPasswordWidget.php  ElseExpression         The method sendResetLink uses an else expression.
ResetPasswordWidget.php   CamelCaseVariableName  The variable $reset_data is not named in camelCase.
```

PHP Insights sui due widget: `exit=0`, code 100, complexity 100, architecture 88.2, style 98.7, nessun problema di sicurezza.

Non verificato a schermo: nessuna prova nel browser. Non provato l'invio reale del link ne' il reset con un token vero.

## Criteri di accettazione

- [x] Nessuno dei due widget dichiara `$view`.
- [x] Istanziare ciascun widget non solleva eccezioni e la vista risolta esiste.
- [x] Senza override del tema la vista risolta e' `user::filament.widgets.auth.forgot-password` e `user::filament.widgets.auth.reset-password`.
- [x] I due widget si renderizzano con il form della loro vista.
- [x] `phpstan analyse Modules` senza errori.
- [x] Test Pest scritto prima della correzione e verde dopo.
- [x] PHPMD e PHP Insights senza nuove segnalazioni sui file toccati.

## Fuori perimetro, segnalato

- **`RegisterWidget`**: vedi sopra. Oggi mostra un segnaposto invece del form di registrazione.
- **`resources/views/widgets/auth/login-widget.blade.php`**: non usato, `LoginWidget` risolve `filament.widgets.auth.login`.
- **`resources/views/pages/auth/password/reset.blade.php`**: usa `@volt('auth.password.reset')`, che la regola sui widget di autenticazione vieta.
- **`NotificationsCenterWidget`, `LogoutWidget`, `SocialLoginWidget`**: dichiarano `$view` verso viste che esistono. PHPStan non li segnala, ma sono fuori convenzione.
- **Test vicini con fallimenti che non citano i file toccati:** `LoginWidgetTest` (3 su 5, identico prima e dopo), `RegisterWidgetTest` (4 su 5), `UserGapAttackCoverageTest` (1 su 5, `mockeryExpect()` non definita). Per gli ultimi due non ho una misura di prima.

## Procedura seguita

`check.sh` e `lock.sh` su tutti i file prima del primo edit, claim in `docs/chat/` prima di iniziare, test rosso, correzione, gate, `unlock.sh` a gate verdi. Nessun comando git che riscrive il working tree: i file sono stati spostati con `mv`.

## Aperto

- Prova a schermo delle due pagine e dell'invio reale del link.
- Scrivere la vista di `RegisterWidget`.
- Decidere se riallineare alla convenzione anche gli altri tre widget che dichiarano `$view`.

## Lezioni

- Un `property.defaultValue` su `$view (view-string)` vuol dire quasi sempre che la vista non esiste. Il primo controllo e' `view()->exists()`, non il docblock.
- Trovare la vista non basta: va renderizzata. Il test con `Livewire::test()` ha trovato un difetto che l'analisi statica e il controllo sull'esistenza non potevano vedere.
- Prima di spostare un file va aperto. Il blade di `RegisterWidget` era un resto di sei righe, e per pochi minuti lo avevo messo in un punto dove sarebbe stato usato.
