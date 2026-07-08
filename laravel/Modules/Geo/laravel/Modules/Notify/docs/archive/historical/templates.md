# Email Templates

## Panoramica

Il sistema di template permette di:
- Creare e gestire template HTML per le email
- Supportare traduzioni multiple
- Utilizzare variabili dinamiche
- Applicare layout predefiniti
- Utilizzare componenti riutilizzabili
- Preview in tempo reale

## Struttura Template

```html
<x-mail::message>

# {{ $title }}

{{ $content }}

@if($hasButton)
<x-mail::button :url="$buttonUrl">
{{ $buttonText }}
</x-mail::button>
@endif

@if($hasTable)
<x-mail::table>
| {{ $tableHeader }} |
| ----------------- |
@foreach($tableRows as $row)
| {{ $row }} |
@endforeach
</x-mail::table>
@endif

{{ $footer }}<br>
{{ config('app.name') }}
</x-mail::message>
```

## Componenti Standard

### Message
```html
<x-mail::message>
Il contenuto del messaggio
</x-mail::message>
```

### Button
```html
<x-mail::button :url="$url" :color="$color">
Testo Bottone
</x-mail::button>
```

### Panel
```html
<x-mail::panel>
Contenuto in evidenza
</x-mail::panel>
```

### Table
```html
<x-mail::table>
| Prodotto    | Prezzo |
| ----------- | ------ |
| Prodotto 1  | €10    |
| Prodotto 2  | €20    |
</x-mail::table>
```

### Subcopy
```html
<x-mail::subcopy>
Testo più piccolo sotto il contenuto principale
</x-mail::subcopy>
```

## Layout Predefiniti

### Default
```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
</head>
<body>
    <div class="header">
        <img src="{{ asset('images/logo.png') }}" alt="Logo">
    </div>

    <div class="content">
        {{ $slot }}
    </div>

    <div class="footer">
        {{ $footer }}
    </div>
</body>
</html>
```

### Marketing
```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
</head>
<body>
    <div class="hero">
        <img src="{{ $heroImage }}" alt="Hero">
        <h1>{{ $title }}</h1>
    </div>

    <div class="content">
        {{ $slot }}
    </div>

    <div class="cta">
        {{ $cta }}
    </div>

    <div class="footer">
        {{ $footer }}
        <div class="social">
            {{ $social }}
        </div>
    </div>
</body>
</html>
```

## Componenti Personalizzati

### Alert
```html
<x-mail::alert :type="$type">
    {{ $slot }}
</x-mail::alert>
```

### Card
```html
<x-mail::card>
    <x-slot name="header">
        {{ $header }}
    </x-slot>

    {{ $slot }}

    <x-slot name="footer">
        {{ $footer }}
    </x-slot>
</x-mail::card>
```

### Timeline
```html
<x-mail::timeline>
    @foreach($events as $event)
    <x-mail::timeline-item 
        :date="$event->date"
        :title="$event->title"
        :description="$event->description"
    />
    @endforeach
</x-mail::timeline>
```

## Stili

### Colori
```css
:root {
    --primary: #4F46E5;
    --secondary: #6B7280;
    --success: #10B981;
    --danger: #EF4444;
    --warning: #F59E0B;
    --info: #3B82F6;
}
```

### Tipografia
```css
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto;
    line-height: 1.5;
    color: #374151;
}

h1 {
    font-size: 24px;
    font-weight: 600;
    color: #111827;
}

p {
    margin: 16px 0;
}
```

### Layout
```css
.container {
    max-width: 600px;
    margin: 0 auto;
    padding: 24px;
}

.content {
    background: white;
    padding: 32px;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}
```

## Esempi Template

### Welcome Email
```html
<x-mail::message>

# Benvenuto {{ $user->name }}!

Grazie per esserti registrato su {{ config('app.name') }}.

<x-mail::button :url="$loginUrl">
Accedi al tuo account
</x-mail::button>

Se hai bisogno di aiuto, non esitare a contattarci.

Cordiali saluti,<br>
{{ config('app.name') }}
</x-mail::message>
```

### Order Confirmation
```html
<x-mail::message>

# Ordine Confermato

Grazie per il tuo ordine #{{ $order->number }}.

<x-mail::panel>
Spediremo il tuo ordine a:<br>
{{ $order->shipping_address }}
</x-mail::panel>

<x-mail::table>
| Prodotto       | Quantità | Prezzo    |
| -------------- | -------- | --------- |
@foreach($order->items as $item)
| {{ $item->name }} | {{ $item->quantity }} | €{{ $item->price }} |
@endforeach
</x-mail::table>

<x-mail::panel>
Totale: €{{ $order->total }}
</x-mail::panel>

<x-mail::button :url="$trackingUrl">
Traccia il tuo ordine
</x-mail::button>

Grazie per aver scelto {{ config('app.name') }}!
</x-mail::message>
```

### Password Reset
```html
<x-mail::message>

# Reset Password

Hai richiesto il reset della password per il tuo account.

<x-mail::panel>
Il link per il reset della password scadrà tra {{ $expires }} minuti.
</x-mail::panel>

<x-mail::button :url="$resetUrl">
Reset Password
</x-mail::button>

Se non hai richiesto il reset della password, ignora questa email.

Cordiali saluti,<br>
{{ config('app.name') }}

<x-mail::subcopy>
Se hai problemi con il bottone, copia e incolla questo link nel tuo browser: {{ $resetUrl }}
</x-mail::subcopy>
</x-mail::message>
```

## Best Practices

1. **Struttura**
   - Usare componenti per elementi riutilizzabili
   - Mantenere i template semplici e leggibili
   - Seguire una gerarchia logica

2. **Stile**
   - Usare variabili CSS per colori e dimensioni
   - Mantenere consistenza nel design
   - Testare su diversi client email

3. **Contenuto**
   - Scrivere testi chiari e concisi
   - Usare una gerarchia visiva
   - Includere call-to-action evidenti

4. **Responsive**
   - Testare su dispositivi mobili
   - Usare unità relative
   - Ottimizzare immagini

## Vedi Anche

- [Laravel Mail](https://laravel.com/docs/mail)
- [Markdown Mail](https://laravel.com/docs/mail#markdown-mailables)
