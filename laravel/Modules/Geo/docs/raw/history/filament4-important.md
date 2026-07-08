# ⚠️ CRITICO: Progetto utilizza Filament 4

## Versione Filament

**Questo progetto utilizza FILAMENT 4, NON Filament 3 o versioni precedenti.**

## Implicazioni Importanti

### 1. Panel Context Automatico

In Filament 4, quando si chiama `Resource::getUrl()` da un contesto Livewire (come `ListRecords`), Filament **determina automaticamente il panel corretto** dal contesto del livewire.

**✅ CORRETTO**:
```php
// Filament 4 determina automaticamente il panel dal contesto
return $resource::getUrl('log-activity', ['record' => $record]);
```

**❌ ERRATO**:
```php
// NON esiste Filament\Support\Facades\Filament::getCurrentPanel() in Filament 4
$panel = Filament::getCurrentPanel(); // ❌ CLASSE NON ESISTENTE
return $resource::getUrl('log-activity', ['record' => $record], panel: $panelId);
```

### 2. Facades e Namespace

- **NON esiste** `Filament\Support\Facades\Filament` in Filament 4
- Filament 4 usa un sistema di panel diverso da Filament 3
- Il context del panel viene determinato automaticamente dal Livewire component

### 3. API Changes

- Metodi che esistevano in Filament 3 potrebbero non esistere in Filament 4
- Verificare sempre la documentazione ufficiale di Filament 4 prima di usare API non verificate
- Non assumere che API di Filament 3 funzionino in Filament 4

## Best Practices

1. **Sempre verificare** la versione di Filament prima di implementare soluzioni
2. **Non usare** API di Filament 3 senza verifica
3. **Usare** il context automatico del Livewire per determinare il panel
4. **Consultare** la documentazione ufficiale di Filament 4 quando in dubbio

## Riferimenti

- [Filament 4 Documentation](https://filamentphp.com/docs)
- [Modules/User/docs/filament4-migration.md](../../laravel/Modules/User/docs/filament4-migration.md)

## Aggiornamento

**Ultimo aggiornamento**: 2025-01-XX
**Versione Filament**: 4.x

