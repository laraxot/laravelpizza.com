# ERRORE GRAVE: Form Custom invece di Widget Filament

## Data: 2025-05-28

## Errore Commesso
Ho creato un form custom con Livewire/Volt in `/Themes/One/resources/views/pages/patient/book.blade.php` invece di utilizzare il widget Filament esistente `FindDoctorAndAppointmentWidget`.

## File Coinvolti
- ❌ `/laravel/Themes/One/resources/views/pages/patient/book.blade.php` - Form custom creato
- ✅ `/laravel/Modules/<nome progetto>/app/Filament/Widgets/Patient/FindDoctorAndAppointmentWidget.php` - Widget da usare

## Perché è Grave
1. **Duplicazione di codice**: Il widget esiste già
2. **Incoerenza**: Il progetto usa Filament per TUTTI i form
3. **Manutenibilità**: Due implementazioni diverse dello stesso form
4. **Filosofia violata**: "Usa sempre Filament widgets per i form"

## Analisi Filosofica dell'Errore

### Politica
- La politica del progetto è centralizzare i form in Filament
- Ho violato questa politica creando un form esterno

### Filosofia
- DRY (Don't Repeat Yourself) - violato duplicando logica
- Separation of Concerns - i form devono stare nei widget
- Consistency - tutti i form devono essere Filament

### Logica
- Se esiste un widget, usalo
- Non reinventare la ruota
- Mantieni un'unica fonte di verità

### Religione/Zen del Codice
- "Il codice deve fluire in armonia"
- "Un pattern, una via"
- "La coerenza è illuminazione"

## Causa Radice
1. Non ho verificato l'esistenza di widget prima di creare
2. Ho assunto che le pagine Folio debbano avere form custom
3. Non ho seguito la metodologia delle 8 fasi

## Lezione Appresa
SEMPRE verificare l'esistenza di widget Filament prima di creare qualsiasi form.
