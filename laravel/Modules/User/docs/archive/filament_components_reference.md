# Riferimento Componenti Filament Verificati

## ⚠️ REGOLA CRITICA: Verificare SEMPRE l'esistenza dei componenti

**IMPORTANTE**: Prima di usare qualsiasi componente Filament, verificare SEMPRE che esista nella documentazione ufficiale o nel codebase esistente.

### Errori da evitare ASSOLUTAMENTE
- ❌ `x-filament::layouts.card` - NON ESISTE
- ❌ `x-filament::section` - NON VERIFICATO
- ❌ `x-filament::input.wrapper` - NON VERIFICATO
- ❌ `x-filament::input` - NON VERIFICATO

## Componenti Filament Verificati e Funzionanti

### Componenti Base
- ✅ `x-filament::page` - Layout principale per pagine
- ✅ `x-filament::button` - Pulsanti
- ✅ `x-filament::icon-button` - Pulsanti con icona
- ✅ `x-filament::icon` - Icone
- ✅ `x-filament::avatar` - Avatar utente
- ✅ `x-filament::link` - Collegamenti
- ✅ `x-filament::loading-indicator` - Indicatore di caricamento

### Componenti Dropdown
- ✅ `x-filament::dropdown` - Dropdown principale
- ✅ `x-filament::dropdown.list` - Lista dropdown
- ✅ `x-filament::dropdown.list.item` - Elemento lista dropdown

## Esempi di Utilizzo Verificati

### Button
```blade
<x-filament::button
    color="primary"
    size="lg"
    wire:click="action"
>
    Testo Button
</x-filament::button>
```

### Icon
```blade
<x-filament::icon
    name="heroicon-o-user-circle"
    class="h-6 w-6"
/>
```

### Dropdown
```blade
<x-filament::dropdown>
    <x-slot name="trigger">
        <x-filament::button>Menu</x-filament::button>
    </x-slot>
    
    <x-filament::dropdown.list>
        <x-filament::dropdown.list.item href="/link">
            Voce Menu
        </x-filament::dropdown.list.item>
    </x-filament::dropdown.list>
</x-filament::dropdown>
```

### Avatar
```blade
<x-filament::avatar 
    src="{{ $user->getAvatarUrl() }}" 
    alt="{{ $user->name }}"
/>
```

## Come Verificare un Componente

### 1. Cerca nel Codebase
```bash
grep -r "x-filament::" laravel/Themes/ --include="*.blade.php"
```

### 2. Controlla la Documentazione Ufficiale
- [Filament Documentation](https://filamentphp.com/docs)
- Sezione Components

### 3. Testa in un File Esistente
Prima di usare un componente in produzione, testalo in un file di prova.

## Regole di Sicurezza

### SEMPRE fare prima di usare un componente:
1. ✅ Verificare esistenza nella documentazione ufficiale
2. ✅ Cercare esempi nel codebase esistente  
3. ✅ Testare in ambiente di sviluppo
4. ✅ Verificare che non generi errori

### MAI fare:
1. ❌ Usare componenti senza verifica
2. ❌ Assumere che un componente esista
3. ❌ Copiare codice da fonti non verificate
4. ❌ Ignorare errori di componenti mancanti

## Aggiornamento di questo Documento

Questo documento deve essere aggiornato ogni volta che:
- Si scopre un nuovo componente Filament funzionante
- Si identifica un componente che NON esiste
- Cambia la versione di Filament nel progetto

**Data ultimo aggiornamento**: 2025-07-30
**Versione Filament**: Da verificare nel composer.json del progetto
