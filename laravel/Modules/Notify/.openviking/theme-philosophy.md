# OpenViking: THEME PHILOSOPHY

**URI**: `viking://theme/philosophy`  
**Timestamp**: 2026-03-30  
**Priority**: CRITICAL

---

## 🎯 FUNDAMENTAL PRINCIPLE

> *"Il tema è un VESTITO. Configurabile. Intercambiabile. MAI hardcoded."*

---

## ❌ WRONG

```php
// AppServiceProvider.php
$this->app->register(\Themes\Sixteen\Providers\ThemeServiceProvider::class);
```

**Problems**:
- ❌ Hardcoded
- ❌ Not configurable
- ❌ Can't change theme
- ❌ Breaks multi-tenant

---

## ✅ CORRECT

### Configuration

```php
// config/local/fixcity/xra.php
return [
    'pub_theme' => 'Sixteen',  // ← Configurable!
    'register_pub_theme' => true,
];
```

### Dynamic Loading

```php
// Xot module reads config
$themeName = config('xra.pub_theme');  // 'Sixteen'
$shouldRegister = config('xra.register_pub_theme');  // true

if ($shouldRegister) {
    $themeClass = "Themes\\{$themeName}\\Providers\\ThemeServiceProvider";
    app()->register($themeClass);
}
```

---

## 🎨 VIEW NAMESPACE

**ALWAYS**: `pub_theme::`

```blade
<x-pub_theme::blocks.hero.homepage />
<x-pub_theme::components.card.featured />
```

**NOT**: `sixteen::` (theme-specific)

---

## 📁 MULTI-TENANT

```
config/eu/fixcity/xra.php → pub_theme = 'TwentyOne'
config/local/fixcityam/xra.php → pub_theme = 'Sixteen'
```

**Same code, DIFFERENT themes!**

---

## ✅ AppServiceProvider

```php
class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // ✅ DON'T register themes hardcoded
        // Themes registered dynamically from config
    }
}
```

---

## 🧘 MANTRAS

> *"Il tema è un vestito."*

> *"MAI hardcoded. SEMPRE configurabile."*

> *"Namespace 'pub_theme' costante. Tema variabile."*

---

**Status**: ✅ PHILOSOPHY STORED  
**Next**: Apply everywhere
