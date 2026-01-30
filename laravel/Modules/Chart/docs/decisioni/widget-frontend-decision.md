# Decisione Architetturale: Uso dei Widget Filament nel Frontend

## Contesto

Stiamo affrontando la necessità di garantire riusabilità e consistenza nel nostro progetto. Questo ci porta a riflettere sulla strategia generale per i componenti frontend.

## Decisione

**DECISIONE**: Utilizzare i widget Filament sia nell'admin che nel frontend per garantire riusabilità e consistenza.

**Motivazioni**:
1. Riusabilità del codice: i widget contengono business logic che deve essere consistente ovunque.
2. Manutenibilità: una sola implementazione da mantenere.
3. Consistenza UX: stessa logica di validazione ovunque.

## Implementazione

### Struttura dei Widget

```
Modules/<nome progetto>/Filament/Widgets/
├── Admin/          # Widget specifici per l'admin
├── Patient/        # Widget per l'area paziente (frontend)
├── Doctor/         # Widget per l'area dottore
└── Shared/         # Widget condivisi tra le aree
```

### Uso nelle Pagine Folio

```blade
{{-- Themes/One/resources/views/pages/patient/book.blade.php --}}
<x-layouts.app>
    <div class="container mx-auto py-8">
        @livewire('<nome progetto>::patient.find-doctor-and-appointment-widget')
    </div>
</x-layouts.app>
```

### Risoluzione Multiple Root Elements

Nelle view dei widget, assicurarsi SEMPRE di avere un singolo root element:

```blade
{{-- resources/views/filament/widgets/nome-widget.blade.php --}}
<div class="widget-container"> {{-- UN SOLO root element --}}
    <!-- Tutto il contenuto qui -->
</div>
```

## Best Practices

1. **Verificare sempre** l'esistenza di widget prima di creare nuovi componenti.
2. **Riusare i widget** esistenti nelle pagine Folio.
3. **Non duplicare** la logica tra admin e frontend.
4. **Risolvere problemi tecnici** nelle view, non evitando la tecnologia.

## Vantaggi

1. **Chiarezza**: Separazione netta delle responsabilità.
2. **Manutenibilità**: Ogni componente segue il suo pattern.
3. **Flessibilità**: Controllo totale sul frontend.
4. **Performance**: Nessun overhead di widget non necessari.

## Filosofia

### Principio di Responsabilità Singola
- Admin widgets → Gestione dati admin.
- Frontend components → Esperienza utente pubblica.

### Principio di Minima Sorpresa
- Gli sviluppatori si aspettano widget Filament nell'admin.
- Gli sviluppatori si aspettano Volt/Livewire nel frontend.

### Principio DRY con Pragmatismo
- Riusare la logica dove possibile.
- Ma non forzare pattern incompatibili.

## Conseguenze

### Positive
- Codice più pulito e manutenibile.
- Meno errori di incompatibilità.
- Maggiore flessibilità nel design.
- Allineamento con best practices.

### Negative
- Possibile duplicazione di alcune logiche.
- Due componenti da mantenere se servono sia admin che frontend.

## Decisione Finale

**APPROVATA**: Utilizzare i widget Filament sia nell'admin che nel frontend.

## Data: 2025-01-28

## Approvato da: Team di Sviluppo (implicito per best practices)
