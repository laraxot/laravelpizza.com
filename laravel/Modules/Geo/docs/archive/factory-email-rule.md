# Regola Critica: Email nelle Factory - Progetto <nome progetto>

## ⚠️ REGOLA ASSOLUTAMENTE VIETATA ⚠️
**MAI utilizzare email fittizie come "@example.com" nelle factory**

## Significato e Importanza
Questa regola è **SACRA** e **IMMUTABILE** nel progetto <nome progetto>. Ogni factory deve utilizzare sempre i faker appropriati per generare email realistiche e uniche. L'uso di email fittizie come "@example.com" è assolutamente vietato.

## Applicazione Globale

### In Tutti i Moduli
- **<nome progetto>**: Factory Patient, Doctor e tutte le altre
- **User**: Factory per utenti e autenticazione
- **UI**: Factory per componenti e widget
- **Xot**: Factory per funzionalità base

### In Tutti i File Factory
- **PHP**: Email generate sempre con faker
- **Markdown**: Documentazione aggiornata
- **Test**: Verifica compliance con la regola

## Esempi di Applicazione

### ❌ Cosa NON Fare (ASSOLUTAMENTE VIETATO)
```php
// ❌ VIETATO - Email fittizie
'email' => 'patient+'.uniqid('', true).'@example.com',
'email' => 'user@example.com',
'email' => 'test@test.com',
'email' => 'admin@admin.com',
'email' => 'doctor+'.uniqid().'@example.com',
```

### ✅ Cosa Fare SEMPRE (OBBLIGATORIO)
```php
// ✅ OBBLIGATORIO - Email con faker
'email' => $this->faker->unique()->safeEmail(),
'email' => $this->faker->unique()->email(),
'email' => $this->faker->unique()->freeEmail(),
'email' => $this->faker->unique()->companyEmail(),
```

## Pattern Corretto per Tutte le Factory

### PatientFactory
```php
public function definition(): array
{
    return [
        'name' => $this->faker->firstName(),
        'last_name' => $this->faker->lastName(),
        'email' => $this->faker->unique()->safeEmail(), // ✅ SEMPRE così
        'phone' => $this->faker->phoneNumber(),
        'address' => $this->faker->streetAddress(),
        'city' => $this->faker->city(),
        // ... altri campi
    ];
}
```

### DoctorFactory
```php
public function definition(): array
{
    return [
        'name' => $this->faker->firstName(),
        'last_name' => $this->faker->lastName(),
        'email' => $this->faker->unique()->safeEmail(), // ✅ SEMPRE così
        'phone' => $this->faker->phoneNumber(),
        'address' => $this->faker->streetAddress(),
        'city' => $this->faker->city(),
        // ... altri campi
    ];
}
```

## Faker Email Disponibili

### Laravel Faker Standard
- `$this->faker->unique()->safeEmail()` - user@example.org
- `$this->faker->unique()->email()` - user@example.com  
- `$this->faker->unique()->freeEmail()` - user@gmail.com
- `$this->faker->unique()->companyEmail()` - user@company.com

### Pattern Avanzato
```php
'email' => $this->faker->unique()->userName() . '@' . $this->faker->domainName(),
```

## Motivazione

1. **Realismo**: I faker generano email realistiche e valide
2. **Unicità**: `unique()` garantisce email non duplicate
3. **Professionalità**: Codice di produzione, non di test amatoriale
4. **Qualità**: Standard elevato per tutto il progetto
5. **Consistenza**: Uniformità con le best practice Laravel
6. **Manutenibilità**: Codice più pulito e professionale

## Checklist di Verifica Globale

### Prima di ogni commit:
- [ ] Ho rimosso tutte le email "@example.com"?
- [ ] Ho usato sempre i faker appropriati?
- [ ] Ho verificato che le email siano uniche con `unique()`?

### Durante lo sviluppo:
- [ ] Sto usando i faker per tutti i campi email?
- [ ] Sto evitando stringhe hardcoded per email?
- [ ] Sto garantendo l'unicità delle email?

### Code Review:
- [ ] Ho verificato che non ci siano email hardcoded?
- [ ] Ho controllato l'uso corretto dei faker?
- [ ] Ho garantito la qualità del codice?

## Anti-Pattern da Eliminare

1. **Email hardcoded**: `'email' => 'test@test.com'`
2. **Pattern fittizi**: `'email' => 'user+'.uniqid().'@example.com'`
3. **Domini fake**: `'email' => 'admin@admin.com'`
4. **Stringhe statiche**: `'email' => 'user@example.com'`
5. **Concatenazioni manuali**: `'email' => 'user'.uniqid().'@example.com'`

## Responsabilità nel Progetto

### Sviluppatore:
- **MAI** committare factory con email "@example.com"
- **SEMPRE** usare faker appropriati
- **VERIFICARE** l'unicità delle email

### Team Lead:
- **RIFIUTARE** modifiche con email hardcoded
- **VERIFICARE** l'uso corretto dei faker
- **PROMUOVERE** miglioramenti continui

### Code Review:
- **VERIFICARE** sempre il rispetto della regola
- **RIFIUTARE** PR che violano la regola
- **GARANTIRE** la qualità del codice

## Implementazione della Regola

### Fase 1: Identificazione
- Cercare tutte le occorrenze di "@example.com"
- Identificare factory non conformi
- Documentare violazioni trovate

### Fase 2: Correzione
- Sostituire email hardcoded con faker
- Verificare l'unicità delle email
- Testare le factory corrette

### Fase 3: Prevenzione
- Aggiornare regole e documentazione
- Implementare controlli automatici
- Formare il team sulla regola

## Collegamenti

- [Regola Cursor](../../.cursor/rules/factory-email-rule.mdc)
- [Regola <nome progetto>](../laravel/Modules/<nome progetto>/docs/factory-email-rule.md)
- [Regola Windsurf](../../.windsurf/rules/factory-email-rule.mdc)
- [Best Practices](best-practices.md)
- [Factory Guidelines](factory-guidelines.md)

---

**⚠️ RICORDA SEMPRE: Questa regola è SACRA e non può essere violata. Ogni factory deve usare SEMPRE faker per le email, MAI "@example.com"!**


