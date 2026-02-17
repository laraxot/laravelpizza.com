# LoginWidget Filament Schema JavaScript Errors - Roadmap

**Data**: 2025-01-22
**Status**: 🔄 In Progress
**Errore**: Multiple JavaScript errors
**File**: `app/Filament/Widgets/Auth/LoginWidget.php`

---

## 📋 Errori Identificati

### 1. Filament Schema JavaScript Non Definito
```
Uncaught ReferenceError: filamentSchema is not defined
Uncaught ReferenceError: filamentSchemaComponent is not defined
```

**Causa**: Gli script Filament Schema non sono caricati correttamente o non sono disponibili nel contesto frontend.

### 2. Livewire wire:model Error
```
[wire:model="remember"] property does not exist on component: [modules.user.filament.widgets.auth.login-widget]
```

**Causa**: La proprietà `remember` non è inizializzata in `$this->data`.

### 3. Asset 404 Errors
```
GET http://127.0.0.1:8001/images/logo.svg 404 (Not Found)
GET http://127.0.0.1:8001/themes/Meetup/site.webmanifest 404 (Not Found)
```

**Causa**: Asset mancanti (non critico per il funzionamento).

### 4. Cookie Consent Error
```
Uncaught ReferenceError: $dispatch is not defined
```

**Causa**: Alpine.js non caricato correttamente o versione incompatibile.

---

## 🔍 Analisi del Problema

### Widget Structure
Il `LoginWidget` estende `XotBaseWidget` che usa `Filament\Schemas\Schema` (Filament 4).

**Problema Principale**:
- `XotBaseWidget::form()` usa `Schema` che richiede JavaScript `filamentSchema` e `filamentSchemaComponent`
- Questi script sono disponibili solo nel contesto Filament Panel, NON nel frontend pubblico
- Il widget viene usato in una pagina pubblica (`/login`) che non è un Filament Panel

### Layout Analysis
```blade
<!-- Themes/Meetup/resources/views/components/layouts/main.blade.php -->
<body>
    {{ $slot }}
    @filamentStyles
    @livewireStyles
    @livewireScripts
    @filamentScripts  <!-- ⚠️ Questi script potrebbero non includere Schema JS -->
</body>
```

**Problema**: `@filamentScripts` include gli script base di Filament, ma potrebbe non includere gli script Schema necessari per i widget usati fuori dal panel.

---

## ✅ Soluzioni Proposte

### Soluzione 1: Inizializzare $this->data nel Widget (PRIORITÀ ALTA) ✅ IMPLEMENTATO

**Problema**: `$this->data` non è inizializzato con le chiavi necessarie (`email`, `password`, `remember`).

**Fix Implementato**: Modificato `XotBaseWidget::form()` per inizializzare automaticamente quando non c'è modello:

```php
private function initializeFormData(): void
{
    $data = $this->getFormFill();
    if (empty($data)) {
        $data = $this->getDefaultFormData();
    }
    $this->data = $data;
}

private function getDefaultFormData(): array
{
    $schemaKeys = array_keys($this->getFormSchema());
    $data = [];
    foreach ($schemaKeys as $key) {
        $keyString = is_string($key) ? $key : (string) $key;
        if ($this->isCheckboxField($keyString)) {
            $data[$keyString] = false;  // Checkbox default: false
        } else {
            $data[$keyString] = null;   // Altri campi default: null
        }
    }
    return $data;
}
```

**Risultato**:
- ✅ `$this->data` viene inizializzato automaticamente con tutte le chiavi dello schema
- ✅ Checkbox (remember, accept, agree) hanno default `false`
- ✅ Altri campi hanno default `null`
- ✅ PHPStan Level 10 compliant
- ✅ PHPMD compliant (complessità ridotta estraendo metodi)

### Soluzione 2: Verificare Caricamento Script Filament Schema (PRIORITÀ MEDIA)

**Problema**: Script `filamentSchema` e `filamentSchemaComponent` non disponibili.

**Fix**: Verificare che `@filamentScripts` includa gli script Schema. Se non li include, aggiungere manualmente:

```blade
@filamentScripts
@push('scripts')
    <script src="{{ asset('vendor/filament/schemas/schemas.js') }}"></script>
@endpush
```

**Oppure** usare Form tradizionale invece di Schema per widget frontend.

### Soluzione 3: Usare Form invece di Schema per Widget Frontend (PRIORITÀ BASSA)

**Problema**: Schema è pensato per Filament Panel, non per frontend pubblico.

**Fix**: Creare una versione del widget che usa `Form` invece di `Schema` per uso frontend.

---

## 📝 Piano di Implementazione

### Fase 1: Fix Immediato - Inizializzazione Dati ✅
- [x] Aggiungere inizializzazione `$this->data` in `XotBaseWidget::form()` (non in mount)
- [x] Verificare che tutte le chiavi dello schema siano presenti
- [x] Gestire correttamente valori default (false per checkbox, null per altri)
- [x] PHPStan Level 10 compliance

### Fase 2: Verifica Script Filament
- [ ] Verificare cosa include `@filamentScripts`
- [ ] Controllare se gli script Schema sono disponibili
- [ ] Se non disponibili, valutare alternativa (Form vs Schema)

### Fase 3: Fix Asset 404 (Opzionale)
- [ ] Creare/verificare logo.svg
- [ ] Creare/verificare site.webmanifest

### Fase 4: Fix Cookie Consent (Opzionale)
- [ ] Verificare versione Alpine.js
- [ ] Aggiornare cookie-consent.js se necessario

---

## 🔗 Riferimenti

- [Widgets Initialization](./../Xot/docs/widgets-initialization.md)
- [Login Widget Fix](./login-widget-fix.md)
- [Filament 4 Widget Rendering Guide](./filament-4-widget-rendering-guide.md)

---

## 📊 Progresso

| Fase | Status | Note |
|------|--------|------|
| Analisi | ✅ | Errori identificati |
| Fix Dati | ✅ | Inizializzazione aggiunta in XotBaseWidget::form() |
| Verifica PHPStan | ✅ | Nessun errore |
| Verifica PHPMD | ✅ | Nessun errore |
| Verifica PHPInsights | ✅ | Warning pre-esistenti |
| Verifica Script | ⏳ | Da verificare nel browser |
| Fix Asset | ⏳ | Opzionale |
| Fix Cookie | ⏳ | Opzionale |

---

**Ultimo aggiornamento**: 2025-01-22
**Versione**: 1.0.0
