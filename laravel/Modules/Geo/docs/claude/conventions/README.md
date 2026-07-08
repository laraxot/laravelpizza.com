# Code Conventions

This section contains all coding conventions and standards used in the PTVX Laraxot project.

## 📁 Structure

### [Structure](structure/) - Laravel Framework Conventions
- Service Provider configuration
- Routing and middleware patterns
- Controller authorization
- Form Request validation
- Inline validation patterns

### [Naming](naming/) - Naming Standards
- PHP classes, methods, properties
- Database tables and columns
- File and directory naming
- URL and route naming
- Translation keys structure

### [Validation](validation/) - Validation Patterns
- Complete Form Request implementation
- Model validation rules
- API validation patterns
- Custom validation rules
- Livewire component validation

## 🎯 Key Principles

### DRY (Don't Repeat Yourself)
- Extract common validation logic
- Create reusable form request classes
- Use custom validation rules for complex logic

### KISS (Keep It Simple, Stupid)
- Simple, readable validation rules
- Clear error messages
- Consistent validation patterns

### SOLID Principles
- Single Responsibility: Each request class handles one concern
- Open/Closed: Extend validation without modifying existing code
- Liskov Substitution: Request classes are interchangeable
- Interface Segregation: Specific validation interfaces
- Dependency Inversion: Validation depends on abstractions

## 📋 Quick Reference

### Basic Form Request Structure
```php
class StoreUserRequest extends FormRequest
{
    public function authorize(): bool { /* ... */ }
    public function rules(): array { /* ... */ }
    public function messages(): array { /* ... */ }
    public function attributes(): array { /* ... */ }
}
```

### Common Validation Rules
```php
'email' => ['required', 'email:rfc,dns', 'unique:users,email'],
'password' => ['required', 'min:8', 'regex:/complex-pattern/'],
'file' => ['image', 'mimes:jpeg,png', 'max:2048'],
```

### Translation Integration
```php
'messages' => [
    'name.required' => __('validation.name.required'),
    'email.unique' => __('validation.email.unique'),
]
```

## 🔗 Related Documentation

- [Laravel Validation Documentation](https://laravel.com/docs/validation)
- [Spatie Laravel Data](https://spatie.be/docs/laravel-data)
- [Filament Forms](https://filamentphp.com/docs/forms)

---

**Version**: 4.0
**Last Updated**: December 2025
**Applies to**: All PTVX modules
