# Progress Bar

Il componente Progress Bar visualizza l'avanzamento di un'operazione o il progresso verso un obiettivo.

## Utilizzo Base

```blade
<x-filament::progress
    :value="75"
    :max="100"
/>
```

## Varianti

### Colori
```blade
<!-- Success -->
<x-filament::progress
    :value="100"
    color="success"
/>

<!-- Warning -->
<x-filament::progress
    :value="50"
    color="warning"
/>

<!-- Danger -->
<x-filament::progress
    :value="25"
    color="danger"
/>
```

### Con Label
```blade
<x-filament::progress
    :value="75"
    :max="100"
    label="Caricamento..."
/>
```

### Con Percentuale
```blade
<x-filament::progress
    :value="75"
    :max="100"
    show-percentage
/>
```

### Indeterminato
```blade
<x-filament::progress
    indeterminate
/>
```

## Props/Configurazione

| Prop | Tipo | Default | Descrizione |
|------|------|---------|-------------|
| `value` | int/float | 0 | Valore corrente |
| `max` | int/float | 100 | Valore massimo |
| `color` | string | 'primary' | Colore della barra (primary/success/warning/danger) |
| `label` | string | null | Etichetta descrittiva |
| `showPercentage` | boolean | false | Mostra la percentuale |
| `indeterminate` | boolean | false | Stato indeterminato |
| `size` | string | 'md' | Dimensione (sm/md/lg) |

## Best Practices

1. **Accessibilità**
   - Utilizzare attributi ARIA appropriati
   - Fornire feedback per screen reader
   - Mantenere contrasto sufficiente

2. **UX/UI**
   - Indicare chiaramente lo stato di avanzamento
   - Utilizzare colori significativi
   - Fornire feedback visivo immediato

3. **Implementazione**
   - Gestire correttamente gli stati di errore
   - Aggiornare progressivamente il valore
   - Mantenere consistenza nel design

## Esempi

### Upload File
```blade
<div>
    <x-filament::progress
        :value="$uploadProgress"
        color="primary"
        label="Caricamento file..."
        show-percentage
    />
    
    @if($uploadProgress === 100)
        <div class="mt-2 text-success-500">
            Caricamento completato!
        </div>
    @endif
</div>
```

### Multi-step Form
```blade
<div>
    <div class="mb-2">
        Passo {{ $currentStep }} di {{ $totalSteps }}
    </div>
    
    <x-filament::progress
        :value="($currentStep / $totalSteps) * 100"
        color="primary"
        show-percentage
    />
    
    <div class="mt-4">
        <!-- Contenuto del form -->
    </div>
</div>
```

### Task Progress
```blade
<div>
    @foreach($tasks as $task)
        <div class="mb-4">
            <div class="flex justify-between mb-1">
                <span>{{ $task->name }}</span>
                <span>{{ $task->completed_subtasks }}/{{ $task->total_subtasks }}</span>
            </div>
            
            <x-filament::progress
                :value="($task->completed_subtasks / $task->total_subtasks) * 100"
                :color="$task->completed_subtasks === $task->total_subtasks ? 'success' : 'primary'"
            />
        </div>
    @endforeach
</div>
```

## Note sulla Performance

1. **Animazioni**
   - Utilizzare CSS transforms
   - Ottimizzare le transizioni
   - Rispettare `prefers-reduced-motion`

2. **Aggiornamenti**
   - Implementare throttling per aggiornamenti frequenti
   - Utilizzare requestAnimationFrame
   - Evitare reflow non necessari

3. **Accessibilità**
   - Mantenere performance con ARIA live regions
   - Gestire correttamente il focus
   - Fornire alternative non-visuali

4. **Best Practices**
   - Minimizzare il DOM
   - Utilizzare CSS per animazioni
   - Implementare debounce per eventi frequenti 
