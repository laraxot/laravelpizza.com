# Convenzioni per le Pagine Filament

## Regola del Suffisso "Page"
Tutte le classi che rappresentano pagine Filament devono terminare con il suffisso "Page". Questo è un requisito PSR per mantenere la coerenza e la chiarezza nel codice.

### Esempi Corretti
```php
class SendSMSPage extends XotBasePage
class SendWhatsAppPage extends XotBasePage
class SendTelegramPage extends XotBasePage
```

### Esempi Non Corretti
```php
class SendSMS extends XotBasePage
class SendWhatsApp extends XotBasePage
class SendTelegram extends XotBasePage
```

## Motivazione
1. **Coerenza**: Il suffisso "Page" chiarisce immediatamente che la classe rappresenta una pagina Filament
2. **PSR Compliance**: Segue le convenzioni PSR per il naming delle classi
3. **Manutenibilità**: Rende più facile identificare il tipo di componente
4. **Auto-documentazione**: Il nome della classe documenta automaticamente il suo scopo

## Struttura Directory
```
app/Filament/
├── Clusters/
│   └── Test/
│       └── Pages/           # Tutte le classi qui devono finire con "Page"
│           ├── SendSMSPage.php
│           ├── SendWhatsAppPage.php
│           └── SendTelegramPage.php
```

## Best Practices
1. **Naming**: Usa sempre il suffisso "Page" per le classi di pagine Filament
2. **Organizzazione**: Mantieni le pagine nella directory `Pages/`
3. **Coerenza**: Segui lo stesso pattern per tutte le pagine
4. **Documentazione**: Documenta sempre lo scopo della pagina nel PHPDoc

## Esempio di Implementazione Corretta
```php
<?php

namespace Modules\Notify\Filament\Clusters\Test\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Modules\Notify\Datas\SmsData;
use Illuminate\Support\Facades\Log;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Filament\Clusters\Test;
use Modules\Xot\Filament\Pages\XotBasePage;
use Illuminate\Support\Facades\Notification;
use Illuminate\Contracts\Auth\Authenticatable;
use Filament\Forms\Concerns\InteractsWithForms;
use Modules\Notify\Notifications\SmsNotification;
use Modules\Xot\Filament\Traits\NavigationLabelTrait;
use Filament\Notifications\Notification as FilamentNotification;

/**
 * @property ComponentContainer $smsForm
 */
class SendSMSPage extends XotBasePage implements HasForms
{
    // ... implementazione
}
``` 
