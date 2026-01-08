# Mail Layouts - Integrazione con Sistema Temi

## Overview

Il sistema email di PTVX supporta **layout personalizzati per tema**, permettendo a ogni tema di definire il proprio stile per le email mantenendo la logica email separata.

## Business Logic

### Perché Layout Per Tema?

**Scenario**: Installazioni multi-tenant con brand diversi

- Tenant A usa tema "Corporate" → Email con logo/colori aziendali
- Tenant B usa tema "Minimal" → Email minimal design
- Tenant C usa tema "DarkMode" → Email con tema scuro

**Soluzione**: Layout email personalizzato per tema invece di hardcoded.

## Architettura

### File System Structure

```
/var/www/html/ptvx/
│
├─ laravel/
│  ├─ Modules/Notify/resources/mail-layouts/  ← Default fallback
│  │  ├─ base.html
│  │  ├─ base/
│  │  │  ├─ default.html
│  │  │  └─ responsive.html
│  │  └─ themes/
│  │     ├─ light.html
│  │     └─ dark.html
│  │
│  └─ Themes/                                  ← Temi applicazione
│     ├─ Zero/resources/mail-layouts/
│     │  └─ base.html                        # Layout tema Zero (Design Italiano)
│     │
│     ├─ One/resources/mail-layouts/
│     │  └─ base.html                        # Layout tema One
│     │
│     ├─ SbAdmin2Bs4/resources/mail-layouts/
│     │  └─ base.html                        # Layout SbAdmin2Bs4
│     │
│     └─ MetronicOne/resources/mail-layouts/
│        └─ base.html                        # Layout Metronic
```

### Configurazione Tema Attivo

```php
// config/{environment}/xra.php

return [
    'pub_theme' => 'Zero',  // ← Tema pubblico attivo
    // Altri config...
];
```

**Ambienti**:
- `config/local/tv/prov/personale2019/xra.php` → `pub_theme = 'Zero'`
- `config/local/tv/prov/personale2022/xra.php` → `pub_theme = 'Zero'`
- `config/localhost/xra.php` → `pub_theme = 'One'`
- Production può avere tema diverso

### Tema Zero

Il tema **Zero** implementa un layout email basato sul **Design System Italiano** ([italia/design-comuni-pagine-statiche](https://github.com/italia/design-comuni-pagine-statiche)) con:

- ✅ Colori istituzionali italiani (Blu Italia #0066CC, Verde #00AA66)
- ✅ Accessibilità WCAG 2.1 Level AA
- ✅ Responsive design ottimizzato
- ✅ Dark mode support
- ✅ TailwindCSS-inspired spacing e colori
- ✅ Integrazione completa con spatie/laravel-database-mail-templates

**Documentazione**: [Themes/Zero/docs/mail-layouts.md](../../../../Themes/Zero/docs/mail-layouts.md)

## Implementazione getHtmlLayout()

### Codice Corrente

```php
// Modules/Notify/app/Emails/SpatieEmail.php

public function getHtmlLayout(): string
{
    $xot = XotData::make();
    $pub_theme = $xot->pub_theme;  // Legge da config
    
    $pubThemePath = base_path('Themes/'.$pub_theme);
    $pathToLayout = $pubThemePath.'/resources/mail-layouts/base.html';
    
    return file_get_contents($pathToLayout);
}
```

### Strategia Fallback Migliorata

```php
public function getHtmlLayout(): string
{
    $xot = XotData::make();
    $pub_theme = $xot->pub_theme;
    
    // 1. Prova layout tema-specifico
    $themePath = base_path("Themes/{$pub_theme}/resources/mail-layouts/base.html");
    
    if (file_exists($themePath)) {
        return file_get_contents($themePath);
    }
    
    // 2. Fallback a layout default Notify responsive
    $responsivePath = module_path('Notify', 'resources/mail-layouts/base/responsive.html');
    
    if (file_exists($responsivePath)) {
        return file_get_contents($responsivePath);
    }
    
    // 3. Fallback a layout base semplice
    $basePath = module_path('Notify', 'resources/mail-layouts/base.html');
    
    return file_get_contents($basePath);
}
```

## Creazione Layout Custom per Tema

### Step-by-Step

#### 1. Crea Struttura Cartelle

```bash
mkdir -p Themes/MyBrandTheme/resources/mail-layouts
```

#### 2. Copia Layout Base come Template

```bash
cp laravel/Modules/Notify/resources/mail-layouts/base.html \
   Themes/MyBrandTheme/resources/mail-layouts/base.html
```

#### 3. Personalizza Layout

```html
<!-- Themes/MyBrandTheme/resources/mail-layouts/base.html -->

<!DOCTYPE html>
<html>
<head>
    <title>{{ subject }}</title>
    <style>
        /* Brand Colors */
        :root {
            --brand-primary: #0066CC;
            --brand-secondary: #00AA66;
            --brand-accent: #FF6600;
        }
        
        body {
            font-family: 'Brand Font', Arial, sans-serif;
            background-color: #F5F5F5;
        }
        
        .email-header {
            background: linear-gradient(135deg, var(--brand-primary), var(--brand-secondary));
            padding: 30px;
            text-align: center;
        }
        
        .email-button {
            background-color: var(--brand-accent);
            color: #FFFFFF;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <table role="presentation" width="100%">
        <tr>
            <td align="center">
                <table role="presentation" width="600">
                    <!-- Header Brand Custom -->
                    <tr>
                        <td class="email-header">
                            <img src="{{ logo_url }}" alt="Brand Logo" style="height: 60px;" />
                            <p style="color: #FFFFFF; margin: 10px 0 0 0;">{{ company_tagline }}</p>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px; background-color: #FFFFFF;">
                            {{{ body }}}
                        </td>
                    </tr>
                    
                    <!-- Footer Brand Custom -->
                    <tr>
                        <td style="padding: 30px; background-color: #E5E5E5; text-align: center;">
                            <div style="margin-bottom: 20px;">
                                <!-- Social Icons Custom -->
                                <a href="{{ facebook_url }}">
                                    <img src="{{ brand_facebook_icon }}" alt="Facebook" style="height: 32px; margin: 0 5px;" />
                                </a>
                                <a href="{{ linkedin_url }}">
                                    <img src="{{ brand_linkedin_icon }}" alt="LinkedIn" style="height: 32px; margin: 0 5px;" />
                                </a>
                            </div>
                            <p style="font-size: 12px; color: #666;">
                                © {{ year }} {{ company_name }} - {{ company_address }}
                            </p>
                            <p style="font-size: 11px; color: #999;">
                                <a href="{{ privacy_url }}" style="color: #999;">Privacy Policy</a> | 
                                <a href="{{ terms_url }}" style="color: #999;">Termini di Servizio</a> | 
                                <a href="{{ unsubscribe_url }}" style="color: #999;">Annulla iscrizione</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
```

#### 4. Aggiungi Variabili Custom

```php
// Themes/MyBrandTheme/app/Actions/PrepareEmailDataAction.php

class PrepareEmailDataAction
{
    public function execute(array $data): array
    {
        return array_merge($data, [
            'company_tagline' => 'Il tuo partner digitale',
            'brand_facebook_icon' => asset('themes/mybrand/images/social/facebook.png'),
            'brand_linkedin_icon' => asset('themes/mybrand/images/social/linkedin.png'),
            'privacy_url' => route('privacy'),
            'terms_url' => route('terms'),
        ]);
    }
}
```

#### 5. Test Layout

```bash
php artisan tinker
```

```php
config(['xra.pub_theme' => 'MyBrandTheme']);

$user = User::first();
$email = new SpatieEmail($user, 'test');

echo $email->getHtmlLayout();
// ✅ Dovrebbe mostrare layout custom!
```

## Logo vettoriale 2025

> **Aggiornamento 18 novembre 2025**  
> `Modules/Notify/resources/svg/logo.svg` racconta ora il *Notification Communication Hub* con tre canali (email, SMS, push) e palette coerente con il Design System Italiano.

- palette istituzionale: Blu Italia `#0066CC`, Verde `#00AA66`, accento `#00C7B1`
- supporto a dark mode (`prefers-color-scheme`) e rispetto di `prefers-reduced-motion`
- classi semantiche (`.ring`, `.channel`, `.hub`) sovrascrivibili nei temi white-label senza perdere la narrativa multi-tenant
- riutilizzabile via `logo_svg` / `logo_header` nei layout email o nei componenti web

Quando si crea un tema personalizzato duplicare l’SVG, aggiornare i colori di brand e mantenere la tripla metafora dei canali per preservare coerenza visiva fra tenant diversi.

## Pattern Multi-Tenant

### Scenario: Email Diverse Per Tenant

```php
// app/Mail/TenantAwareSpatieEmail.php

class TenantAwareSpatieEmail extends SpatieEmail
{
    public function getHtmlLayout(): string
    {
        $tenant = Filament::getTenant();  // Tenant corrente
        
        // Layout specifico tenant
        $tenantPath = storage_path("tenants/{$tenant->id}/mail-layouts/base.html");
        
        if (file_exists($tenantPath)) {
            return file_get_contents($tenantPath);
        }
        
        // Fallback a layout tema
        return parent::getHtmlLayout();
    }
}
```

**Business Case**: SaaS con white-label, ogni cliente ha email branded.

## Gestione Layout da Admin Panel

### Feature Request: Layout Manager

```php
// Modules/Notify/app/Filament/Resources/EmailLayoutResource.php

class EmailLayoutResource extends XotBaseResource
{
    protected static ?string $model = EmailLayout::class;
    
    public static function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name'),
            'theme' => Select::make('theme')
                ->options([
                    'Zero' => 'SbAdmin2',
                    'One' => 'Tema One',
                    'MetronicOne' => 'Metronic',
                ]),
            'html_content' => MonacoEditor::make('html_content')
                ->language('html')
                ->height('500px'),
        ];
    }
}
```

**Vantaggio**: Modifica layout email da admin panel senza accesso filesystem.

## Collegamenti

### Documentazione Interna
- [Spatie Database Mail Templates Deep Dive](./spatie-database-mail-templates-deep-dive.md)
- [Mail Layouts README](../resources/mail-layouts/README.md)
- [SpatieEmail Class](../app/Emails/SpatieEmail.php)

### Esempi Layout
- [Base Layout](../resources/mail-layouts/base.html)
- [Default Layout](../resources/mail-layouts/base/default.html)
- [Responsive Layout](../resources/mail-layouts/base/responsive.html)

---

**Ultimo aggiornamento**: 27 Ottobre 2025  
**Pattern**: Layout per tema con fallback chain  
**Status**: ✅ IMPLEMENTATO

