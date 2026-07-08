# 🔄 Laravel Core Patterns - Implementazione PTVX

## 📡 Event & Listener Pattern

### Event

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\NomeModulo\Models\User;

class UserCreatedEvent
{
    use Dispatchable, SerializesModels;
    
    public function __construct(
        public readonly User $user
    ) {}
}
```

### Listener

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Modules\NomeModulo\Events\UserCreatedEvent;
use Modules\NomeModulo\Notifications\WelcomeNotification;

class SendWelcomeNotification implements ShouldQueue
{
    use InteractsWithQueue;
    
    public function handle(UserCreatedEvent $event): void
    {
        $event->user->notify(new WelcomeNotification($event->user));
    }
}
```

## 🔔 Notification Pattern

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Modules\NomeModulo\Models\User;

class WelcomeNotification extends Notification implements ShouldQueue
{
    use Queueable;
    
    public function __construct(
        private readonly User $user
    ) {}
    
    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }
    
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('nomemodulo::notifications.welcome.subject'))
            ->greeting(__('nomemodulo::notifications.welcome.greeting', ['name' => $this->user->name]))
            ->line(__('nomemodulo::notifications.welcome.message'))
            ->action(__('nomemodulo::notifications.welcome.action'), route('dashboard'));
    }
    
    public function toArray($notifiable): array
    {
        return [
            'user_id' => $this->user->id,
            'message' => __('nomemodulo::notifications.welcome.database_message'),
        ];
    }
}
```

## 🛡️ Policy Pattern

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\NomeModulo\Models\User;
use Modules\NomeModulo\Models\Post;

class PostPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view posts');
    }
    
    public function view(User $user, Post $post): bool
    {
        return $user->hasPermissionTo('view posts') || $user->id === $post->user_id;
    }
    
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create posts');
    }
    
    public function update(User $user, Post $post): bool
    {
        return $user->hasPermissionTo('edit posts') || $user->id === $post->user_id;
    }
    
    public function delete(User $user, Post $post): bool
    {
        return $user->hasPermissionTo('delete posts') || $user->id === $post->user_id;
    }
}
```
