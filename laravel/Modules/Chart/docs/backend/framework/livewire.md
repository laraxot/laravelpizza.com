# Livewire 3.x

## Prerequisiti
- Laravel 12.x
- PHP 8.2+
- Alpine.js 3.x

## Struttura Base

```
app/Livewire/
├── Forms/
│   ├── LoginForm.php
│   └── RegisterForm.php
├── Tables/
│   └── UserTable.php
└── Components/
    └── SearchDropdown.php
```

## Convenzioni

### 1. Componenti Base
```php
class LoginForm extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;
    
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];
    }
    
    public function login(): void
    {
        $this->validate();
        
        Auth::attempt([
            'email' => $this->email,
            'password' => $this->password,
        ], $this->remember);
        
        redirect()->intended('/dashboard');
    }
    
    public function render()
    {
        return view('livewire.forms.login');
    }
}
```

### 2. Componenti con Proprietà Computate
```php
class UserProfile extends Component
{
    public User $user;
    
    #[Computed]
    public function fullName(): string
    {
        return "{$this->user->first_name} {$this->user->last_name}";
    }
    
    #[Computed]
    public function posts(): Collection
    {
        return $this->user->posts()
            ->latest()
            ->take(5)
            ->get();
    }
}
```

### 3. Componenti con Actions
```php
class TodoList extends Component
{
    public Collection $todos;
    
    #[On('todo-added')]
    public function refreshTodos(): void
    {
        $this->todos = Todo::latest()->get();
    }
    
    public function toggleComplete(Todo $todo): void
    {
        $todo->update(['completed' => !$todo->completed]);
    }
}
```

### 4. Form Objects
```php
class CreateUser extends Form
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    
    public function rules(): array
    {
        return [
            'name' => ['required', 'min:2'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8'],
        ];
    }
    
    public function save(): void
    {
        $this->validate();
        
        User::create($this->all());
        
        $this->reset();
        
        $this->dispatch('user-created');
    }
}
```

## Best Practices

### 1. Lifecycle Hooks
```php
class SearchUsers extends Component
{
    public string $search = '';
    public Collection $users;
    
    public function mount(): void
    {
        $this->users = collect();
    }
    
    public function updated($property): void
    {
        if ($property === 'search') {
            $this->users = User::search($this->search)->get();
        }
    }
}
```

### 2. Validazione
```php
class ContactForm extends Component
{
    public string $name = '';
    public string $email = '';
    public string $message = '';
    
    protected $rules = [
        'name' => 'required|min:2',
        'email' => 'required|email',
        'message' => 'required|min:10',
    ];
    
    protected $validationAttributes = [
        'name' => 'nome completo',
        'email' => 'indirizzo email',
        'message' => 'messaggio',
    ];
    
    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }
}
```

### 3. Eventi
```php
class Notification extends Component
{
    public ?string $message = null;
    
    protected $listeners = [
        'show-notification' => 'showNotification',
    ];
    
    public function showNotification(string $message): void
    {
        $this->message = $message;
        
        $this->dispatch('notification-shown');
    }
}
```

### 4. Query Builder
```php
class UserTable extends Component
{
    use WithPagination;
    
    public string $search = '';
    public string $sortField = 'name';
    public string $sortDirection = 'asc';
    
    public function updatingSearch(): void
    {
        $this->resetPage();
    }
    
    public function sortBy(string $field): void
    {
        $this->sortDirection = $this->sortField === $field 
            ? $this->sortDirection === 'asc' ? 'desc' : 'asc'
            : 'asc';
            
        $this->sortField = $field;
    }
    
    public function render()
    {
        return view('livewire.user-table', [
            'users' => User::search($this->search)
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(10),
        ]);
    }
}
```

## Performance

### 1. Lazy Loading
```php
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.dashboard')
            ->layout('layouts.app');
    }
}

// View
<div>
    <livewire:stats lazy />
    <livewire:chart lazy />
    <livewire:table lazy />
</div>
```

### 2. Debounce & Throttle
```php
class SearchUsers extends Component
{
    #[Url]
    public string $search = '';
    
    public function updatedSearch()
    {
        // Automatically debounced for 300ms
    }
}

// View
<div>
    <input 
        wire:model.live.debounce.300ms="search" 
        type="search"
    >
</div>
```

### 3. Caching
```php
class UserStats extends Component
{
    #[Computed]
    public function stats()
    {
        return cache()->remember('user-stats', 3600, function () {
            return [
                'total' => User::count(),
                'active' => User::active()->count(),
                'inactive' => User::inactive()->count(),
            ];
        });
    }
}
```

## Troubleshooting

### Common Issues
1. **Component Not Updating**
   - Verificare wire:model
   - Controllare gli eventi
   - Verificare la cache

2. **Validation Not Working**
   - Verificare le regole
   - Controllare i messaggi
   - Verificare gli attributi

3. **Events Not Firing**
   - Verificare i listeners
   - Controllare i dispatch
   - Verificare il DOM

## Collegamenti
- [Struttura Base](../laravel/Modules/Xot/docs/STRUCTURE.md)
- [Convenzioni di Namespace](../laravel/Modules/Xot/docs/namespace-conventions.md)
- [Documentazione Laravel](LARAVEL.md)
- [Documentazione Folio & Volt](FOLIO_VOLT.md) 