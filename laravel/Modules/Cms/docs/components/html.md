# Componenti HTML

## Introduzione
I componenti HTML del modulo CMS seguono le best practices HTML5 e utilizzano tag semantici per garantire accessibilità e SEO.

## Struttura Base

### Layout Component
```php
<x-cms::layout>
    <x-slot name="header">
        <!-- Header content -->
    </x-slot>

    <main>
        <!-- Main content -->
    </main>

    <x-slot name="footer">
        <!-- Footer content -->
    </x-slot>
</x-cms::layout>
```

### Section Component
```php
<x-cms::section>
    <x-slot name="title">
        <h2>Titolo Sezione</h2>
    </x-slot>

    <div class="content">
        <!-- Section content -->
    </div>
</x-cms::section>
```

## Componenti Semantici

### Header Component
```php
<x-cms::header>
    <x-cms::logo />
    <x-cms::navigation />
    <x-cms::actions />
</x-cms::header>
```

### Navigation Component
```php
<x-cms::navigation>
    <x-cms::nav-item href="/home">Home</x-cms::nav-item>
    <x-cms::nav-item href="/about">Chi Siamo</x-cms::nav-item>
    <x-cms::nav-item href="/contact">Contatti</x-cms::nav-item>
</x-cms::navigation>
```

### Article Component
```php
<x-cms::article>
    <x-slot name="header">
        <h1>Titolo Articolo</h1>
        <x-cms::meta />
    </x-slot>

    <div class="content">
        <!-- Article content -->
    </div>

    <x-slot name="footer">
        <x-cms::tags />
        <x-cms::share />
    </x-slot>
</x-cms::article>
```

### Aside Component
```php
<x-cms::aside>
    <x-cms::widget title="Widget Title">
        <!-- Widget content -->
    </x-cms::widget>
</x-cms::aside>
```

### Footer Component
```php
<x-cms::footer>
    <x-cms::footer-nav />
    <x-cms::copyright />
    <x-cms::social-links />
</x-cms::footer>
```

## Best Practices

### 1. Accessibilità
- Utilizzare attributi ARIA appropriati
- Mantenere una struttura navigabile
- Fornire alternative testuali
- Supportare la navigazione da tastiera

### 2. SEO
- Utilizzare tag semantici
- Strutturare correttamente i contenuti
- Implementare meta tag
- Ottimizzare per i motori di ricerca

### 3. Performance
- Lazy loading per immagini
- Ottimizzazione del codice
- Caching appropriato
- Minimizzazione delle risorse

### 4. Manutenibilità
- Codice modulare
- Componenti riutilizzabili
- Documentazione chiara
- Testing automatizzato

## Esempi di Implementazione

### Page Layout
```php
<x-cms::layout>
    <x-cms::header>
        <x-cms::navigation :items="$menuItems" />
    </x-cms::header>

    <main>
        <x-cms::section>
            <x-cms::article :content="$pageContent" />
        </x-cms::section>

        <x-cms::aside>
            <x-cms::widget-area :widgets="$sidebarWidgets" />
        </x-cms::aside>
    </main>

    <x-cms::footer :data="$footerData" />
</x-cms::layout>
```

### Content Block
```php
<x-cms::content-block>
    <x-slot name="header">
        <h2>{{ $title }}</h2>
    </x-slot>

    {!! $content !!}

    <x-slot name="footer">
        <x-cms::meta :author="$author" :date="$date" />
    </x-slot>
</x-cms::content-block>
```

## Collegamenti
- [Elementi Semantici](../html/semantic.md)
- [Struttura Layout](../structure/layout.md)
- [Accessibilità](../accessibility/README.md) 
