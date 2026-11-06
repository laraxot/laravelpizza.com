---
title: "🔧 Fix Traduzioni Pagina Login"
type: concept
tags: [login, page, translation, fix]
created: 2026-07-14
updated: 2026-07-14
qmd: "login-page-translation-fix 🔧 fix traduzioni pagina login"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
status: draft
---

# 🔧 Fix Traduzioni Pagina Login

**Data**: 14 Ottobre 2025  
**Problema**: Chiavi di traduzione non risolte nella vista widget

---

## 🚨 Problema Identificato

### Nell'HTML Renderizzato

```html
<p class="text-italia-gray-600 dark:text-gray-400">
    Non hai un account?
    <a href="...">
        user::auth.login.register_now  <!-- ❌ NON TRADOTTO -->
    </a>
</p>

<p class="text-italia-gray-600 dark:text-gray-400">
    user::auth.login.forgot_password_text  <!-- ❌ NON TRADOTTO -->
    <a href="...">
        user::auth.login.reset_it  <!-- ❌ NON TRADOTTO -->
    </a>
</p>
```

### ✅ Ma Funzionano

```html
<h2>Accedi al tuo account</h2>  <!-- ✅ TRADOTTO -->
<p>Inserisci le tue credenziali per accedere</p>  <!-- ✅ TRADOTTO -->
<button>Accedi</button>  <!-- ✅ TRADOTTO -->
```

---

## 🔍 Analisi Causa

### Struttura Traduzioni Trovata

**File**: `laravel/Modules/User/lang/it/auth.php`

```php
return [
    'login' => [
        'title' => 'Accedi al tuo account',  // ✅ Funziona
        'subtitle' => 'Inserisci le tue credenziali per accedere',  // ✅ Funziona
        'register_now' => 'Registrati ora',  // ❌ Non accessibile con user::auth.login.xxx
        'forgot_password_text' => 'Password dimenticata?',
        'reset_it' => 'Reimposta',
    ],
];
```

### Path Traduzioni

**Vista cerca**: `__('user::auth.login.register_now')`  
**Path reale**: `user::login.register_now` (perché è sotto 'login', non 'auth.login')

---

## ✅ Soluzione

### Opzione 1: Correggere Vista (CONSIGLIATO)

**File**: `laravel/Themes/Sixteen/resources/views/filament/widgets/auth/login.blade.php`

**Cambiare**:
```blade
<!-- DA -->
{{ __('user::auth.login.register_now') }}
{{ __('user::auth.login.forgot_password_text') }}
{{ __('user::auth.login.reset_it') }}

<!-- A -->
{{ __('user::login.register_now') }}
{{ __('user::login.forgot_password_text') }}
{{ __('user::login.reset_it') }}
```

### Opzione 2: Riorganizzare File Traduzione

**File**: `laravel/Modules/User/lang/it/auth.php`

```php
return [
    // ... altre chiavi ...
    
    'auth' => [
        'login' => [
            'register_now' => 'Registrati ora',
            'forgot_password_text' => 'Password dimenticata?',
            'reset_it' => 'Reimposta',
        ],
    ],
];
```

---

## 🎯 Implementazione

Procedo con Opzione 1 (correzione vista) perché più semplice e mantiene struttura esistente.




