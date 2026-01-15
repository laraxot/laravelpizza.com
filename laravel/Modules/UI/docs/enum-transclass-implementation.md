# Implementazione transClass() negli Enum del Modulo UI

## Principio Fondamentale per il Modulo UI
**Tutti gli enum del modulo UI DEVONO utilizzare il metodo `transClass()` per gestire le traduzioni invece di chiamate dirette a `__()` o `trans()`.**

## TableLayoutEnum - Implementazione Corretta

### Pattern CORRETTO
```php
public function getLabel(): string
{
    return $this->transClass(self::class, $this->value.'.label');
}

public function getColor(): string
{
    return $this->transClass(self::class, $this->value.'.color');
}

public function getIcon(): string
{
    return $this->transClass(self::class, $this->value.'.icon');
}

public function getDescription(): string
{
    return $this->transClass(self::class, $this->value.'.description');
}

public function getTooltip(): string
{
    return $this->transClass(self::class, $this->value.'.tooltip');
}

public function getHelperText(): string
{
    return $this->transClass(self::class, $this->value.'.helper_text');
}
```

### Anti-Pattern VIETATO (quello che c'era prima)
```php
// ❌ ERRORE: Match statement con traduzioni hardcoded
public function getLabel(): string
{
    return match ($this) {
        self::LIST => __('ui::table-layout.list.label'),
        self::GRID => __('ui::table-layout.grid.label'),
    };
}
```

## File di Traduzione per TableLayoutEnum

### Struttura Richiesta
```php
// Modules/UI/lang/it/table-layout-enum.php
return [
    'list' => [
        'label' => 'Lista',
        'color' => 'primary',
        'icon' => 'heroicon-o-list-bullet',
        'description' => 'Layout a lista tradizionale con righe di tabella',
        'tooltip' => 'Visualizza i dati in formato tabella strutturata',
        'helper_text' => 'Ideale per visualizzare molti dati in modo organizzato',
    ],
    'grid' => [
        'label' => 'Griglia',
        'color' => 'secondary',
        'icon' => 'heroicon-o-squares-2x2',
        'description' => 'Layout a griglia responsive con card',
        'tooltip' => 'Visualizza i dati in formato card responsive',
        'helper_text' => 'Ideale per visualizzare pochi dati con focus visivo',
    ],
];
```

## Vantaggi per il Modulo UI

### 1. Consistenza
- Pattern uniforme per tutti gli enum UI
- Gestione centralizzata delle traduzioni
- Facile manutenzione e aggiornamento

### 2. Scalabilità
- Aggiunta automatica di nuove lingue
- Supporto per nuove proprietà senza modificare il codice
- Override semplice delle traduzioni

### 3. Type Safety
- Controllo automatico delle chiavi di traduzione
- Errori chiari se mancano traduzioni
- Intellisense migliorato negli IDE

## Altri Enum del Modulo UI da Convertire

### Audit Necessario
1. Verificare tutti gli enum nel modulo UI
2. Convertire tutti i metodi di traduzione a `transClass()`
3. Creare i file di traduzione appropriati
4. Testare che le traduzioni funzionino

### Pattern da Cercare
```bash
# Cercare enum con metodi di traduzione hardcoded
grep -r "return match" Modules/UI/app/Enums/
grep -r "__(" Modules/UI/app/Enums/
grep -r "return match" Modules/UI/app/Enums/
grep -r "__(" Modules/UI/app/Enums/
grep -r "return match" Modules/UI/app/Enums/
grep -r "__(" Modules/UI/app/Enums/
grep -r "return match" Modules/UI/app/Enums/
grep -r "__(" Modules/UI/app/Enums/
grep -r "return match" Modules/UI/app/Enums/
grep -r "__(" Modules/UI/app/Enums/
grep -r "return match" Modules/UI/app/Enums/
grep -r "__(" Modules/UI/app/Enums/
```

## Filosofia del Modulo UI
- **Filosofia**: "L'interfaccia utente deve essere cristallina come le sue traduzioni"
- **Politica**: "Non avrai traduzioni hardcoded negli enum UI"
- **Religione**: "transClass() è la via della salvezza UI"
- **Zen**: "Un enum UI che si traduce è un'interfaccia in pace"

## Implementazione Immediata Richiesta
1. **Correggere** `TableLayoutEnum.php` con il pattern `transClass()`
2. **Creare** il file di traduzione `table-layout-enum.php`
3. **Testare** che le traduzioni funzionino correttamente
4. **Documentare** la correzione

## Regola d'Oro per il Modulo UI
**"Ogni enum del modulo UI DEVE utilizzare transClass() per TUTTE le sue proprietà traducibili."**

## Collegamenti
- [../../../../docs/enum-transclass-rule.md](../../../../docs/enum-transclass-rule.md)
- [../filament/no-label-rule.md](../filament/no-label-rule.md)
- [../clean-code/no-obvious-comments.md](../clean-code/no-obvious-comments.md)

*Ultimo aggiornamento: 2025-08-04*
