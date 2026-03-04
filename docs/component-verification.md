# Regole per la Verifica dei Componenti Blade

## ERRORE CRITICO DA NON RIPETERE MAI

**NON usare mai componenti Blade senza verificarne l'esistenza nella documentazione ufficiale!**

### Errore Commesso

```blade
{{-- ERRORE GRAVE: Componenti inesistenti --}}
<x-filament::layouts.card>
<x-filament::section>
<x-filament::input.wrapper>
<x-filament::input>
<x-filament::button>
```

**Risultato**: Internal Server Error - `Unable to locate a class or view for component [filament::layouts.card]`

## Regole di Verifica OBBLIGATORIE

### 1. Prima di Usare Qualsiasi Componente

1. **Verificare esistenza nel progetto**:
   ```bash
   find resources/views/components -name "*.blade.php"
   ```

2. **Controllare documentazione ufficiale Filament**

3. **Testare in ambiente di sviluppo**

### 2. Componenti Disponibili nel Progetto

#### Layout Components (x-layouts.*)
- `x-layouts.app`
- `x-layouts.guest` 
- `x-layouts.main`
- `x-layouts.marketing`
- `x-layouts.navigation`

#### UI Components (x-ui.*)
- `x-ui.button`
- `x-ui.checkbox`
- `x-ui.input`
- `x-ui.link`
- `x-ui.logo`
- `x-ui.text-link`
- `x-ui.badge`
- `x-ui.modal`

#### Standard Components (x-*)
- `x-button`
- `x-input`
- `x-checkbox`
- `x-input-label`
- `x-input-error`
- `x-primary-button`
- `x-secondary-button`
- `x-danger-button`

### 3. Componenti Filament NON Disponibili

❌ **NON USARE MAI**:
- `x-filament::layouts.card`
- `x-filament::section`
- `x-filament::input.wrapper`
- `x-filament::input`
- `x-filament::button`
- `x-filament::link`

## Implementazione Corretta

### Login Form - Versione Corretta

```blade
<x-layouts.main>
    <div class="flex flex-col items-center justify-center min-h-screen py-10">
        
        <div class="w-full max-w-md">
            <x-ui.logo class="w-auto h-10 text-gray-700 fill-current dark:text-gray-100 mx-auto mb-6" />

            <h2 class="mt-5 text-2xl font-extrabold leading-9 text-center text-gray-800 dark:text-gray-200">
                {{ __('auth.login.title') }}
            </h2>
        </div>

        <div class="mt-8 w-full max-w-md">
            <div class="px-10 py-8 bg-white dark:bg-gray-950/50 border border-gray-200/60 dark:border-gray-200/10 rounded-lg shadow-sm">
                {{-- Usa widget Filament per form di autenticazione --}}
                @livewire(Modules\User\Filament\Widgets\Auth\LoginWidget::class)
            </div>
        </div>

    </div>
</x-layouts.main>
```

## Processo di Verifica

### Checklist Obbligatoria

Prima di usare qualsiasi componente:

- [ ] Il componente esiste nel progetto?
- [ ] È documentato nella documentazione ufficiale?
- [ ] È stato testato in ambiente di sviluppo?
- [ ] Non causa errori di compilazione?

### Strumenti di Verifica

1. **Ricerca componenti**:
   ```bash
   find resources/views/components -name "*.blade.php" | grep -i "nome_componente"
   ```

2. **Test compilazione**:
   ```bash
   php artisan view:cache
   php artisan view:clear
   ```

3. **Verifica in browser**: Sempre testare la pagina prima di considerare il lavoro completato

## Conseguenze dell'Errore

- **Internal Server Error**: L'applicazione si blocca completamente
- **Esperienza utente compromessa**: Gli utenti non possono accedere
- **Perdita di tempo**: Debugging e correzione errori
- **Perdita di credibilità**: Errori evitabili in produzione

## Best Practices

1. **Usa sempre componenti esistenti**: Verifica prima di implementare
2. **Documentazione first**: Leggi sempre la documentazione ufficiale
3. **Test incrementale**: Testa ogni modifica prima di procedere
4. **Fallback HTML**: Se un componente non esiste, usa HTML standard
5. **Code review**: Sempre rivedere il codice prima del deploy

## Collegamenti

- [Documentazione Filament Ufficiale](https://filamentphp.com/docs)
- [Laravel Blade Components](https://laravel.com/docs/blade#components)
- [Componenti UI del Progetto](../../../Themes/Sixteen/resources/views/components/ui/)
