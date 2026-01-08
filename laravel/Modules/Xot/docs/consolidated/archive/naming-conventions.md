# Convenzioni di Naming dei Campi in Base

## Regola Fondamentale
In Base, i campi relativi ai nomi delle persone seguono sempre la convenzione inglese:

- ✅ SEMPRE usare `first_name` (mai `name`)
- ✅ SEMPRE usare `last_name` (mai `surname`)

## Convenzioni Generali

### Campi Personali
- `first_name`: Nome della persona
- `last_name`: Cognome della persona
- `birth_date`: Data di nascita (formato YYYY-MM-DD)
- `gender`: Genere (enum)
- `tax_code`: Codice fiscale
- `email`: Indirizzo email
- `phone`: Numero di telefono
- `mobile`: Numero di cellulare
- `address`: Indirizzo completo
- `city`: Città
- `province`: Provincia (2 caratteri)
- `postal_code`: CAP (5 caratteri)
- `country`: Paese (default: 'IT')

### Campi Medici
- `health_card`: Numero tessera sanitaria
- `family_doctor`: Medico di base
- `blood_type`: Gruppo sanguigno
- `allergies`: Allergie (array)
- `chronic_diseases`: Malattie croniche (array)
- `medications`: Farmaci assunti (array)

### Campi Odontoiatrici
- `dental_history`: Anamnesi odontoiatrica
- `last_checkup`: Ultima visita di controllo
- `next_appointment`: Prossimo appuntamento
- `treatment_plan`: Piano di trattamento
- `dental_notes`: Note odontoiatriche

### Campi Amministrativi
- `created_at`: Data di creazione
- `updated_at`: Data di ultima modifica
- `deleted_at`: Data di cancellazione (soft delete)
- `created_by`: ID utente che ha creato il record
- `updated_by`: ID utente che ha modificato il record
- `deleted_by`: ID utente che ha cancellato il record

## Esempi di Implementazione

### Model
```php
class Patient extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'birth_date',
        'gender',
        'tax_code',
        'email',
        'phone',
        'address',
        'city',
        'province',
        'postal_code',
        'health_card',
        'family_doctor',
        'blood_type',
        'allergies',
        'chronic_diseases',
        'medications',
        'dental_history',
        'last_checkup',
        'next_appointment',
        'treatment_plan',
        'dental_notes',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'allergies' => 'array',
        'chronic_diseases' => 'array',
        'medications' => 'array',
        'last_checkup' => 'datetime',
        'next_appointment' => 'datetime',
    ];
}
```

### Migration
```php
Schema::create('patients', function (Blueprint $table) {
    $table->id();
    $table->string('first_name');
    $table->string('last_name');
    $table->date('birth_date');
    $table->string('gender');
    $table->string('tax_code', 16)->unique();
    $table->string('email')->unique();
    $table->string('phone', 20);
    $table->string('address');
    $table->string('city');
    $table->string('province', 2);
    $table->string('postal_code', 5);
    $table->string('health_card')->nullable();
    $table->string('family_doctor')->nullable();
    $table->string('blood_type')->nullable();
    $table->json('allergies')->nullable();
    $table->json('chronic_diseases')->nullable();
    $table->json('medications')->nullable();
    $table->text('dental_history')->nullable();
    $table->timestamp('last_checkup')->nullable();
    $table->timestamp('next_appointment')->nullable();
    $table->text('treatment_plan')->nullable();
    $table->text('dental_notes')->nullable();
    $table->timestamps();
    $table->softDeletes();
});
```

## Best Practices

1. **Consistenza**: Mantenere sempre la stessa convenzione in tutto il progetto
2. **Chiarità**: Usare nomi descrittivi e autoesplicativi
3. **Standard**: Seguire gli standard Laravel per i nomi delle colonne
4. **Documentazione**: Documentare sempre le convenzioni di naming nel README del modulo

## Collegamenti Correlati

- [Convenzioni](../../../project_docs/conventions.md)
- [Naming Conventions](../../../project_docs/naming-conventions.md)
- [Documentazione Xot](../CODE-STANDARDS.md)
- [Collegamenti Documentazione](../../../../project_docs/collegamenti-documentazione.md) 
