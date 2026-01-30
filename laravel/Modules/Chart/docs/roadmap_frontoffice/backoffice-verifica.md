# Backoffice: Verifica e Approvazione

## Panoramica
Questa parte del backoffice è dedicata alla verifica e approvazione delle richieste di iscrizione, sia per i pazienti che per gli odontoiatri. L'amministratore del sistema ha accesso a un'interfaccia centralizzata per gestire tutte le richieste in attesa, visualizzare i documenti allegati e prendere decisioni in merito all'approvazione o al rifiuto.

**Percentuale di completamento: 85%**

## Componenti Principali

### 1. Schermata di Accesso
- **Implementazione**: 75% completata
- **Descrizione**: Interfaccia di accesso protetta per gli amministratori con autenticazione a due fattori.
- **File di Implementazione**:
  ```php
  // /var/www/html/<nome progetto>/laravel/Modules/Admin/app/Http/Livewire/Auth/Login.php
  namespace Modules\Admin\Http\Livewire\Auth;
  
  class Login extends Component
  {
      // Implementazione del form di login con 2FA
  }
  ```

### 2. Dashboard Richieste
- **Implementazione**: 90% completata
- **Descrizione**: Visualizzazione centralizzata di tutte le richieste in attesa di verifica, con filtri e ordinamento.
- **Componenti UI**:
  - Tabella con filtri avanzati (stato, data, tipo di utente)
  - Badge colorati per lo stato delle richieste
  - Contatori in tempo reale
- **File di Implementazione**:
  ```php
  // /var/www/html/<nome progetto>/laravel/Modules/Admin/app/Filament/Resources/RequestResource.php
  namespace Modules\Admin\Filament\Resources;
  
  class RequestResource extends XotBaseResource
  {
      // Implementazione della risorsa Filament per le richieste
  }
  ```

### 3. Visualizzazione Dettaglio Richiesta
- **Implementazione**: 85% completata
- **Descrizione**: Interfaccia per visualizzare tutti i dettagli di una richiesta, inclusi documenti caricati.
- **Funzionalità**:
  - Visualizzazione anteprima documenti direttamente nell'interfaccia
  - Zoom sui documenti senza download
  - Validazione documenti con verifica automatica (OCR)
- **File di Implementazione**:
  ```php
  // /var/www/html/<nome progetto>/laravel/Modules/Admin/app/Filament/Resources/RequestResource/Pages/ViewRequest.php
  namespace Modules\Admin\Filament\Resources\RequestResource\Pages;
  
  class ViewRequest extends XotBaseViewRecord
  {
      // Implementazione della pagina di visualizzazione dettaglio
  }
  ```

### 4. Processo di Approvazione
- **Implementazione**: 90% completata
- **Descrizione**: Workflow per approvare una richiesta, con notifiche automatiche.
- **Flusso Dati**:
  1. Amministratore verifica tutti i documenti
  2. Se tutto è corretto, seleziona "Approva"
  3. Sistema aggiorna lo stato dell'utente (attivo)
  4. Notifica automatica inviata all'utente via email e SMS
  5. Utente riceve credenziali di accesso
- **File di Implementazione**:
  ```php
  // /var/www/html/<nome progetto>/laravel/Modules/Admin/app/Actions/ApproveRequestAction.php
  namespace Modules\Admin\Actions;
  
  class ApproveRequestAction
  {
      public function handle(Request $request, User $approver): bool
      {
          // Logica di approvazione
      }
  }
  ```

### 5. Processo di Rifiuto
- **Implementazione**: 80% completata
- **Descrizione**: Workflow per rifiutare una richiesta, con motivazione obbligatoria.
- **Flusso Dati**:
  1. Amministratore seleziona "Rifiuta"
  2. Sistema richiede motivazione (obbligatoria)
  3. Stato richiesta aggiornato a "Rifiutata"
  4. Notifica automatica inviata all'utente con motivazione del rifiuto
  5. Possibilità per l'utente di correggere problemi e ripresentare
- **File di Implementazione**:
  ```php
  // /var/www/html/<nome progetto>/laravel/Modules/Admin/app/Actions/RejectRequestAction.php
  namespace Modules\Admin\Actions;
  
  class RejectRequestAction
  {
      public function handle(Request $request, string $reason, User $rejector): bool
      {
          // Logica di rifiuto con motivazione
      }
  }
  ```

## Interfaccia Utente
![Mockup Backoffice Verifica](/var/www/html/<nome progetto>/docs/immagini/mockup-backoffice-verifica.png)

## Implementazione Tecnica

### Filament Resource

La gestione delle richieste è implementata come una risorsa Filament, con metodi personalizzati per gestire il workflow di approvazione:

```php
// /var/www/html/<nome progetto>/laravel/Modules/Admin/app/Filament/Resources/RequestResource.php
namespace Modules\Admin\Filament\Resources;

use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\Action;
use Modules\Xot\Filament\Resources\XotBaseResource;

class RequestResource extends XotBaseResource
{
    protected static ?string $model = Request::class;
    
    public static function getFormSchema(): array
    {
        return [
            'note' => Textarea::make('note')
                ->label(__('admin.requests.fields.note.label'))
                ->placeholder(__('admin.requests.fields.note.placeholder'))
                ->maxLength(1000),
            // Altri campi...
        ];
    }
    
    public static function getTableActions(): array
    {
        return [
            'approve' => Action::make('approve')
                ->label(__('admin.requests.actions.approve.label'))
                ->icon('heroicon-o-check')
                ->color('success')
                ->requiresConfirmation()
                ->action(fn (Request $record) => app(ApproveRequestAction::class)->handle($record, auth()->user())),
                
            'reject' => Action::make('reject')
                ->label(__('admin.requests.actions.reject.label'))
                ->icon('heroicon-o-x-mark')
                ->color('danger')
                ->form([
                    Textarea::make('reason')
                        ->label(__('admin.requests.fields.rejection_reason.label'))
                        ->required()
                        ->maxLength(500)
                ])
                ->action(fn (Request $record, array $data) => app(RejectRequestAction::class)->handle($record, $data['reason'], auth()->user())),
            // Altre azioni...
        ];
    }
}
```

### Sistema di Notifiche

Le notifiche di approvazione/rifiuto utilizzano il sistema multi-canale di <nome progetto>:

```php
// /var/www/html/<nome progetto>/laravel/Modules/Admin/app/Notifications/RequestApprovedNotification.php
namespace Modules\Admin\Notifications;

use Illuminate\Notifications\Notification;
use Modules\Notify\Actions\Email\SendSpatieEmailAction;

class RequestApprovedNotification extends Notification
{
    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }
    
    public function toMail($notifiable): SpatieEmail
    {
        $email = new SpatieEmail('request_approved', [
            'name' => $notifiable->name,
            'login_url' => route('login'),
        ]);
        
        // Impostazione esplicita del destinatario (regola obbligatoria)
        if (method_exists($notifiable, 'routeNotificationFor')) {
            $email->to($notifiable->routeNotificationFor('mail'));
        }
        
        return $email;
    }
}
```

## Test e Validazione

### Test Unitari
```php
// /var/www/html/<nome progetto>/laravel/Modules/Admin/Tests/Unit/ApproveRequestActionTest.php
namespace Modules\Admin\Tests\Unit;

use Tests\TestCase;
use Modules\Admin\Actions\ApproveRequestAction;

class ApproveRequestActionTest extends TestCase
{
    /** @test */
    public function it_approves_a_request_and_activates_the_user()
    {
        // Implementazione test
    }
    
    /** @test */
    public function it_sends_notification_after_approval()
    {
        // Implementazione test
    }
}
```

### E2E Test
```php
// /var/www/html/<nome progetto>/laravel/Tests/Browser/RequestApprovalTest.php
namespace Tests\Browser;

use Laravel\Dusk\Browser;

class RequestApprovalTest extends DuskTestCase
{
    /** @test */
    public function admin_can_approve_a_pending_request()
    {
        // Implementazione test end-to-end
    }
}
```

## Prossimi Sviluppi
1. Implementare sistema di approvazione batch per richieste multiple *(Priorità: Media)*
2. Integrazione con sistema di verifica documenti di terze parti *(Priorità: Alta)*
3. Dashboard analytics per tempi di approvazione *(Priorità: Bassa)*
4. Migliorare UX della visualizzazione documenti *(Priorità: Media)*

## Collegamenti Correlati
- [Backoffice Gestione](./backoffice-gestione.md)
- [Backoffice Avvisi](./backoffice-avvisi.md)
- [Backoffice Rifiuti](./backoffice-rifiuti.md)
- [Iscrizione Odontoiatra](./09-iscrizione-odontoiatra.md)
- [Iscrizione Paziente](./06-iscrizione-paziente.md)
