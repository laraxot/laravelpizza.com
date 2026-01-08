# Blade Components Best Practices

## Gestione degli Attributi

### Errori Comuni

#### 1. Merge Ricorsivo di Attributi
```blade
❌ ERRATO
<section {{ $attributes->merge($attributes) }}>  {{-- Causa TypeError --}}

✅ CORRETTO
<section {{ $attributes->merge(['class' => 'default-class']) }}>
```

**Problema**: Il merge ricorsivo degli stessi attributi causa un TypeError perché:
- `$attributes` è già un oggetto `ComponentAttributeBag`
- Non si può fare merge di un `ComponentAttributeBag` con se stesso
- Causa un loop infinito di merge

### Pattern Corretti

#### 1. Merge con Array di Default
```blade
@props(['class' => ''])

<section {{ $attributes->merge(['class' => 'section '.$class]) }}>
    {{ $slot }}
</section>
```

#### 2. Merge con Classi Condizionali
```blade
@props(['type' => 'default'])

<section {{ $attributes->merge([
    'class' => 'section '.($type === 'primary' ? 'bg-primary' : 'bg-default')
]) }}>
    {{ $slot }}
</section>
```

#### 3. Gestione Props Multiple
```blade
@props([
    'title' => null,
    'description' => null,
    'class' => ''
])

<section {{ $attributes->merge([
    'class' => 'section '.$class,
    'role' => 'region',
    'aria-label' => $title
]) }}>
    @if($title)
        <h2>{{ $title }}</h2>
    @endif
    
    @if($description)
        <p>{{ $description }}</p>
    @endif
    
    {{ $slot }}
</section>
```

## Best Practices

### 1. Definizione Props
```blade
{{-- Definire sempre tutte le props all'inizio --}}
@props([
    'name' => null,
    'blocks' => [],
    'class' => ''
])
```

### 2. Validazione Props
```php
class Section extends Component
{
    public function __construct(
        public ?string $name = null,
        public array $blocks = [],
        public string $class = ''
    ) {
        // Validazione
        if (!empty($blocks)) {
            foreach ($blocks as $block) {
                if (!isset($block['type'])) {
                    throw new InvalidArgumentException('Each block must have a type');
                }
            }
        }
    }
}
```

### 3. Organizzazione Template
```blade
{{-- 1. Props --}}
@props(['name' => null])

{{-- 2. Preparazione Dati --}}
@php
$hasHeader = !empty($name);
@endphp

{{-- 3. Template Structure --}}
<section {{ $attributes->merge(['class' => 'section']) }}>
    {{-- 4. Sezioni Condizionali --}}
    @if($hasHeader)
        <header>{{ $name }}</header>
    @endif
    
    {{-- 5. Contenuto Principale --}}
    <div class="section-content">
        {{ $slot }}
    </div>
</section>
```

## Testing

### 1. Unit Tests
```php
public function test_section_renders_with_attributes()
{
    $view = $this->blade(
        '<x-section class="custom-class" id="test" />'
    );
    
    $view->assertSee('class="section custom-class"', false);
    $view->assertSee('id="test"', false);
}
```

### 2. Integration Tests
```php
public function test_section_renders_blocks()
{
    $blocks = [
        ['type' => 'text', 'content' => 'Test']
    ];
    
    $view = $this->blade(
        '<x-section :blocks="$blocks" />',
        ['blocks' => $blocks]
    );
    
    $view->assertSee('Test');
}
```

## Collegamenti
- [Documentazione Blade](https://laravel.com/docs/blade)
- [Section Component](section-component.md)
- [Documentazione Root](../../../../docs/components.md) 
