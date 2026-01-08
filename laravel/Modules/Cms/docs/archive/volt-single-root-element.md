# Regola del Singolo Elemento Root in Volt/Livewire

## Descrizione
Livewire e Volt richiedono che ogni componente abbia un singolo elemento HTML root. Questo è un requisito fondamentale per il corretto funzionamento del sistema di aggiornamento DOM di Livewire.

## Struttura Corretta

```php
@volt('register')
<div> {{-- Singolo elemento root --}}
    <div class="header">...</div>
    <div class="content">...</div>
    <div class="footer">...</div>
</div>
@endvolt
```

## Errori Comuni

### Elementi Root Multipli (Non Valido)
```php
@volt('register')
<div class="header">...</div>
<div class="content">...</div>
<div class="footer">...</div>
@endvolt
```

### Soluzione
Wrappare sempre gli elementi multipli in un singolo elemento container:
```php
@volt('register')
<div class="register-container">
    <div class="header">...</div>
    <div class="content">...</div>
    <div class="footer">...</div>
</div>
@endvolt
```

## Best Practices
1. Utilizzare sempre un div container come elemento root
2. Assegnare una classe semantica al container
3. Mantenere la gerarchia degli elementi chiara
4. Evitare elementi root multipli

## Collegamenti Bidirezionali
- [Volt Introduction](volt-introduction.md)
- [Volt Folio Esempio](volt-folio-esempio.md)
- [Struttura Layout](struttura-layout-componenti-blade-<nome progetto>.md)

## Vedi Anche
- [Documentazione Principale](../../docs/INDEX.md)
- [Best Practices Frontend](web-design-rules.md)
- [Gestione Componenti](components.md) 