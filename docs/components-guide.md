# Guida ai Componenti UI

## Layout

### Frontoffice
- Utilizzare `x-layouts.main` come layout principale
- Struttura standard:
  ```blade
  <x-layouts.main>
      <x-slot name="title">
          {{ __('Page Title') }}
      </x-slot>

      <div class="container mx-auto px-4">
          <!-- Contenuto della pagina -->
      </div>
  </x-layouts.main>
  ```

### Backoffice
- Utilizzare i layout Filament
- Non utilizzare i layout Filament nel frontoffice

## Componenti Filament

### Dropdown
Il componente dropdown di Filament offre una soluzione completa per i menu a tendina con le seguenti funzionalità:

```blade
<x-filament::dropdown>
    <x-slot name="trigger">
        <x-filament::button>
            {{ __('More actions') }}
        </x-filament::button>
    </x-slot>

    <x-filament::dropdown.list>
        <x-filament::dropdown.list.item>
            {{ __('View') }}
        </x-filament::dropdown.list.item>
    </x-filament::dropdown.list>
</x-filament::dropdown>
```

#### Caratteristiche Principali:
- **Trigger Personalizzabile**: Usa lo slot `trigger` per personalizzare il pulsante
- **Posizionamento**: Controlla il posizionamento con `placement` (top-start, top-end, bottom-start, bottom-end)
- **Larghezza**: Imposta la larghezza con `width` (xs, sm, md, lg, xl, 2xl, 3xl, 4xl, 5xl, 6xl, 7xl)
- **Altezza Massima**: Controlla l'altezza massima con `max-height`
- **Colori**: Supporto per colori (danger, info, primary, success, warning)
- **Icone**: Aggiungi icone con l'attributo `icon`
- **Badge**: Aggiungi badge con lo slot `badge`
- **Link**: Converti in link con `tag="a"` e `href`

### Avatar
Il componente avatar di Filament gestisce le immagini profilo con:

```blade
<x-filament::avatar
    src="{{ $user->profile_photo_url }}"
    alt="{{ $user->name }}"
    size="md"
/>
```

#### Caratteristiche:
- **Dimensioni**: sm, md, lg o classi personalizzate
- **Forma**: Controlla la forma con `:circular="true/false"`
- **Fallback**: Gestione automatica delle immagini mancanti

### Loading Indicator
Il componente loading indicator di Filament mostra lo stato di caricamento:

```blade
<x-filament::loading-indicator />
```

#### Caratteristiche:
- **Dimensioni**: sm, md, lg
- **Colori**: Personalizzabili
- **Animazione**: Smooth e responsive

## Best Practices

### Layout
- Mantenere la separazione tra frontoffice e backoffice
- Utilizzare i layout appropriati per ogni contesto
- Seguire la struttura standard dei layout
- Supportare il tema scuro

### Componenti
- Utilizzare i componenti Filament quando disponibili
- Personalizzare i componenti solo quando necessario
- Documentare i componenti personalizzati
- Testare in entrambi i temi

### Cosa NON fare
- ❌ Utilizzare layout Filament nel frontoffice
- ❌ Mischiare componenti tra frontoffice e backoffice
- ❌ Duplicare funzionalità già presenti in Filament
- ❌ Ignorare il supporto per il tema scuro

### Cosa fare
- ✅ Utilizzare `x-layouts.main` per il frontoffice
- ✅ Utilizzare i componenti Filament quando disponibili
- ✅ Seguire le convenzioni di naming
- ✅ Documentare i componenti personalizzati
- ✅ Testare in entrambi i temi

## Esempi di Implementazione

### Dropdown Utente
```blade
<x-filament::dropdown>
    <x-slot name="trigger">
        <button class="flex items-center">
            <x-filament::avatar
                src="{{ $user->profile_photo_url }}"
                alt="{{ $user->name }}"
                size="md"
            />
            <x-filament::icon
                name="heroicon-o-chevron-down"
                class="ml-1 h-4 w-4"
            />
        </button>
    </x-slot>

    <x-filament::dropdown.list>
        <x-filament::dropdown.list.item
            icon="heroicon-o-user"
            href="{{ route('profile.show') }}"
            tag="a"
        >
            {{ __('Profile') }}
        </x-filament::dropdown.list.item>

        <x-filament::dropdown.list.item
            icon="heroicon-o-cog-6-tooth"
            href="{{ route('settings') }}"
            tag="a"
        >
            {{ __('Settings') }}
        </x-filament::dropdown.list.item>

        <x-filament::dropdown.list.item
            icon="heroicon-o-arrow-right-on-rectangle"
            color="danger"
            wire:click="logout"
        >
            {{ __('Log Out') }}
        </x-filament::dropdown.list.item>
    </x-filament::dropdown.list>
</x-filament::dropdown>
```

### Loading State
```blade
<div>
    <x-filament::loading-indicator wire:loading />
    <div wire:loading.remove>
        {{ $content }}
    </div>
</div>
```

## Collegamenti Correlati
- [Documentazione Dropdown Filament](https://filamentphp.com/docs/3.x/support/blade-components/dropdown)
- [Documentazione Avatar Filament](https://filamentphp.com/docs/3.x/support/blade-components/avatar)
- [Documentazione Loading Indicator Filament](https://filamentphp.com/docs/3.x/support/blade-components/loading-indicator)

## Volt e Folio

### Componenti Volt
- Utilizzare la direttiva `@volt` per i componenti Volt
- Struttura standard:
  ```blade
  @volt('component.name')
  <?php
  use function Livewire\Volt\{state, mount};

  state([
      'property' => null,
  ]);

  $action = function () {
      // Logica dell'azione
  };
  ?>

  <div>
      <!-- Template del componente -->
  </div>
  @endvolt
  ```

### Pagine Folio
- Utilizzare Folio per le pagine del frontoffice
- Struttura standard:
  ```blade
  <?php
  use function Laravel\Folio\{middleware, name};
  use function Livewire\Volt\{state, mount};

  middleware(['auth']);
  name('page.name');

  state([
      'property' => null,
  ]);
  ?>

  <x-layouts.main>
      <!-- Contenuto della pagina -->
  </x-layouts.main>
  ```

### Gestione dello Stato
- Utilizzare `state()` per definire le proprietà
- Utilizzare `mount()` per l'inizializzazione
- Gestire gli errori con try/catch
- Implementare stati di loading

### Esempi

#### Componente Volt
```blade
@volt('auth.logout')
<?php
use function Livewire\Volt\{state, mount};

state([
    'isLoggingOut' => false,
    'success' => false,
    'error' => false,
]);

$logout = function () {
    try {
        $this->isLoggingOut = true;
        // Logica di logout
        $this->success = true;
    } catch (\Exception $e) {
        $this->error = true;
    }
    $this->isLoggingOut = false;
};
?>

<div>
    @if($success)
        <!-- Success state -->
    @elseif($error)
        <!-- Error state -->
    @else
        <!-- Default state -->
    @endif

    @if($isLoggingOut)
        <x-filament::loading-indicator />
    @endif
</div>
@endvolt
```

#### Pagina Folio
```blade
<?php
use function Laravel\Folio\{middleware, name};
use function Livewire\Volt\{state, mount};

middleware(['auth']);
name('auth.logout');

state([
    'isLoggingOut' => false,
    'success' => false,
    'error' => false,
]);

$logout = function () {
    try {
        $this->isLoggingOut = true;
        // Logica di logout
        $this->success = true;
    } catch (\Exception $e) {
        $this->error = true;
    }
    $this->isLoggingOut = false;
};
?>

<x-layouts.main>
    <x-slot name="title">
        {{ __('auth.logout.title') }}
    </x-slot>

    <div>
        @if($success)
            <!-- Success state -->
        @elseif($error)
            <!-- Error state -->
        @else
            <!-- Default state -->
        @endif

        @if($isLoggingOut)
            <x-filament::loading-indicator />
        @endif
    </div>
</x-layouts.main>
```

### Best Practices

#### Gestione dello Stato
- Mantenere gli stati semplici e chiari
- Documentare gli stati e le loro transizioni
- Gestire correttamente gli errori
- Implementare stati di loading

#### Componenti
- Utilizzare la direttiva `@volt` per i componenti Volt
- Seguire la struttura standard
- Mantenere la separazione tra logica e presentazione
- Testare i componenti in isolamento

#### Cosa NON fare
- ❌ Omettere la direttiva `@volt` nei componenti Volt
- ❌ Mischiare logica di business con la presentazione
- ❌ Duplicare stati tra componenti
- ❌ Ignorare la gestione degli errori

#### Cosa fare
- ✅ Utilizzare la direttiva `@volt` per i componenti Volt
- ✅ Seguire la struttura standard per i componenti
- ✅ Gestire correttamente gli stati e le azioni
- ✅ Implementare la gestione degli errori
- ✅ Testare i componenti

## Componenti di Autenticazione

### User Dropdown
- Utilizzare `x-blocks.navigation.user-dropdown` per utenti autenticati
- Struttura standard:
  ```blade
  <x-blocks.navigation.user-dropdown :user="auth()->user()">
      <x-slot name="trigger">
          <x-filament::avatar
              src="{{ $user->profile_photo_url }}"
              alt="{{ $user->name }}"
          />
      </x-slot>
  </x-blocks.navigation.user-dropdown>
  ```

### Login Buttons
- Utilizzare `x-blocks.navigation.login-buttons` per utenti non autenticati
- Struttura standard:
  ```blade
  <x-blocks.navigation.login-buttons>
      <x-ui.button
          href="{{ route('login') }}"
          color="primary"
      >
          {{ __('auth.login.link') }}
      </x-ui.button>

      <x-ui.button
          href="{{ route('register') }}"
          color="secondary"
      >
          {{ __('auth.register.link') }}
      </x-ui.button>
  </x-blocks.navigation.login-buttons>
  ```

### Gestione dello Stato
- Utilizzare `@auth` e `@else` per gestire gli stati
- Esempio:
  ```blade
  @auth
      <x-blocks.navigation.user-dropdown :user="auth()->user()" />
  @else
      <x-blocks.navigation.login-buttons />
  @endauth
  ```

### Traduzioni
- Utilizzare il namespace `auth.` per le traduzioni
- Struttura standard:
  ```php
  return [
      'login' => [
          'title' => 'Login',
          'email' => 'Email',
          'password' => 'Password',
          'remember_me' => 'Remember me',
          'forgot_password' => 'Forgot password?',
          'submit' => 'Login',
          'link' => 'Login',
      ],
      'register' => [
          'title' => 'Register',
          'email' => 'Email',
          'password' => 'Password',
          'confirm_password' => 'Confirm password',
          'submit' => 'Register',
          'link' => 'Register',
      ],
      'logout' => [
          'title' => 'Logout',
          'confirm_message' => 'Are you sure you want to log out?',
          'success_title' => 'Logged out successfully',
          'success_message' => 'You have been logged out.',
          'error_title' => 'Error',
          'error_message' => 'An error occurred while logging out.',
          'confirm_button' => 'Logout',
          'cancel_button' => 'Cancel',
          'back_to_home' => 'Back to home',
          'try_again' => 'Try again',
      ],
      'user_dropdown' => [
          'manage_account' => 'Manage Account',
          'profile' => 'Profile',
          'settings' => 'Settings',
          'logout' => 'Logout',
      ],
  ];
  ```

### Best Practices

#### Componenti
- Mantenere la separazione tra stati autenticati e non
- Utilizzare i componenti appropriati
- Gestire correttamente le traduzioni
- Supportare il tema scuro

#### Traduzioni
- Utilizzare chiavi semantiche
- Mantenere la coerenza nella struttura
- Documentare le traduzioni
- Testare in tutte le lingue

#### Cosa NON fare
- ❌ Mischiare stati autenticati e non
- ❌ Duplicare logica di autenticazione
- ❌ Ignorare le traduzioni
- ❌ Ignorare il supporto per il tema scuro

#### Cosa fare
- ✅ Utilizzare i componenti appropriati
- ✅ Seguire la struttura standard
- ✅ Gestire correttamente le traduzioni
- ✅ Testare in entrambi gli stati
# Guida ai Componenti UI

## Layout

### Frontoffice
- Utilizzare `x-layouts.main` come layout principale
- Struttura standard:
  ```blade
  <x-layouts.main>
      <x-slot name="title">
          {{ __('Page Title') }}
      </x-slot>

      <div class="container mx-auto px-4">
          <!-- Contenuto della pagina -->
      </div>
  </x-layouts.main>
  ```

### Backoffice
- Utilizzare i layout Filament
- Non utilizzare i layout Filament nel frontoffice

## Componenti Filament

### Dropdown
Il componente dropdown di Filament offre una soluzione completa per i menu a tendina con le seguenti funzionalità:

```blade
<x-filament::dropdown>
    <x-slot name="trigger">
        <x-filament::button>
            {{ __('More actions') }}
        </x-filament::button>
    </x-slot>

    <x-filament::dropdown.list>
        <x-filament::dropdown.list.item>
            {{ __('View') }}
        </x-filament::dropdown.list.item>
    </x-filament::dropdown.list>
</x-filament::dropdown>
```

#### Caratteristiche Principali:
- **Trigger Personalizzabile**: Usa lo slot `trigger` per personalizzare il pulsante
- **Posizionamento**: Controlla il posizionamento con `placement` (top-start, top-end, bottom-start, bottom-end)
- **Larghezza**: Imposta la larghezza con `width` (xs, sm, md, lg, xl, 2xl, 3xl, 4xl, 5xl, 6xl, 7xl)
- **Altezza Massima**: Controlla l'altezza massima con `max-height`
- **Colori**: Supporto per colori (danger, info, primary, success, warning)
- **Icone**: Aggiungi icone con l'attributo `icon`
- **Badge**: Aggiungi badge con lo slot `badge`
- **Link**: Converti in link con `tag="a"` e `href`

### Avatar
Il componente avatar di Filament gestisce le immagini profilo con:

```blade
<x-filament::avatar
    src="{{ $user->profile_photo_url }}"
    alt="{{ $user->name }}"
    size="md"
/>
```

#### Caratteristiche:
- **Dimensioni**: sm, md, lg o classi personalizzate
- **Forma**: Controlla la forma con `:circular="true/false"`
- **Fallback**: Gestione automatica delle immagini mancanti

### Loading Indicator
Il componente loading indicator di Filament mostra lo stato di caricamento:

```blade
<x-filament::loading-indicator />
```

#### Caratteristiche:
- **Dimensioni**: sm, md, lg
- **Colori**: Personalizzabili
- **Animazione**: Smooth e responsive

## Best Practices

### Layout
- Mantenere la separazione tra frontoffice e backoffice
- Utilizzare i layout appropriati per ogni contesto
- Seguire la struttura standard dei layout
- Supportare il tema scuro

### Componenti
- Utilizzare i componenti Filament quando disponibili
- Personalizzare i componenti solo quando necessario
- Documentare i componenti personalizzati
- Testare in entrambi i temi

### Cosa NON fare
- ❌ Utilizzare layout Filament nel frontoffice
- ❌ Mischiare componenti tra frontoffice e backoffice
- ❌ Duplicare funzionalità già presenti in Filament
- ❌ Ignorare il supporto per il tema scuro

### Cosa fare
- ✅ Utilizzare `x-layouts.main` per il frontoffice
- ✅ Utilizzare i componenti Filament quando disponibili
- ✅ Seguire le convenzioni di naming
- ✅ Documentare i componenti personalizzati
- ✅ Testare in entrambi i temi

## Esempi di Implementazione

### Dropdown Utente
```blade
<x-filament::dropdown>
    <x-slot name="trigger">
        <button class="flex items-center">
            <x-filament::avatar
                src="{{ $user->profile_photo_url }}"
                alt="{{ $user->name }}"
                size="md"
            />
            <x-filament::icon
                name="heroicon-o-chevron-down"
                class="ml-1 h-4 w-4"
            />
        </button>
    </x-slot>

    <x-filament::dropdown.list>
        <x-filament::dropdown.list.item
            icon="heroicon-o-user"
            href="{{ route('profile.show') }}"
            tag="a"
        >
            {{ __('Profile') }}
        </x-filament::dropdown.list.item>

        <x-filament::dropdown.list.item
            icon="heroicon-o-cog-6-tooth"
            href="{{ route('settings') }}"
            tag="a"
        >
            {{ __('Settings') }}
        </x-filament::dropdown.list.item>

        <x-filament::dropdown.list.item
            icon="heroicon-o-arrow-right-on-rectangle"
            color="danger"
            wire:click="logout"
        >
            {{ __('Log Out') }}
        </x-filament::dropdown.list.item>
    </x-filament::dropdown.list>
</x-filament::dropdown>
```

### Loading State
```blade
<div>
    <x-filament::loading-indicator wire:loading />
    <div wire:loading.remove>
        {{ $content }}
    </div>
</div>
```

## Collegamenti Correlati
- [Documentazione Dropdown Filament](https://filamentphp.com/docs/3.x/support/blade-components/dropdown)
- [Documentazione Avatar Filament](https://filamentphp.com/docs/3.x/support/blade-components/avatar)
- [Documentazione Loading Indicator Filament](https://filamentphp.com/docs/3.x/support/blade-components/loading-indicator)

## Volt e Folio

### Componenti Volt
- Utilizzare la direttiva `@volt` per i componenti Volt
- Struttura standard:
  ```blade
  @volt('component.name')
  <?php
  use function Livewire\Volt\{state, mount};

  state([
      'property' => null,
  ]);

  $action = function () {
      // Logica dell'azione
  };
  ?>

  <div>
      <!-- Template del componente -->
  </div>
  @endvolt
  ```

### Pagine Folio
- Utilizzare Folio per le pagine del frontoffice
- Struttura standard:
  ```blade
  <?php
  use function Laravel\Folio\{middleware, name};
  use function Livewire\Volt\{state, mount};

  middleware(['auth']);
  name('page.name');

  state([
      'property' => null,
  ]);
  ?>

  <x-layouts.main>
      <!-- Contenuto della pagina -->
  </x-layouts.main>
  ```

### Gestione dello Stato
- Utilizzare `state()` per definire le proprietà
- Utilizzare `mount()` per l'inizializzazione
- Gestire gli errori con try/catch
- Implementare stati di loading

### Esempi

#### Componente Volt
```blade
@volt('auth.logout')
<?php
use function Livewire\Volt\{state, mount};

state([
    'isLoggingOut' => false,
    'success' => false,
    'error' => false,
]);

$logout = function () {
    try {
        $this->isLoggingOut = true;
        // Logica di logout
        $this->success = true;
    } catch (\Exception $e) {
        $this->error = true;
    }
    $this->isLoggingOut = false;
};
?>

<div>
    @if($success)
        <!-- Success state -->
    @elseif($error)
        <!-- Error state -->
    @else
        <!-- Default state -->
    @endif

    @if($isLoggingOut)
        <x-filament::loading-indicator />
    @endif
</div>
@endvolt
```

#### Pagina Folio
```blade
<?php
use function Laravel\Folio\{middleware, name};
use function Livewire\Volt\{state, mount};

middleware(['auth']);
name('auth.logout');

state([
    'isLoggingOut' => false,
    'success' => false,
    'error' => false,
]);

$logout = function () {
    try {
        $this->isLoggingOut = true;
        // Logica di logout
        $this->success = true;
    } catch (\Exception $e) {
        $this->error = true;
    }
    $this->isLoggingOut = false;
};
?>

<x-layouts.main>
    <x-slot name="title">
        {{ __('auth.logout.title') }}
    </x-slot>

    <div>
        @if($success)
            <!-- Success state -->
        @elseif($error)
            <!-- Error state -->
        @else
            <!-- Default state -->
        @endif

        @if($isLoggingOut)
            <x-filament::loading-indicator />
        @endif
    </div>
</x-layouts.main>
```

### Best Practices

#### Gestione dello Stato
- Mantenere gli stati semplici e chiari
- Documentare gli stati e le loro transizioni
- Gestire correttamente gli errori
- Implementare stati di loading

#### Componenti
- Utilizzare la direttiva `@volt` per i componenti Volt
- Seguire la struttura standard
- Mantenere la separazione tra logica e presentazione
- Testare i componenti in isolamento

#### Cosa NON fare
- ❌ Omettere la direttiva `@volt` nei componenti Volt
- ❌ Mischiare logica di business con la presentazione
- ❌ Duplicare stati tra componenti
- ❌ Ignorare la gestione degli errori

#### Cosa fare
- ✅ Utilizzare la direttiva `@volt` per i componenti Volt
- ✅ Seguire la struttura standard per i componenti
- ✅ Gestire correttamente gli stati e le azioni
- ✅ Implementare la gestione degli errori
- ✅ Testare i componenti

## Componenti di Autenticazione

### User Dropdown
- Utilizzare `x-blocks.navigation.user-dropdown` per utenti autenticati
- Struttura standard:
  ```blade
  <x-blocks.navigation.user-dropdown :user="auth()->user()">
      <x-slot name="trigger">
          <x-filament::avatar
              src="{{ $user->profile_photo_url }}"
              alt="{{ $user->name }}"
          />
      </x-slot>
  </x-blocks.navigation.user-dropdown>
  ```

### Login Buttons
- Utilizzare `x-blocks.navigation.login-buttons` per utenti non autenticati
- Struttura standard:
  ```blade
  <x-blocks.navigation.login-buttons>
      <x-ui.button
          href="{{ route('login') }}"
          color="primary"
      >
          {{ __('auth.login.link') }}
      </x-ui.button>

      <x-ui.button
          href="{{ route('register') }}"
          color="secondary"
      >
          {{ __('auth.register.link') }}
      </x-ui.button>
  </x-blocks.navigation.login-buttons>
  ```

### Gestione dello Stato
- Utilizzare `@auth` e `@else` per gestire gli stati
- Esempio:
  ```blade
  @auth
      <x-blocks.navigation.user-dropdown :user="auth()->user()" />
  @else
      <x-blocks.navigation.login-buttons />
  @endauth
  ```

### Traduzioni
- Utilizzare il namespace `auth.` per le traduzioni
- Struttura standard:
  ```php
  return [
      'login' => [
          'title' => 'Login',
          'email' => 'Email',
          'password' => 'Password',
          'remember_me' => 'Remember me',
          'forgot_password' => 'Forgot password?',
          'submit' => 'Login',
          'link' => 'Login',
      ],
      'register' => [
          'title' => 'Register',
          'email' => 'Email',
          'password' => 'Password',
          'confirm_password' => 'Confirm password',
          'submit' => 'Register',
          'link' => 'Register',
      ],
      'logout' => [
          'title' => 'Logout',
          'confirm_message' => 'Are you sure you want to log out?',
          'success_title' => 'Logged out successfully',
          'success_message' => 'You have been logged out.',
          'error_title' => 'Error',
          'error_message' => 'An error occurred while logging out.',
          'confirm_button' => 'Logout',
          'cancel_button' => 'Cancel',
          'back_to_home' => 'Back to home',
          'try_again' => 'Try again',
      ],
      'user_dropdown' => [
          'manage_account' => 'Manage Account',
          'profile' => 'Profile',
          'settings' => 'Settings',
          'logout' => 'Logout',
      ],
  ];
  ```

### Best Practices

#### Componenti
- Mantenere la separazione tra stati autenticati e non
- Utilizzare i componenti appropriati
- Gestire correttamente le traduzioni
- Supportare il tema scuro

#### Traduzioni
- Utilizzare chiavi semantiche
- Mantenere la coerenza nella struttura
- Documentare le traduzioni
- Testare in tutte le lingue

#### Cosa NON fare
- ❌ Mischiare stati autenticati e non
- ❌ Duplicare logica di autenticazione
- ❌ Ignorare le traduzioni
- ❌ Ignorare il supporto per il tema scuro

#### Cosa fare
- ✅ Utilizzare i componenti appropriati
- ✅ Seguire la struttura standard
- ✅ Gestire correttamente le traduzioni
- ✅ Testare in entrambi gli stati
