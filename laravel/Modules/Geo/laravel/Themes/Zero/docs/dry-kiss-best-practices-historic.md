# DRY & KISS Best Practices - Tema Zero

**Data:** 15 Ottobre 2025  
**Tipo:** Best Practices & Guidelines  
**Stato:** ✅ Completato

## 📚 Principi Fondamentali

### DRY (Don't Repeat Yourself)
- Non duplicare codice tra componenti
- Riutilizzare componenti esistenti
- Centralizzare logica comune nei layouts

### KISS (Keep It Simple, Stupid)
- Preferire semplicità a complessità
- Un componente = una responsabilità
- Evitare over-engineering

## 🎨 Struttura del Tema

```
Themes/Zero/
├── resources/
│   ├── views/          # Blade templates
│   │   ├── layouts/    # Layout base
│   │   ├── components/ # Componenti riutilizzabili
│   │   └── pages/      # Pagine specifiche
│   └── lang/           # Traduzioni
├── public/             # Assets compilati
├── docs/               # Documentazione
└── theme.json          # Configurazione tema
```

## ✅ Best Practices Attuali

### 1. **Layouts Centralizzati**
- Layout base riutilizzato da tutte le pagine
- Header/Footer componentizzati
- Navigazione centralizzata

### 2. **Componenti Blade Riutilizzabili**
- Componenti atomici (button, input, card)
- Componenti molecolari (form, table)
- Componenti organici (dashboard widgets)

### 3. **Traduzioni Centralizzate**
- File lang per ogni feature
- Nessun testo hardcoded nei template
- Supporto multi-lingua

## 📋 Raccomandazioni DRY/KISS

### ✅ DO - Pattern Raccomandati

#### 1. Riutilizzare Componenti
```blade
{{-- ✅ CORRETTO: Riutilizza componente esistente --}}
<x-zero::button variant="primary">
    Salva
</x-zero::button>

{{-- ❌ SBAGLIATO: HTML duplicato --}}
<button class="px-4 py-2 bg-blue-500 text-white rounded">
    Salva
</button>
```

#### 2. Layout Inheritance
```blade
{{-- ✅ CORRETTO: Estende layout base --}}
@extends('zero::layouts.app')

@section('content')
    <!-- Contenuto pagina -->
@endsection

{{-- ❌ SBAGLIATO: HTML layout duplicato --}}
<!DOCTYPE html>
<html>
    <head>...</head>
    <body>
        <!-- HTML completo duplicato -->
    </body>
</html>
```

#### 3. Traduzioni Centralizzate
```blade
{{-- ✅ CORRETTO: Usa file di traduzione --}}
<h1>@lang('zero::pages.dashboard.title')</h1>

{{-- ❌ SBAGLIATO: Testo hardcoded --}}
<h1>Dashboard</h1>
```

#### 4. Componenti Parametrizzati
```blade
{{-- ✅ CORRETTO: Componente parametrizzato --}}
<x-zero::card 
    :title="$title" 
    :icon="$icon"
    :color="$color">
    {{ $slot }}
</x-zero::card>

{{-- ❌ SBAGLIATO: HTML ripetuto per ogni card --}}
<div class="bg-white rounded-lg shadow p-6">
    <h2>{{ $title }}</h2>
    <!-- ... -->
</div>
```

### ❌ DON'T - Anti-Pattern da Evitare

#### 1. Duplicazione HTML
```blade
{{-- ❌ Non ripetere strutture HTML identiche --}}
{{-- Crea un componente invece --}}
```

#### 2. Logica Business nei Template
```blade
{{-- ❌ SBAGLIATO: Logica complessa nel template --}}
@php
    $total = 0;
    foreach ($items as $item) {
        $total += $item->price * $item->quantity;
    }
@endphp

{{-- ✅ CORRETTO: Logica nel ViewModel o Component --}}
{{ $cart->total }}
```

#### 3. CSS Inline Ripetuto
```blade
{{-- ❌ SBAGLIATO: Style duplicati --}}
<div style="padding:20px; margin:10px; border:1px solid #ccc">

{{-- ✅ CORRETTO: Classi Tailwind o componente --}}
<div class="p-5 m-2.5 border border-gray-300">
{{-- O meglio: --}}
<x-zero::container>
```

## 🎨 Componenti Tema Zero

### Componenti Atomici (Livello 1)
- `button` - Pulsanti
- `input` - Campi input
- `select` - Select dropdown
- `checkbox` - Checkbox
- `icon` - Icone
- `badge` - Badge/Tag

### Componenti Molecolari (Livello 2)
- `card` - Card container
- `form-field` - Campo form con label ed errori
- `table` - Tabelle dati
- `modal` - Modali
- `dropdown` - Menu dropdown

### Componenti Organici (Livello 3)
- `header` - Header applicazione
- `footer` - Footer applicazione
- `sidebar` - Sidebar navigazione
- `navigation` - Menu navigazione
- `breadcrumbs` - Breadcrumb trail

## 📝 Checklist Sviluppo Tema

### Prima di Creare Nuovo Componente
- [ ] Esiste già un componente simile?
- [ ] Può essere parametrizzato un componente esistente?
- [ ] Il componente è riutilizzabile in altri contesti?
- [ ] Ha una sola responsabilità?

### Durante lo Sviluppo
- [ ] HTML semantico e accessibile
- [ ] Classi Tailwind invece di CSS custom
- [ ] Props ben documentati
- [ ] Slot per massima flessibilità
- [ ] Esempi di utilizzo nel PHPDoc

### Dopo lo Sviluppo
- [ ] Testato in vari contesti
- [ ] Documentato in docs/components.md
- [ ] Esempi di utilizzo forniti
- [ ] Verificata accessibilità

## 🔧 Configurazione DRY

### theme.json
```json
{
    "name": "Zero",
    "description": "Tema base per applicazioni Laraxot",
    "version": "1.0.0",
    "components": {
        "prefix": "zero",
        "directory": "resources/views/components"
    },
    "layouts": {
        "default": "layouts.app",
        "auth": "layouts.guest"
    }
}
```

## 📊 Metriche Qualità Tema

| Metrica | Target | Attuale | Status |
|---------|--------|---------|--------|
| Componenti Riutilizzabili | >30 | TBD | 🔄 |
| Duplicazione HTML | <5% | TBD | 🔄 |
| Traduzioni Hardcoded | 0 | TBD | 🔄 |
| Accessibilità (WCAG) | AA | TBD | 🔄 |

## 🔗 Risorse

- [Architecture](./architecture.md) - Architettura tema
- [Components](./components.md) - Lista componenti disponibili
- [Layouts](./layouts.md) - Layouts disponibili
- [Customization](./customization.md) - Guida personalizzazione

---

**Ultimo Aggiornamento:** 15 Ottobre 2025  
**Autore:** Team Laraxot  
**Versione:** 1.0

