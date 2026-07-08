# ⚡ Action Pattern - Implementazione PTVX

> **ACTION PATTERN**: Incapsula una singola logica di business in una classe eseguibile.

## 🎯 Scopo

Il Action Pattern serve a:
- ✅ Eseguire un compito specifico (Single Responsibility)
- ✅ Essere riutilizzabile (Controller, API, Console, Job)
- ✅ Essere facilmente testabile
- ✅ Supportare code e decoratori (Spatie QueueableAction)

## 📋 Implementazione

### Classe Action

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Actions;

use Spatie\QueueableAction\QueueableAction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\NomeModulo\Data\UserData;
use Modules\NomeModulo\Repositories\Contracts\UserRepositoryInterface;
use Modules\NomeModulo\Notifications\UserCreatedNotification;

class CreateUserAction implements ShouldQueue
{
    use QueueableAction;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}
    
    public function execute(UserData $userData, bool $sendNotification = true): \Modules\NomeModulo\Models\User
    {
        // Elabora i dati dell'utente
        $user = $this->userRepository->create($userData->toArray());
        
        // Notifica il completamento se richiesto
        if ($sendNotification) {
            $user->notify(new UserCreatedNotification($user));
        }
        
        return $user;
    }
}
```

## 🎮 Utilizzo

### In Controller
```php
public function store(UserRequest $request, CreateUserAction $action)
{
    $userData = UserData::fromRequest($request);
    $user = $action->execute($userData);
    
    return redirect()->route('users.show', $user);
}
```

### In Filament
```php
$action(function (array $data) {
    app(CreateUserAction::class)->execute(UserData::from($data));
});
```

---
**Vedi anche**: [Data Transfer Objects](./dto.md), [Repository Pattern](./repository.md)
