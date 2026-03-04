# Console Commands per Use Case Bancario

## Introduzione
I console commands permettono di gestire operazioni bancarie (apertura conto, deposito, prelievo, trasferimento) da terminale, utili per amministratori, test e automazione.

## Best Practice
- **Naming**: nomi chiari e coerenti (es. `account:open`, `account:deposit`, `account:withdraw`, `account:transfer`)
- **Parametri**: validare input, fornire default, gestire importi e UUID
- **Output**: messaggi chiari, dettagliati, colorati
- **Error Handling**: gestire errori di saldo, account non trovati, ecc.
- **Logging**: tracciare operazioni critiche

## Esempi di Comandi

### 1. Apertura Conto
```php
php artisan account:open --user=UUID --initial=1000
```
**Implementazione**:
```php
class OpenAccount extends Command {
    protected $signature = 'account:open {--user=} {--initial=0}';
    public function handle() {
        // Validazione e apertura conto
        $this->info('Conto aperto con successo!');
    }
}
```

### 2. Deposito
```php
php artisan account:deposit --account=UUID --amount=500
```

### 3. Prelievo
```php
php artisan account:withdraw --account=UUID --amount=200
```

### 4. Trasferimento
```php
php artisan account:transfer --from=UUID --to=UUID --amount=100
```

## Casi d'Uso
- Apertura massiva di conti per test
- Script di bonifici multipli
- Audit e reportistica batch

## Suggerimenti
- Usare output tabellare per riepiloghi
- Prevedere opzioni di simulazione (`--dry-run`)
- Documentare ogni comando con `php artisan help`
