# Regole per i ServiceProvider

## Principi Fondamentali

1. **Studio Preliminare**
   - SEMPRE studiare `XotBaseServiceProvider` prima di modificare un ServiceProvider
   - Analizzare i metodi già disponibili nella classe base
   - Evitare duplicazioni di funzionalità

2. **Registrazione Componenti**
   - La registrazione dei componenti Blade è già gestita da `XotBaseServiceProvider::registerBladeComponents()`
   - NON registrare manualmente i componenti nei ServiceProvider derivati
   - Usare la convenzione dei namespace per i componenti: `{ModuleName}\View\Components`

3. **Struttura Standard**
   ```php
   class MyModuleServiceProvider extends XotBaseServiceProvider
   {
       public string $name = 'MyModule';
       protected string $module_dir = __DIR__;
       protected string $module_ns = __NAMESPACE__;

       public function boot(): void
       {
           parent::boot();
           // Solo configurazioni specifiche del modulo
           $this->registerConfig();
       }
   }
   ```

4. **Gestione Assets**
   - Gli assets vengono gestiti automaticamente
   - Le viste vengono caricate da `resources/views`
   - I componenti da `View/Components`
   - Le traduzioni da `lang`

5. **Best Practices**
   - Mantenere i ServiceProvider leggeri
   - Delegare la logica complessa ad Actions
   - Seguire le convenzioni di naming
   - Documentare le personalizzazioni

## Errori Comuni da Evitare

1. **Registrazione Manuale Componenti**
   ```php
   // ❌ NON FARE
   $this->loadViewComponentsAs('mymodule', [
       MyComponent::class,
   ]);

   // ✅ CORRETTO
   // Lasciare che XotBaseServiceProvider gestisca la registrazione
   ```

2. **Duplicazione Funzionalità**
   ```php
   // ❌ NON FARE
   $this->loadViewsFrom(__DIR__.'/../resources/views', 'mymodule');

   // ✅ CORRETTO
   // Già gestito da XotBaseServiceProvider::registerViews()
   ```

## Checklist Verifica

Prima di modificare un ServiceProvider:
- [ ] Ho studiato XotBaseServiceProvider?
- [ ] Ho verificato se la funzionalità è già presente?
- [ ] Ho controllato le convenzioni di naming?
- [ ] Ho documentato le modifiche?
- [ ] Ho evitato duplicazioni? 