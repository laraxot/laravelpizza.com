# Enums del Progetto

## Enums per le Visite

### VisitType
```php
enum VisitType: string
{
    case FIRST = 'first';
    case FOLLOWUP = 'followup';
    case EMERGENCY = 'emergency';
    case SPECIALIST = 'specialist';
    case ORTHODONTIC = 'orthodontic';
    case SURGERY = 'surgery';

    public function getLabel(): string
    {
        return match($this) {
            self::FIRST => 'Prima Visita',
            self::FOLLOWUP => 'Controllo',
            self::EMERGENCY => 'Emergenza',
            self::SPECIALIST => 'Visita Specialistica',
            self::ORTHODONTIC => 'Ortodontica',
            self::SURGERY => 'Intervento Chirurgico',
        };
    }

    public function getColor(): string
    {
        return match($this) {
            self::FIRST => 'primary',
            self::FOLLOWUP => 'success',
            self::EMERGENCY => 'danger',
            self::SPECIALIST => 'info',
            self::ORTHODONTIC => 'warning',
            self::SURGERY => 'gray',
        };
    }

    public function getIcon(): string
    {
        return match($this) {
            self::FIRST => 'heroicon-o-user-plus',
            self::FOLLOWUP => 'heroicon-o-clipboard-document-check',
            self::EMERGENCY => 'heroicon-o-exclamation-triangle',
            self::SPECIALIST => 'heroicon-o-user-group',
            self::ORTHODONTIC => 'heroicon-o-tooth',
            self::SURGERY => 'heroicon-o-scissors',
        };
    }
}
```

### VisitStatus
```php
enum VisitStatus: string
{
    case SCHEDULED = 'scheduled';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case NO_SHOW = 'no_show';

    public function getLabel(): string
    {
        return match($this) {
            self::SCHEDULED => 'Programmata',
            self::IN_PROGRESS => 'In Corso',
            self::COMPLETED => 'Completata',
            self::CANCELLED => 'Cancellata',
            self::NO_SHOW => 'Non Presentata',
        };
    }

    public function getColor(): string
    {
        return match($this) {
            self::SCHEDULED => 'info',
            self::IN_PROGRESS => 'warning',
            self::COMPLETED => 'success',
            self::CANCELLED => 'danger',
            self::NO_SHOW => 'gray',
        };
    }
}
```

## Enums per i Denti

### ToothPosition
```php
enum ToothPosition: string
{
    case UPPER_RIGHT = 'UR';
    case UPPER_LEFT = 'UL';
    case LOWER_RIGHT = 'LR';
    case LOWER_LEFT = 'LL';

    public function getLabel(): string
    {
        return match($this) {
            self::UPPER_RIGHT => 'Superiore Destro',
            self::UPPER_LEFT => 'Superiore Sinistro',
            self::LOWER_RIGHT => 'Inferiore Destro',
            self::LOWER_LEFT => 'Inferiore Sinistro',
        };
    }
}
```

### ToothStatus
```php
enum ToothStatus: string
{
    case HEALTHY = 'healthy';
    case CARIOUS = 'carious';
    case MISSING = 'missing';
    case RESTORED = 'restored';
    case ROOT_CANAL = 'root_canal';
    case CROWN = 'crown';
    case BRIDGE = 'bridge';
    case IMPLANT = 'implant';

    public function getLabel(): string
    {
        return match($this) {
            self::HEALTHY => 'Sano',
            self::CARIOUS => 'Cariato',
            self::MISSING => 'Mancante',
            self::RESTORED => 'Ricostruito',
            self::ROOT_CANAL => 'Devitalizzato',
            self::CROWN => 'Corona',
            self::BRIDGE => 'Ponte',
            self::IMPLANT => 'Impianto',
        };
    }

    public function getColor(): string
    {
        return match($this) {
            self::HEALTHY => 'success',
            self::CARIOUS => 'danger',
            self::MISSING => 'gray',
            self::RESTORED => 'warning',
            self::ROOT_CANAL => 'info',
            self::CROWN => 'primary',
            self::BRIDGE => 'secondary',
            self::IMPLANT => 'success',
        };
    }
}
```

## Enums per i Documenti

### DocumentType
```php
enum DocumentType: string
{
    case ID_CARD = 'id_card';
    case FISCAL_CODE = 'fiscal_code';
    case ISEE = 'isee';
    case MEDICAL_HISTORY = 'medical_history';
    case CONSENT = 'consent';
    case X_RAY = 'x_ray';
    case PRESCRIPTION = 'prescription';
    case REPORT = 'report';

    public function getLabel(): string
    {
        return match($this) {
            self::ID_CARD => 'Carta d\'Identità',
            self::FISCAL_CODE => 'Codice Fiscale',
            self::ISEE => 'ISEE',
            self::MEDICAL_HISTORY => 'Storico Medico',
            self::CONSENT => 'Consenso',
            self::X_RAY => 'Radiografia',
            self::PRESCRIPTION => 'Prescrizione',
            self::REPORT => 'Referto',
        };
    }

    public function getIcon(): string
    {
        return match($this) {
            self::ID_CARD => 'heroicon-o-identification',
            self::FISCAL_CODE => 'heroicon-o-document-text',
            self::ISEE => 'heroicon-o-currency-euro',
            self::MEDICAL_HISTORY => 'heroicon-o-clipboard-document-list',
            self::CONSENT => 'heroicon-o-clipboard-document-check',
            self::X_RAY => 'heroicon-o-photo',
            self::PRESCRIPTION => 'heroicon-o-document',
            self::REPORT => 'heroicon-o-document-check',
        };
    }
}
```

### DocumentStatus
```php
enum DocumentStatus: string
{
    case PENDING = 'pending';
    case VALID = 'valid';
    case EXPIRED = 'expired';
    case REJECTED = 'rejected';

    public function getLabel(): string
    {
        return match($this) {
            self::PENDING => 'In Attesa',
            self::VALID => 'Valido',
            self::EXPIRED => 'Scaduto',
            self::REJECTED => 'Rifiutato',
        };
    }

    public function getColor(): string
    {
        return match($this) {
            self::PENDING => 'warning',
            self::VALID => 'success',
            self::EXPIRED => 'danger',
            self::REJECTED => 'gray',
        };
    }
}
```

## Enums per le Notifiche

### NotificationType
```php
enum NotificationType: string
{
    case VISIT_REMINDER = 'visit_reminder';
    case DOCUMENT_EXPIRY = 'document_expiry';
    case TREATMENT_UPDATE = 'treatment_update';
    case EMERGENCY = 'emergency';
    case SYSTEM = 'system';

    public function getLabel(): string
    {
        return match($this) {
            self::VISIT_REMINDER => 'Promemoria Visita',
            self::DOCUMENT_EXPIRY => 'Scadenza Documento',
            self::TREATMENT_UPDATE => 'Aggiornamento Trattamento',
            self::EMERGENCY => 'Emergenza',
            self::SYSTEM => 'Sistema',
        };
    }

    public function getIcon(): string
    {
        return match($this) {
            self::VISIT_REMINDER => 'heroicon-o-calendar',
            self::DOCUMENT_EXPIRY => 'heroicon-o-document-exclamation',
            self::TREATMENT_UPDATE => 'heroicon-o-clipboard-document-check',
            self::EMERGENCY => 'heroicon-o-exclamation-triangle',
            self::SYSTEM => 'heroicon-o-cog',
        };
    }

    public function getColor(): string
    {
        return match($this) {
            self::VISIT_REMINDER => 'info',
            self::DOCUMENT_EXPIRY => 'warning',
            self::TREATMENT_UPDATE => 'success',
            self::EMERGENCY => 'danger',
            self::SYSTEM => 'gray',
        };
    }
}
```

## Utilizzo negli Enum

### Esempio di Utilizzo in Filament
```php
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;

// In un form
Select::make('visit_type')
    ->options(collect(VisitType::cases())->mapWithKeys(fn ($case) => [$case->value => $case->getLabel()]))
    ->required(),

// In una tabella
TextColumn::make('visit_type')
    ->badge()
    ->color(fn (VisitType $state): string => $state->getColor())
    ->formatStateUsing(fn (VisitType $state): string => $state->getLabel()),
```

### Esempio di Utilizzo nelle Policy
```php
public function canViewVisit(User $user, Visit $visit): bool
{
    return match($visit->status) {
        VisitStatus::COMPLETED => $user->can('view completed visits'),
        VisitStatus::IN_PROGRESS => $user->can('view in progress visits'),
        VisitStatus::SCHEDULED => $user->can('view scheduled visits'),
        default => false,
    };
}
```

### Esempio di Utilizzo nei Service
```php
public function scheduleVisitReminder(Visit $visit): void
{
    if ($visit->status === VisitStatus::SCHEDULED) {
        Notification::create([
            'type' => NotificationType::VISIT_REMINDER,
            'title' => 'Promemoria Visita',
            'message' => "Hai una visita programmata per {$visit->visit_date->format('d/m/Y H:i')}",
            'user_id' => $visit->patient_id,
        ]);
    }
}
``` 