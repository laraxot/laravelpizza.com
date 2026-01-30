# ERRORE GRAVE: Widget Filament e Viste Personalizzate

## ❌ ERRORE DA NON RIPETERE MAI

### Cosa NON fare

1. **MAI creare viste blade personalizzate per widget Filament Form-based**
2. **MAI definire `protected static string $view` nei widget che estendono Form**
3. **MAI creare file in `/Modules/*/resources/views/filament/widgets/`**
4. **MAI usare widget Filament nelle pagine pubbliche/frontend**

### Perché è un errore grave
- I widget Filament Form-based generano automaticamente il loro HTML
- Filament gestisce internamente il rendering dei form
- Creare viste personalizzate causa errori di "multiple root elements" in Livewire
- Viola la struttura modulare del progetto

## ✅ Approccio Corretto

### Widget Form-based (con form())
```php
class MyWidget extends XotBaseWidget
{
    protected function getFormSchema(): array
    {
        return [
            'field_name' => TextInput::make('field_name'),
        ];
    }
    
    // NON definire $view!
}
```

### Widget con vista personalizzata (senza form)
```php
class MyCustomWidget extends XotBaseWidget
{
    protected static string $view = 'module::widgets.my-custom-widget';
    
    // NON usare getFormSchema()!
}
```

## Struttura Corretta

### Per i Form Widget
- Il widget PHP gestisce tutto
- Nessuna vista blade necessaria
- Il form viene renderizzato automaticamente

### Per le pagine Folio
- Le pagine sono nel tema: `/Themes/One/resources/views/pages/`
- I widget sono nei moduli: `/Modules/*/app/Filament/Widgets/`
- Le pagine USANO i widget, non il contrario

## Checklist di Verifica

Prima di creare qualsiasi widget:
1. ✓ Il widget estende XotBaseWidget?
2. ✓ Il widget usa form()? → NON creare vista
3. ✓ Il widget ha logica custom? → Crea vista SOLO se necessario
4. ✓ La vista è nel posto giusto? → `module::widgets.nome-widget`
5. ✓ Hai verificato la documentazione Filament?

## Comandi Utili
```bash

# Pulire la cache delle viste dopo modifiche
php artisan view:clear

# Verificare che non ci siano viste errate
find Modules/*/resources/views/filament/widgets -name "*.blade.php"
```

## Decisione Architetturale

### Widget Filament sono SOLO per Admin

**Politica Approvata**: I widget Filament devono essere usati esclusivamente nel pannello di amministrazione.

**Per le pagine pubbliche**:
- Usare componenti Volt nelle pagine Folio
- Usare Livewire components standalone
- Integrare Filament Forms direttamente nel componente

**Motivazioni**:
1. Separazione delle responsabilità
2. Evitare conflitti di pattern
3. Maggiore controllo sul frontend
4. Conformità alle best practices

Vedi [Decisione completa](/docs/decisioni/widget_frontend_decision.md)

## Riferimenti
- [Documentazione Widget Filament](/docs/tecnico/filament/widgets.md)
- [Architettura del Sistema](/docs/ARCHITETTURA_SISTEMA.md)
- [Struttura Moduli](/docs/modules/README.md)
- [Decisione Architetturale Widget Frontend](/docs/decisioni/widget_frontend_decision.md)
