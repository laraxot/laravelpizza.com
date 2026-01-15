# Sistema Email con Tailwind CSS nel Modulo Notify

## 1. Configurazione Base

### 1.1 Setup Iniziale
```javascript
// tailwind.config.js
module.exports = {
  content: [
    './Modules/Notify/resources/views/emails/**/*.blade.php',
    './Modules/Notify/resources/views/components/email/**/*.blade.php',
  ],
  theme: {
    extend: {
      colors: {
        'notify': {
          50: '#f0f9ff',
          // ... altri colori
          900: '#0c4a6e',
        }
      }
    }
  }
}
```

### 1.2 Configurazione Email
```php
// config/notify.php
return [
    'email' => [
        'use_queue' => true,
        'template_path' => 'notify::emails',
        'styles' => [
            'body' => 'bg-gray-100 font-sans',
            'wrapper' => 'max-w-2xl mx-auto my-8 bg-white',
            'content' => 'p-8',
        ],
    ]
];
```

## 2. Layout Base Email

### 2.1 Master Layout
```php
// resources/views/layouts/email.blade.php
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    
    <style>
        /* Tailwind Base Styles */
        @layer base {
            body {
                margin: 0;
                padding: 0;
                width: 100%;
                background-color: #f3f4f6;
            }
        }
        
        /* Email-safe Tailwind utilities */
        .notify-email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
        }
        
        .notify-email-header {
            padding: 1.5rem;
            background-color: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .notify-email-content {
            padding: 2rem;
        }
        
        .notify-email-footer {
            padding: 1.5rem;
            background-color: #f9fafb;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 0.875rem;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="notify-email-wrapper">
        <div class="notify-email-header">
            @include('notify::emails.partials.logo')
        </div>
        
        <div class="notify-email-content">
            @yield('content')
        </div>
        
        <div class="notify-email-footer">
            @include('notify::emails.partials.footer')
        </div>
    </div>
</body>
</html>
```

### 2.2 Componenti Email Base
```php
// resources/views/components/email/button.blade.php
@props([
    'url',
    'color' => 'primary',
    'align' => 'center'
])

@php
$styles = match($color) {
    'primary' => 'background-color: #2563eb; color: white;',
    'secondary' => 'background-color: #4b5563; color: white;',
    'success' => 'background-color: #059669; color: white;',
    'danger' => 'background-color: #dc2626; color: white;',
    default => 'background-color: #2563eb; color: white;',
};

$alignment = match($align) {
    'left' => 'text-align: left;',
    'center' => 'text-align: center;',
    'right' => 'text-align: right;',
    default => 'text-align: center;',
};
@endphp

<div style="{{ $alignment }}">
    <a href="{{ $url }}" 
       style="display: inline-block; padding: 12px 24px; {{ $styles }} text-decoration: none; border-radius: 6px; font-weight: 500;">
        {{ $slot }}
    </a>
</div>
```

## 3. Template Email

### 3.1 Template Benvenuto
```php
// resources/views/emails/welcome.blade.php
@extends('notify::layouts.email')

@section('content')
<div style="text-align: center; padding: 2rem 0;">
    <h1 style="color: #111827; font-size: 1.875rem; font-weight: 700; margin-bottom: 1rem;">
        Benvenuto in {{ config('app.name') }}
    </h1>
    
    <p style="color: #4b5563; font-size: 1rem; margin-bottom: 2rem;">
        Siamo felici di averti con noi! Ecco alcune informazioni importanti per iniziare.
    </p>
    
    <x-notify::email.button 
        :url="route('dashboard')"
        color="primary"
        align="center">
        Accedi alla Dashboard
    </x-notify::email.button>
</div>

<div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #e5e7eb;">
    <h2 style="color: #111827; font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem;">
        Prossimi Passi
    </h2>
    
    <ul style="list-style-type: none; padding: 0; margin: 0;">
        <li style="margin-bottom: 1rem; padding-left: 1.5rem; position: relative;">
            <span style="position: absolute; left: 0; color: #2563eb;">✓</span>
            Completa il tuo profilo
        </li>
        <li style="margin-bottom: 1rem; padding-left: 1.5rem; position: relative;">
            <span style="position: absolute; left: 0; color: #2563eb;">✓</span>
            Esplora i servizi disponibili
        </li>
        <li style="margin-bottom: 1rem; padding-left: 1.5rem; position: relative;">
            <span style="position: absolute; left: 0; color: #2563eb;">✓</span>
            Configura le tue preferenze
        </li>
    </ul>
</div>
```

### 3.2 Template Notifica
```php
// resources/views/emails/notification.blade.php
@extends('notify::layouts.email')

@section('content')
<div style="background-color: #f0f9ff; border-left: 4px solid #2563eb; padding: 1rem; margin-bottom: 2rem;">
    <div style="display: flex; align-items: flex-start;">
        <div style="margin-right: 1rem;">
            <svg style="width: 1.5rem; height: 1.5rem; color: #2563eb;" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
            </svg>
        </div>
        <div>
            <h3 style="margin: 0 0 0.5rem 0; color: #1e40af; font-weight: 600;">
                {{ $notification->title }}
            </h3>
            <p style="margin: 0; color: #1e40af;">
                {{ $notification->message }}
            </p>
        </div>
    </div>
</div>

@if($notification->action_url)
    <div style="margin-top: 2rem;">
        <x-notify::email.button 
            :url="$notification->action_url"
            color="primary"
            align="left">
            {{ $notification->action_text }}
        </x-notify::email.button>
    </div>
@endif
```

## 4. Utility Email

### 4.1 Helper per Email
```php
// app/Helpers/EmailStyleHelper.php
class EmailStyleHelper
{
    public static function getButtonStyle($color = 'primary'): string
    {
        return match($color) {
            'primary' => 'background-color: #2563eb; color: white;',
            'secondary' => 'background-color: #4b5563; color: white;',
            'success' => 'background-color: #059669; color: white;',
            'danger' => 'background-color: #dc2626; color: white;',
            default => 'background-color: #2563eb; color: white;',
        };
    }

    public static function getTextStyle($size = 'base', $color = 'gray-900'): string
    {
        $fontSize = match($size) {
            'xs' => '0.75rem',
            'sm' => '0.875rem',
            'base' => '1rem',
            'lg' => '1.125rem',
            'xl' => '1.25rem',
            '2xl' => '1.5rem',
            default => '1rem',
        };

        $textColor = match($color) {
            'gray-900' => '#111827',
            'gray-700' => '#374151',
            'gray-500' => '#6b7280',
            default => '#111827',
        };

        return "font-size: {$fontSize}; color: {$textColor};";
    }
}
```

### 4.2 Mixins per Email
```css
/* resources/css/email.css */
@layer components {
    .notify-email-text-base {
        color: #111827;
        font-size: 1rem;
        line-height: 1.5;
    }

    .notify-email-heading {
        color: #111827;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .notify-email-link {
        color: #2563eb;
        text-decoration: underline;
    }

    .notify-email-button {
        display: inline-block;
        padding: 12px 24px;
        background-color: #2563eb;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-weight: 500;
    }
}
```

## 5. Testing Email

### 5.1 Test Visuali
```php
// tests/Feature/Email/WelcomeEmailTest.php
class WelcomeEmailTest extends TestCase
{
    /** @test */
    public function welcome_email_contains_correct_styles()
    {
        $user = User::factory()->create();
        
        $mailable = new WelcomeEmail($user);
        
        $mailable->assertSeeInHtml('background-color: #2563eb');
        $mailable->assertSeeInHtml('font-weight: 700');
    }

    /** @test */
    public function welcome_email_is_responsive()
    {
        $user = User::factory()->create();
        
        $mailable = new WelcomeEmail($user);
        
        $mailable->assertSeeInHtml('max-width: 600px');
        $mailable->assertSeeInHtml('@media (max-width: 600px)');
    }
}
```

### 5.2 Test Contenuto
```php
// tests/Feature/Email/NotificationEmailTest.php
class NotificationEmailTest extends TestCase
{
    /** @test */
    public function notification_email_renders_correctly()
    {
        $notification = Notification::factory()->create([
            'title' => 'Test Notification',
            'message' => 'This is a test message',
            'action_url' => 'https://example.com',
            'action_text' => 'Click Here',
        ]);
        
        $mailable = new NotificationEmail($notification);
        
        $mailable->assertSeeInHtml('Test Notification');
        $mailable->assertSeeInHtml('This is a test message');
        $mailable->assertSeeInHtml('href="https://example.com"');
        $mailable->assertSeeInHtml('Click Here');
    }
}
```

## Note
- Tutti i collegamenti sono relativi
- La documentazione è mantenuta in italiano
- I collegamenti sono bidirezionali quando appropriato
- Ogni sezione ha il suo README.md specifico

## Contribuire
Per contribuire alla documentazione, seguire le [Linee Guida](../../../docs/linee-guida-documentazione.md) e le [Regole dei Collegamenti](../../../docs/regole_collegamenti_documentazione.md).

## Collegamenti Completi
Per una lista completa di tutti i collegamenti tra i README.md, consultare il file [README_links.md](../../../docs/README_links.md). 
