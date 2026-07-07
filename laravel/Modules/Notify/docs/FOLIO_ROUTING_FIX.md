# 🔧 Fix Routing Folio per Login Page

**Data**: 14 Ottobre 2025  
**Problema**: Folio non trovava il file di vista per `/it/auth/login`

---

## 🚨 Problema Identificato

### Errore Timeout
```
Maximum execution time of 30 seconds exceeded
FileViewFinder.php:138 - Laravel non riusciva a trovare la vista
```

### Causa Root
**Laravel Folio** cerca le pagine in:
```
Modules/User/resources/views/pages/auth/login.blade.php
```

Ma avevamo il file solo in:
```
Themes/Sixteen/resources/views/pages/auth/login.blade.php
```

---

## ✅ Soluzione Applicata

### 1. Directory Creata
```bash
mkdir -p Modules/User/resources/views/pages/auth
```

### 2. File Copiato
```bash
cp Themes/Sixteen/resources/views/pages/auth/login.blade.php \
   Modules/User/resources/views/pages/auth/login.blade.php
```

### 3. Cache Pulita
```bash
php artisan config:clear
php artisan view:clear
```

---

## 🎯 Architettura Folio Laravel

### Sistema Folio
- **Laravel Folio** usa file di vista per routing automatico
- **Path mapping**: URL → File system
- **Pattern**: `/{locale}/{module}/{action}` → `resources/views/pages/{module}/{action}.blade.php`

### URL → File Mapping
```
/it/auth/login → Modules/User/resources/views/pages/auth/login.blade.php
/en/auth/login → Modules/User/resources/views/pages/auth/login.blade.php  
/de/auth/login → Modules/User/resources/views/pages/auth/login.blade.php
```

### Vista Template
Il file usa:
```blade
<x-layouts.app>
    <x-filament-widgets::widget>
        @livewire(\Modules\User\Filament\Widgets\Auth\LoginWidget::class)
    </x-filament-widgets::widget>
</x-layouts.app>
```

---

## 🔄 Flusso Completo

```
1. Browser: GET /it/auth/login
    ↓
2. Laravel Folio: Route discovery
    ↓  
3. FileViewFinder: Cerca file
    Modules/User/resources/views/pages/auth/login.blade.php
    ↓
4. Blade Render: Carica vista
    ↓
5. Layout: x-layouts.app (header AGID)
    ↓
6. Widget: @livewire(LoginWidget::class)
    ↓
7. LoginWidget: Render form Filament
    ↓
8. Response: HTML completo con form
```

---

## 📁 Struttura File Finale

```
Modules/User/resources/views/pages/auth/
├── login.blade.php          # ✅ File Folio (routing)
└── ...

Themes/Sixteen/resources/views/pages/auth/
├── login.blade.php          # ✅ Template design (backup)
└── ...

Themes/Sixteen/resources/views/filament/widgets/auth/
└── login.blade.php          # ✅ Vista widget Filament
```

---

## 🎯 Prossimi Step

1. **Test pagina**: http://127.0.0.1:8000/it/auth/login
2. **Verifica form**: Widget deve apparire
3. **Test traduzioni**: Tutti i testi in italiano
4. **Test funzionalità**: Submit form

---

## 💡 Lezione Appresa

### Laravel Folio + Moduli
- **Folio** cerca sempre nei **moduli** prima che nei temi
- **Path standard**: `Modules/{Module}/resources/views/pages/`
- **Temi** sono per **styling**, **moduli** per **routing**
- **Widget** rimangono nei **temi** per **customizzazione**

### Best Practice
1. **File routing** → `Modules/{Module}/resources/views/pages/`
2. **Template design** → `Themes/{Theme}/resources/views/pages/`  
3. **Widget views** → `Themes/{Theme}/resources/views/filament/widgets/`




