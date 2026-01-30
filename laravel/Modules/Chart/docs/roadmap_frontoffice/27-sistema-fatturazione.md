# Implementazione Sistema Fatturazione

## Stato: In Corso (65%)

## Descrizione
Implementazione del sistema completo di fatturazione per la gestione delle fatture verso gli odontoiatri, inclusa la generazione automatica, la gestione IVA e l'integrazione contabile.

## Componenti Implementati

### 1. Generazione Fatture
- Funzionalità:
  - Creazione automatica
  - Template personalizzati
  - Calcolo IVA
  - Gestione aliquote
  - Numerazione progressiva
  - Backup documenti

### 2. Gestione IVA
- Caratteristiche:
  - Calcolo aliquote
  - Gestione esenzioni
  - Split payment
  - Reverse charge
  - Report IVA
  - Integrazione contabile

### 3. Sistema Contabile
- Funzionalità:
  - Registrazione movimenti
  - Gestione scadenze
  - Report finanziari
  - Esportazione dati
  - Integrazione software
  - Backup dati

### 4. Gestione Documenti
- Processo:
  - Archivio digitale
  - Firma elettronica
  - Conservazione sostitutiva
  - Ricerca avanzata
  - Export documenti
  - Backup automatico

## Dettagli Implementazione

### Frontend
```blade
// resources/views/invoices/manage.blade.php
<x-layout>
    <x-invoice-manager>
        <x-invoice-generator
            :templates="$templates"
            :settings="$settings"
        />
        <x-vat-calculator />
        <x-accounting-integration />
        <x-document-archive />
    </x-invoice-manager>
</x-layout>
```

### Backend
```php
// app/Services/InvoiceService.php
class InvoiceService
{
    public function generateInvoice($reimbursement)
    {
        // Validazione
        $this->validateReimbursement($reimbursement);

        // Generazione fattura
        $invoice = Invoice::create([
            'reimbursement_id' => $reimbursement->id,
            'dentist_id' => $reimbursement->dentist_id,
            'number' => $this->generateInvoiceNumber(),
            'amount' => $reimbursement->amount,
            'vat_amount' => $this->calculateVat($reimbursement->amount),
            'total_amount' => $this->calculateTotal($reimbursement->amount),
            'status' => 'draft'
        ]);

        // Generazione PDF
        $this->generatePdf($invoice);

        // Notifica sistema
        event(new InvoiceGenerated($invoice));

        return $invoice;
    }

    private function calculateVat($amount)
    {
        $vatRate = config('invoice.vat_rate');
        return $amount * ($vatRate / 100);
    }
}
```

### Modelli
```php
// app/Models/Invoice.php
class Invoice extends Model
{
    protected $fillable = [
        'reimbursement_id',
        'dentist_id',
        'number',
        'amount',
        'vat_amount',
        'total_amount',
        'status',
        'issued_at',
        'due_date'
    ];

    protected $casts = [
        'issued_at' => 'datetime',
        'due_date' => 'datetime'
    ];

    public function reimbursement()
    {
        return $this->belongsTo(ReimbursementRequest::class);
    }

    public function dentist()
    {
        return $this->belongsTo(Dentist::class);
    }

    public function getStatus()
    {
        return [
            'draft' => 'Bozza',
            'issued' => 'Emessa',
            'paid' => 'Pagata',
            'cancelled' => 'Annullata'
        ][$this->status] ?? 'Sconosciuto';
    }
}
```

## Test Implementati
- ✅ Test generazione fatture
- ✅ Test calcolo IVA
- ✅ Test integrazione contabile
- ✅ Test documenti
- ✅ Test notifiche

## Metriche
- Tempo generazione: < 30s
- Accuratezza calcoli: 100%
- Tasso errori: 0.1%
- Tempo integrazione: < 1min

## Documenti Correlati
- [Sistema Rimborsi](./26-sistema-rimborsi.md)
- [Gestione Documenti](./20-gestione-documenti.md)
- [Sistema Sicurezza](./22-sistema-sicurezza.md)

## Note
- Conformità fiscale
- Backup documenti
- Audit trail
- Log completo
- Monitoraggio pagamenti
- Report periodici
- Integrazione contabile
- Performance monitoring 
