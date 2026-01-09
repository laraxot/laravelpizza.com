# Activity Module - Documentation Index

**Last Update**: 13 Dicembre 2025
**Status**: ✅ PHPStan Level 10 Compliant (Nativo)
**Module Version**: 1.0

## 📚 Quick Navigation

### 🎯 Essential Reading
1. [README.md](./README.md) - Overview del modulo Activity
2. [phpstan_compliance_dec_2025.md](./phpstan_compliance_dec_2025.md) - Compliance nativa

### 🏗️ Architecture
Il modulo Activity fornisce funzionalità di logging delle attività utente nel sistema.

**Core Components**:
- **LogActivityAction**: Action principale per logging
- **Activity Model**: Modello per memorizzare attività

### 🔧 Actions Pattern
```php
use Modules\Activity\Actions\LogActivityAction;

// Pattern di utilizzo
app(LogActivityAction::class)->execute(
    type: 'user.login',
    user: $user,
    subject: $record,
    properties: ['ip' => request()->ip()],
    description: 'User logged in successfully'
);
```

### 📊 Best Practices

1. **Type Safety Nativa**: Il modulo è già type-safe
2. **Type Narrowing**: Uso corretto di `getAttribute()` e validazioni
3. **Exception Handling**: Lancio di eccezioni specifiche per errori

### ✅ PHPStan Compliance

Il modulo Activity serve da **riferimento** per compliance nativa:
- Nessun errore PHPStan
- Type hints rigorosi
- Gestione null corretta
- Validazioni appropriate

### 🔗 Related Modules

- [Xot](../../Xot/docs/README.md) - Core framework
- [User](../../User/docs/README.md) - User authentication

## 📈 Module Statistics

- **Total Docs**: 102 files
- **PHPStan Compliance**: ✅ Level 10 (Nativo)
- **Type Safety**: 100%
- **Code Quality**: Eccellente

---

*Modulo di riferimento per PHPStan compliance nel progetto Laraxot*
