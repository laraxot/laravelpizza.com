# Pattern State in Laravel

## Introduzione

Questa guida illustra l'implementazione del pattern State nel modulo CMS, con particolare attenzione alla gestione degli stati delle entità e alle transizioni tra stati.

## Implementazione Base

### 1. Trait per la Gestione degli Stati

```php
namespace Modules\Cms\Traits;

trait HasStates
{
    public function state()
    {
        return $this->morphOne(State::class, 'stateable');
    }

    public function transitionTo(string $state)
    {
        if (! $this->canTransitionTo($state)) {
            throw new InvalidStateTransitionException(
                "Non è possibile transitare dallo stato {$this->state->name} a {$state}"
            );
        }

        $this->state()->update(['name' => $state]);
        
        $this->fireStateChangedEvent($state);
    }

    protected function canTransitionTo(string $state): bool
    {
        return in_array($state, $this->allowedTransitions());
    }

    abstract protected function allowedTransitions(): array;
    
    protected function fireStateChangedEvent(string $newState): void
    {
        event(new StateChanged($this, $newState));
    }
}
```

### 2. Modello State

```php
namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = ['name'];

    public function stateable()
    {
        return $this->morphTo();
    }
}
```

### 3. Esempio di Implementazione su Post

```php
namespace Modules\Cms\Models;

use Modules\Cms\Traits\HasStates;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasStates;

    const STATE_DRAFT = 'draft';
    const STATE_REVIEW = 'review';
    const STATE_PUBLISHED = 'published';
    const STATE_ARCHIVED = 'archived';

    protected function allowedTransitions(): array
    {
        return [
            self::STATE_DRAFT => [self::STATE_REVIEW],
            self::STATE_REVIEW => [self::STATE_PUBLISHED, self::STATE_DRAFT],
            self::STATE_PUBLISHED => [self::STATE_ARCHIVED],
            self::STATE_ARCHIVED => [self::STATE_PUBLISHED],
        ];
    }
}
```

## Pattern State con Volt

### 1. Componente di Gestione Stati

```php
<?php

// Resources/views/components/volt/state-manager.blade.php
use function Livewire\Volt\{state, computed};

state(['model' => null, 'currentState' => '']);

$availableTransitions = computed(function () {
    return $this->model->allowedTransitions()[$this->model->state->name] ?? [];
});

$transition = function (string $newState) {
    try {
        $this->model->transitionTo($newState);
        $this->currentState = $newState;
        
        session()->flash('success', 'Stato aggiornato con successo');
    } catch (\Exception $e) {
        session()->flash('error', $e->getMessage());
    }
};
?>

<div>
    <div class="flex items-center gap-4">
        <span class="text-sm font-medium text-gray-700">
            Stato attuale: {{ $currentState }}
        </span>

        <div class="flex gap-2">
            @foreach($availableTransitions as $transition)
                <x-cms::button
                    wire:click="transition('{{ $transition }}')"
                    size="sm"
                >
                    {{ ucfirst($transition) }}
                </x-cms::button>
            @endforeach
        </div>
    </div>

    @if(session('success'))
        <div class="mt-2 text-sm text-green-600">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mt-2 text-sm text-red-600">
            {{ session('error') }}
        </div>
    @endif
</div>
```

### 2. Utilizzo nel Form di Modifica Post

```php
<?php

// Resources/views/pages/posts/edit.blade.php
use function Livewire\Volt\{state, computed};
use Modules\Cms\Models\Post;

state(['post' => fn () => Post::findOrFail($id)]);

?>

<x-layouts.cms>
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg p-6">
            <div class="flex justify-between items-start mb-6">
                <h1 class="text-2xl font-semibold">
                    Modifica Post
                </h1>

                <livewire:volt.state-manager
                    :model="$post"
                    :current-state="$post->state->name"
                />
            </div>

            <!-- Form di modifica -->
        </div>
    </div>
</x-layouts.cms>
```

## Eventi e Notifiche

### 1. Evento State Changed

```php
namespace Modules\Cms\Events;

class StateChanged
{
    public function __construct(
        public $model,
        public string $newState
    ) {}
}
```

### 2. Notifica di Cambio Stato

```php
namespace Modules\Cms\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class StateChangeNotification extends Notification
{
    public function __construct(
        private $model,
        private string $newState
    ) {}

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Cambio di Stato')
            ->line("Lo stato è cambiato in: {$this->newState}")
            ->action('Visualizza', route('cms.posts.show', $this->model));
    }
}
```

## Testing

```php
namespace Modules\Cms\Tests\Unit;

use Tests\TestCase;
use Modules\Cms\Models\Post;
use Modules\Cms\Exceptions\InvalidStateTransitionException;

class StateTest extends TestCase
{
    /** @test */
    public function it_can_transition_to_allowed_state()
    {
        $post = Post::factory()->create();
        $post->state()->create(['name' => Post::STATE_DRAFT]);

        $post->transitionTo(Post::STATE_REVIEW);

        $this->assertEquals(Post::STATE_REVIEW, $post->state->name);
    }

    /** @test */
    public function it_cannot_transition_to_invalid_state()
    {
        $this->expectException(InvalidStateTransitionException::class);

        $post = Post::factory()->create();
        $post->state()->create(['name' => Post::STATE_DRAFT]);

        $post->transitionTo(Post::STATE_PUBLISHED);
    }
}
```

## Best Practices

1. **Definizione degli Stati**
   - Utilizzare costanti per gli stati
   - Documentare chiaramente le transizioni permesse
   - Implementare validazioni per le transizioni

2. **Gestione delle Transizioni**
   - Validare sempre le transizioni prima di eseguirle
   - Emettere eventi per le transizioni di stato
   - Implementare rollback in caso di errori

3. **Testing**
   - Testare tutte le transizioni possibili
   - Verificare le transizioni non permesse
   - Testare gli eventi e le notifiche

## Risorse Utili

- [Laravel Documentation - Events](https://laravel.com/docs/events)
- [Laravel Documentation - Notifications](https://laravel.com/docs/notifications)
- [Design Patterns in PHP](https://refactoring.guru/design-patterns/state/php) 
