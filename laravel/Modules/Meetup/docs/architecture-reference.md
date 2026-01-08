# 🏗️ Laravel Pizza Meetups - Architecture Reference

## 🚨 Critical Rule: Front Office Architecture

**For the front office, we use exclusively:**
- ✅ **Laravel Folio** - File-based routing (NO traditional controllers/routes in web.php/api.php)
- ✅ **Laravel Volt** - Declarative components
- ✅ **Filament** - Admin panel and backend UI

**What we do NOT use for front office:**
- ❌ Traditional controllers
- ❌ Routes in web.php/api.php for front office
- ❌ Traditional Laravel views with controller approach

## 📋 Key Principles

- **DRY** - Don't Repeat Yourself
- **KISS** - Keep It Simple, Stupid
- **SOLID** - Object-oriented design principles
- **Robust** - Error-resistant and reliable
- **Laraxot** - Modular architecture patterns

## 📁 Directory Structure (Front Office)

```
/resources/views/
├── pages/              # Folio routes (become URLs automatically)
│   ├── events/
│   │   ├── index.blade.php     # /events
│   │   └── show.blade.php      # /events/{event}
│   ├── profile.blade.php       # /profile
│   └── dashboard.blade.php     # /dashboard
├── components/         # Volt components
│   └── event-card.blade.php
└── layouts/            # Page layouts
    └── app.blade.php
```

## 📚 Repository Analizzati

Sono stati analizzati **20 repository GitHub** che utilizzano Folio + Volt per estrarre pattern comuni e best practices. Vedi [Analisi Completa Repository](./folio-volt-repositories-analysis.md) per dettagli.

### Pattern Comuni Identificati

1. **Routing File-Based**: Tutti i repository usano `resources/views/pages/` per routing Folio
2. **Volt Inline**: `@volt('component-name')` direttamente nelle pagine Blade
3. **SPA Mode**: `wire:navigate` e `@persist` per navigazione fluida
4. **Actions Pattern**: Spatie QueueableAction per business logic
5. **Nessun Controller**: Frontoffice usa solo Folio + Volt + Actions

---

## 💡 Quick Implementation Examples

### Folio Route (File: `/resources/views/pages/events/show.blade.php`)
```blade
<?php
use App\Models\Event;
use Livewire\Volt\Component;

new class extends Component {
    public Event $event;
    
    public function mount(Event $event) {
        $this->event = $event;
    }
};
?>

<div>
    <h1>{{ $event->title }}</h1>
    <p>{{ $event->description }}</p>
</div>
```

### Accessible at: `/events/{event}` automatically

### Genesis Starter Kit Pattern Example (File: `/resources/views/pages/auth/login.blade.php`)
```blade
<?php
use function Laravel\Volt\{state, rules};
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public $email = '';
    public $password = '';
    public $remember = false;
    
    public function rules()
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];
    }
    
    public function authenticate()
    {
        $credentials = $this->validate();
        
        if (!Auth::attempt($credentials, $this->remember)) {
            $this->addError('email', trans('auth.failed'));
            return;
        }
        
        return redirect()->intended('/dashboard');
    }
}; ?>

<x-layout>
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Sign in to your account
                </h2>
            </div>
            
            <form class="mt-8 space-y-6" wire:submit="authenticate">
                <div class="rounded-md shadow-sm space-y-4">
                    <div>
                        <input 
                            wire:model="email" 
                            type="email" 
                            required 
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Email address"
                        />
                        <div wire:loading.remove class="text-red-500 text-sm mt-1">
                            @error('email') {{ $message }} @enderror
                        </div>
                    </div>
                    <div>
                        <input 
                            wire:model="password" 
                            type="password" 
                            required 
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Password"
                        />
                        <div wire:loading.remove class="text-red-500 text-sm mt-1">
                            @error('password') {{ $message }} @enderror
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input 
                            wire:model="remember" 
                            type="checkbox" 
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                        />
                        <label class="ml-2 block text-sm text-gray-900">
                            Remember me
                        </label>
                    </div>
                </div>

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Sign in
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
```

### Warriorfolio Pattern Example: Advanced Search Component (File: `/resources/views/components/advanced-search.blade.php`)
```blade
<?php
use Livewire\Volt\Component;
use function Laravel\Volt\{state, computed};

new class extends Component {
    public $searchTerm = '';
    public $filters = [
        'category' => null,
        'date' => null,
        'tags' => []
    ];
    
    public function mount()
    {
        $this->searchTerm = request('q', '');
        $this->filters = [
            'category' => request('category', null),
            'date' => request('date', null),
            'tags' => request('tags', [])
        ];
    }
    
    public function getSearchResultsProperty()
    {
        return \App\Models\Event::when($this->searchTerm, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('title', 'like', '%' . $this->searchTerm . '%')
                             ->orWhere('description', 'like', '%' . $this->searchTerm . '%');
                });
            })
            ->when($this->filters['category'], function ($query) {
                $query->where('category_id', $this->filters['category']);
            })
            ->with(['category', 'organizer'])
            ->orderBy('start_datetime', 'desc')
            ->get();
    }
    
    public function searchUpdated()
    {
        $this->dispatch('search-updated');
    }
}; ?>

<div class="relative">
    <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
        <input 
            wire:model.live.debounce.500ms="searchTerm"
            wire:keydown="searchUpdated"
            type="text" 
            placeholder="Search events, topics, speakers..."
            class="flex-1 px-4 py-2 focus:outline-none"
        />
        <button class="px-4 py-2 bg-gray-100 border-l border-gray-300">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </button>
    </div>
    
    @if($searchTerm && $this->searchResults->count() > 0)
        <div class="absolute top-full left-0 right-0 bg-white shadow-lg rounded-lg z-10 mt-1 border border-gray-200">
            <div class="p-3 border-b border-gray-200 bg-gray-50">
                <span class="text-sm text-gray-600">
                    {{ $this->searchResults->count() }} results for "{{ $searchTerm }}"
                </span>
            </div>
            <div class="max-h-96 overflow-y-auto">
                @foreach($this->searchResults->take(10) as $result)
                    <a href="{{ route('events.show', $result) }}" 
                       class="block p-3 border-b border-gray-100 hover:bg-blue-50 transition-colors">
                        <div class="font-medium text-gray-900">{{ $result->title }}</div>
                        <div class="text-sm text-gray-600 mt-1 line-clamp-2">{{ Str::limit($result->description, 100) }}</div>
                        <div class="text-xs text-gray-500 mt-2">
                            {{ $result->start_datetime->format('M j, Y') }} • {{ $result->category?->name }}
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @elseif($searchTerm && $this->searchResults->count() === 0)
        <div class="absolute top-full left-0 right-0 bg-white shadow-lg rounded-lg z-10 mt-1 border border-gray-200">
            <div class="p-6 text-center text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No results found</h3>
                <p class="mt-1 text-sm text-gray-500">Try different keywords or remove search filters.</p>
            </div>
        </div>
    @endif
</div>
```

## 🎯 Architecture Summary

| Layer | Technology | Purpose |
|-------|------------|---------|
| **Front Office** | Laravel Folio + Volt | Public-facing pages and user interactions |
| **Back Office** | Filament | Admin panel and management |
| **Structure** | Laravel Modules | Modular organization |
| **Principles** | DRY+KISS+SOLID+Robust+Laraxot | Development standards |

---

**Last Updated**: November 28, 2025  
**Focus**: Front office implementation using Folio + Volt (no traditional controllers/routes)