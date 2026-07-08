# 📦 Data Transfer Object (DTO) Pattern

> **DTO PATTERN**: Trasferimento dati strutturato e tipizzato tra i layer dell'applicazione.

## 🎯 Scopo

I DTO servono a:
- ✅ Garantire la struttura dei dati (Type Safety)
- ✅ Evitare il passaggio di array associativi non tipizzati
- ✅ Validare i dati alla fonte
- ✅ Disaccoppiare i layer (es. Request -> DTO -> Action)

## 📋 Implementazione (Spatie Laravel Data)

### Classe DTO

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;

class UserData extends Data
{
    public function __construct(
        #[Required, StringType]
        public readonly string $name,
        
        #[Required, Email]
        public readonly string $email,
        
        #[WithCast(DateTimeInterfaceCast::class)]
        public readonly ?\DateTimeInterface $created_at = null,
        
        #[WithCast(DateTimeInterfaceCast::class)]
        public readonly ?\DateTimeInterface $updated_at = null,
        
        public readonly ?int $id = null,
    ) {
    }
    
    /**
     * Crea un nuovo UserData da un modello User.
     */
    public static function fromModel(\Modules\NomeModulo\Models\User $user): self
    {
        return new self(
            name: $user->name,
            email: $user->email,
            created_at: $user->created_at,
            updated_at: $user->updated_at,
            id: $user->id,
        );
    }
    
    /**
     * Crea un'istanza del modello User da questo Data Object.
     */
    public function toModel(): \Modules\NomeModulo\Models\User
    {
        $user = $this->id
            ? \Modules\NomeModulo\Models\User::findOrFail($this->id)
            : new \Modules\NomeModulo\Models\User();
            
        $user->name = $this->name;
        $user->email = $this->email;
        
        return $user;
    }
}
```

---
**Vedi anche**: [Action Pattern](./action.md)
