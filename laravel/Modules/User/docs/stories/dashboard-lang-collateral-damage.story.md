---
id: story-dashboard-lang-collateral-damage-2026-09-21
slug: dashboard-lang-collateral-damage-2026-09-21
title: "STORY — 500 reale su /user/admin da file lang troncato, audit blast radius commit 0701a777a"
description: "Modules/User/lang/it/.php (gruppo traduzione vuoto) senza return, troncato dal commit 0701a777a. require() ritorna int(1), array_replace_recursive() fatale in FileLoader::loadNamespaceOverrides(). Stesso commit ha troncato 323 file in 12+ moduli, 158 ancora rotti oggi."
document_type: story
category: bmad
scope: module:User
status: done
version: 1.0.0
language: it-IT
ecosystem: Laraxot
priority: critical
created_at: '2026-09-21'
updated_at: '2026-09-21'
tags: [bmad, story, user, lang, filament, production-bug, collateral-damage, git-archaeology]
related:
  - ../../../laravel/Modules/User/lang/it/.php
  - ../../../laravel/Modules/User/lang/it/client.php
  - ../../../laravel/Modules/User/lang/it/login.php
  - ../../../laravel/Modules/User/lang/it/role.php
  - ../../../laravel/Modules/User/lang/it/view_user.php
  - ../../../laravel/Modules/User/resources/views/filament/widgets/auth/login.blade.php
  - ../../../laravel/Modules/User/resources/views/filament/pages/my-profile.blade.php
  - ../../../laravel/Modules/Xot/app/Actions/GetTransKeyAction.php
  - ../../../laravel/Modules/Lang/app/Actions/Filament/AutoLabelAction.php
  - 10.3.retire-auth-livewire-twins.story.md
github:
  repository: https://github.com/laraxot/module_user_fila5
  issues: https://github.com/laraxot/module_user_fila5/issues
---

# STORY — 500 reale su /user/admin da file lang troncato, audit blast radius commit 0701a777a

## Contesto

Utente ha riportato un `TypeError` reale (report Laravel/Filament completo:
stack trace, request, query log) su `GET /user/admin`,
`192.168.1.35:8000`, PHP 8.4.25, Laravel 13.26.1:

```
array_replace_recursive(): Argument #2 must be of type array, int given
```

`vendor/laravel/framework/.../Translation/FileLoader.php:129`, dentro
`loadNamespaceOverrides()`, chiamato da
`Modules/Lang/app/Actions/Filament/AutoLabelAction.php:113` (`trans($label_key)`),
agganciato via `Action::configureUsing()` in `LangServiceProvider` a OGNI
Filament Action — incluse le action del menu utente sulla Dashboard, da cui il 500.

## Root cause

`require`-are un file PHP senza `return` produce `int(1)`, non `null` ne'
array vuoto. `Modules\Translation\FileLoader::loadNamespaceOverrides()` fa
`array_replace_recursive($output, $this->files->getRequire($file))` senza
validare il tipo — un file di lang troncato e' fatale, non silenzioso.

Il file colpevole, `Modules/User/lang/it/.php` (nome letterale, gruppo di
traduzione **vuoto**), esiste per via di un bug architetturale distinto e
preesistente in `Modules/Xot/app/Actions/GetTransKeyAction.php`: quando la
classe chiamante e' del tipo `Dashboard` e il prefisso `dashboard` (o
`list`/`get`/`manage`/`edit`/`view`/`create`) viene strippato senza lasciare
resto, `$class_snake` diventa stringa vuota → chiave `user::.actions.profile.label`
→ `SaveTransAction` scrive/legge da `lang/it/.php`. Bug NON corretto in
questa story (fuori scope, architetturale, richiederebbe decidere il fallback
quando `$class_snake` e' vuoto — probabile causa di chiavi malformate simili
in altri moduli, da verificare separatamente).

Il file era vuoto (senza `return`) perche' il commit `0701a777a`
("feat(gitmodules): add new submodule for Setting module" — messaggio non
correlato) lo ha troncato, insieme a **323 altri file** in 12+ moduli
(misurato con `git diff --numstat 0701a777a^ 0701a777a`, escluso lo
scaffolding legittimo di `Modules/Setting/`).

## Fix applicato (forward-only, mai checkout/revert)

Recuperato il contenuto pre-danno con `git show 0701a777a^:<path>` e
riscritto con `Write`/`cp`, per gli 8 file della stessa classe di crash
("nessun return" o "vista troncata a poche righe") trovati nel raggio di
questo commit su `Modules/User`:

| File | Prima | Dopo | Verifica |
|---|---|---|---|
| `lang/it/.php` | 4 righe, no return | `return [...]` ripristinato | `curl /user/admin` → `302` (era `500`) |
| `lang/it/client.php` | 3 righe, no return | ripristinato | `php -l` + `is_array` |
| `lang/it/login.php` | 3 righe, no return | ripristinato | `trans('user::login')` → array |
| `lang/it/role.php` | 3 righe, no return | ripristinato (154 righe) | `trans('user::role')` → array |
| `lang/it/view_user.php` | 3 righe, no return | ripristinato (58 righe) | `is_array` OK |
| `.../widgets/auth/login.blade.php` | 1 riga orfana `</div>` | ripristinato (111 righe) | `php -l` OK |
| `.../pages/my-profile.blade.php` | corpo vuoto | ripristinato (18 righe) | `php -l` OK |
| `Modules/Xot/phpstan_constants.php` | cancellato | ripristinato (13 righe) | vedi nota sotto |

Nota su `phpstan_constants.php`: e' gitignored dalla STESSA commit che lo ha
tolto (`Modules/Xot/.gitignore:156`, regola aggiunta in `0701a777a`), e NON
e' referenziato da `bootstrapFiles` di `phpstan.neon`/`phpstan-strict.neon`
(puntano a `./phpstan_constants.php` relativo a `laravel/` root, file
diverso). Ripristino innocuo, non necessario al gate PHPStan, pattern
locale/non tracciato ripetuto in altri moduli (`Modules/Setting/`, root).

I due bug su `login.php`/`login.blade.php` erano gia' **documentati** in
`10.3.retire-auth-livewire-twins.story.md` (sessione 2026-09-03/04) come
"fuori scope, da correggere" — MAI stati effettivamente corretti fino a
oggi, 15+ giorni dopo. Prova diretta che "documentato" non implica
"risolto": serve verifica live (`git status`, `curl`) prima di assumere
chiuso, vedi [[verify-after-swarm-before-reporting-done]].

## Non corretto in questa story (richiede conferma utente / story dedicata)

Dei 323 file troncati dal commit, **158 sono ancora oggi nello stato
troncato**, mai riparati da nessun commit successivo:
- 9 test file in `Modules/User/tests/` (200-400+ righe di test reali
  svuotate: `TeamManagementBusinessLogicTest.php`, `Pest.php`,
  `GetCurrentDeviceActionTest.php`, `UserEnumsTest.php`, `DeviceTest.php`,
  `PermissionTest.php`, `ProfileTest.php`, `RoleTest.php`, `UserTest.php`)
- ~142 altri file, perlopiu' `docs/*.md`/`docs/coverage*.md`, in Notify (40),
  Cms (24), Gdpr (23), Activity (11), Xot, Geo, Job, UI, Tenant, Lang,
  Media, AI — non auditati singolarmente

Decisione rimandata: scope troppo ampio (12+ moduli) per fix autonomo senza
conferma esplicita. Candidato per una story/epic BMAD dedicata all'audit
completo del commit `0701a777a`, modulo per modulo.

## Verifiche eseguite

```
$ curl -s -o /dev/null -w "%{http_code}" http://192.168.1.35:8000/user/admin
302   # era 500 prima del fix

$ php -r "var_dump(is_array(require 'Modules/User/lang/it/.php'));"
bool(true)

$ php artisan tinker --execute="dd(gettype(trans('user::login')));"
"array"

$ php -l Modules/User/resources/views/filament/widgets/auth/login.blade.php
No syntax errors detected.
```

## Second brain aggiornato

- `story-103-auth-login-widget-broken-by-collateral-commit.md` (riscritta
  con findings completi)
- Follow-up aggiunto anche in Dev Agent Record di
  `10.3.retire-auth-livewire-twins.story.md`

## Lezione

Vedi [[story-103-auth-login-widget-broken-by-collateral-commit]] per le
lezioni complete (memoria che documenta senza correggere non e' sufficiente;
`git diff --numstat` sul commit sospetto misura il raggio reale, non
assumerlo piccolo; `.gitignore` aggiunto nella stessa commit puo' essere
cleanup intenzionale, non danno).
