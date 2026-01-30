# Best Practice di Debugging

## Principi Fondamentali

### 1. Logging
- Usare SEMPRE logging strutturato
- Implementare SEMPRE log rotation
- Gestire SEMPRE i livelli di log

### 2. Tracing
- Usare SEMPRE tracing distribuito
- Implementare SEMPRE correlation ID
- Gestire SEMPRE il context

### 3. Error Handling
- Usare SEMPRE try-catch
- Implementare SEMPRE error reporting
- Gestire SEMPRE le eccezioni

## Esempio di Implementazione

### 1. Logging
```php
<?php

namespace Modules\Doctor\Services;

use Illuminate\Support\Facades\Log;
use Modules\Doctor\Models\Doctor;

class DoctorService
{
    public function create(array $data): Doctor
    {
        Log::info('Creating new doctor', [
            'email' => $data['email'],
            'name' => $data['name'],
        ]);

        try {
            $doctor = Doctor::create($data);
            Log::info('Doctor created successfully', [
                'id' => $doctor->id,
                'email' => $doctor->email,
            ]);
            return $doctor;
        } catch (\Exception $e) {
            Log::error('Failed to create doctor', [
                'error' => $e->getMessage(),
                'data' => $data,
            ]);
            throw $e;
        }
    }
}
```

### 2. Tracing
```php
<?php

namespace Modules\Doctor\Services;

use Illuminate\Support\Facades\Log;
use Modules\Doctor\Models\Doctor;

class DoctorService
{
    public function create(array $data): Doctor
    {
        $correlationId = uniqid('doctor_');
        Log::withContext(['correlation_id' => $correlationId]);

        try {
            $doctor = Doctor::create($data);
            Log::info('Doctor created successfully', [
                'id' => $doctor->id,
                'email' => $doctor->email,
            ]);
            return $doctor;
        } catch (\Exception $e) {
            Log::error('Failed to create doctor', [
                'error' => $e->getMessage(),
                'data' => $data,
            ]);
            throw $e;
        }
    }
}
```

### 3. Error Handling
```php
<?php

namespace Modules\Doctor\Exceptions;

use Exception;

class DoctorCreationException extends Exception
{
    public function __construct(string $message, array $context = [])
    {
        parent::__construct($message);
        $this->context = $context;
    }

    public function getContext(): array
    {
        return $this->context;
    }
}

namespace Modules\Doctor\Services;

use Modules\Doctor\Exceptions\DoctorCreationException;
use Modules\Doctor\Models\Doctor;

class DoctorService
{
    public function create(array $data): Doctor
    {
        try {
            $doctor = Doctor::create($data);
            return $doctor;
        } catch (\Exception $e) {
            throw new DoctorCreationException(
                'Failed to create doctor',
                ['data' => $data, 'error' => $e->getMessage()]
            );
        }
    }
}
```

## Errori Comuni

### 1. Logging Mancante
❌ Non implementare logging
✅ Implementare SEMPRE logging

### 2. Tracing Mancante
❌ Non implementare tracing
✅ Implementare SEMPRE tracing

### 3. Error Handling Mancante
❌ Non implementare error handling
✅ Implementare SEMPRE error handling

## Checklist

### Prima di Implementare Logging
- [ ] Logging strutturato
- [ ] Log rotation
- [ ] Livelli di log
- [ ] Test di logging

### Prima di Implementare Tracing
- [ ] Tracing distribuito
- [ ] Correlation ID
- [ ] Context
- [ ] Test di tracing

### Prima di Implementare Error Handling
- [ ] Try-catch
- [ ] Error reporting
- [ ] Eccezioni
- [ ] Test di error handling 
