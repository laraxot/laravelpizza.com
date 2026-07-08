# Container Loop Prevention

## Root Cause Analysis (RCA)

### Sintomo Ricorrente
```
[ERROR] Maximum execution time of 120 seconds exceeded
at Illuminate/Container/Container.php:1504
```

**Quando**: Accesso a `/it/tests/segnalazione-crea` dopo modifiche a widget/views

### Catena di Eventi

```
Accesso pagina
    ↓
@livewire(CreateTicketWizardWidget::class)
    ↓
XotBaseWidget::__construct() → $this->resolveView()
    ↓
GetViewByClassAction → view()->exists()
    ↓
Compiled View Cache CORROTTO (null bytes)
    ↓
Container retry → loop infinito
    ↓
Maximum execution time exceeded (120s)
```

### Root Cause

**NON è una dipendenza circolare nel codice** (che sarebbe permanente e riproducibile).

È causato da **compiled view cache corrotto**:
- File in `storage/framework/views/` con contenuto invalido
- Path con null bytes (`\0`)
- ViewFinder entra in retry loop
- Container non ha timeout interno → muore dopo 120s

### Evidenze Sperimentali

| Test | Risultato | Tempo |
|------|-----------|-------|
| Container base | ✅ OK | < 1s |
| `new CreateTicketWizardWidget()` | ✅ OK | < 1s |
| `$widget->mount()` | ✅ OK | < 1s |
| `$widget->getFormSchema()` con cache corrotto | ❌ null bytes error | - |
| Dopo `php artisan view:clear` | ✅ OK (page 200) | < 5s |

**Conclusione**: Il loop è **effimero** (cache corrotta), non strutturale.

---

## Zen: "Il cache è una bugia ottimizzata"

Il sistema di cache di Laravel è un'**ottimizzazione**, non una fonte di verità.

```
Fonte di verità     → Blade files (.blade.php)
Ottimizzazione      → Compiled views (.php in storage/framework/views)
Quando si corrompe  → L'ottimizzazione diventa una bugia
Soluzione           → Invalidare e rigenerare
```

### Religione: "Ogni cache DEVE essere invalidabile"

Dopo OGNI modifica a:
- Blade views
- Service Providers  
- Widget constructors
- View resolution logic

→ **ESEGUIRE** `php artisan view:clear`

---

## Prevenzione — 3 Livelli di Difesa

### Livello 1: Lazy View Resolution

**PROBLEMA**: `resolveView()` nel costruttore è costoso e fragile

```php
// ❌ SBAGLIATO: nel costruttore
public function __construct()
{
    $this->resolveView();
}

// ✅ CORRETTO: lazy resolution
public function getView(): string
{
    if ($this->view === 'xot::filament.widgets.base') {
        try {
            $this->view = app(GetViewByClassAction::class)->execute(static::class);
        } catch (\Throwable $e) {
            $this->view = 'xot::filament.widgets.base';
            if (app()->isLocal()) {
                throw $e;
            }
        }
    }
    return $this->view;
}
```

### Livello 2: Auto-Healing Hook

**PROBLEMA**: Cache corrotto non viene validato prima dell'uso

```php
// In AppServiceProvider.php o bootstrap/app.php
if (app()->isLocal()) {
    View::creator('*', function ($view) {
        $path = $view->getPath();
        if ($path && is_string($path) && strpos($path, "\0") !== false) {
            \Log::error('[View] Corrupted compiled view detected', ['path' => $path]);
            \Artisan::call('view:clear');
        }
    });
}
```

### Livello 3: Pre-Commit Hook

**PROBLEMA**: Dev dimentica di clearare cache dopo modifiche

```bash
# In bashscripts/pre-commit (aggiungere)
echo "Clearing compiled views..."
php artisan view:clear
php artisan optimize:clear
```

---

## Politiche di Progetto

### 1. Costruttori Leggeri

I costruttori di widget NON devono:
- Chiamare `app()` o `resolve()` per servizi complessi
- Fare I/O (file, database, network)
- Entrare in sistemi di cache non validati

**Devono**:
- Inizializzare proprietà con valori default
- Delegare risoluzione a metodi lazy

### 2. Timeout di Sicurezza

Ogni render di widget dovrebbe monitorare il tempo:

```php
public function render(): View
{
    $start = microtime(true);
    $result = view($this->getView(), $data);
    $elapsed = round(microtime(true) - $start, 2);
    
    if ($elapsed > 5.0) {
        \Log::warning('[Widget] Slow render', [
            'widget' => static::class,
            'elapsed' => $elapsed . 's',
        ]);
    }
    
    return $result;
}
```

### 3. Clear Cache Post-Modifica

**Regola**: Dopo modifiche a widget/view, SEMPRE eseguire:

```bash
php artisan view:clear
php artisan optimize:clear
```

**Automazione**: Pre-commit hook lo fa automaticamente.

---

## Debugging Guide

### Se vedi "Maximum execution time exceeded"

1. **Prima azione**: `php artisan view:clear && php artisan optimize:clear`
2. **Testa**: `curl -s -o /dev/null -w "%{http_code}" --max-time 10 http://127.0.0.1:8000/it/tests/segnalazione-crea`
3. **Se ancora fallisce**: Controlla `storage/logs/laravel.log` per errori specifici
4. **Se errore "null bytes"**: Cache corrotto confermato → step 1 risolve

### Diagnostica Rapida

```bash
# Verifica se cache è corrotto
find laravel/storage/framework/views -name "*.php" -exec grep -l "\\\\0" {} \;

# Conta file compiled
ls -la laravel/storage/framework/views/*.php | wc -l

# Clear tutto
cd laravel && php artisan optimize:clear
```

---

## Riferimenti

| Documento | URL |
|-----------|-----|
| Lazy View Resolution | `./lazy-view-resolution.md` |
| XotBaseWidget | `../../app/Filament/Widgets/XotBaseWidget.php` |
| Story 7-43 | `_bmad-output/implementation-artifacts/7-43-prevent-container-loop-rca.md` |
| Laravel View Caching | https://laravel.com/docs/12.x/views#optimizing-views |

---

*Ultimo aggiornamento: 2026-04-14*
