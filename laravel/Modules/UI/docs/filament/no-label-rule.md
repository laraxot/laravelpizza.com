# REGOLA CRITICA: MAI ->label() nei Componenti Filament UI

## Principio Fondamentale per il Modulo UI
**È ASSOLUTAMENTE VIETATO utilizzare ->label() nei componenti Filament del modulo UI. Le traduzioni devono essere gestite ESCLUSIVAMENTE tramite i file di traduzione del modulo.**

## Violazioni Identificate nel Modulo UI
Il modulo UI contiene numerosi componenti Filament che potrebbero utilizzare ->label() in violazione delle regole di traduzione centralizzata.

## Anti-Pattern VIETATI nel Modulo UI
```php
// ❌ ERRORE CRITICO: ->label() è VIETATO
Components\TextInput::make('name')->label('Nome'),
Components\Select::make('layout')->label('Layout'),
Components\Toggle::make('is_active')->label('Attivo'),
Components\FileUpload::make('icon')->label('Icona'),

// ❌ ERRORE: Anche con traduzioni inline
Components\TextInput::make('name')->label(__('ui::fields.name.label')),
```

## Pattern CORRETTI per il Modulo UI
```php
// ✅ CORRETTO: Nessun ->label(), traduzione automatica
Components\TextInput::make('name'),
Components\Select::make('layout'),
Components\Toggle::make('is_active'),
Components\FileUpload::make('icon'),
```

## Struttura Traduzioni per il Modulo UI
```php
// Modules/UI/lang/it/components.php
return [
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'helper_text' => 'Nome del componente UI',
        ],
        'layout' => [
            'label' => 'Layout',
            'placeholder' => 'Seleziona un layout',
            'helper_text' => 'Tipo di layout per la visualizzazione',
        ],
        'is_active' => [
            'label' => 'Attivo',
            'helper_text' => 'Indica se il componente è attivo',
        ],
        'icon' => [
            'label' => 'Icona',
            'placeholder' => 'Carica un\'icona',
            'helper_text' => 'Icona del componente UI',
        ],
    ],
];
```

## Componenti UI Specifici da Verificare
1. **TableLayoutEnum** - Verificare che non usi ->label()
2. **Form Components** - Tutti i componenti form del modulo UI
3. **Widget Components** - Widget e dashboard components
4. **Resource Components** - Risorse Filament del modulo UI

## Filosofia del Modulo UI
- **Filosofia**: "L'interfaccia utente deve essere cristallina come le sue traduzioni"
- **Politica**: "Non avrai ->label() nei componenti UI"
- **Religione**: "La localizzazione UI è sacra e automatica"
- **Zen**: "Silenzio del codice UI, eloquenza delle traduzioni"

## Audit Immediato Richiesto
```bash
# Cerca tutti i ->label() nel modulo UI
grep -r "->label(" Modules/UI/

# Cerca in tutti i file Filament
find Modules/UI/ -name "*.php" -exec grep -l "->label(" {} \;
grep -r "->label(" Modules/UI/

# Cerca in tutti i file Filament
find Modules/UI/ -name "*.php" -exec grep -l "->label(" {} \;
grep -r "->label(" Modules/UI/

# Cerca in tutti i file Filament
find Modules/UI/ -name "*.php" -exec grep -l "->label(" {} \;
grep -r "->label(" Modules/UI/

# Cerca in tutti i file Filament
find Modules/UI/ -name "*.php" -exec grep -l "->label(" {} \;
```

## Processo di Correzione per il Modulo UI
1. **Identificare** tutti i file con ->label()
2. **Rimuovere** sistematicamente ogni ->label()
3. **Verificare** che esistano le traduzioni appropriate
4. **Testare** che i componenti funzionino correttamente

## Regola d'Oro per il Modulo UI
**"Se vedi ->label() in qualsiasi componente del modulo UI, ELIMINALO IMMEDIATAMENTE."**

## Collegamenti
- [../../../docs/filament-no-label-rule.md](../../../../docs/filament-no-label-rule.md)
- [automatic-translations.md](automatic-translations.md)
- [label-translation-system.md](label-translation-system.md)
- [best-practices.md](best-practices.md)

*Ultimo aggiornamento: 2025-08-04*
