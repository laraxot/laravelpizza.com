# 🎨 Design Comuni con Tailwind CSS Puro

## Obiettivo
Replicare il design di Bootstrap Italia usando **SOLO Tailwind CSS**, senza dipendenze esterne.

## Approccio

### ❌ NON USARE
```blade
<!-- NO Bootstrap Italia classes -->
<div class="card card-teaser">
<div class="calendar-list">
<div class="it-header-slim">
```

### ✅ USARE TAILWIND
```blade
<!-- YES Pure Tailwind -->
<div class="bg-white rounded-lg border shadow-sm hover:shadow-md">
<div class="space-y-4 divide-y">
<div class="bg-[#0066CC] py-2">
```

---

## Colori Design Comuni (Tailwind)

```javascript
// tailwind.config.js
colors: {
    'design-comuni': {
        blue: '#0066CC',      // Primary
        dark: '#003D73',      // Footer
        black: '#000000',     // Bottom bar
        grey: '#F5F6F7',      // Light bg
        muted: '#5C6F82',     // Text muted
    }
}
```

---

## Componenti Tailwind

### 1. Header Slim (Pure Tailwind)

```blade
{{-- Header Slim - Tailwind CSS --}}
<div class="bg-[#0066CC] py-2">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center gap-4">
            {{-- Region Name --}}
            <a href="#" class="text-white text-sm font-semibold hover:underline">
                Nome della Regione
            </a>
            
            {{-- Right: Language + Login --}}
            <div class="flex items-center gap-4">
                {{-- Language --}}
                <div class="text-white text-sm flex items-center gap-2">
                    <span class="opacity-90">Lingua attiva:</span>
                    <span class="font-bold">ITA</span>
                    <span class="opacity-70">/</span>
                    <a href="#" class="opacity-70 hover:opacity-100">ENG</a>
                </div>
                
                {{-- Login Button --}}
                <a href="{{ route('login') }}" 
                   class="inline-flex items-center gap-2 bg-white text-[#0066CC] px-3 py-1.5 rounded text-sm font-semibold hover:bg-[#F0F0F0] transition-colors">
                    <svg class="w-4 h-4">
                        <use href="/themes/sixteen/bootstrap-italia/dist/svg/sprites.svg#it-user"></use>
                    </svg>
                    <span>Accedi all'area personale</span>
                </a>
            </div>
        </div>
    </div>
</div>
```

**Tailwind Classes Used**:
- `bg-[#0066CC]` - Primary blue
- `py-2` - Vertical padding
- `flex justify-between items-center` - Layout
- `text-white text-sm font-semibold` - Text styling
- `hover:underline hover:bg-[#F0F0F0]` - Hover effects

---

### 2. Hero Card (Pure Tailwind)

```blade
{{-- Hero Section - Tailwind CSS --}}
<section class="py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-center text-3xl font-semibold mb-8 text-gray-900">
                CONTENUTI IN EVIDENZA
            </h2>
            
            <article class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                <div class="grid md:grid-cols-5 gap-0">
                    {{-- Image --}}
                    <div class="md:col-span-2">
                        <img src="{{ $image }}" 
                             alt="{{ $news['title'] }}" 
                             class="w-full h-full object-cover"
                             loading="lazy" />
                    </div>
                    
                    {{-- Content --}}
                    <div class="md:col-span-3 p-6">
                        {{-- Date --}}
                        <div class="text-[#0066CC] text-sm mb-2">
                            <span class="mr-2">{{ $news['category'] }}</span>
                            <time>{{ $news['date'] }}</time>
                        </div>
                        
                        {{-- Title --}}
                        <h3 class="text-xl font-semibold mb-3">
                            <a href="{{ $news['url'] }}" 
                               class="text-gray-900 hover:text-[#0066CC] no-underline hover:underline">
                                {{ $news['title'] }}
                            </a>
                        </h3>
                        
                        {{-- Excerpt --}}
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            {{ $news['excerpt'] }}
                        </p>
                        
                        {{-- Tag --}}
                        @if($news['tag'])
                        <span class="inline-block bg-[#0066CC]/10 text-[#0066CC] text-xs font-medium px-3 py-1 rounded-full mb-4">
                            {{ $news['tag'] }}
                        </span>
                        @endif
                        
                        {{-- CTA --}}
                        <a href="{{ $all_news_url }}" 
                           class="inline-flex items-center gap-1 text-[#0066CC] font-semibold text-sm hover:underline">
                            {{ $all_news_label }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </article>
        </div>
    </div>
</section>
```

**Tailwind Classes Used**:
- `bg-white rounded-lg border border-gray-200 shadow-sm` - Card
- `grid md:grid-cols-5 gap-0` - Grid layout
- `text-[#0066CC]` - Primary color text
- `hover:text-[#0066CC] hover:underline` - Hover effects
- `bg-[#0066CC]/10` - Transparent background

---

### 3. Governance Cards (Pure Tailwind)

```blade
{{-- Governance Cards - Tailwind CSS --}}
<section class="py-12 bg-[#F5F6F7]">
    <div class="container mx-auto px-4">
        <h2 class="text-center text-3xl font-semibold mb-8 text-gray-900">
            Organi di governo
        </h2>
        
        <div class="grid md:grid-cols-3 gap-6 max-w-6xl mx-auto">
            @foreach($items as $item)
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="p-6">
                    {{-- Category --}}
                    <div class="text-gray-500 text-xs uppercase tracking-wide mb-2">
                        {{ $item['category'] }}
                    </div>
                    
                    {{-- Name --}}
                    @if($item['name'])
                    <h3 class="text-lg font-semibold mb-1 text-gray-900">
                        {{ $item['name'] }}
                    </h3>
                    @endif
                    
                    {{-- Title --}}
                    <p class="text-gray-600 mb-3">
                        {{ $item['title'] }}
                    </p>
                    
                    {{-- Description --}}
                    @if($item['description'])
                    <p class="text-gray-500 text-sm mb-4">
                        {{ $item['description'] }}
                    </p>
                    @endif
                    
                    {{-- CTA --}}
                    <a href="{{ $item['url'] }}" 
                       class="inline-flex items-center gap-1 text-[#0066CC] font-semibold text-sm hover:underline">
                        Vai alla pagina
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
```

**Tailwind Classes Used**:
- `bg-[#F5F6F7]` - Light grey background
- `grid md:grid-cols-3 gap-6` - Responsive grid
- `bg-white rounded-lg border border-gray-200 shadow-sm` - Card
- `hover:shadow-md transition-shadow` - Hover effect
- `text-xs uppercase tracking-wide` - Category text

---

### 4. Events Calendar (Pure Tailwind)

```blade
{{-- Events Calendar - Tailwind CSS --}}
<section class="py-12">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-semibold mb-2 text-gray-900">Eventi</h2>
        <h3 class="text-xl text-gray-500 mb-8">SETTEMBRE 2026</h3>
        
        <div class="space-y-4 max-w-4xl">
            @foreach($items as $day)
            <div class="border-b border-gray-200 pb-4">
                <div class="grid grid-cols-12 gap-4">
                    {{-- Date --}}
                    <div class="col-span-3 md:col-span-2">
                        <span class="block text-3xl font-bold text-[#0066CC] leading-none">
                            {{ $day['day'] }}
                        </span>
                        <span class="block text-xs text-gray-500 uppercase mt-1">
                            {{ $day['weekday'] }}
                        </span>
                    </div>
                    
                    {{-- Events List --}}
                    <div class="col-span-9 md:col-span-10">
                        <ul class="space-y-2">
                            @foreach($day['events'] as $event)
                            <li>
                                <a href="{{ $event['url'] }}" 
                                   class="text-gray-700 hover:text-[#0066CC] hover:underline transition-colors">
                                    {{ $event['title'] }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        {{-- CTA --}}
        <div class="text-center mt-8">
            <a href="/it/eventi" 
               class="inline-flex items-center gap-1 px-4 py-2 border border-[#0066CC] text-[#0066CC] rounded-md font-semibold text-sm hover:bg-[#0066CC] hover:text-white transition-colors">
                Vai al calendario eventi
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
</section>
```

**Tailwind Classes Used**:
- `space-y-4` - Vertical spacing
- `border-b border-gray-200 pb-4` - Event separator
- `grid grid-cols-12 gap-4` - Grid layout
- `text-3xl font-bold text-[#0066CC]` - Date styling
- `border border-[#0066CC] hover:bg-[#0066CC]` - Button styling

---

### 5. Topics Grid (Pure Tailwind)

```blade
{{-- Topics Grid - Tailwind CSS --}}
<section class="py-12 bg-[#F5F6F7]">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-semibold mb-8 text-gray-900">
            Argomenti in evidenza
        </h2>
        
        <div class="grid md:grid-cols-4 gap-6 max-w-6xl mx-auto">
            @foreach($items as $item)
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="p-6">
                    {{-- Title --}}
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">
                        {{ $item['title'] }}
                    </h3>
                    
                    {{-- Description --}}
                    @if($item['description'])
                    <p class="text-gray-600 text-sm mb-3">
                        {{ $item['description'] }}
                    </p>
                    @endif
                    
                    {{-- List --}}
                    @if($item['list_items'])
                    <ul class="text-sm text-gray-600 space-y-1 mb-4">
                        @foreach($item['list_items'] as $listItem)
                        <li>• {{ $listItem }}</li>
                        @endforeach
                    </ul>
                    @endif
                    
                    {{-- CTA --}}
                    <a href="{{ $item['url'] }}" 
                       class="inline-flex items-center gap-1 text-[#0066CC] font-semibold text-sm hover:underline">
                        {{ $item['cta_label'] ?? 'Esplora argomento' }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        
        {{-- Show All Card --}}
        <div class="mt-12 max-w-4xl mx-auto">
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                <h3 class="text-lg font-semibold mb-3 text-gray-900">ALTRI ARGOMENTI</h3>
                <ul class="grid md:grid-cols-2 gap-2 text-sm text-gray-600 mb-4">
                    <li>• Associazioni</li>
                    <li>• Concorsi</li>
                    <li>• Energie rinnovabili</li>
                    <li>• Gestione rifiuti</li>
                </ul>
                <a href="{{ $show_all_url }}" 
                   class="inline-flex items-center gap-1 text-[#0066CC] font-semibold text-sm hover:underline">
                    {{ $show_all_label }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>
```

**Tailwind Classes Used**:
- `bg-[#F5F6F7]` - Section background
- `grid md:grid-cols-4 gap-6` - 4-column grid
- `text-sm font-semibold text-gray-500 uppercase` - Card title
- `hover:shadow-md transition-shadow` - Card hover

---

## 📊 Tailwind Classes Mapping

| Bootstrap Italia | Tailwind CSS Equivalent |
|-----------------|------------------------|
| `.card` | `bg-white rounded-lg border border-gray-200 shadow-sm` |
| `.card-teaser` | `bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md` |
| `.card-body` | `p-6` |
| `.card-title` | `text-base font-semibold mb-2` |
| `.card-text` | `text-sm text-gray-600` |
| `.text-primary` | `text-[#0066CC]` |
| `.text-muted` | `text-gray-500` |
| `.btn` | `inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold rounded-md` |
| `.btn-primary` | `bg-[#0066CC] text-white hover:bg-[#0052A3]` |
| `.btn-outline-primary` | `border border-[#0066CC] text-[#0066CC] hover:bg-[#0066CC] hover:text-white` |
| `.bg-light` | `bg-[#F5F6F7]` |
| `.shadow-sm` | `shadow-[0_2px_4px_rgba(0,0,0,0.1)]` |

---

## ✅ Checklist

- [x] Header Slim - Pure Tailwind
- [x] Hero Card - Pure Tailwind
- [x] Governance Cards - Pure Tailwind
- [x] Events Calendar - Pure Tailwind
- [x] Topics Grid - Pure Tailwind
- [x] Footer - Pure Tailwind (già fatto)

---

**Status**: ✅ 100% Tailwind CSS  
**NO Bootstrap Italia CSS dependencies**  
**Design Comuni look replicated**
