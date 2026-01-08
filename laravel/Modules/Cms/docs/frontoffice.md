# Documentazione Frontoffice

## Introduzione

Questo documento descrive l'architettura e l'implementazione del frontoffice del progetto. Il frontoffice è l'interfaccia pubblica attraverso cui le gestanti possono accedere alle informazioni sul programma di <slogan>, verificare la propria idoneità, prenotare appuntamenti e monitorare il proprio percorso di cura.

## Architettura Generale

Il frontoffice è basato su un'architettura moderna che utilizza:

1. **Laravel Folio**: Per il routing basato su file
2. **Laravel Volt**: Per componenti interattivi con sintassi semplificata
3. **Livewire**: Per componenti interattivi più complessi 
4. **Alpine.js**: Per interazioni JavaScript leggere e reattive
5. **Tailwind CSS**: Per lo styling e la creazione di un'interfaccia moderna e accessibile

Questa architettura è stata scelta per garantire:
- Tempi di sviluppo rapidi
- Facilità di manutenzione
- Prestazioni ottimali
- Accessibilità per tutti gli utenti
- Esperienza coerente su tutti i dispositivi

## Sistema di Routing con Laravel Folio

Il routing del frontoffice è gestito principalmente attraverso Laravel Folio, un sistema di routing basato su file che permette di creare pagine senza definire esplicitamente le rotte.

```php
// app/Providers/FolioServiceProvider.php
use Laravel\Folio\Folio;

Folio::path(resource_path('views/pages'))->middleware([
    'web',
    'localization',
    'track-visits',
]);
```

Le caratteristiche principali implementate includono:

- **Routing basato su file**: Le pagine in `resources/views/pages/` diventano automaticamente rotte accessibili
- **Parametri dinamici**: Supporto per parametri nelle URL (es. `appointments/[id].blade.php`)
- **Middleware per localizzazione**: Supporto multilingua integrato
- **Middleware per privacy**: Gestione automatica dei consensi

Esempio di pagina Folio per visualizzare un appuntamento:

```php
// resources/views/pages/appointments/[id].blade.php
<?php

use function Laravel\Folio\{middleware, name};
use Modules\Dental\Models\Appointment;
use Modules\Patient\Models\Patient;

name('appointments.show');
middleware(['auth', 'can:view,appointment']);

$appointment = Appointment::findOrFail($id);
$patient = $appointment->patient;
?>

<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Dettaglio Appuntamento</h1>
        
        <x-appointment-card :appointment="$appointment" :detailed="true" />
        
        <!-- Cronologia appuntamenti -->
        <livewire:appointment-history :patient="$patient" :exclude="$appointment->id" />
    </div>
</x-app-layout>
```

## Componenti Interattivi con Volt e Livewire

Il frontoffice utilizza Laravel Volt per componenti semplici e Livewire per componenti più complessi. Questa combinazione permette di sviluppare rapidamente interfacce interattive mantenendo il codice leggibile e manutenibile.

### Esempi di Componenti Volt

```php
// resources/views/pages/components/eligibility-checker.blade.php

<x-volt>
    @prop(['redirectTo' => 'appointment.create'])
    @state(['iseeValue' => '', 'isPregnant' => false, 'errors' => [], 'isEligible' => null])
    
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">Verifica Idoneità</h2>
        
        <form wire:submit="checkEligibility">
            <div class="mb-4">
                <x-input-label for="iseeValue" value="Valore ISEE" />
                <x-text-input id="iseeValue" wire:model="iseeValue" type="number" class="mt-1 block w-full" required />
                @error('iseeValue') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" wire:model="isPregnant" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                    <span class="ml-2">Sono in stato di gravidanza</span>
                </label>
                @error('isPregnant') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            
            <x-primary-button type="submit">Verifica Idoneità</x-primary-button>
        </form>
        
        @if ($isEligible === true)
            <div class="mt-4 p-4 bg-green-100 text-green-700 rounded-md">
                <p class="font-medium">Congratulazioni! Sei idonea a partecipare al programma.</p>
                <a href="{{ route($redirectTo) }}" class="mt-2 inline-block text-indigo-600 underline">Prenota un appuntamento</a>
            </div>
        @elseif ($isEligible === false)
            <div class="mt-4 p-4 bg-red-100 text-red-700 rounded-md">
                <p class="font-medium">Ci dispiace, non risulti idonea al programma in base ai criteri indicati.</p>
                <p class="mt-1">Per maggiori informazioni contatta il nostro centro supporto.</p>
            </div>
        @endif
    </div>
    
    <script>
        function checkEligibility() {
            // Controlla che i valori siano validi
            this.errors = [];
            
            if (!this.iseeValue) {
                this.errors.push('Il valore ISEE è obbligatorio');
                return;
            }
            
            if (!this.isPregnant) {
                this.errors.push('Solo le gestanti possono accedere al programma');
                return;
            }
            
            // Valore ISEE massimo per l'idoneità
            this.isEligible = (this.iseeValue <= 20000 && this.isPregnant);
        }
    </script>
</x-volt>
```

### Componenti Livewire Principali

I componenti Livewire implementati includono:

- **AppointmentBooking**: Workflow completo per prenotazione appuntamenti
- **EligibilityVerification**: Verifica i requisiti di accesso al programma
- **PatientProfile**: Gestione del profilo paziente
- **AppointmentCalendar**: Visualizzazione e gestione appuntamenti
- **OralHealthAssessment**: Questionario di valutazione <slogan>
- **Notifications**: Sistema di notifiche per le pazienti

## Integrazione con il Backend

Il frontoffice si integra con il backend tramite diversi canali:

1. **Connessione diretta ai modelli**: Per operazioni semplici (Volt/Folio)
2. **Livewire**: Per operazioni complesse con validazione e logica sul server
3. **API RESTful**: Per operazioni asincrone avanzate
4. **Eventi real-time**: Per notifiche push in tempo reale

Esempio di integrazione tramite API:

```php
// resources/js/api/appointments.js
import axios from 'axios';

export default {
    getAvailableSlots(date, dentistId = null) {
        return axios.get('/api/appointments/available-slots', {
            params: { date, dentist_id: dentistId }
        });
    },
    
    bookAppointment(data) {
        return axios.post('/api/appointments', data);
    },
    
    rescheduleAppointment(id, data) {
        return axios.patch(`/api/appointments/${id}/reschedule`, data);
    },
    
    cancelAppointment(id, reason) {
        return axios.delete(`/api/appointments/${id}`, {
            data: { cancellation_reason: reason }
        });
    }
};
```

## Caratteristiche Chiave del Frontoffice

### 1. Portale Informativo

Il frontoffice include sezioni informative sulle tematiche di <slogan> durante la gravidanza:

- Importanza dell'igiene orale in gravidanza
- Rischi e problematiche comuni
- Consigli pratici e best practice
- FAQ e glossario

### 2. Verifica Idoneità

Sistema di verifica dei requisiti di accesso al programma (ISEE inferiore a 20.000 euro e stato di gravidanza).

### 3. Gestione Appuntamenti

Funzionalità complete per la gestione degli appuntamenti, inclusi:

- Prenotazione guidata multi-step
- Visualizzazione disponibilità in tempo reale
- Ricalendarizzazione e cancellazione
- Promemoria automatici

### 4. Area Personale

Ogni gestante ha accesso a un'area personale che include:

- Riepilogo dati personali
- Cronologia appuntamenti
- Documenti e referti
- Piano di trattamento
- Notifiche e comunicazioni

### 5. Materiale Educativo

Sezione contenente risorse educative sulla <slogan>:

- Articoli informativi
- Video tutorial
- Infografiche
- Checklist per l'igiene orale quotidiana

## Accessibilità e Compliance

Il frontoffice è stato sviluppato con particolare attenzione a:

- **Accessibilità WCAG 2.1 AA**: Supporto completo per screen reader e navigazione da tastiera
- **Design responsivo**: Ottimizzato per desktop, tablet e dispositivi mobili
- **Compliance GDPR**: Gestione trasparente dei consensi e dei dati personali
- **Multilingua**: Supporto per italiano e le principali lingue straniere

## Testing e Qualità

Il frontoffice è sottoposto a:

- Test automatizzati di UI con Laravel Dusk
- Test unitari per la logica di business
- Test di accessibilità con strumenti automatizzati
- Test manuali con utenti reali

## Override dei Template FrontOffice

La personalizzazione dell'header del FrontOffice si effettua sovrascrivendo la Blade nel tema attivo:
```
<laravel_base>/Themes/<ThemeName>/resources/views/components/sections/header.blade.php
```
I dati dell'header sono caricati da:
```
<laravel_base>/config/local/<project_key>/database/content/sections/1.json
```
Assicurarsi che la directory `database` sia minuscola.

## Estensione del Frontoffice

Per estendere il frontoffice con nuove funzionalità:

1. Aggiungere nuove pagine nella directory `resources/views/pages/`
2. Creare nuovi componenti Volt o Livewire come necessario
3. Integrare con il backend tramite Livewire o APIs
4. Aggiornare la documentazione

## Collegamenti Bidirezionali
- [README](README.md) - Documentazione principale del modulo
- [Architettura](architecture.md) - Architettura generale del frontoffice
- [Gestione Route](gestione-route-folio.md) - Gestione delle route con Folio
- [Volt](volt-web-application.md) - Sviluppo con Laravel Volt
- [Layout](struttura-layout-componenti-blade-<nome progetto>.md) - Struttura dei layout
- [Homepage](homepage.md) - Gestione della homepage
- [Componenti](components.md) - Componenti riutilizzabili
- [Wizard](ux-wizard-registrazione-paziente.md) - Wizard di registrazione

## Vedi Anche
- [Modulo UI](../UI/docs/README.md) - Componenti UI per il frontoffice
- [Modulo Lang](../Lang/docs/README.md) - Gestione traduzioni
- [Modulo User](../User/docs/README.md) - Gestione utenti
- [Modulo Xot](../Xot/docs/README.md) - Classi base e utilities
- [Documentazione Volt](volt-introduction.md) - Introduzione a Laravel Volt
- [Documentazione Folio](folio-pages.md) - Gestione delle pagine con Laravel Folio