# Architettura Xot

## Classi Base

### XotBaseModel

Modello base per tutti i moduli.

```php
namespace Modules\Xot\Models;

abstract class XotBaseModel extends Model
{
    use Updater;
    
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
```

### XotBaseMigration

Migrazioni anonime standardizzate.

```php
return new class() extends XotBaseMigration {
    protected string $table_name = 'example';
    
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->timestamps();
        });
    }
};
```

## Collegamenti

- [Xot Principale](../README.md)
- [Filament](../filament/)
