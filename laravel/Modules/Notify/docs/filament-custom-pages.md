# Filament Custom Pages - Documentazione Modulo Notify

## Overview

Il modulo **Notify** implementa pagine Filament custom per la gestione delle notifiche (Email, Telegram, Push) e il testing dei servizi di notifica.

## Pattern Utilizzato

### XotBasePage in Cluster Test

Le pagine sono organizzate in un Filament Cluster chiamato `Test`:

```php
namespace Modules\Notify\Filament\Clusters\Test\Pages;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Modules\Xot\Filament\Pages\XotBasePage;

class SendEmail extends XotBasePage implements HasForms
{
    use InteractsWithForms;
    
    public ?array $emailData = [];
    protected static ?string $cluster = Test::class;
    protected string $view = 'notify::filament.pages.send-email';
    
    public function emailForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('recipient')
                            ->email()
                            ->required(),
                        TextInput::make('subject')->required(),
                        RichEditor::make('body_html')->required(),
                    ]),
            ])
            ->model($this->getUser())
            ->statePath('emailData');
    }
}
```

## Pagine Disponibili

### 1. SendEmail
- **Cluster**: Test
- **Funzione**: Invio email tramite form
- **Componenti**: TextInput (recipient, subject), RichEditor (body_html)
- **View**: `notify::filament.pages.send-email`

### 2. TestSmtpPage
- **Cluster**: Test
- **Funzione**: Test configurazione SMTP
- **Componenti**: host, port, username, password, encryption, from_email, from, recipient, subject, body_html
- **Uso**: Debug e verifica configurazione mail

### 3. SendTelegram
- **Cluster**: Test
- **Funzione**: Invio notifiche Telegram
- **Integrazione**: Telegram Bot API, NotificationChannels\Telegram

### 4. SendTelegramPage
- **Cluster**: Test
- **Funzione**: Gestione invio Telegram con form dedicato
- **View**: `notify::filament.pages.send-telegram`

### 5. SendPushNotification
- **Cluster**: Test
- **Funzione**: Invio notifiche Push via Firebase
- **Componenti**: Repeater, Select, TextInput
- **Integrazione**: Kreait\Firebase

## Cluster Organization

```php
// Modules/Notify/app/Filament/Clusters/Test.php
namespace Modules\Notify\Filament\Clusters;

use Filament\Clusters\Cluster;

class Test extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?string $navigationLabel = 'Test Notifications';
}
```

## Pattern Comuni

### Mount con fillForms()
```php
public function mount(): void
{
    $this->fillForms();
}
```

### Schema con Model
```php
public function emailForm(Schema $schema): Schema
{
    return $schema
        ->components([...])
        ->model($this->getUser())  // o altro modello
        ->statePath('emailData');
}
```

### RichEditor per HTML
```php
RichEditor::make('body_html')
    ->required()
    ->columnSpanFull(),
```

## View Blade

```
Modules/Notify/resources/views/filament/pages/
├── send-email.blade.php
├── send-telegram.blade.php
└── send-push-notification.blade.php
```

## Best Practices

1. **Sempre usare short array syntax `[]`** nei file PHP
2. **Cluster organization** per raggruppare pagine di test
3. **State path** con nome descrittivo (es. `emailData`, `telegramData`)
4. **Model binding** per associare dati form a modelli Eloquent
5. **View namespace** modulo-specifico (`notify::filament.pages.nome`)

## Collegamenti

- [Filament 5 Clusters](../../../../docs/filament-5-clusters.md)
- [XotBasePage Documentation](../../xot/docs/filament/xotbasepage.md)
- [Telegram Notifications](../docs/telegram-setup.md)
