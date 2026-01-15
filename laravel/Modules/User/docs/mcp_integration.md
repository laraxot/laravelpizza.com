# Integrazione dei Server MCP con il Modulo User

## Panoramica

Questo documento fornisce linee guida per l'integrazione dei server MCP (Model Context Protocol) con il modulo User, seguendo le regole di sviluppo e le convenzioni di codice stabilite per i progetti base_predict_fila3_mono.

## Server MCP Consigliati

Per il modulo User, si consigliano i seguenti server MCP:

### 1. Memory

**Scopo**: Memorizzazione delle preferenze degli utenti, sessioni e dati temporanei.

**Casi d'uso**:
- Memorizzazione delle preferenze dell'interfaccia utente
- Gestione delle sessioni utente
- Memorizzazione di dati temporanei dell'utente
- Caching delle informazioni del profilo

**Esempio di implementazione**:
```php
<?php

declare(strict_types=1);

namespace Modules\User\Actions;

use Modules\Xot\Contracts\UserContract;
use Modules\AI\Services\Contracts\MCPServiceContract;

class StoreUserPreferencesAction
{
    /**
     * @param MCPServiceContract $mcpService
     */
    public function __construct(
        private readonly MCPServiceContract $mcpService
    ) {
    }

    /**
     * Memorizza le preferenze dell'utente.
     *
     * @param UserContract $user L'utente
     * @param array<string, mixed> $preferences Le preferenze dell'utente
     *
     * @return bool True se l'operazione è riuscita, false altrimenti
     */
    public function execute(UserContract $user, array $preferences): bool
    {
        return $this->mcpService->memory()->store(
            "user_preferences_{$user->id}",
            $preferences
        );
    }
}
```

### 2. Fetch

**Scopo**: Interazione con API esterne per la verifica e l'arricchimento dei dati utente.

**Casi d'uso**:
- Verifica degli indirizzi email
- Integrazione con servizi di autenticazione esterni
- Recupero di informazioni aggiuntive dell'utente da API esterne
- Verifica degli indirizzi postali

**Esempio di implementazione**:
```php
<?php

declare(strict_types=1);

namespace Modules\User\Actions;

use Modules\Xot\Contracts\UserContract;
use Modules\AI\Services\Contracts\MCPServiceContract;
use Illuminate\Support\Facades\Log;

class VerifyUserEmailAction
{
    /**
     * @param MCPServiceContract $mcpService
     */
    public function __construct(
        private readonly MCPServiceContract $mcpService
    ) {
    }

    /**
     * Verifica l'email dell'utente tramite un servizio esterno.
     *
     * @param UserContract $user L'utente
     *
     * @return bool True se l'email è valida, false altrimenti
     */
    public function execute(UserContract $user): bool
    {
        try {
            $response = $this->mcpService->fetch()->get(
                "https://api.email-validator.net/api/verify",
                [
                    'query' => [
                        'EmailAddress' => $user->email,
                        'APIKey' => config('services.email_validator.api_key')
                    ]
                ]
            );
            
            if ($response['status'] === 'success') {
                $data = $response['data'] ?? [];
                return ($data['status'] ?? '') === 'valid';
            }
            
            return false;
        } catch (\Exception $e) {
            Log::error('Email verification failed', [
                'user_id' => $user->id,
                'email' => $user->email,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }
}
```

### 3. MySQL

**Scopo**: Interazione con il database per operazioni complesse sugli utenti.

**Casi d'uso**:
- Query complesse per statistiche sugli utenti
- Ricerca avanzata negli utenti
- Aggregazione di dati per dashboard di amministrazione

**Esempio di implementazione**:
```php
<?php

declare(strict_types=1);

namespace Modules\User\Repositories;

use Modules\AI\Services\Contracts\MCPServiceContract;
use Modules\User\DataObjects\UserStatisticsData;

class UserStatisticsRepository
{
    /**
     * @param MCPServiceContract $mcpService
     */
    public function __construct(
        private readonly MCPServiceContract $mcpService
    ) {
    }

    /**
     * Ottiene le statistiche degli utenti per ruolo.
     *
     * @return array<string, UserStatisticsData>
     */
    public function getStatisticsByRole(): array
    {
        $results = $this->mcpService->mysql()->executeQuery(
            'SELECT r.name as role, COUNT(u.id) as user_count, 
             AVG(DATEDIFF(NOW(), u.created_at)) as avg_account_age, 
             SUM(u.is_active) as active_users
             FROM users u
             JOIN role_user ru ON u.id = ru.user_id
             JOIN roles r ON ru.role_id = r.id
             GROUP BY r.name'
        );
        
        $statistics = [];
        
        foreach ($results as $result) {
            $statistics[$result['role']] = new UserStatisticsData(
                role: $result['role'],
                userCount: (int) $result['user_count'],
                avgAccountAge: (float) $result['avg_account_age'],
                activeUsers: (int) $result['active_users']
            );
        }
        
        return $statistics;
    }
}
```

### 4. Redis

**Scopo**: Gestione della cache e delle code per le operazioni relative agli utenti.

**Casi d'uso**:
- Caching delle informazioni degli utenti
- Gestione delle code per le email di verifica
- Throttling delle richieste di login
- Gestione delle sessioni

**Esempio di implementazione**:
```php
<?php

declare(strict_types=1);

namespace Modules\User\Services;

use Modules\Xot\Contracts\UserContract;
use Modules\AI\Services\Contracts\MCPServiceContract;

class UserCacheService
{
    /**
     * @param MCPServiceContract $mcpService
     */
    public function __construct(
        private readonly MCPServiceContract $mcpService
    ) {
    }

    /**
     * Memorizza le informazioni dell'utente in cache.
     *
     * @param UserContract $user L'utente
     * @param int $ttl Tempo di vita in secondi
     *
     * @return bool True se l'operazione è riuscita, false altrimenti
     */
    public function cacheUserInfo(UserContract $user, int $ttl = 3600): bool
    {
        $userInfo = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'roles' => $user->roles->pluck('name')->toArray(),
            'permissions' => $user->getAllPermissions()->pluck('name')->toArray(),
            'last_login' => $user->last_login_at?->toIso8601String(),
            'is_active' => $user->is_active
        ];
        
        return $this->mcpService->redis()->set(
            "user_info_{$user->id}",
            $userInfo,
            $ttl
        );
    }

    /**
     * Recupera le informazioni dell'utente dalla cache.
     *
     * @param int $userId ID dell'utente
     *
     * @return array<string, mixed>|null Le informazioni dell'utente o null se non trovate
     */
    public function getUserInfo(int $userId): ?array
    {
        $userInfo = $this->mcpService->redis()->get("user_info_{$userId}");
        
        return $userInfo ?: null;
    }

    /**
     * Elimina le informazioni dell'utente dalla cache.
     *
     * @param int $userId ID dell'utente
     *
     * @return bool True se l'operazione è riuscita, false altrimenti
     */
    public function clearUserInfo(int $userId): bool
    {
        return $this->mcpService->redis()->delete("user_info_{$userId}");
    }
}
```

## Integrazione con Filament

Per integrare i server MCP con Filament nel modulo User, è possibile creare risorse Filament che utilizzano i server MCP:

```php
<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Modules\User\Filament\Resources\UserResource;
use Modules\AI\Services\Contracts\MCPServiceContract;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Placeholder;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;
    
    public function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('verifyEmail')
                ->label('Verifica Email')
                ->icon('heroicon-o-envelope')
                ->action(function () {
                    $user = $this->record;
                    
                    /** @var MCPServiceContract $mcpService */
                    $mcpService = app(MCPServiceContract::class);
                    
                    /** @var \Modules\User\Actions\VerifyUserEmailAction $verifyEmailAction */
                    $verifyEmailAction = app(\Modules\User\Actions\VerifyUserEmailAction::class);
                    
                    $isValid = $verifyEmailAction->execute($user);
                    
                    if ($isValid) {
                        $user->update([
                            'email_verified_at' => now()
                        ]);
                        
                        Notification::make()
                            ->title('Email verificata con successo')
                            ->success()
                            ->send();
                    } else {
                        Notification::make()
                            ->title('Verifica email fallita')
                            ->danger()
                            ->send();
                    }
                    
                    $this->refreshFormData([
                        'email_verified_at'
                    ]);
                })
        ];
    }
    
    protected function getHeaderWidgets(): array
    {
        return [
            \Modules\User\Filament\Widgets\UserActivityWidget::class,
        ];
    }
}
```

## Conclusione

L'integrazione dei server MCP con il modulo User consente di migliorare significativamente le funzionalità del modulo, fornendo memorizzazione efficiente delle preferenze degli utenti, interazione con API esterne per la verifica dei dati, operazioni complesse sul database e gestione avanzata della cache. Seguendo le linee guida e gli esempi forniti in questo documento, è possibile implementare queste funzionalità in modo conforme alle regole di sviluppo stabilite per i progetti base_predict_fila3_mono.
