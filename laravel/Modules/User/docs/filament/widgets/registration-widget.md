# RegistrationWidget: Widget generico per la registrazione utente

## Scopo e filosofia
Il widget `RegistrationWidget` è progettato per essere **completamente generico e riutilizzabile** in qualsiasi progetto che utilizza il modulo User. Non contiene logica di dominio specifica (es. Doctor, Patient, ecc.), ma si limita a:
- raccogliere i dati dal form,
- determinare dinamicamente la risorsa, il modello e l'action da eseguire,
- delegare la logica di salvataggio e gestione dello stato a una Action specifica del modulo che implementa il tipo di utente.
## Pattern di delega
- Il widget riceve il tipo di utente (`$type`) e determina la resource, il modello e l'action tramite convenzioni di namespace.
- La proprietà `$action` viene costruita sostituendo `\Models\` con `\Actions\` e aggiungendo `\RegisterAction`.
- L'action viene invocata tramite `app($this->action)->execute($data)`.
- **Non va mai inserita logica di business o riferimenti a tipi di utente specifici nel widget.**
## Esempio di estensione nei moduli
Ogni modulo che implementa un tipo di utente deve fornire la propria Action di registrazione, ad esempio:
- `Modules\Patient\Actions\Doctor\RegisterAction`
- `Modules\Patient\Actions\Patient\RegisterAction`
Queste Action devono occuparsi di:
- Validare i dati ricevuti
- Creare il modello corretto (Doctor, Patient, ...)
- Impostare lo stato iniziale tramite Enum/Spatie Model States
- Gestire eventuali workflow o notifiche
## Best Practice
1. **Non inserire logica di business nel widget**: tutta la logica di salvataggio e gestione stato va delegata alle Action specifiche.
2. **Implementare una RegisterAction per ogni tipo di utente**: seguendo la convenzione dei namespace.
3. **Utilizzare Enum centralizzate per lo stato**: definite nel modulo corretto.
4. **Documentare i punti di estensione**: ogni progetto può aggiungere nuove Action per nuovi tipi di utente.
5. **Non citare mai tipi di utente o logiche di dominio nel modulo User**: mantenere la massima riusabilità.
## Collegamenti
- [RegistrationWidget.php](../../app/Filament/Widgets/RegistrationWidget.php)
- [EditUserWidget.php](../../app/Filament/Widgets/EditUserWidget.php) - Widget per modifica dati utente
- [Documentazione EditUserWidget](./edit-user-widget.md) - Documentazione completa dell'EditUserWidget
- [Documentazione Xot sulla proprietà $data](../../../Xot/docs/filament/widgets/data-property.md)
- [Esempio di Action di registrazione Doctor](../../../../Patient/app/Actions/Doctor/RegisterAction.php)
- [Esempio di Action di registrazione Patient](../../../../Patient/app/Actions/Patient/RegisterAction.php)
- [Documentazione generale: Registrazione Odontoiatra](../../../../../docs/doctor-registration.md)
- [Documentazione Xot sulla proprietà $data](../../../Xot/project_docs/filament/widgets/data-property.md)
- [Documentazione generale: Registrazione Odontoiatra](../../../../../project_docs/doctor-registration.md)
---
**Nota:**
Se vuoi estendere la logica di registrazione per un nuovo tipo di utente, crea una nuova Action seguendo la convenzione e aggiorna la documentazione del modulo specifico. La documentazione generale delle regole e delle convenzioni si trova nel modulo Xot e va sempre collegata da qui.
## Overview
Il widget `RegistrationWidget` è un componente Filament che gestisce la registrazione degli utenti nel sistema. È un esempio fondamentale di come i form Livewire interagiscono con la proprietà `$data` definita in `XotBaseWidget`.
## Struttura
```php
namespace Modules\User\Filament\Widgets;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
// Altri import...
class RegistrationWidget extends XotBaseWidget
{
    protected int | string | array $columnSpan = 'full';
    public string $type;
    public string $resource;
    protected static string $view = 'pub_theme::filament.widgets.registration';
    public function mount(string $type): void
    {
        $this->type = $type;
        $this->resource = XotData::make()->getUserResourceClassByType($type);
        $this->form->fill();
    }
    public function getFormSchema(): array
        return $this->resource::getFormSchemaWidget();
}
```
## Utilizzo della proprietà `$data`
Il `RegistrationWidget` utilizza implicitamente la proprietà `$data` ereditata da `XotBaseWidget` per gestire i dati del form. Questa proprietà è fondamentale perché:
1. I campi nel form Blade usano `wire:model="data.*"` per il binding dei dati
2. Quando il form viene inviato, i dati sono disponibili tramite `$this->data`
3. La proprietà è già dichiarata in `XotBaseWidget` come `public ?array $data = []`
## Template Blade
Nel file `registration.blade.php`, il form utilizza la direttiva `wire:submit.prevent="register"` per inviare i dati:
```blade
<form wire:submit.prevent="register" class="space-y-6">
    {{ $this->form }}
</form>
I campi generati dal form Filament saranno automaticamente collegati utilizzando `wire:model="data.*"`.
## Errori comuni
### 1. Errore di proprietà non esistente
Livewire: [wire:model="data.first_name"] property does not exist on component: [modules.user.filament.widgets.registration-widget]
Questo errore si verificherebbe se:
- La proprietà `$data` non fosse dichiarata in `XotBaseWidget`
- Ci fosse un tentativo di ridichiarare `$data` nel widget, causando conflitti
### 2. Accesso errato ai dati
// ERRATO ❌
public function register()
    $firstName = $this->first_name; // La proprietà non esiste
// CORRETTO ✅
    $firstName = $this->data['first_name'];
## Best Practices
1. **Non ridichiarare la proprietà `$data`** - È già fornita da `XotBaseWidget`
2. **Accedere ai campi tramite `$this->data['campo']`** - Non come proprietà dirette
3. **Validare i dati prima dell'uso** - Utilizzare i metodi di validazione di Livewire
4. **Utilizzare `$this->form->fill()`** nel metodo `mount()` per inizializzare il form
5. **Evitare binding diretti** come `wire:model="first_name"` che non usano la struttura `data.*`
- [Documentazione sulla proprietà `$data` in XotBaseWidget](../../../Xot/docs/filament/widgets/data-property.md)
- [Filament Forms Documentation](https://filamentphp.com/docs/3.x/forms/installation)
- [Livewire Data Binding](https://livewire.laravel.com/docs/properties)
- [Documentazione sulla proprietà `$data` in XotBaseWidget](../../../Xot/project_docs/filament/widgets/data-property.md)
- [Filament Forms Documentation](https://filamentphp.com/project_docs/3.x/forms/installation)
- [Livewire Data Binding](https://livewire.laravel.com/project_docs/properties)
## Gestione dinamica del salvataggio e delle azioni
Il `RegistrationWidget` è progettato per essere generico e riusabile in qualsiasi progetto che utilizza il modulo User. La logica di salvataggio e la gestione dello stato dell'utente non sono hardcodate, ma vengono risolte dinamicamente in base al tipo di utente (`$type`).
### Scelte progettuali
- Il widget determina dinamicamente la resource, il modello e l'action da eseguire tramite `$type` e la struttura delle classi.
- La proprietà `$action` viene costruita sostituendo `\Models\` con `\Actions\` e aggiungendo `\RegisterAction` al namespace del modello.
- Questo permette di delegare la logica di registrazione a una Action specifica per ogni tipo di utente (es. `Modules\Patient\Actions\Doctor\RegisterAction`, `Modules\Patient\Actions\Patient\RegisterAction`).
- Il widget non contiene logica di business specifica, ma si limita a raccogliere i dati e a invocare l'action corretta.
### Pattern consigliato
- Ogni modulo che definisce un tipo di utente deve implementare la propria Action di registrazione (es. `Doctor\RegisterAction`, `Patient\RegisterAction`).
- L'action deve occuparsi di validare, creare il modello, impostare lo stato iniziale e gestire eventuali notifiche o workflow.
- Il widget rimane generico e riusabile in qualsiasi contesto.
### Best Practice
### Azioni da implementare (esempio per il modulo Patient)
- Impostare lo stato iniziale tramite Enum
### Collegamenti
- [Esempio di Action di registrazione (da creare)](../../../../Patient/app/Actions/Doctor/RegisterAction.php)
## 🔐 **WIDGET DI AUTENTICAZIONE - BEST PRACTICES**
### **Convenzioni per Widget Auth/**
I widget di autenticazione (`LoginWidget`, `RegisterWidget`, `ResetPasswordWidget`, ecc.) devono seguire pattern specifici per garantire coerenza e sicurezza:
#### **1. Struttura Directory Obbligatoria**
Modules/User/app/Filament/Widgets/Auth/
├── LoginWidget.php
├── RegisterWidget.php
├── ResetPasswordWidget.php
└── ForgotPasswordWidget.php
#### **2. Namespace e Naming Convention**
namespace Modules\User\Filament\Widgets\Auth;
class ResetPasswordWidget extends XotBaseWidget
    // Naming: {Action}Widget (es. ResetPassword + Widget)
#### **3. View Path Convention**
// SEMPRE con prefisso 'user::' per widget nel modulo User
protected static string $view = 'user::widgets.auth.reset-password-widget';
// File Blade corrispondente:
// Modules/User/resources/views/widgets/auth/reset-password-widget.blade.php
#### **4. Proprietà Obbligatorie per Widget Auth**
/**
 * Widget data array (CRITICAL: eredita da XotBaseWidget, NON ridichiarare!)
 * @var array<string, mixed>|null
 */
// NON dichiarare: public ?array $data = []; <- GIÀ in XotBaseWidget
 * Form schema with string keys (Filament requirement)
 * @return array<string, \Filament\Forms\Components\Component>
public function getFormSchema(): array
    return [
        'email' => TextInput::make('email')->email()->required(),
        'password' => TextInput::make('password')->password()->required(),
        // SEMPRE chiavi stringa, mai numeriche
    ];
#### **5. Pattern Sicurezza per Widget Auth**
 * Handle authentication action with proper error handling
 * @return \Illuminate\Http\RedirectResponse|void
public function resetPassword()
    $data = $this->form->getState();

    // SEMPRE validazione rigorosa
    $status = Password::reset([
        'email' => (string) $data['email'],           // Cast espliciti
        'password' => (string) $data['password'],     // per sicurezza
        'token' => (string) request()->route('token'),
    ], function ($user, $password): void {           // Tipo ritorno esplicito
        $user->forceFill([
            'password' => Hash::make($password),
            'remember_token' => Str::random(60),
        ])->save();
    });
    // Gestione response sicura
    if ($status === Password::PASSWORD_RESET) {
        session()->flash('status', __((string) $status));
        return redirect()->route('login');
    $this->addError('email', __((string) $status));
#### **6. PHPDoc Rigorosi (Conformità PHPStan)**
 * Reset password widget for user authentication.
 *
 * Handles password reset functionality with token validation,
 * proper security measures, and user feedback.
 * @property ComponentContainer $form Form container from XotBaseWidget
    /**
     * The view for this widget.
     * @var view-string
     */
    protected static string $view = 'user::widgets.auth.reset-password-widget';
     * Mount the widget and initialize the form.
     * @return void
    public function mount(): void
### **Checklist Widget Auth Quality**
- [ ] Estende `XotBaseWidget` (mai direttamente Widget Filament)
- [ ] Directory `Auth/` per organizzazione logica
- [ ] View path con namespace `user::widgets.auth.*`
- [ ] NON ridichiarare proprietà `$data` di XotBaseWidget
- [ ] `getFormSchema()` con chiavi stringa associative
- [ ] PHPDoc completi con tipo `@var view-string` per `$view`
- [ ] Metodi tipizzati con `@return` espliciti
- [ ] Cast espliciti `(string)` per dati critici
- [ ] Gestione errori e security con Laravel best practices
- [ ] Traduzioni struttura espansa (mai `->label()` hardcoded)
### **Differenze vs RegistrationWidget**
- **RegistrationWidget**: Generico, delega azioni esterne
- **Widget Auth**: Specifici, logica autenticazione interna sicura
- **Entrambi**: Stesso pattern XotBaseWidget + form schema + view convention
## Collegamenti aggiornati
