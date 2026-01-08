# Validazione

## Configurazione Base

### Validazione
```php
// config/validation.php
return [
    'default' => 'default',
    'custom' => [
        'attributes' => [
            'email' => 'indirizzo email',
            'password' => 'password',
        ],
        'messages' => [
            'required' => 'Il campo :attribute è obbligatorio.',
            'email' => 'Il campo :attribute deve essere un indirizzo email valido.',
        ],
    ],
];
```

## Validazione Base

### Form Request
```php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user?->id,
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,user,editor',
            'avatar' => 'nullable|image|max:1024',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Il nome è obbligatorio',
            'email.required' => 'L\'email è obbligatoria',
            'password.required' => 'La password è obbligatoria',
        ];
    }
}
```

### Validazione Manuale
```php
use Illuminate\Support\Facades\Validator;

$validator = Validator::make($request->all(), [
    'title' => 'required|unique:posts|max:255',
    'body' => 'required',
]);

if ($validator->fails()) {
    return redirect('post/create')
        ->withErrors($validator)
        ->withInput();
}
```

## Regole di Validazione

### Regole Base
```php
'required'              // Campo obbligatorio
'string'               // Deve essere una stringa
'integer'              // Deve essere un intero
'numeric'              // Deve essere un numero
'email'                // Deve essere un'email valida
'url'                  // Deve essere un URL valido
'date'                 // Deve essere una data valida
'boolean'              // Deve essere un booleano
'array'                // Deve essere un array
'file'                 // Deve essere un file
'image'                // Deve essere un'immagine
```

### Regole Avanzate
```php
'unique:table,column'   // Deve essere unico nella tabella
'exists:table,column'   // Deve esistere nella tabella
'confirmed'            // Deve avere un campo di conferma
'different:field'      // Deve essere diverso da un altro campo
'same:field'           // Deve essere uguale a un altro campo
'in:value1,value2'     // Deve essere uno dei valori specificati
'not_in:value1,value2' // Non deve essere uno dei valori specificati
'between:min,max'      // Deve essere compreso tra min e max
'size:value'           // Deve avere la dimensione specificata
```

## Best Practices

### 1. Struttura
- Utilizzare Form Requests
- Separare le regole
- Documentare le validazioni
- Gestire i messaggi

### 2. Performance
- Ottimizzare le regole
- Utilizzare le cache
- Implementare il rate limiting
- Monitorare le validazioni

### 3. Sicurezza
- Sanitizzare gli input
- Validare i file
- Proteggere i dati sensibili
- Implementare il logging

### 4. Manutenzione
- Monitorare le validazioni
- Gestire i fallimenti
- Implementare alerting
- Documentare le regole

## Esempi di Utilizzo

### Validazione Custom
```php
use Illuminate\Validation\Rule;

$rules = [
    'email' => [
        'required',
        'email',
        Rule::unique('users')->ignore($user->id),
    ],
    'role' => [
        'required',
        Rule::in(['admin', 'user', 'editor']),
    ],
];
```

### Validazione Condizionale
```php
$rules = [
    'type' => 'required|in:individual,company',
    'company_name' => 'required_if:type,company',
    'vat_number' => 'required_if:type,company',
    'first_name' => 'required_if:type,individual',
    'last_name' => 'required_if:type,individual',
];
```

## Strumenti Utili

### Comandi Artisan
```bash
# Creare un Form Request
php artisan make:request UserRequest

# Creare una Rule
php artisan make:rule CustomRule
```

### Custom Rules
```php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CustomRule implements Rule
{
    public function passes($attribute, $value)
    {
        return $value === 'custom';
    }

    public function message()
    {
        return 'Il valore deve essere custom.';
    }
}
```

## Gestione degli Errori

### Errori di Validazione
```php
try {
    $validated = $request->validate([
        'email' => 'required|email',
    ]);
} catch (\Illuminate\Validation\ValidationException $e) {
    return response()->json([
        'message' => 'Dati non validi',
        'errors' => $e->errors(),
    ], 422);
}
```

### Logging
```php
use Illuminate\Support\Facades\Log;

Validator::make($request->all(), [
    'email' => 'required|email',
])->after(function ($validator) {
    if ($validator->fails()) {
        Log::warning('Validazione fallita', [
            'errors' => $validator->errors()->toArray(),
        ]);
    }
});
``` 