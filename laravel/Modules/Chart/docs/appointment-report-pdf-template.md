# Appointment Report PDF Template

## Overview
The appointment report PDF template (`laravel/Themes/One/resources/views/appointment/report_pdf.blade.php`) provides a comprehensive, professional PDF generation for appointment reports in the <nome progetto> system.

## Features

### 📋 **Complete Appointment Information**
- Appointment ID and scheduling details
- Studio information (name, address, phone, email)
- Appointment status with color-coded badges
- Date and time information

### 👤 **Patient and Doctor Details**
- Patient information (name, email, phone)
- Doctor information (name, specialization)
- Conditional display based on data availability

### 🏥 **Comprehensive Medical Report**
- Complete dental health questionnaire
- All medical history questions from the Report model
- Conditional display of pregnancy information
- Detailed specifications for each health condition

### 🌍 **Multilingual Support**
- Full support for Italian, English, and German
- All text uses translation keys from `pub_theme::appointment.*`
- Dynamic language switching based on user locale

### 🎨 **Professional Styling**
- Clean, medical-grade layout
- Color-coded status badges
- Proper typography and spacing
- Page breaks for better organization
- Professional header and footer

## Translation Keys

### Core Appointment Keys
```php
'pub_theme::txt.appointment.title' => 'Appuntamento in programma'
'pub_theme::txt.appointment.data' => 'Data'
'pub_theme::txt.appointment.time' => 'Orario'
'pub_theme::txt.appointment.studio' => 'Studio'
'pub_theme::txt.appointment.studio_address' => 'Indirizzo studio'
'pub_theme::txt.appointment.phone' => 'Telefono'
'pub_theme::txt.appointment.email' => 'Email'
'pub_theme::txt.appointment.state' => 'Stato'
```

### Medical Report Keys
```php
'pub_theme::appointment.medical_report.title' => 'Referto Medico'
'pub_theme::appointment.medical_report.pain_history' => 'Ha sofferto di dolore a bocca o denti negli ultimi 12 mesi?'
'pub_theme::appointment.medical_report.smoking' => 'Fuma?'
'pub_theme::appointment.medical_report.dental_visits' => 'Si reca dal dentista almeno una volta l\'anno?'
'pub_theme::appointment.medical_report.diseases' => 'È affetta da qualche malattia?'
'pub_theme::appointment.medical_report.missing_teeth' => 'Ha denti mancanti?'
'pub_theme::appointment.medical_report.decayed_teeth' => 'Ha denti cariati?'
'pub_theme::appointment.medical_report.prosthesis_implants' => 'Ha protesi fissa o impianti?'
'pub_theme::appointment.medical_report.tartar' => 'Ha tartaro?'
'pub_theme::appointment.medical_report.plaque' => 'Ha placca?'
'pub_theme::appointment.medical_report.additional_care' => 'La Paziente necessita di ulteriori cure odontoiatriche?'
'pub_theme::appointment.medical_report.yes' => 'Sì'
'pub_theme::appointment.medical_report.no' => 'No'
```

## Data Structure

### Appointment Model Requirements
The template expects an `$appointment` object with the following relationships:
- `$appointment->studio` (Studio model)
- `$appointment->patient` (User model, optional)
- `$appointment->doctor` (User model, optional)
- `$appointment->report` (Report model, optional)

### Report Model Fields
The medical report section uses all fields from the Report model:
- `has_mouth_or_teeth_pain`
- `mouth_teeth_pain_frequency`
- `pregnancy_month`
- `pregnancy_week`
- `teeth_brushing_frequency`
- `smokes`
- `visits_dentist_yearly`
- `has_diseases`
- `specify_diseases`
- `follows_diet_rules`
- `uses_asl_clinic_for_dental_care`
- `missing_teeth`
- `specify_missing_teeth`
- `more_info_missing_teeth`
- `decayed_teeth`
- `specify_decayed_teeth`
- `more_info_decayed_teeth`
- `has_fixed_prosthesis_or_implants`
- `specify_prosthesis_or_implants`
- `more_info_prosthesis`
- `has_tartar`
- `specify_tartar`
- `more_info_tartar`
- `has_plaque`
- `specify_plaque`
- `more_info_plaque`
- `needs_more_dental_care`
- `further_notes`

## Usage

### Basic Usage
```php
// In a controller or action
$appointment = Appointment::with(['studio', 'patient', 'doctor', 'report'])->find($id);

// Generate PDF using the template
$pdf = PDF::loadView('pub_theme::appointment.report_pdf', compact('appointment'));

// Download or display
return $pdf->download('appointment-report-' . $appointment->id . '.pdf');
```

### With Custom Data
```php
// Add additional data if needed
$data = [
    'appointment' => $appointment,
    'custom_header' => 'Custom Report Header',
    'additional_notes' => 'Additional notes...'
];

$pdf = PDF::loadView('pub_theme::appointment.report_pdf', $data);
```

## Styling

### CSS Classes
- `.header`: Main document header
- `.section`: Content sections
- `.section-title`: Section headers with blue accent
- `.info-grid`: Table-like layout for information
- `.medical-section`: Medical report container
- `.medical-question`: Medical question styling
- `.medical-answer`: Medical answer styling
- `.status-badge`: Status indicator badges
- `.footer`: Document footer

### Color Scheme
- Primary Blue: `#3b82f6`
- Success Green: `#065f46`
- Warning Yellow: `#92400e`
- Danger Red: `#991b1b`
- Info Blue: `#1e40af`

## Conditional Display

### Medical Report Section
The medical report section only displays if:
```php
@if($appointment->hasReport() && $appointment->report)
```

### Optional Fields
Many fields display conditionally:
- Pregnancy information only if month or week is set
- Dental hygiene frequency only if specified
- Additional specifications only if main condition is true
- Further notes only if provided

## Browser Compatibility

### PDF Generation
- Compatible with DomPDF, mPDF, and other Laravel PDF packages
- Uses standard CSS properties for consistent rendering
- Includes proper font fallbacks for PDF generation

### Font Support
- Primary: DejaVu Sans (PDF-friendly)
- Fallback: Arial, sans-serif
- Supports UTF-8 characters for multilingual content

## Maintenance

### Adding New Fields
1. Add the field to the Report model
2. Add translation keys for the new field
3. Update the PDF template with conditional display
4. Test with sample data

### Updating Translations
1. Modify the translation files in all three languages
2. Verify syntax with `php -l`
3. Test PDF generation in each language
4. Update documentation

### Styling Changes
1. Modify CSS in the template
2. Test PDF generation
3. Verify layout in different content scenarios
4. Update documentation if needed

## Related Files

### Translation Files
- `laravel/Themes/One/lang/it/appointment.php`
- `laravel/Themes/One/lang/en/appointment.php`
- `laravel/Themes/One/lang/de/appointment.php`

### Models
- `laravel/Modules/<nome progetto>/app/Models/Appointment.php`
- `laravel/Modules/<nome progetto>/app/Models/Report.php`
- `laravel/Modules/<nome progetto>/app/Models/Studio.php`

### Documentation
- `docs/translation_completeness_audit.md`
- `docs/appointment_item_translation_fix.md`

## Notes
- The template maintains exact visual structure and layout
- All text is properly localized for multilingual support
- No hardcoded text remains in the template
- Professional medical-grade formatting
- Comprehensive error handling for missing data 