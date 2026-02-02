# Architettura Separazione Tema - Modulo Meetup

**Data**: 2026-02-02  
**Stato**: Documentazione fondamentale per il progetto

---

## 🏗️ **Introduzione**

Il modulo Meetup è strettamente legato all'architettura di tema separato del progetto Laravel Pizza. Questa documentazione spiega come il modulo interagisce con il tema e le sue dipendenze.

---

## 📁 **Integrazione Modulo-Tema**

### **Struttura del Modulo**
```
laravel/Modules/Meetup/
├── app/
│   ├── Models/
│   │   └── Event.php                    # Modello Evento
│   ├── Filament/                        # Admin Panel
│   │   └── Resources/
│   │       └── EventResource.php
│   └── Http/
│       └── Livewire/
│           └── EventsPage.php
├── docs/                                # Documentazione modulo
├── resources/                           # Risorse modulo
│   ├── views/                           # Viste modulo
│   └── lang/                            # Traduzioni
└── database/
    └── migrations/                      # Migrazioni
```

### **Relazione con il Tema**
```
Modulo Meetup → Tema Meetup → Frontend Utente
    ↓              ↓              ↓
Business Logic   Componenti     Pagina
Data Layer       Blade/Volt     Visiva
```

---

## 🔧 **Workflow di Sviluppo**

### **1. Modifiche al Modulo**
```bash
# Modifiche al modello Event.php
# Modifiche alle migrazioni
# Modifiche ai componenti Livewire
```

### **2. Verifica con PHPStan**
```bash
cd laravel
./vendor/bin/phpstan analyse Modules/Meetup --memory-limit=-1
```

### **3. Modifiche al Tema (se necessario)**
```bash
cd laravel/Themes/Meetup/
npm run build
npm run copy
```

---

## 🎯 **Regole Fondamentali**

### **Moduli vs Tema**
- **Moduli**: Logica di business, servizi, modelli
- **Temi**: Interfaccia utente, componenti Blade, stili

### **Comunicazione**
- I moduli forniscono i dati e la logica
- I temi consumano i dati e li presentano
- Usare pattern `Request → Folio → Blade → Volt → Action → Service/Model`

---

## 📊 **Workflow Completo Modulo-Tema**

```
Modifica Modulo → PHPStan L10 → Migrazioni → 
Test Business Logic → 
Modifica Tema → npm run build → npm run copy → 
Test Frontend → 
Verifica SEO → 
Commit e Push
```

---

## 🚨 **Errori Comuni**

### **Errore 1: Modifiche al tema senza aggiornare il modulo**
```bash
# ❌ SBAGLIATO
Modifico resources/views/components/ui/header.blade.php
Vado su http://127.0.0.1:8000/it
Modifiche non riflettono logica modulo

# ✅ CORRETTO
Modifico Modules/Meetup/app/Models/Event.php
Modifico Modules/Meetup/app/Filament/Resources/EventResource.php
Modifico laravel/Themes/Meetup/resources/views/components/ui/header.blade.php
npm run build
npm run copy
```

---

## 🎨 **Pattern Architetturali**

### **Componenti Livewire**
```php
// ✅ CORRETTO - Pattern Laraxot
class EventsPage extends Component
{
    public function render()
    {
        return view('livewire.events-page', [
            'events' => Event::where('status', 'published')->get(),
        ]);
    }
}
```

### **Folio + Volt Pattern**
```blade
{{-- ✅ CORRETTO - Pattern Obbligatorio --}}
@volt('events')
    @php
        $events = Event::where('status', 'published')->get();
    @endphp
    
    <div class="container mx-auto">
        @foreach($events as $event)
            <x-event-card :event="$event" />
        @endforeach
    </div>
@endvolt
```

---

## 🔍 **Debugging**

### **Verifica Integrazione**
```bash
# Controlla se il modulo è registrato
php artisan tinker
>>> app('Modules\Meetup\MeetupServiceProvider')
=> Modules\Meetup\MeetupServiceProvider {#...}

# Controlla se il tema è registrato
>>> config('local.laravelpizza.pub_theme')
=> "Meetup"
```

### **Verifica Componenti**
```bash
# Controlla se i componenti Blade sono registrati
php artisan view:clear
php artisan config:clear
```

---

## 📚 **Documentazione Correlata**

- [theme-separation-architecture.md](../../Themes/Meetup/docs/02-architecture/01-theme-separation-architecture.md)
- [folio-volt-json-system-complete.md](../../Themes/Meetup/docs/folio-volt-json-system-complete.md)
- [laravelpizza-com-conversion-architecture.md](../../Themes/Meetup/docs/laravelpizza-com-conversion-architecture.md)

---

## 🎯 **Conclusione**

Il modulo Meetup e il tema sono strettamente interconnessi. La separazione permette:
- ✅ **Modularità** e riutilizzo del codice
- ✅ **Testabilità** della logica di business
- ✅ **Manutenibilità** dell'interfaccia utente
- ✅ **Scalabilità** del progetto

**Seguire rigorosamente le regole di integrazione tra modulo e tema!**

---

**Documentazione**: `laravel/Modules/Meetup/docs/02-architecture/02-theme-separation-architecture.md`  
**Ultimo Aggiornamento**: 2026-02-02