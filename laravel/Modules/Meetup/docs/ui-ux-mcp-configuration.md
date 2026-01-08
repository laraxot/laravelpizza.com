# Configurazione MCP per UI/UX e Tailwind CSS

## 📋 Panoramica

Questo documento descrive la configurazione dei server MCP specifici per migliorare lo sviluppo UI/UX e l'utilizzo di Tailwind CSS nel progetto Laravel Pizza.

## 🎨 Server MCP per Design e UI/UX

### Server Essenziali

#### 1. **puppeteer**
**Scopo**: Automazione browser per testing visuale e screenshot.

**Utilizzo**:
- Screenshot automatici delle pagine
- Test responsive design
- Validazione layout
- Generazione mockup visuali
- Test end-to-end UI

**Configurazione**:
```json
{
  "puppeteer": {
    "command": "npx",
    "args": ["-y", "@modelcontextprotocol/server-puppeteer"]
  }
}
```

**Casi d'uso per Meetup**:
- Screenshot homepage e menu
- Test responsive su mobile/tablet/desktop
- Validazione componenti Tailwind
- Generazione documentazione visuale

### Server Consigliati (Opzionali)

#### 2. **filesystem** (già configurato)
**Utilizzo UI/UX**:
- Gestione file CSS/JS
- Modifica file Tailwind config
- Gestione assets tema
- Organizzazione componenti Blade

#### 3. **memory** (già configurato)
**Utilizzo UI/UX**:
- Memorizzare decisioni design
- Pattern UI riutilizzabili
- Palette colori scelte
- Componenti preferiti

#### 4. **fetch** (già configurato)
**Utilizzo UI/UX**:
- Scaricare risorse design
- Integrazione con API design tools
- Fetch esempi UI da repository
- Validazione URL risorse

## 🎯 Utilizzo per Tailwind CSS

### Configurazione Tailwind nel Progetto

Il progetto utilizza Tailwind CSS v4 con configurazione in:
- `laravel/resources/css/app.css` - Stili principali
- `laravel/vite.config.js` - Plugin Tailwind
- `laravel/Modules/User/resources/views/tailwind.config.js` - Configurazione tema

### Pattern Tailwind per Meetup

#### Componenti Base

```blade
{{-- Card Pizza --}}
<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
    <img src="{{ $pizza->image }}" alt="{{ $pizza->name }}" class="w-full h-48 object-cover">
    <div class="p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $pizza->name }}</h3>
        <p class="text-gray-600 mb-4">{{ $pizza->short_description }}</p>
        <div class="flex items-center justify-between">
            <span class="text-2xl font-bold text-primary-600">{{ number_format($pizza->price, 2) }}€</span>
            <button class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition-colors">
                Aggiungi
            </button>
        </div>
    </div>
</div>
```

#### Layout Responsive

```blade
{{-- Grid Responsive --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @foreach($pizzas as $pizza)
        @include('meetup::components.pizza-card', ['pizza' => $pizza])
    @endforeach
</div>
```

#### Utility Classes Personalizzate

```css
/* In app.css o tema specifico */
@layer utilities {
    .pizza-card {
        @apply bg-white rounded-lg shadow-md overflow-hidden transition-all duration-300;
    }
    
    .pizza-card:hover {
        @apply shadow-xl transform scale-105;
    }
    
    .btn-primary {
        @apply bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-700 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2;
    }
}
```

## 🎨 Best Practices UI/UX

### 1. Design System

**Colori**:
- Primary: `#0ea5e9` (blu)
- Secondary: `#64748b` (grigio)
- Success: `#10b981` (verde)
- Danger: `#ef4444` (rosso)
- Warning: `#f59e0b` (arancione)

**Tipografia**:
- Font principale: `Instrument Sans` o `Figtree`
- Heading: `font-bold`
- Body: `font-normal`
- Small: `text-sm`

**Spaziatura**:
- Container: `max-w-7xl mx-auto px-4 sm:px-6 lg:px-8`
- Section spacing: `py-12 md:py-16 lg:py-20`
- Card padding: `p-6`

### 2. Componenti Riutilizzabili

#### Button Variants

```blade
{{-- Primary Button --}}
<button class="btn-primary">Aggiungi al Carrello</button>

{{-- Secondary Button --}}
<button class="bg-gray-200 text-gray-800 px-6 py-3 rounded-lg font-semibold hover:bg-gray-300 transition-colors">
    Annulla
</button>

{{-- Outline Button --}}
<button class="border-2 border-primary-600 text-primary-600 px-6 py-3 rounded-lg font-semibold hover:bg-primary-50 transition-colors">
    Dettagli
</button>
```

#### Form Inputs

```blade
{{-- Text Input --}}
<input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">

{{-- Select --}}
<select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
    <option>Seleziona categoria</option>
</select>
```

### 3. Animazioni e Transizioni

```blade
{{-- Fade In --}}
<div class="animate-fade-in">
    <!-- Contenuto -->
</div>

{{-- Slide Up --}}
<div class="transform transition-all duration-300 translate-y-4 opacity-0 hover:translate-y-0 hover:opacity-100">
    <!-- Contenuto -->
</div>
```

## 🔧 Workflow con MCP

### 1. Sviluppo Componente

1. **Puppeteer**: Genera screenshot del componente
2. **Filesystem**: Salva componente in `Themes/Meetup/resources/views/components/`
3. **Memory**: Memorizza pattern utilizzato
4. **Fetch**: Cerca ispirazioni da design system esterni

### 2. Testing Responsive

1. **Puppeteer**: Screenshot a diverse risoluzioni
2. **Filesystem**: Salva screenshot in `docs/screenshots/`
3. **Memory**: Traccia problemi responsive risolti

### 3. Ottimizzazione Tailwind

1. **Filesystem**: Analizza classi utilizzate
2. **Memory**: Memorizza pattern ottimizzati
3. **Sequential-thinking**: Pianifica refactoring CSS

## 📚 Risorse Design

### Palette Colori

```javascript
// tailwind.config.js
colors: {
  primary: {
    50: '#f0f9ff',
    100: '#e0f2fe',
    200: '#bae6fd',
    300: '#7dd3fc',
    400: '#38bdf8',
    500: '#0ea5e9', // Main
    600: '#0284c7',
    700: '#0369a1',
    800: '#075985',
    900: '#0c4a6e',
  },
  pizza: {
    red: '#dc2626',    // Pomodoro
    green: '#16a34a',  // Basilico
    yellow: '#eab308', // Formaggio
    brown: '#92400e',  // Impasto
  }
}
```

### Breakpoints

```javascript
screens: {
  'sm': '640px',   // Mobile landscape
  'md': '768px',   // Tablet
  'lg': '1024px',  // Desktop
  'xl': '1280px',  // Large desktop
  '2xl': '1536px', // Extra large
}
```

## 🎯 Checklist UI/UX

### Design
- [ ] Palette colori definita
- [ ] Tipografia scelta
- [ ] Spaziatura consistente
- [ ] Icone selezionate
- [ ] Immagini ottimizzate

### Componenti
- [ ] Button variants
- [ ] Form inputs
- [ ] Cards
- [ ] Navigation
- [ ] Modals
- [ ] Alerts

### Responsive
- [ ] Mobile (< 640px)
- [ ] Tablet (640px - 1024px)
- [ ] Desktop (> 1024px)
- [ ] Test su dispositivi reali

### Accessibilità
- [ ] Contrasto colori WCAG AA
- [ ] Focus states visibili
- [ ] Keyboard navigation
- [ ] Screen reader friendly
- [ ] Alt text immagini

## 🔗 Collegamenti

- [Configurazione MCP Base](./mcp_configuration.md)
- [Architettura Tema](./theme_integration.md)
- [Documentazione Tailwind CSS](https://tailwindcss.com/docs)

## 📝 Note

- Usa sempre utility-first approach di Tailwind
- Evita CSS custom quando possibile
- Mantieni consistenza con design system
- Documenta componenti custom
- Testa su dispositivi reali

