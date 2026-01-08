# Filament Best Practices

## Visibilità dei Metodi

### Principio di Liskov
Quando si estendono le classi base di Filament o XotBase, è fondamentale rispettare il principio di sostituzione di Liskov. Questo significa che:
- La visibilità dei metodi non può essere ridotta nelle classi figlie
- I tipi di ritorno devono essere compatibili
- I parametri devono essere compatibili

### Metodi Comuni e loro Visibilità
| Metodo | Classe Base | Visibilità Richiesta |
|--------|-------------|---------------------|
| getTableActions() | XotBaseListRecords | public |
| getFormSchema() | XotBaseCreateRecord | public |
| getFormSchema() | XotBaseEditRecord | public |
| getHeaderActions() | XotBaseListRecords | public |
| getTableColumns() | XotBaseListRecords | public |

### Esempi di Implementazione Corretta

```php
class ListPosts extends XotBaseListRecords
{
    public function getTableActions(): array
    {
        return [
            // Le tue azioni personalizzate
        ];
    }

    public function getTableColumns(): array
    {
        return [
            // Le tue colonne personalizzate
        ];
    }
}
```

### Errori Comuni da Evitare

1. Riduzione della Visibilità
```php
// ❌ SBAGLIATO: Riduzione della visibilità
protected function getTableActions(): array

// ✅ CORRETTO: Mantenimento della visibilità
public function getTableActions(): array
```

2. Tipo di Ritorno Incompatibile
```php
// ❌ SBAGLIATO: Tipo di ritorno incompatibile
public function getTableActions(): Collection

// ✅ CORRETTO: Tipo di ritorno compatibile
public function getTableActions(): array
```

## Collegamenti
- [Documentazione Filament Ufficiale](https://filamentphp.com/)
- [Principio di Sostituzione di Liskov](https://it.wikipedia.org/wiki/Principio_di_sostituzione_di_Liskov)
- [Best Practices PHP](../php-strict-types.md) 
- [Best Practices PHP](../PHP-STRICT-TYPES.md) 
