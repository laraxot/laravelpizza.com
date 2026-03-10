# Form Component

## 📊 Stato Implementazione
Completamento: 45%

## 🎯 Obiettivi
1. Creare un form builder tipizzato e flessibile
2. Integrare validazione lato client e server
3. Supportare form dinamici e nested
4. Ottimizzare la UX con feedback immediato

## 🤔 Sfide di Design

### 1. Type Safety
- Validazione input tipizzata
- Gestione form nidificati
- Type inference per campi dinamici

### 2. Validazione
- Sincronizzazione client/server
- Validazione real-time
- Custom validation rules

### 3. State Management
- Form state tracking
- Dirty checking
- Error handling

## 💡 Soluzioni Proposte

### 1. Form Builder
```php
class FormBuilder extends XotBaseUIComponent
{
    /** @var array<string, FormField> */
    protected array $fields = [];
    
    /** @var array<string, mixed> */
    protected array $values = [];
    
    public function addField(string $name, FormField $field): self
    {
        $this->fields[$name] = $field;
        return $this;
    }
    
    public function validate(): ValidationResult
    {
        return $this->validator->validate($this->values);
    }
}
```

### 2. Form Field Type System
```php
abstract class FormField
{
    protected string $name;
    protected string $label;
    protected bool $required = false;
    protected ?string $placeholder = null;
    protected array $validators = [];
    
    abstract public function render(): View;
    abstract public function validate($value): ValidationResult;
}

class InputField extends FormField
{
    protected string $type = 'text';
    protected ?int $maxLength = null;
    protected ?string $pattern = null;
    
    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }
}
```

## 📝 Steps Implementazione

### Fase 1: Core (✅ Completato)
1. ✅ Form builder base
2. ✅ Field type system
3. ✅ Basic validation
4. ✅ Event system

### Fase 2: Fields (🏗️ In Progress)
1. ✅ Text input
2. ✅ Select
3. 🏗️ Checkbox/Radio
4. 🏗️ File upload
5. 📝 Rich text editor

### Fase 3: Advanced Features
1. 📝 Dynamic fields
2. 📝 Nested forms
3. 📝 Custom validators
4. 📝 Auto-save
5. 📝 Multi-step forms

## 🎭 Edge Cases

1. **Nested Data**
```php
// Problema: Validazione dati nidificati
$form->validate(['user' => ['name' => 'John']])

// Soluzione: Dot notation validator
class NestedValidator implements ValidatorInterface
{
    public function validate(array $data): ValidationResult
    {
        return $this->validateNested(Arr::dot($data));
    }
}
```

2. **Dynamic Fields**
```php
// Problema: Type safety con campi dinamici
$form->addDynamicField('custom_field')

// Soluzione: Field type registry
class DynamicField extends FormField
{
    public function __construct(
        protected FieldTypeRegistry $registry,
        protected string $fieldType
    ) {
        $this->validator = $registry->getValidator($fieldType);
    }
}
```

## ✅ Code Review Checklist

1. Type Safety
   - [ ] Field types definiti
   - [ ] Validation rules tipizzate
   - [ ] Event handlers typed

2. Validation
   - [ ] Client validation
   - [ ] Server validation
   - [ ] Custom rules support

3. UX
   - [ ] Error messages
   - [ ] Loading states
   - [ ] Success feedback

## 🚀 Performance Considerations

1. **Lazy Validation**
```php
protected function validateField(string $name): void
{
    if (!isset($this->dirtyFields[$name])) {
        return;
    }
    
    $result = $this->fields[$name]->validate(
        $this->values[$name]
    );
    
    $this->errors[$name] = $result->errors();
}
```

2. **State Management**
```php
class FormState
{
    /** @var array<string, mixed> */
    protected array $initialValues = [];
    
    /** @var array<string, mixed> */
    protected array $currentValues = [];
    
    public function isDirty(string $field): bool
    {
        return $this->initialValues[$field] !== 
               $this->currentValues[$field];
    }
}
```

## 📚 Lessons Learned

1. Importanza della validazione incrementale
2. Necessità di type safety per nested data
3. UX critical per form complessi
4. Performance impact della validazione real-time

## 🔗 Resources

- [Form Architecture](docs/architecture/forms.md)
- [Validation System](docs/validation/rules.md)
- [Field Types](docs/fields/types.md)
- [State Management](docs/state/form_state.md)

## 🤝 Contributing

1. Implementa nuovi field types
2. Aggiungi custom validators
3. Migliora la documentazione
4. Scrivi test
5. Ottimizza performance

## ⚠️ Known Issues

1. **Nested Validation**
   - Performance con form deeply nested
   - Solution: Validation caching

2. **Dynamic Fields**
   - Type safety compromessa
   - Solution: Typed field registry

## 🎯 Next Steps

1. Completare checkbox/radio components
2. Implementare file upload
3. Aggiungere nested form support
4. Migliorare validation performance
5. Documentare best practices 