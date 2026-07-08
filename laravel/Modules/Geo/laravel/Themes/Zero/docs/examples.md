# Esempi di Utilizzo - Tema Zero

## Panoramica

Questa sezione fornisce esempi pratici di come utilizzare il Tema Zero in diverse situazioni. Tutti gli esempi sono funzionanti e possono essere utilizzati come punto di partenza per i tuoi progetti.

## Pagina Home Completa

### File: `resources/views/pages/home.blade.php`

```blade
<x-layouts.main>
    <x-slot name="title">
        Home - {{ config('app.name', 'Laravel') }}
    </x-slot>
    
    <x-slot name="description">
        Benvenuto nella nostra applicazione. Scopri le nostre funzionalità e servizi.
    </x-slot>
    
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-20">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                Benvenuto nel Tema Zero
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-blue-100">
                Un tema Laravel moderno, pulito e personalizzabile
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#features" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition-colors">
                    Scopri di più
                </a>
                <a href="#contact" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors">
                    Contattaci
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">
                Caratteristiche Principali
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature Cards -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-800">Performance</h3>
                    <p class="text-gray-600">
                        Ottimizzato per velocità e efficienza, con caricamento rapido e rendering fluido.
                    </p>
                </div>
                <!-- Altri feature cards... -->
            </div>
        </div>
    </section>
</x-layouts.main>
```

## Dashboard Semplice

### File: `resources/views/pages/dashboard.blade.php`

```blade
<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-2 bg-blue-100 rounded-lg">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Utenti Totali</p>
                                <p class="text-2xl font-semibold text-gray-900">1,234</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-2 bg-green-100 rounded-lg">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Ordini Completati</p>
                                <p class="text-2xl font-semibold text-gray-900">567</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-2 bg-yellow-100 rounded-lg">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Fatturato</p>
                                <p class="text-2xl font-semibold text-gray-900">€12,345</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-2 bg-red-100 rounded-lg">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Crescita</p>
                                <p class="text-2xl font-semibold text-gray-900">+12.5%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Activity -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Attività Recenti</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                            <p class="text-sm text-gray-600">Nuovo utente registrato: Mario Rossi</p>
                            <span class="text-xs text-gray-400">2 minuti fa</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                            <p class="text-sm text-gray-600">Ordine completato: #12345</p>
                            <span class="text-xs text-gray-400">15 minuti fa</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                            <p class="text-sm text-gray-600">Pagamento ricevuto: €150.00</p>
                            <span class="text-xs text-gray-400">1 ora fa</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
```

## Form di Contatto

### File: `resources/views/pages/contact.blade.php`

```blade
<x-layouts.main>
    <x-slot name="title">
        Contatti - {{ config('app.name', 'Laravel') }}
    </x-slot>
    
    <x-slot name="description">
        Contattaci per qualsiasi domanda o richiesta. Siamo qui per aiutarti.
    </x-slot>
    
    <div class="py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-12">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">Contattaci</h1>
                    <p class="text-xl text-gray-600">
                        Hai domande? Siamo qui per aiutarti. Compila il form qui sotto e ti risponderemo il prima possibile.
                    </p>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <!-- Contact Form -->
                    <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200">
                        <h2 class="text-2xl font-semibold mb-6 text-gray-900">Invia un messaggio</h2>
                        
                        <form class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nome *
                                    </label>
                                    <input 
                                        type="text" 
                                        id="first_name" 
                                        name="first_name" 
                                        required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    >
                                </div>
                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Cognome *
                                    </label>
                                    <input 
                                        type="text" 
                                        id="last_name" 
                                        name="last_name" 
                                        required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    >
                                </div>
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email *
                                </label>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                >
                            </div>
                            
                            <div>
                                <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                                    Oggetto *
                                </label>
                                <select 
                                    id="subject" 
                                    name="subject" 
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                >
                                    <option value="">Seleziona un oggetto</option>
                                    <option value="general">Informazioni generali</option>
                                    <option value="support">Supporto tecnico</option>
                                    <option value="sales">Vendite</option>
                                    <option value="partnership">Partnership</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                                    Messaggio *
                                </label>
                                <textarea 
                                    id="message" 
                                    name="message" 
                                    rows="6" 
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Scrivi il tuo messaggio qui..."
                                ></textarea>
                            </div>
                            
                            <div class="flex items-center">
                                <input 
                                    type="checkbox" 
                                    id="privacy" 
                                    name="privacy" 
                                    required
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                >
                                <label for="privacy" class="ml-2 block text-sm text-gray-700">
                                    Accetto la <a href="/privacy" class="text-blue-600 hover:text-blue-500">Privacy Policy</a> *
                                </label>
                            </div>
                            
                            <button 
                                type="submit" 
                                class="w-full bg-blue-600 text-white py-3 px-6 rounded-md font-semibold hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                            >
                                Invia Messaggio
                            </button>
                        </form>
                    </div>
                    
                    <!-- Contact Info -->
                    <div class="space-y-8">
                        <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200">
                            <h3 class="text-xl font-semibold mb-6 text-gray-900">Informazioni di Contatto</h3>
                            
                            <div class="space-y-4">
                                <div class="flex items-start space-x-3">
                                    <div class="w-6 h-6 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Indirizzo</p>
                                        <p class="text-gray-600">Via Roma 123, 00100 Roma, Italia</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start space-x-3">
                                    <div class="w-6 h-6 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Telefono</p>
                                        <p class="text-gray-600">+39 06 1234 5678</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start space-x-3">
                                    <div class="w-6 h-6 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Email</p>
                                        <p class="text-gray-600">info@example.com</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200">
                            <h3 class="text-xl font-semibold mb-6 text-gray-900">Orari di Apertura</h3>
                            
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Lunedì - Venerdì</span>
                                    <span class="font-medium">9:00 - 18:00</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Sabato</span>
                                    <span class="font-medium">9:00 - 12:00</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Domenica</span>
                                    <span class="font-medium">Chiuso</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.main>
```

## Pagina 404 Personalizzata

### File: `resources/views/errors/404.blade.php`

```blade
<x-layouts.main>
    <x-slot name="title">
        Pagina non trovata - {{ config('app.name', 'Laravel') }}
    </x-slot>
    
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full text-center">
            <div class="mb-8">
                <div class="mx-auto h-24 w-24 text-gray-400">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.47-.881-6.08-2.33"></path>
                    </svg>
                </div>
            </div>
            
            <h1 class="text-6xl font-bold text-gray-900 mb-4">404</h1>
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Pagina non trovata</h2>
            <p class="text-gray-600 mb-8">
                La pagina che stai cercando non esiste o è stata spostata.
            </p>
            
            <div class="space-y-4">
                <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                    Torna alla Home
                </a>
                
                <div class="text-sm text-gray-500">
                    <p>Oppure prova a:</p>
                    <ul class="mt-2 space-y-1">
                        <li><a href="#" class="text-blue-600 hover:text-blue-500">Cercare nel sito</a></li>
                        <li><a href="#" class="text-blue-600 hover:text-blue-500">Contattare il supporto</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-layouts.main>
```

## Componente Card Riutilizzabile

### File: `resources/views/components/card.blade.php`

```blade
@props(['title' => '', 'subtitle' => '', 'image' => '', 'href' => null])

<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
    @if($image)
        <div class="aspect-w-16 aspect-h-9">
            <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-48 object-cover">
        </div>
    @endif
    
    <div class="p-6">
        @if($title)
            <h3 class="text-xl font-semibold text-gray-900 mb-2">
                @if($href)
                    <a href="{{ $href }}" class="hover:text-blue-600 transition-colors">
                        {{ $title }}
                    </a>
                @else
                    {{ $title }}
                @endif
            </h3>
        @endif
        
        @if($subtitle)
            <p class="text-gray-600 mb-4">{{ $subtitle }}</p>
        @endif
        
        <div class="text-gray-700">
            {{ $slot }}
        </div>
    </div>
</div>
```

### Utilizzo del Componente Card

```blade
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <x-card 
        title="Articolo 1" 
        subtitle="Descrizione breve dell'articolo"
        image="/images/article1.jpg"
        href="/articles/1"
    >
        <p>Contenuto dell'articolo che può essere più lungo e dettagliato...</p>
        <div class="mt-4">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                Tecnologia
            </span>
        </div>
    </x-card>
    
    <x-card 
        title="Articolo 2" 
        subtitle="Un altro articolo interessante"
        image="/images/article2.jpg"
        href="/articles/2"
    >
        <p>Altro contenuto interessante...</p>
        <div class="mt-4">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                Design
            </span>
        </div>
    </x-card>
</div>
```

## Best Practices

### 1. Struttura delle Pagine

- Utilizzare sempre il layout appropriato (`main` per pagine pubbliche, `app` per dashboard)
- Includere sempre meta tag per SEO
- Strutturare il contenuto con heading semantici
- Utilizzare componenti riutilizzabili

### 2. Responsive Design

- Testare sempre su diversi dispositivi
- Utilizzare classi responsive di Tailwind
- Implementare menu mobile appropriati
- Ottimizzare le immagini per mobile

### 3. Accessibilità

- Utilizzare attributi ARIA appropriati
- Fornire testi alternativi per le immagini
- Assicurare contrasto adeguato
- Implementare navigazione da tastiera

### 4. Performance

- Ottimizzare le immagini
- Utilizzare lazy loading
- Minimizzare gli asset
- Implementare caching appropriato

## Riferimenti

- [Documentazione Blade](https://laravel.com/docs/blade)
- [Documentazione Tailwind CSS](https://tailwindcss.com/docs)
- [Guida Accessibilità](https://www.w3.org/WAI/WCAG21/quickref/)
- [Best Practices SEO](https://developers.google.com/search/docs) 