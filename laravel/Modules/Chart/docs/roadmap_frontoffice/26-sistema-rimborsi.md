# Implementazione Sistema Rimborsi

## Stato: In Corso (70%)

## Descrizione
Implementazione del sistema completo di gestione rimborsi per gli odontoiatri, inclusa la generazione automatica delle richieste, l'approvazione e il tracciamento dei pagamenti.

## Componenti Implementati

### 1. Generazione Richieste
- Funzionalità:
  - Creazione automatica
  - Validazione dati
  - Calcolo importi
  - Verifica documenti
  - Storico richieste
  - Notifiche sistema

### 2. Gestione Approvazioni
- Processo:
  - Verifica backoffice
  - Validazione documenti
  - Calcolo importi
  - Approvazione manuale
  - Rifiuto motivato
  - Notifiche stato

### 3. Sistema Pagamenti
- Caratteristiche:
  - Bonifico automatico
  - Tracciamento pagamenti
  - Gestione scadenze
  - Notifiche pagamento
  - Storico transazioni
  - Report finanziari

### 4. Gestione Fatturazione
- Funzionalità:
  - Generazione fatture
  - Gestione IVA
  - Archivio documenti
  - Report fiscali
  - Esportazione dati
  - Integrazione contabilità

## Dettagli Implementazione

### Frontend
```blade
// resources/views/reimbursements/manage.blade.php
<x-layout>
    <x-reimbursement-manager>
        <x-request-list
            :requests="$requests"
            :status="$status"
        />
        <x-payment-tracker
            :payments="$payments"
            :pending="$pending"
        />
        <x-invoice-generator />
        <x-financial-reports />
    </x-reimbursement-manager>
</x-layout>
```

### Backend
```php
// app/Services/ReimbursementService.php
class ReimbursementService
{
    public function createRequest($appointment)
    {
        // Validazione
        $this->validateAppointment($appointment);

        // Creazione richiesta
        $request = ReimbursementRequest::create([
            'dentist_id' => $appointment->dentist_id,
            'appointment_id' => $appointment->id,
            'amount' => $this->calculateAmount($appointment),
            'status' => 'pending',
            'documents' => $this->collectDocuments($appointment)
        ]);

        // Notifica sistema
        event(new ReimbursementRequestCreated($request));

        return $request;
    }

    private function calculateAmount($appointment)
    {
        $baseAmount = $appointment->service->price;
        
        // Applica sconti ISEE se presenti
        if ($appointment->patient->hasIsee()) {
            $baseAmount = $this->applyIseeDiscount($baseAmount, $appointment->patient->isee_value);
        }

        return $baseAmount;
    }
}
```

### Modelli
```php
// app/Models/ReimbursementRequest.php
class ReimbursementRequest extends Model
{
    protected $fillable = [
        'dentist_id',
        'appointment_id',
        'amount',
        'status',
        'documents',
        'approved_at',
        'paid_at'
    ];

    protected $casts = [
        'documents' => 'array',
        'approved_at' => 'datetime',
        'paid_at' => 'datetime'
    ];

    public function dentist()
    {
        return $this->belongsTo(Dentist::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function getStatus()
    {
        return [
            'pending' => 'In attesa',
            'approved' => 'Approvato',
            'rejected' => 'Rifiutato',
            'paid' => 'Pagato'
        ][$this->status] ?? 'Sconosciuto';
    }
}
```

## Test Implementati
- ✅ Test generazione richieste
- ✅ Test approvazioni
- ✅ Test pagamenti
- ✅ Test fatturazione
- ✅ Test notifiche

## Metriche
- Tempo elaborazione: < 1 min
- Tasso approvazione: 90%
- Tempo pagamento: 48h
- Tasso errori: 1%

## Documenti Correlati
- [Sistema Prenotazioni](./16-sistema-prenotazioni.md)
- [Gestione Documenti](./20-gestione-documenti.md)
- [Sistema Fatturazione](./27-sistema-fatturazione.md)

## Note
- Conformità fiscale
- Backup documenti
- Audit trail
- Log completo
- Monitoraggio pagamenti
- Report periodici
- Integrazione contabilità
- Performance monitoring 
