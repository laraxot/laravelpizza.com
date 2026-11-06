# Piano di completamento — Notify

## Scopo
Fornire trasporti e template per email, SMS, WhatsApp, Telegram e push lasciando la decisione applicativa al dominio.

## Piano BMAD

1. Mappare contratti, template, canali, preferenze, queue e fallback.
2. Isolare credenziali e segreti, definire errori/retry e impedire invii duplicati.
3. Verificare risorse Filament, traduzioni, `Panel|null` e configurazione tenant.
4. Completare la `SettingPage` con Data coerente senza esporre `.env` oltre il necessario.
5. Chiudere gate statici, Pest e test di trasporto con fake/adapters.

## Criteri di accettazione
Il dominio decide se notificare, il modulo decide come consegnare, ogni fallimento è diagnosticabile e i segreti non entrano nei form pubblici.

