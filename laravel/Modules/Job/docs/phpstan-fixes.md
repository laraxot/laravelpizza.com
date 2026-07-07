<<<<<<< HEAD
# PHPStan Fixes – Gennaio 2025
=======
# PHPStan Fixes — Job

## 2026-06-10 — STORY-307 · L10 · 0 errori codice

795→0. [#336](https://github.com/laraxot/base_fixcity_fila5/issues/336). `GetTaskFrequenciesAction` + test Assert.

---

## Storico — Gennaio 2025
>>>>>>> origin/dev

## ✅ Stato complessivo

Il modulo Job è completamente conforme al livello PHPStan 7 con **0 errori rimanenti**. Le correzioni riguardano sia i modelli Eloquent sia le Filament Resources, in modo allineato con le convenzioni `XotBase`.

---

## 🔧 Correzioni implementate

### 1. Modello `Modules/Job/app/Models/Result.php`

- Allineati i PHPDoc `@property-read` a `\Modules\Xot\Contracts\ProfileContract|null` per gli attributi `creator` e `updater`.
- Verificato e documentato il metodo `factory()` con il namespace completo `\Modules\Job\Database\Factories\ResultFactory`.

### 2. Filament Resource `FailedJobResource/Pages/ListFailedJobs.php`

- `getHeaderActions()` ora restituisce array associativi con chiavi string coerenti.
- PHPDoc aggiornato a `@return array<string, \Filament\Actions\Action>` secondo gli standard Filament/Xot.

---

## 📋 Pattern applicati

### PHPDoc Contracts

- Utilizzare sempre `ProfileContract` nei PHPDoc degli attributi relazionali.
- Specificare i namespace completi per le factory `Modules\{Module}\Database\Factories\{Model}Factory`.

### Array associativi Filament

```php
/**
 * @return array<string, \Filament\Actions\Action>
 */
protected function getHeaderActions(): array
{
    return [
        'locale_switcher' => Actions\LocaleSwitcher::make(),
        'create' => Actions\CreateAction::make(),
        'clear_all' => Actions\Action::make('clear_all')
            ->label('Clear All Failed Jobs')
            ->icon('heroicon-o-trash')
            ->color('danger')
            ->requiresConfirmation()
            ->action(function (): void {
                // Implementazione pulizia job falliti
            }),
    ];
}
```

---

## 🎯 Risultati

- **Errori PHPStan**: 0
- **File corretti**: 2 (Result model + FailedJobResource page)
- **Compatibilità**: confermata con `XotBaseListRecords`
- **Pattern applicati**: PHPDoc Contracts, Array associativi Filament

---

## 📚 Documentazione di riferimento

- `docs/phpstan-level7-guide.md` – guida completa allineata al livello 7
- `docs/phpstan/guida_filament_table_actions.md` – best practice sulle azioni Filament


---

## Collegamenti tra versioni di lang-link.md

- [lang-link.md](../../../chart/docs/lang-link.md)
- [lang-link.md](../../../reporting/docs/lang-link.md)
- [lang-link.md](../../../gdpr/docs/lang-link.md)
- [lang-link.md](../../../notify/docs/lang-link.md)
- [lang-link.md](../../../xot/docs/lang-link.md)
- [lang-link.md](../../../dental/docs/lang-link.md)
- [lang-link.md](../../../user/docs/lang-link.md)
- [lang-link.md](../../../ui/docs/lang-link.md)
- [lang-link.md](../../../job/docs/lang-link.md)
- [lang-link.md](../../../media/docs/lang-link.md)
- [lang-link.md](../../../tenant/docs/lang-link.md)
- [lang-link.md](../../../activity/docs/lang-link.md)
- [lang-link.md](../../../patient/docs/lang-link.md)
- [lang-link.md](../../../cms/docs/lang-link.md)
