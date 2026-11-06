---
title: "Soluzione Errori di Routing nel Frontoffice"
type: concept
tags: [routing, solution]
created: 2026-07-14
updated: 2026-07-14
qmd: "routing-solution soluzione errori di routing nel frontoffice"
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

# Soluzione Errori di Routing nel Frontoffice

In un modulo User che usa Volt + Folio + Filament, **non** definire mai rotte in `routes/web.php`. Se incappi in un errore di tipo “Route not found” o conflitti di middleware dovuti a rotte imperative, ecco come risolvere:

## 1. Filament (Admin Panel)
**Errore comune:**
```php
// routes/web.php (ERRATO)
Route::get('/admin/users', [UserController::class, 'index']);
```
**Soluzione:**
- Crea o aggiorna la resource Filament:
  ```php
  // Modules/User/app/Filament/Resources/UserResource.php
  class UserResource extends XotBaseResource {
      // Filament gestisce automaticamente le rotte /admin/users
  }
  ```
- Rimuovi la rotta da `web.php`.

## 2. Folio (Pagine Statiche)
**Errore comune:**
```php
// routes/web.php (ERRATO)
Route::get('/profile', [ProfilePageController::class, 'show']);
```
**Soluzione:**
- Crea la pagina Blade:
  ```
  resources/views/pages/profile.blade.php
  ```
- Il FolioServiceProvider del modulo la registra automaticamente.
- Rimuovi la rotta da `web.php`.

## 3. Volt (Componenti Livewire/Vue)
**Errore comune:**
```php
// routes/web.php (ERRATO)
Route::get('/settings', [SettingsComponent::class, 'render']);
```
**Soluzione:**
- Crea il componente Volt:
  ```php
  // app/Livewire/Settings.php
  class Settings extends Component { ... }
  ```
- Oppure con Vue 3 + Inertia:
  ```bash
  resources/js/pages/Settings.vue  → route '/settings'
  ```
- Volt discovery genera automaticamente la rotta.
- Rimuovi la rotta da `web.php`.

## Pulizia e Verifica
1. Elimina tutte le rotte frontoffice da `routes/web.php`.
2. Pulisci e rigenera la cache delle rotte:
   ```bash
   php artisan route:clear
   php artisan route:cache
   ```
3. Controlla che:
   - `/admin/users` funzioni via Filament.
   - `/profile` carichi la pagina Folio.
   - `/settings` instanzi il componente Volt.

---
Questa procedura mantiene fede ai principi di **modularità**, **dichiaratività** e **manutenibilità** della nostra architettura.
