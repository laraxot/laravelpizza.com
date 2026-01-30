# Implementazione Frontend

## Stato Attuale

Il frontend del progetto il progetto deve essere implementato seguendo il design presentato nel documento di progetto, con particolare attenzione ai flussi utente per pazienti, odontoiatri e personale di back office.

### Componenti Implementati ✅

- Moduli UI e ThemeOne di Laraxot integrati
- Struttura base per Filament

### Componenti Da Implementare ⏳

- Interfaccia pubblica per pazienti
- Dashboard per odontoiatri
- Pannello amministrativo per back office
- Flussi di registrazione e autenticazione

## Attività da Completare

### 1. Configurazione Filament (P0)

#### Descrizione
Configurare Filament come framework di amministrazione per il progetto.

#### Implementazione
1. **Installare Filament**:
   ```bash
   cd /var/www/html/<nome progetto>/laravel
   composer require filament/filament:"^3.0"
   php artisan filament:install --panels
   ```

2. **Configurare i pannelli**:
   ```php
   // Pannello amministrativo
   php artisan make:filament-panel admin
   
   // Pannello odontoiatra
   php artisan make:filament-panel dentist
   
   // Pannello paziente
   php artisan make:filament-panel patient
   ```

3. **Personalizzare tema**:
   Utilizzare il modulo ThemeOne per applicare il tema personalizzato a Filament.

### 2. Implementazione Interfaccia Pubblica (P1)

#### Descrizione
Creare l'interfaccia pubblica per la homepage e la registrazione delle pazienti.

#### Implementazione
1. **Creare layout principale**:
   ```blade
   <!-- resources/views/layouts/public.blade.php -->
   <!DOCTYPE html>
   <html lang="it">
   <head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <title>il progetto - @yield('title')</title>
       @vite(['resources/css/app.css', 'resources/js/app.js'])
   </head>
   <body>
       <header class="bg-white shadow">
           <div class="container mx-auto px-4 py-6">
               <div class="flex justify-between items-center">
                   <img src="{{ asset('images/logo.png') }}" alt="il progetto" class="h-16">
                   <nav>
                       <ul class="flex space-x-6">
                           <li><a href="{{ route('home') }}">Home</a></li>
                           <li><a href="{{ route('about') }}">Il Progetto</a></li>
                           <li><a href="{{ route('register') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Partecipa</a></li>
                       </ul>
                   </nav>
               </div>
           </div>
       </header>
       
       <main>
           @yield('content')
       </main>
       
       <footer class="bg-gray-800 text-white py-12">
           <div class="container mx-auto px-4">
               <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                   <!-- Footer content -->
               </div>
           </div>
       </footer>
   </body>
   </html>
   ```

2. **Creare homepage**:
   ```blade
   <!-- resources/views/home.blade.php -->
   @extends('layouts.public')
   
   @section('title', 'Homepage')
   
   @section('content')
   <div class="hero bg-blue-100 py-20">
       <div class="container mx-auto px-4">
           <h1 class="text-4xl font-bold mb-6">Promozione della salute orale per le gestanti</h1>
           <p class="text-xl mb-8">Un'iniziativa coordinata dall'INMP, con la collaborazione della Fondazione ETS.</p>
           <a href="{{ route('register') }}" class="bg-blue-500 text-white px-6 py-3 rounded-lg text-xl">Partecipa al Progetto</a>
       </div>
   </div>
   
   <div class="py-16 container mx-auto px-4">
       <!-- Content sections -->
   </div>
   @endsection
   ```

3. **Implementare form di registrazione**:
   Creare un form multi-step per la registrazione delle pazienti secondo i requisiti del progetto.

### 3. Dashboard Paziente (P1)

#### Descrizione
Implementare la dashboard per le pazienti con funzionalità di prenotazione e gestione appuntamenti.

#### Implementazione
1. **Creare risorse Filament per il pannello paziente**:
   ```bash
   php artisan make:filament-page Dashboard --panel=patient
   php artisan make:filament-page FindDentist --panel=patient
   php artisan make:filament-page BookAppointment --panel=patient
   php artisan make:filament-page MyAppointments --panel=patient
   ```

2. **Implementare mappa per trovare dentisti**:
   Integrare una soluzione di geocoding e mappa per la ricerca degli studi odontoiatrici.

3. **Implementare calendario per prenotazioni**:
   Utilizzare un componente calendario per la selezione delle date disponibili.

### 4. Dashboard Odontoiatra (P1)

#### Descrizione
Implementare la dashboard per gli odontoiatri con gestione appuntamenti e referti.

#### Implementazione
1. **Creare risorse Filament per il pannello odontoiatra**:
   ```bash
   php artisan make:filament-page Dashboard --panel=dentist
   php artisan make:filament-resource Appointment --panel=dentist
   php artisan make:filament-page MyAvailability --panel=dentist
   php artisan make:filament-page Reimbursements --panel=dentist
   ```

2. **Implementare gestione disponibilità**:
   Creare un'interfaccia per la gestione degli orari di disponibilità.

3. **Implementare form per referti**:
   Creare form per la compilazione dei referti post-visita.

### 5. Pannello Amministrativo (P1)

#### Descrizione
Implementare il pannello di amministrazione per il back office.

#### Implementazione
1. **Creare risorse Filament per il pannello admin**:
   ```bash
   php artisan make:filament-resource Patient --panel=admin
   php artisan make:filament-resource Dentist --panel=admin
   php artisan make:filament-resource Appointment --panel=admin
   php artisan make:filament-resource Reimbursement --panel=admin
   ```

2. **Implementare dashboard con statistiche**:
   ```php
   // App\Filament\Admin\Widgets\StatsOverview.php
   use Filament\Widgets\StatsOverviewWidget as BaseWidget;
   
   class StatsOverview extends BaseWidget
   {
       protected function getStats(): array
       {
           return [
               // Stats cards
           ];
       }
   }
   ```

3. **Implementare widget di notifica**:
   Creare widget per le notifiche di sistema al superamento delle soglie.

### 6. Implementazione GDPR UI (P0)

#### Descrizione
Implementare interfacce per la gestione del consenso e diritti GDPR.

#### Implementazione
1. **Creare form di consenso**:
   Implementare form di consenso durante la registrazione.

2. **Implementare pagina per gestione diritti**:
   Creare pagina dove gli utenti possono esercitare i propri diritti (accesso, rettifica, cancellazione).

### 7. Responsive Design (P2)

#### Descrizione
Assicurarsi che tutte le interfacce siano responsive e funzionino su dispositivi mobili.

#### Implementazione
1. **Utilizzare TailwindCSS**:
   ```bash
   npm install tailwindcss postcss autoprefixer
   npx tailwindcss init -p
   ```

2. **Implementare breakpoint responsive**:
   Utilizzare le classi responsive di Tailwind per adattare l'interfaccia a diversi dispositivi.

## Criteri di Accettazione

- ✅ Le interfacce corrispondono ai mockup nel documento di progetto
- ✅ Tutti i flussi utente sono implementati e funzionanti
- ✅ L'interfaccia è responsive e funziona su dispositivi mobili
- ✅ I form includono validazione e feedback per l'utente
- ✅ Le interfacce GDPR sono conformi alle normative

## Dipendenze e Prerequisiti

- Laravel Framework 12.x
- Filament 4.x
- TailwindCSS
- AlpineJS
- Backend API funzionante
