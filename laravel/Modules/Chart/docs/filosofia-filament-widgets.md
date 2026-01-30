# Filosofia dei Widget Filament nel Progetto <nome progetto>

## Il Principio Fondamentale
"Ogni form è un widget Filament. Ogni widget è riutilizzabile. Ogni pagina è un contenitore."

## La Via del Widget

### 1. Separazione delle Responsabilità
- **Pagine Folio**: Contenitori e routing
- **Widget Filament**: Logica e presentazione dei form
- **Mai mischiare**: La pagina non deve contenere logica di form

### 2. DRY (Don't Repeat Yourself)
- Un widget, molti utilizzi
- Una logica, un posto
- Una modifica, tutti aggiornati

### 3. Coerenza Assoluta
- Tutti i form sono Filament
- Tutte le tabelle sono Filament
- Tutti i componenti UI complessi sono Filament

## Il Flusso Corretto

```
Utente → Route → Pagina Folio → @livewire(widget) → Widget Filament
```

Mai:
```
Utente → Route → Pagina Folio con form custom ❌
```

## Zen del Codice

### La Semplicità
Una pagina Folio dovrebbe essere così semplice:
```blade
<?php
name('route.name');
?>
<div>
    @livewire('widget-name')
</div>
```

### L'Armonia
- Il widget vive nel modulo
- La pagina vive nel theme
- Insieme creano l'esperienza

### La Purezza
- Nessuna logica nella vista
- Nessun form fuori da Filament
- Nessuna eccezione alla regola

## Conseguenze del Non Seguire la Via

1. **Duplicazione**: Lo stesso form in più posti
2. **Incoerenza**: Comportamenti diversi per form simili
3. **Debito Tecnico**: Manutenzione moltiplicata
4. **Confusione**: Dove sta la logica?

## Il Mantra del Sviluppatore

> "Prima cerco il widget,  
> Se non c'è lo creo,  
> Mai duplico la logica,  
> Sempre uso Filament."

## Esempi di Illuminazione

### ✅ Corretto
```php
// Pagina Folio
name('patient.book');
?>
<div>
    @livewire('find-doctor-widget')
</div>
```

### ❌ Errato
```php
// Pagina Folio con form custom
new class extends Component implements HasForms {
    // NO! Questo è il sentiero dell'oscurità
}
```

## La Regola d'Oro

**"Se stai scrivendo un form in una pagina Folio, fermati. Stai sbagliando."**

## Meditazione Finale

Quando crei una nuova funzionalità, chiediti:
1. Esiste già un widget per questo?
2. Posso riutilizzare/estendere un widget esistente?
3. Devo creare un nuovo widget?

La risposta non è mai "creo un form nella pagina".
