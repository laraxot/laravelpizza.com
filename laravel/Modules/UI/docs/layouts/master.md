# Master Layout Documentation

## Overview
Il layout `master.blade.php` è il template base per il modulo UI, fornendo la struttura HTML fondamentale per tutte le pagine.

## Struttura

### Meta Tags
```html
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
```

### Asset Management
- Supporto per Laravel Vite
- CSS e JS caricati tramite helper `module_vite()`
- Assets organizzati per modulo

### Content Yield
- Sezione principale del contenuto tramite `@yield('content')`

## Utilizzo
```php
@extends('ui::layouts.master')

@section('content')
    // Contenuto della pagina
@endsection
```

## Recent Changes
- Rimossi conflitti di merge
- Standardizzata l'indentazione
- Migliorata la gestione degli assets con Vite
- Aggiunta documentazione del layout 