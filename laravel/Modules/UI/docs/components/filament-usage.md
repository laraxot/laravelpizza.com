# Utilizzo dei Componenti Filament nel Progetto

Questo documento serve come punto di riferimento centrale per l'utilizzo dei componenti Filament in tutto il progetto.

## Principio Base
il progetto utilizza Filament come starterkit sia per il backend che per il frontend. Tutti i componenti UI dovrebbero utilizzare i componenti Filament nativi quando possibile.

## Collegamenti alla Documentazione

### Documentazione Principale
- [Best Practices Components](../../../Cms/docs/best-practices/components.md)
- [Documentazione Ufficiale Filament](https://filamentphp.com/docs/3.x/support/blade-components)
- [Guida all'Implementazione dei Componenti](../../../Cms/docs/components/README.md)

### Implementazioni di Riferimento
- [Documentazione Dettagliata del Footer](../../../../Themes/One/docs/components/layouts/footer.md)
- [Navigation Component](../../../../Themes/One/docs/components/layouts/navigation.md)
- [Form Components](../../../Cms/docs/components/forms/README.md)

## Componenti Disponibili

### 1. Componenti Base
- Button (`x-filament::button`) - Può essere usato anche come link con `tag="a"`
- Icon Button (`x-filament::icon-button`) - Supporta anche `tag="a"` per link
- Input (`x-filament::input`)

### 2. Componenti di Layout
- Card (`x-filament::card`)
- Section (`x-filament::section`)
- Grid (`x-filament::grid`)

### 3. Componenti di Navigazione
- Dropdown (`x-filament::dropdown`)
- Tabs (`x-filament::tabs`)
- Breadcrumbs (`x-filament::breadcrumbs`)

### 4. Componenti di Form
- Select (`x-filament::select`)
- Textarea (`x-filament::textarea`)
- Checkbox (`x-filament::checkbox`)
- Radio (`x-filament::radio`)

## Best Practices

1. **Link vs Button**
   ```blade
   <!-- ✅ CORRETTO - Per i link -->
   <x-filament::button
       href="/example"
       tag="a"
       color="gray"
       size="sm"
   >
       Link Example
   </x-filament::button>

   <!-- ✅ CORRETTO - Per i bottoni -->
   <x-filament::button>
       Button Example
   </x-filament::button>

   <!-- ❌ ERRATO -->
   <a href="#" class="custom-link">Link Example</a>
   ```

2. **Personalizzazione**
   ```blade
   <!-- ✅ CORRETTO -->
   <x-filament::button
       color="primary"
       size="lg"
       :disabled="$disabled"
   >
       Submit
   </x-filament::button>

   <!-- ❌ ERRATO -->
   <button class="custom-button large disabled">
       Submit
   </button>
   ```

3. **Icon Usage**
   ```blade
   <!-- ✅ CORRETTO -->
   <x-filament::icon-button
       icon="heroicon-o-plus"
       label="Add Item"
       tag="a"
       href="#"
   />

   <!-- ❌ ERRATO -->
   <button>
       <i class="fas fa-plus"></i>
       <span class="sr-only">Add Item</span>
   </button>
   ```

## Testing

```php
it('uses filament button component as link correctly', function () {
    $this->blade(
        '<x-filament::button tag="a" href="/test">Test</x-filament::button>'
    )
    ->assertSeeHtml('href="/test"')
    ->assertSee('Test');
});
```

## Note Importanti
- Utilizzare sempre i componenti Filament invece di creare componenti custom
- Per i link, usare `x-filament::button` con `tag="a"` invece di creare componenti link personalizzati
- Seguire la documentazione ufficiale di Filament per le best practices
- Mantenere la coerenza nell'utilizzo dei componenti in tutto il progetto

## Vedi Anche
- [Tema One Documentation](../../../../Themes/One/docs/README.md)
- [Filament Admin Panel](../../../Cms/docs/admin/filament.md)
- [Linee Guida per il Web Design](../../../Cms/docs/webdesign/README.md)
