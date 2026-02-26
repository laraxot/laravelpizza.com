# PHPStan Error Patterns and Solutions Guide

## Common PHPStan Error Patterns

### 1. Class Not Found Errors
**Pattern**: `Class [ClassName] not found`
**Causes**:
- Missing dependencies
- Incorrect namespace references
- Typographical errors

**Solutions**:
```php
// Check class existence before use
if (class_exists('Full\\Namespace\\ClassName')) {
    // Use the class
} else {
    // Handle missing class gracefully
    throw new \Exception('Required class not available');
}

// Use service container for dependency resolution
$instance = app()->make(Interface::class);
```

### 2. Property Not Found Errors
**Pattern**: `Access to an undefined property [ClassName]::$property`
**Causes**:
- Missing property declarations
- Typographical errors
- Accessing properties on null objects

**Solutions**:
```php
// Use null-safe operator
$value = $object?->property;

// Explicit null check
if ($object !== null) {
    $value = $object->property;
}

// Property existence check
if (property_exists($object, 'property')) {
    $value = $object->property;
}
```

### 3. Type Declaration Issues
**Pattern**: `Parameter [param] expects [type], [actual type] given`
**Causes**:
- Missing type declarations
- Incorrect PHPDoc annotations
- Type mismatches

**Solutions**:
```php
// Add proper type declarations
public function methodName(string $param): int
{
    return (int)$param;
}

// Use PHPDoc for complex types
/**
 * @param array<int, array<string, mixed>> $data
 * @return array<string, string>
 */
public function processData(array $data): array
{
    // implementation
}
```

### 4. Method Not Found Errors
**Pattern**: `Call to an undefined method [ClassName]::methodName()`
**Causes**:
- Missing method implementations
- Interface compliance issues
- Typographical errors

**Solutions**:
```php
// Check method existence
if (method_exists($object, 'methodName')) {
    $result = $object->methodName();
}

// Interface compliance
class MyClass implements MyInterface
{
    public function requiredMethod(): void
    {
        // implementation
    }
}
```

### 5. Casting and Type Conversion Issues
**Pattern**: `Cannot cast [type] to [target type]`
**Causes**:
- Invalid type casting
- Mixed type operations
- Missing validation

**Solutions**:
```php
// Validate before casting
if (is_numeric($value)) {
    $floatValue = (float)$value;
}

// Use type-safe conversion methods
$intValue = filter_var($value, FILTER_VALIDATE_INT);
if ($intValue !== false) {
    // valid integer
}
```

### 6. Array and Collection Issues
**Pattern**: `Invalid array key type` / `Unable to resolve template type`
**Causes**:
- Missing array shape definitions
- Incorrect collection type annotations
- Invalid offset access

**Solutions**:
```php
// Proper collection type annotations
/** @var \Illuminate\\Support\\Collection<int, \stdClass> $collection */

// Array shape validation
/** @var array{id: int, name: string} $item */

// Safe array access
if (isset($array[$key]) && is_string($key)) {
    $value = $array[$key];
}
```

## Specific Pattern Solutions

### Pattern: Static call to instance method
**Error**: `Static call to instance method Class::method()`
**Solution**:
```php
// Incorrect
ClassName::method();

// Correct
$instance = new ClassName();
$instance->method();

// Or if it should be static:
public static function method(): void
{
    // implementation
}
```

### Pattern: Binary operation between mixed types
**Error**: `Binary operation between [type] and [type] results in an error`
**Solution**:
```php
// Validate types before operation
if (is_numeric($a) && is_numeric($b)) {
    $result = $a * $b;
}

// Use type casting
$result = (float)$a * (float)$b;
```

### Pattern: Parameter type mismatch
**Error**: `Parameter expects [type], [actual type] given`
**Solution**:
```php
// Add type validation
public function process($value): void
{
    if (!is_string($value)) {
        throw new \InvalidArgumentException('Expected string');
    }
    // process string
}

// Or use proper type declaration
public function process(string $value): void
{
    // process string
}
```

### Pattern: Property access on nullable object
**Error**: `Cannot access property $property on [ClassName]|null`
**Solution**:
```php
// Use null-safe operator
$value = $object?->property;

// Explicit null check
if ($object !== null) {
    $value = $object->property;
}

// Provide default value
$value = $object !== null ? $object->property : null;
```

## Advanced Patterns

### Pattern: Generic Type Resolution
**Error**: `Unable to resolve the template type T in call to method`
**Solution**:
```php
// Add proper PHPDoc for generics
/**
 * @template TKey of array-key
 * @template TValue
 * @param array<TKey, TValue> $array
 * @return array<TKey, TValue>
 */
function processArray(array $array): array
{
    return $array;
}
```

### Pattern: Covariance/Contravariance Issues
**Error**: `Method should return [type] but returns [type]`
**Solution**:
```php
// Ensure return type compatibility
interface MyInterface
{
    public function method(): array;
}

class MyClass implements MyInterface
{
    public function method(): array
    {
        return []; // Must return array, not mixed
    }
}
```

### Pattern: Safe Function Usage
**Error**: `Function [function] is unsafe to use`
**Solution**:
```php
// Use Safe functions or proper error handling

try {
    $result = \Safe\\json_encode($data);
} catch (\Exception $e) {
    // Handle error
}

// OR

$result = json_encode($data);
if ($result === false) {
    throw new \RuntimeException('JSON encoding failed');
}
```

## Prevention Strategies

### 1. Code Organization
- Use proper namespaces and autoloading
- Follow PSR standards
- Implement clear module boundaries

### 2. Type Safety
- Always declare strict types
- Use proper PHPDoc annotations
- Implement input validation

### 3. Defensive Programming
- Check for null values
- Validate method existence
- Handle edge cases gracefully

### 4. Testing
- Write comprehensive unit tests
- Include type validation in tests
- Test error conditions

### 5. Tooling
- Use PHPStan regularly
- Integrate with CI/CD
- Monitor error trends over time

## Common Pitfalls and How to Avoid Them

### Pitfall 1: Missing Type Declarations
**Problem**: Mixed types causing operations to fail
**Solution**: Always declare parameter and return types

### Pitfall 2: Direct Property Access
**Problem**: Accessing properties without validation
**Solution**: Use getter methods or null-safe operators

### Pitfall 3: Cross-Module Dependencies
**Problem**: Tight coupling between modules
**Solution**: Use service contracts and dependency injection

### Pitfall 4: Insufficient Error Handling
**Problem**: Operations failing silently
**Solution**: Implement proper exception handling

## Recommended Coding Patterns

### Pattern 1: Defensive Property Access
```php
public function getProperty(): ?string
{
    return $this->property;
}

// Usage
$value = $object->getProperty() ?? 'default';
```

### Pattern 2: Type-Safe Operations
```php
public function calculate(float $a, float $b): float
{
    return $a * $b;
}

// Validate input before calling
if (is_numeric($inputA) && is_numeric($inputB)) {
    $result = calculate((float)$inputA, (float)$inputB);
}
```

### Pattern 3: Safe Array Access
```php
/**
 * @param array<string, mixed> $data
 * @param string $key
 * @return mixed
 */
public function getSafe(array $data, string $key)
{
    return $data[$key] ?? null;
}
```

### Pattern 4: Method Existence Checking
```php
public function callIfExists(object $object, string $method, array $params = [])
{
    if (method_exists($object, $method)) {
        return $object->$method(...$params);
    }
    return null;
}
```

By following these patterns and solutions, you can prevent common PHPStan errors and create more robust, type-safe code.