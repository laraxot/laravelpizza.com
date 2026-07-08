# Filament Integration in Laraxot

## Resource Implementation

### Base Structure
- Estendere `XotBaseResource` per tutte le risorse Filament
- Implementare solo i metodi necessari, lasciando il resto alla classe base
- Utilizzare il sistema di traduzione automatico

### Form Schema
```php
public static function getFormSchema(): array
{
    return [
        // Campi base
        TextInput::make('name')
            ->required()
            ->maxLength(255),
            
        // Relazioni
        Select::make('type')
            ->relationship('type', 'name'),
            
        // File e Media
        FileUpload::make('avatar')
            ->image()
            ->directory('avatars'),
    ];
}
```

### Navigation
- La navigazione è gestita automaticamente da XotBaseResource
- Non sovrascrivere le proprietà di navigazione a meno che non sia strettamente necessario
- Utilizzare il sistema di traduzione per le etichette di navigazione

## Componenti Personalizzati

### Forms
- Utilizzare i componenti Filament standard quando possibile
- Creare componenti personalizzati solo quando necessario
- Mantenere la coerenza con lo stile Filament

### Tables
- Implementare colonne personalizzate quando necessario
- Utilizzare le funzionalità di ordinamento e filtro integrate
- Mantenere le prestazioni con la lazy loading

## Best Practices

### Validazione
- Utilizzare Form Request per la validazione complessa
- Implementare regole di validazione nei modelli quando appropriato
- Utilizzare le funzionalità di validazione di Filament per casi semplici

### Autorizzazioni
- Implementare le policies per ogni modello
- Utilizzare il sistema di autorizzazione di Filament
- Definire chiaramente i ruoli e le permissioni

### Performance
- Utilizzare il lazy loading per le relazioni
- Implementare il caching dove appropriato
- Ottimizzare le query del database
