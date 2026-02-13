# Analisi Dettagliata di LoginWidget

**File**: `Modules/User/app/Filament/Widgets/LoginWidget.php`
**Namespace**: `Modules\User\Filament\Widgets`

## Estensione e Imports
- Estende `XotBaseWidget`.
- Import attuali:
  - `Filament\Forms\Components\TextInput`
  - `Filament\Forms\Components\Checkbox`
  - `Filament\Forms\Components\Actions\Button`
  - `Illuminate\Support\Facades\Auth`
  - `Illuminate\Validation\ValidationException`

## Metodo getFormSchema()
- Inizialmente definito come `public static function getFormSchema(): array`.
  - **Issue**: firma statica non compatibile con l’astrazione di `XotBaseWidget`, che richiede un metodo d’istanza `public function getFormSchema(): array`.
  - Motivo: PHP non permette di sovrascrivere un metodo di istanza con uno statico.
- Restituisce array associativo con componenti.
  - Chiavi stringa ok per PHPStan.
- **Mancanza**: manca il pulsante di submit per invocare `authenticate`.

## Autenticazione
- Metodo `authenticate(array $data): void`.
  - **Issue**: accetta `$data` come parametro; Filament Widgets preferiscono usare `$this->form->getState()`.
- Non chiama `session()->regenerate()` dopo login.
- Manca integrazione `WithRateLimiting` per proteggere da brute-force.
- Gestione errori via `ValidationException`, ma si può migliorare con `Notification::make()`.

## Miglioramenti Proposti
1. Correggere import di Button:
   ```php
   use Filament\Forms\Components\Actions\Button;
   ```
2. Rimuovere la parola chiave `static` e allineare la firma all’astrazione:
   ```php
   public function getFormSchema(): array { ... }
   ```
3. Aggiungere pulsante di submit nello schema:
   ```php
   Button::make('authenticate')
       ->label(__('Login'))
       ->action('authenticate')
       ->primary(),
   ```
4. Implementare `mount()` per inizializzare lo stato del form:
   ```php
   public function mount(): void {
       $this->form->fill([]);
   }
   ```
5. Usare `$this->form->getState()` dentro `authenticate()`, rimuovendo il parametro `$data`.
6. Aggiungere `session()->regenerate()` dopo `Auth::attempt()`:
   ```php
   if (Auth::attempt($credentials, $remember)) {
       session()->regenerate();
       //...
   }
   ```
7. Integrare trait `WithRateLimiting` per throttle:
   ```php
   use DanHarrin\LivewireRateLimiting\WithRateLimiting;
   class LoginWidget extends XotBaseWidget {
       use WithRateLimiting;
       //...
   }
   ```
8. Utilizzare `Notification::make()->danger()` per messaggi utente-friendly.

## Collegamenti
- [WIDGETS_STRUCTURE.md](../WIDGETS_STRUCTURE.md) — Regole di struttura per widget Filament nel modulo User.
- [filament_best_practices.md](filament_best_practices.md) — Best practices per risorse Filament.
- [login-widget-conversion.md](login-widget-conversion.md) — Conversione del componente Livewire a LoginWidget.
# Analisi Dettagliata di LoginWidget

**File**: `Modules/User/app/Filament/Widgets/LoginWidget.php`
**Namespace**: `Modules\User\Filament\Widgets`

## Estensione e Imports
- Estende `XotBaseWidget`.
- Import attuali:
  - `Filament\Forms\Components\TextInput`
  - `Filament\Forms\Components\Checkbox`
  - `Filament\Forms\Components\Actions\Button`
  - `Illuminate\Support\Facades\Auth`
  - `Illuminate\Validation\ValidationException`

## Metodo getFormSchema()
- Inizialmente definito come `public static function getFormSchema(): array`.
  - **Issue**: firma statica non compatibile con l’astrazione di `XotBaseWidget`, che richiede un metodo d’istanza `public function getFormSchema(): array`.
  - Motivo: PHP non permette di sovrascrivere un metodo di istanza con uno statico.
- Restituisce array associativo con componenti.
  - Chiavi stringa ok per PHPStan.
- **Mancanza**: manca il pulsante di submit per invocare `authenticate`.

## Autenticazione
- Metodo `authenticate(array $data): void`.
  - **Issue**: accetta `$data` come parametro; Filament Widgets preferiscono usare `$this->form->getState()`.
- Non chiama `session()->regenerate()` dopo login.
- Manca integrazione `WithRateLimiting` per proteggere da brute-force.
- Gestione errori via `ValidationException`, ma si può migliorare con `Notification::make()`.

## Miglioramenti Proposti
1. Correggere import di Button:
   ```php
   use Filament\Forms\Components\Actions\Button;
   ```
2. Rimuovere la parola chiave `static` e allineare la firma all’astrazione:
   ```php
   public function getFormSchema(): array { ... }
   ```
3. Aggiungere pulsante di submit nello schema:
   ```php
   Button::make('authenticate')
       ->label(__('Login'))
       ->action('authenticate')
       ->primary(),
   ```
4. Implementare `mount()` per inizializzare lo stato del form:
   ```php
   public function mount(): void {
       $this->form->fill([]);
   }
   ```
5. Usare `$this->form->getState()` dentro `authenticate()`, rimuovendo il parametro `$data`.
6. Aggiungere `session()->regenerate()` dopo `Auth::attempt()`:
   ```php
   if (Auth::attempt($credentials, $remember)) {
       session()->regenerate();
       //...
   }
   ```
7. Integrare trait `WithRateLimiting` per throttle:
   ```php
   use DanHarrin\LivewireRateLimiting\WithRateLimiting;
   class LoginWidget extends XotBaseWidget {
       use WithRateLimiting;
       //...
   }
   ```
8. Utilizzare `Notification::make()->danger()` per messaggi utente-friendly.

## Collegamenti
- [WIDGETS_STRUCTURE.md](../WIDGETS_STRUCTURE.md) — Regole di struttura per widget Filament nel modulo User.
- [filament_best_practices.md](filament_best_practices.md) — Best practices per risorse Filament.
- [login-widget-conversion.md](login-widget-conversion.md) — Conversione del componente Livewire a LoginWidget.
