# 💡 **Esempi Pratici Modulo Lang - Laraxot**

## 🎯 **Panoramica**

Questo documento fornisce esempi pratici e casi d'uso reali per il modulo Lang, seguendo i principi **DRY**, **KISS**, **SOLID**, **Robust** e **Laraxot**. Ogni esempio è testato e validato.

---

## 🏗️ **Struttura File Traduzioni**

### **1. File Base - fields.php**

#### **Struttura Completa**
```php
<?php

declare(strict_types=1);

/**
 * Traduzioni per i campi del modulo User.
 *
 * @return array<string, array<string, string>>
 */
return [
    'name' => [
        'label' => 'Nome',
        'placeholder' => 'Inserisci il nome completo',
        'help' => 'Il nome verrà utilizzato per identificare l\'utente nel sistema',
        'validation' => [
            'required' => 'Il nome è obbligatorio',
            'string' => 'Il nome deve essere una stringa',
            'min' => 'Il nome deve essere di almeno :min caratteri',
            'max' => 'Il nome non può superare :max caratteri'
        ]
    ],
    
    'email' => [
        'label' => 'Indirizzo Email',
        'placeholder' => 'esempio@dominio.com',
        'help' => 'L\'email verrà utilizzata per l\'accesso al sistema',
        'validation' => [
            'required' => 'L\'email è obbligatoria',
            'email' => 'L\'email deve essere valida',
            'unique' => 'Questa email è già in uso',
            'max' => 'L\'email non può superare :max caratteri'
        ]
    ],
    
    'role' => [
        'label' => 'Ruolo',
        'placeholder' => 'Seleziona un ruolo',
        'help' => 'Il ruolo determina i permessi dell\'utente nel sistema',
        'options' => [
            'admin' => 'Amministratore',
            'manager' => 'Manager',
            'user' => 'Utente',
            'guest' => 'Ospite'
        ],
        'validation' => [
            'required' => 'Il ruolo è obbligatorio',
            'in' => 'Il ruolo selezionato non è valido'
        ]
    ],
    
    'password' => [
        'label' => 'Password',
        'placeholder' => 'Inserisci la password',
        'help' => 'La password deve contenere almeno 8 caratteri',
        'validation' => [
            'required' => 'La password è obbligatoria',
            'min' => 'La password deve essere di almeno :min caratteri',
            'confirmed' => 'La conferma password non corrisponde'
        ]
    ],
    
    'password_confirmation' => [
        'label' => 'Conferma Password',
        'placeholder' => 'Conferma la password inserita',
        'help' => 'Ripeti la password per confermare'
    ]
];
```

#### **Struttura Semplificata per Campi Semplici**
```php
<?php

declare(strict_types=1);

/**
 * Traduzioni per campi semplici.
 *
 * @return array<string, array<string, string>>
 */
return [
    'id' => [
        'label' => 'ID',
        'help' => 'Identificativo univoco'
    ],
    
    'created_at' => [
        'label' => 'Data Creazione',
        'help' => 'Data e ora di creazione del record'
    ],
    
    'updated_at' => [
        'label' => 'Data Aggiornamento',
        'help' => 'Data e ora dell\'ultimo aggiornamento'
    ]
];
```

---

### **2. File Azioni - actions.php**

#### **Azioni CRUD Standard**
```php
<?php

declare(strict_types=1);

/**
 * Traduzioni per le azioni del modulo User.
 *
 * @return array<string, array<string, string>>
 */
return [
    'create' => [
        'label' => 'Nuovo Utente',
        'icon' => 'heroicon-o-plus',
        'color' => 'primary',
        'tooltip' => 'Crea un nuovo utente nel sistema',
        'modal' => [
            'heading' => 'Crea Nuovo Utente',
            'description' => 'Inserisci i dati per creare un nuovo utente',
            'confirm' => 'Crea Utente',
            'cancel' => 'Annulla'
        ],
        'messages' => [
            'success' => 'Utente creato con successo',
            'error' => 'Si è verificato un errore durante la creazione dell\'utente'
        ]
    ],
    
    'edit' => [
        'label' => 'Modifica',
        'icon' => 'heroicon-o-pencil',
        'color' => 'warning',
        'tooltip' => 'Modifica i dati dell\'utente selezionato',
        'modal' => [
            'heading' => 'Modifica Utente',
            'description' => 'Modifica i dati dell\'utente selezionato',
            'confirm' => 'Salva Modifiche',
            'cancel' => 'Annulla'
        ],
        'messages' => [
            'success' => 'Utente modificato con successo',
            'error' => 'Si è verificato un errore durante la modifica dell\'utente'
        ]
    ],
    
    'delete' => [
        'label' => 'Elimina',
        'icon' => 'heroicon-o-trash',
        'color' => 'danger',
        'tooltip' => 'Elimina l\'utente selezionato',
        'modal' => [
            'heading' => 'Elimina Utente',
            'description' => 'Sei sicuro di voler eliminare questo utente? Questa azione è irreversibile.',
            'confirm' => 'Elimina Utente',
            'cancel' => 'Annulla'
        ],
        'messages' => [
            'success' => 'Utente eliminato con successo',
            'error' => 'Si è verificato un errore durante l\'eliminazione dell\'utente'
        ]
    ],
    
    'view' => [
        'label' => 'Visualizza',
        'icon' => 'heroicon-o-eye',
        'color' => 'info',
        'tooltip' => 'Visualizza i dettagli dell\'utente',
        'modal' => [
            'heading' => 'Dettagli Utente',
            'description' => 'Visualizza le informazioni complete dell\'utente'
        ]
    ]
];
```

#### **Azioni Personalizzate**
```php
<?php

declare(strict_types=1);

/**
 * Azioni personalizzate per il modulo User.
 *
 * @return array<string, array<string, string>>
 */
return [
    'approve' => [
        'label' => 'Approva Utente',
        'icon' => 'heroicon-o-check-circle',
        'color' => 'success',
        'tooltip' => 'Approva l\'utente per l\'accesso al sistema',
        'modal' => [
            'heading' => 'Approva Utente',
            'description' => 'Stai per approvare questo utente. Confermi?',
            'confirm' => 'Approva',
            'cancel' => 'Annulla'
        ],
        'messages' => [
            'success' => 'Utente approvato con successo',
            'error' => 'Si è verificato un errore durante l\'approvazione'
        ]
    ],
    
    'suspend' => [
        'label' => 'Sospendi Utente',
        'icon' => 'heroicon-o-pause-circle',
        'color' => 'warning',
        'tooltip' => 'Sospendi temporaneamente l\'utente',
        'modal' => [
            'heading' => 'Sospendi Utente',
            'description' => 'Stai per sospendere questo utente. Inserisci il motivo:',
            'confirm' => 'Sospendi',
            'cancel' => 'Annulla'
        ],
        'fields' => [
            'reason' => [
                'label' => 'Motivo Sospensione',
                'placeholder' => 'Inserisci il motivo della sospensione',
                'help' => 'Questo motivo verrà comunicato all\'utente'
            ],
            'duration' => [
                'label' => 'Durata Sospensione',
                'placeholder' => 'Seleziona la durata',
                'help' => 'Periodo di sospensione',
                'options' => [
                    '1_day' => '1 giorno',
                    '1_week' => '1 settimana',
                    '1_month' => '1 mese',
                    'permanent' => 'Permanente'
                ]
            ]
        ],
        'messages' => [
            'success' => 'Utente sospeso con successo',
            'error' => 'Si è verificato un errore durante la sospensione'
        ]
    ],
    
    'export' => [
        'label' => 'Esporta Utenti',
        'icon' => 'heroicon-o-document-download',
        'color' => 'info',
        'tooltip' => 'Esporta la lista degli utenti in formato CSV',
        'modal' => [
            'heading' => 'Esporta Utenti',
            'description' => 'Seleziona le opzioni di esportazione:',
            'confirm' => 'Esporta',
            'cancel' => 'Annulla'
        ],
        'fields' => [
            'format' => [
                'label' => 'Formato Esportazione',
                'options' => [
                    'csv' => 'CSV',
                    'xlsx' => 'Excel',
                    'pdf' => 'PDF'
                ]
            ],
            'filters' => [
                'label' => 'Filtri Applicati',
                'help' => 'I filtri attualmente applicati verranno inclusi nell\'esportazione'
            ]
        ],
        'messages' => [
            'success' => 'Esportazione completata con successo',
            'error' => 'Si è verificato un errore durante l\'esportazione'
        ]
    ]
];
```

---

### **3. File Messaggi - messages.php**

#### **Messaggi Generali**
```php
<?php

declare(strict_types=1);

/**
 * Messaggi generali del modulo User.
 *
 * @return array<string, string|array<string, string>>
 */
return [
    'welcome' => 'Benvenuto nel sistema di gestione utenti',
    
    'errors' => [
        'general' => 'Si è verificato un errore. Riprova più tardi.',
        'not_found' => 'L\'utente richiesto non è stato trovato.',
        'unauthorized' => 'Non sei autorizzato ad accedere a questa risorsa.',
        'validation' => 'Si sono verificati errori di validazione.',
        'database' => 'Errore di connessione al database.',
        'permission' => 'Non hai i permessi necessari per eseguire questa azione.'
    ],
    
    'notifications' => [
        'success' => 'Operazione completata con successo',
        'info' => 'Informazione importante',
        'warning' => 'Attenzione',
        'error' => 'Errore'
    ],
    
    'confirmations' => [
        'delete' => 'Sei sicuro di voler eliminare questo elemento?',
        'cancel' => 'Sei sicuro di voler annullare? Le modifiche non salvate andranno perse.',
        'discard' => 'Le modifiche non salvate andranno perse. Continuare?',
        'logout' => 'Sei sicuro di voler uscire dal sistema?'
    ],
    
    'empty_states' => [
        'default' => 'Nessun elemento trovato',
        'users' => 'Nessun utente trovato',
        'search' => 'Nessun risultato trovato per la ricerca',
        'filtered' => 'Nessun elemento corrisponde ai filtri applicati',
        'no_permissions' => 'Non hai i permessi per visualizzare questi elementi'
    ],
    
    'counts' => [
        'users' => '{0} Nessun utente|{1} Un utente|[2,*] :count utenti',
        'active_users' => '{0} Nessun utente attivo|{1} Un utente attivo|[2,*] :count utenti attivi',
        'inactive_users' => '{0} Nessun utente inattivo|{1} Un utente inattivo|[2,*] :count utenti inattivi'
    ]
];
```

---

### **4. File Validazione - validation.php**

#### **Messaggi di Validazione**
```php
<?php

declare(strict_types=1);

/**
 * Messaggi di validazione per il modulo User.
 *
 * @return array<string, array<string, string>>
 */
return [
    'attributes' => [
        'name' => 'nome',
        'email' => 'email',
        'password' => 'password',
        'password_confirmation' => 'conferma password',
        'role' => 'ruolo',
        'status' => 'stato'
    ],
    
    'custom' => [
        'email' => [
            'unique' => 'Questa email è già registrata nel sistema.',
            'regex' => 'L\'email deve essere in un formato valido.'
        ],
        'password' => [
            'strong' => 'La password deve contenere almeno una lettera maiuscola, una minuscola, un numero e un carattere speciale.'
        ],
        'role' => [
            'valid_role' => 'Il ruolo selezionato non è valido per il tuo account.'
        ]
    ],
    
    'values' => [
        'accepted' => 'deve essere accettato',
        'accepted_if' => 'deve essere accettato quando :other è :value',
        'active_url' => 'non è un URL valido',
        'after' => 'deve essere una data successiva al :date',
        'after_or_equal' => 'deve essere una data successiva o uguale al :date',
        'alpha' => 'può contenere solo lettere',
        'alpha_dash' => 'può contenere solo lettere, numeri, trattini e underscore',
        'alpha_num' => 'può contenere solo lettere e numeri',
        'array' => 'deve essere un array',
        'before' => 'deve essere una data precedente al :date',
        'before_or_equal' => 'deve essere una data precedente o uguale al :date',
        'between' => [
            'numeric' => 'deve essere compreso tra :min e :max',
            'file' => 'deve essere compreso tra :min e :max kilobyte',
            'string' => 'deve essere compreso tra :min e :max caratteri',
            'array' => 'deve avere tra :min e :max elementi'
        ],
        'boolean' => 'deve essere vero o falso',
        'confirmed' => 'la conferma non corrisponde',
        'current_password' => 'la password non è corretta',
        'date' => 'non è una data valida',
        'date_equals' => 'deve essere una data uguale a :date',
        'date_format' => 'non corrisponde al formato :format',
        'declined' => 'deve essere rifiutato',
        'declined_if' => 'deve essere rifiutato quando :other è :value',
        'different' => ':attribute e :other devono essere diversi',
        'digits' => 'deve essere di :digits cifre',
        'digits_between' => 'deve essere tra :min e :max cifre',
        'dimensions' => 'le dimensioni dell\'immagine non sono valide',
        'distinct' => 'ha un valore duplicato',
        'doesnt_end_with' => 'non può terminare con uno dei seguenti: :values',
        'doesnt_start_with' => 'non può iniziare con uno dei seguenti: :values',
        'email' => 'deve essere un indirizzo email valido',
        'ends_with' => 'deve terminare con uno dei seguenti: :values',
        'enum' => 'il valore selezionato non è valido',
        'exists' => 'il valore selezionato non è valido',
        'extensions' => 'deve avere una delle seguenti estensioni: :values',
        'file' => 'deve essere un file',
        'filled' => 'deve avere un valore',
        'gt' => [
            'numeric' => 'deve essere maggiore di :value',
            'file' => 'deve essere maggiore di :value kilobyte',
            'string' => 'deve essere maggiore di :value caratteri',
            'array' => 'deve avere più di :value elementi'
        ],
        'gte' => [
            'numeric' => 'deve essere maggiore o uguale a :value',
            'file' => 'deve essere maggiore o uguale a :value kilobyte',
            'string' => 'deve essere maggiore o uguale a :value caratteri',
            'array' => 'deve avere :value o più elementi'
        ],
        'image' => 'deve essere un\'immagine',
        'in' => 'il valore selezionato non è valido',
        'in_array' => 'non esiste in :other',
        'integer' => 'deve essere un numero intero',
        'ip' => 'deve essere un indirizzo IP valido',
        'ipv4' => 'deve essere un indirizzo IPv4 valido',
        'ipv6' => 'deve essere un indirizzo IPv6 valido',
        'json' => 'deve essere una stringa JSON valida',
        'lowercase' => 'deve essere minuscolo',
        'lt' => [
            'numeric' => 'deve essere minore di :value',
            'file' => 'deve essere minore di :value kilobyte',
            'string' => 'deve essere minore di :value caratteri',
            'array' => 'deve avere meno di :value elementi'
        ],
        'lte' => [
            'numeric' => 'deve essere minore o uguale a :value',
            'file' => 'deve essere minore o uguale a :value kilobyte',
            'string' => 'deve essere minore o uguale a :value caratteri',
            'array' => 'non deve avere più di :value elementi'
        ],
        'mac_address' => 'deve essere un indirizzo MAC valido',
        'max' => [
            'numeric' => 'non può essere maggiore di :max',
            'file' => 'non può essere maggiore di :max kilobyte',
            'string' => 'non può essere maggiore di :max caratteri',
            'array' => 'non può avere più di :max elementi'
        ],
        'max_digits' => 'non può avere più di :max cifre',
        'mimes' => 'deve essere un file di tipo: :values',
        'mimetypes' => 'deve essere un file di tipo: :values',
        'min' => [
            'numeric' => 'deve essere almeno :min',
            'file' => 'deve essere almeno :min kilobyte',
            'string' => 'deve essere almeno :min caratteri',
            'array' => 'deve avere almeno :min elementi'
        ],
        'min_digits' => 'deve avere almeno :min cifre',
        'missing' => 'deve essere mancante',
        'missing_if' => 'deve essere mancante quando :other è :value',
        'missing_unless' => 'deve essere mancante a meno che :other non sia :value',
        'missing_with' => 'deve essere mancante quando :values è presente',
        'missing_with_all' => 'deve essere mancante quando :values sono presenti',
        'multiple_of' => 'deve essere un multiplo di :value',
        'not_in' => 'il valore selezionato non è valido',
        'not_regex' => 'il formato non è valido',
        'numeric' => 'deve essere un numero',
        'password' => [
            'letters' => 'deve contenere almeno una lettera',
            'mixed' => 'deve contenere almeno una lettera maiuscola e una minuscola',
            'numbers' => 'deve contenere almeno un numero',
            'symbols' => 'deve contenere almeno un simbolo',
            'uncompromised' => 'il valore :attribute è apparso in una perdita di dati. Cambia :attribute.'
        ],
        'present' => 'deve essere presente',
        'present_if' => 'deve essere presente quando :other è :value',
        'present_unless' => 'deve essere presente a meno che :other non sia :value',
        'present_with' => 'deve essere presente quando :values è presente',
        'present_with_all' => 'deve essere presente quando :values sono presenti',
        'prohibited' => 'è proibito',
        'prohibited_if' => 'è proibito quando :other è :value',
        'prohibited_unless' => 'è proibito a meno che :other non sia in :values',
        'prohibits' => 'proibisce :other di essere presente',
        'regex' => 'il formato non è valido',
        'required' => 'è obbligatorio',
        'required_array_keys' => 'deve contenere voci per: :values',
        'required_if' => 'è obbligatorio quando :other è :value',
        'required_if_accepted' => 'è obbligatorio quando :other è accettato',
        'required_unless' => 'è obbligatorio a meno che :other non sia in :values',
        'required_with' => 'è obbligatorio quando :values è presente',
        'required_with_all' => 'è obbligatorio quando :values sono presenti',
        'required_without' => 'è obbligatorio quando :values non è presente',
        'required_without_all' => 'è obbligatorio quando nessuno di :values è presente',
        'same' => ':attribute e :other devono corrispondere',
        'size' => [
            'numeric' => 'deve essere :size',
            'file' => 'deve essere :size kilobyte',
            'string' => 'deve essere :size caratteri',
            'array' => 'deve contenere :size elementi'
        ],
        'starts_with' => 'deve iniziare con uno dei seguenti: :values',
        'string' => 'deve essere una stringa',
        'timezone' => 'deve essere un fuso orario valido',
        'unique' => 'è già stato preso',
        'uploaded' => 'il caricamento è fallito',
        'uppercase' => 'deve essere maiuscolo',
        'url' => 'il formato non è valido',
        'ulid' => 'deve essere un ULID valido',
        'uuid' => 'deve essere un UUID valido'
    ]
];
```

---

## 🎨 **Integrazione Filament**

### **1. Resource Base**

#### **UserResource.php**
```php
<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Modules\Xot\Filament\Resources\XotBaseResource;

class UserResource extends XotBaseResource
{
    protected static ?string $model = \Modules\User\Models\User::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-users';
    
    protected static ?string $navigationGroup = 'Gestione Utenti';
    
    protected static ?int $navigationSort = 1;
    
    /**
     * @return array<int, \Filament\Forms\Components\Component>
     */
    public static function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make()
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                        
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),
                        
                    Forms\Components\Select::make('role')
                        ->options([
                            'admin' => __('fields.role.options.admin'),
                            'manager' => __('fields.role.options.manager'),
                            'user' => __('fields.role.options.user'),
                            'guest' => __('fields.role.options.guest')
                        ])
                        ->required(),
                        
                    Forms\Components\TextInput::make('password')
                        ->password()
                        ->required(fn (string $context): bool => $context === 'create')
                        ->minLength(8)
                        ->confirmed(),
                        
                    Forms\Components\TextInput::make('password_confirmation')
                        ->password()
                        ->required(fn (string $context): bool => $context === 'create')
                ])
        ];
    }
    
    /**
     * @return array<int, \Filament\Tables\Columns\Column>
     */
    public static function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable(),
                
            Tables\Columns\TextColumn::make('email')
                ->searchable()
                ->sortable(),
                
            Tables\Columns\TextColumn::make('role')
                ->formatStateUsing(fn (string $state): string => __("fields.role.options.{$state}"))
                ->sortable(),
                
            Tables\Columns\IconColumn::make('email_verified_at')
                ->boolean()
                ->sortable(),
                
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }
    
    /**
     * @return array<string, \Filament\Tables\Actions\Action>
     */
    public static function getTableActions(): array
    {
        return [
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ];
    }
    
    /**
     * @return array<string, \Filament\Tables\Actions\BulkAction>
     */
    public static function getTableBulkActions(): array
    {
        return [
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ];
    }
}
```

### **2. Actions Personalizzate**

#### **ApproveUserAction.php**
```php
<?php

declare(strict_types=1);

namespace Modules\User\Filament\Actions;

use Filament\Actions\Action;
use Filament\Support\Colors\Color;

class ApproveUserAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->label(__('actions.approve.label'))
            ->icon(__('actions.approve.icon'))
            ->color(Color::from(__('actions.approve.color')))
            ->requiresConfirmation()
            ->modalHeading(__('actions.approve.modal.heading'))
            ->modalDescription(__('actions.approve.modal.description'))
            ->modalSubmitActionLabel(__('actions.approve.modal.confirm'))
            ->modalCancelActionLabel(__('actions.approve.modal.cancel'))
            ->action(function ($record): void {
                $record->update(['status' => 'approved']);
                
                // Notifica successo
                $this->successNotificationTitle(__('actions.approve.messages.success'));
            });
    }
}
```

---

## 🔧 **Utilizzo nei Controller**

### **1. Controller Base**

#### **UserController.php**
```php
<?php

declare(strict_types=1);

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\User\Models\User;
use Modules\User\Services\UserService;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService
    ) {}
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $users = $this->userService->getPaginatedUsers($request);
        
        return response()->json([
            'success' => true,
            'data' => $users,
            'message' => __('messages.success.retrieved', ['resource' => __('messages.counts.users', ['count' => $users->count()])])
        ]);
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,manager,user,guest'
        ]);
        
        $user = $this->userService->createUser($validated);
        
        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => __('messages.success.created', ['resource' => __('fields.name.label')])
        ], 201);
    }
    
    /**
     * Display the specified resource.
     */
    public function show(User $user): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => __('messages.success.retrieved', ['resource' => __('fields.name.label')])
        ]);
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'role' => 'sometimes|in:admin,manager,user,guest'
        ]);
        
        $user = $this->userService->updateUser($user, $validated);
        
        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => __('messages.success.updated', ['resource' => __('fields.name.label')])
        ]);
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): JsonResponse
    {
        $this->userService->deleteUser($user);
        
        return response()->json([
            'success' => true,
            'message' => __('messages.success.deleted', ['resource' => __('fields.name.label')])
        ]);
    }
}
```

---

## 🧪 **Testing**

### **1. Test Unitari**

#### **UserTranslationTest.php**
```php
<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTranslationTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function it_loads_user_field_translations(): void
    {
        $this->app->setLocale('it');
        
        $this->assertEquals('Nome', __('fields.name.label'));
        $this->assertEquals('Inserisci il nome completo', __('fields.name.placeholder'));
        $this->assertEquals('Il nome verrà utilizzato per identificare l\'utente nel sistema', __('fields.name.help'));
    }
    
    /** @test */
    public function it_loads_user_action_translations(): void
    {
        $this->app->setLocale('it');
        
        $this->assertEquals('Nuovo Utente', __('actions.create.label'));
        $this->assertEquals('Crea Nuovo Utente', __('actions.create.modal.heading'));
        $this->assertEquals('Utente creato con successo', __('actions.create.messages.success'));
    }
    
    /** @test */
    public function it_loads_user_validation_translations(): void
    {
        $this->app->setLocale('it');
        
        $this->assertEquals('Il nome è obbligatorio', __('validation.custom.name.required'));
        $this->assertEquals('L\'email deve essere valida', __('validation.custom.email.email'));
    }
    
    /** @test */
    public function it_handles_pluralization_correctly(): void
    {
        $this->app->setLocale('it');
        
        $this->assertEquals('Nessun utente', trans_choice('messages.counts.users', 0));
        $this->assertEquals('Un utente', trans_choice('messages.counts.users', 1));
        $this->assertEquals('5 utenti', trans_choice('messages.counts.users', 5, ['count' => 5]));
    }
}
```

### **2. Test Feature**

#### **UserResourceTest.php**
```php
<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature;

use Tests\TestCase;
use Modules\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserResourceTest extends TestCase
{
    use RefreshDatabase;
    
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->actingAs(User::factory()->create(['role' => 'admin']));
    }
    
    /** @test */
    public function it_displays_user_list_with_correct_translations(): void
    {
        $response = $this->get('/admin/users');
        
        $response->assertStatus(200);
        $response->assertSee(__('actions.create.label'));
        $response->assertSee(__('fields.name.label'));
        $response->assertSee(__('fields.email.label'));
    }
    
    /** @test */
    public function it_creates_user_with_correct_validation_messages(): void
    {
        $response = $this->post('/admin/users', []);
        
        $response->assertSessionHasErrors([
            'name' => __('validation.custom.name.required'),
            'email' => __('validation.custom.email.required'),
            'password' => __('validation.custom.password.required')
        ]);
    }
}
```

---

## 🔗 **Riferimenti e Collegamenti**

### **1. Documentazione**
- [README.md](README.md) - Documentazione principale
- [BEST_PRACTICES.md](BEST_PRACTICES.md) - Best practices
- [API_REFERENCE.md](API_REFERENCE.md) - Riferimento API
- [TROUBLESHOOTING.md](TROUBLESHOOTING.md) - Troubleshooting

### **2. Configurazione**
- [config/lang.php](../config/lang.php) - Configurazione centralizzata

---

**Ultimo aggiornamento**: Gennaio 2025  
**Versione**: 2.0.0  
**Autore**: Team Laraxot  
**Mantenuto da**: Community Laraxot
