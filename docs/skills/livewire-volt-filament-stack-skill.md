# Livewire Volt Filament Stack Skill

## Quando usarla

Usare questa skill quando il lavoro coinvolge:

- Laravel Folio
- Livewire / Volt
- Filament 5.x
- plugin Filament di supporto UI come Google Fonts

## Workflow

1. Classificare il problema:
   - route/page tree -> Folio
   - interazione/stato/lifecycle -> Volt o Livewire
   - admin panel/resource/schema/action -> Filament
   - typography panel -> plugin Filament
2. Evitare soluzioni ibride che spostano responsabilita' nel layer sbagliato.
3. Verificare dove va registrata la configurazione:
   - provider Folio
   - componente Volt/Livewire
   - PanelProvider Filament
4. Aggiungere test nel layer corretto.

## Anti-pattern

- business logic pesante in page Blade;
- UI admin costruita fuori da Filament quando il panel gia' offre il contratto corretto;
- font management incoerente tra panel e theme;
- usare Volt dove serve un semplice block Blade statico o viceversa.
