# Impostazioni Notifiche

## Descrizione
Sistema per la gestione delle preferenze di notifica da parte del paziente, con supporto multi-canale e configurazione granulare.

## Stato Attuale
- **Completamento**: 100%
- **Responsabile**: Team Backend/Frontend
- **Data completamento**: Maggio 2025

## Funzionalità Implementate
- Preferenze canali di notifica (email, SMS, push)
- Configurazione per tipo di notifica
- Gestione orari preferiti per notifiche
- Template personalizzati per paziente
- Silenziamento temporaneo
- Digest settimanali configurabili
- Preview notifiche in-app

## Tipi di Notifiche Configurabili
- Promemoria appuntamenti (24h, 48h, 7 giorni)
- Nuovi documenti disponibili
- Risposte a richieste
- Modifiche appuntamenti
- Conferme pagamenti
- Aggiornamenti piano di cura
- Avvisi amministrativi
- Promemoria follow-up

## Canali Disponibili
- Email (priorità alta/bassa)
- SMS
- Notifiche push (app mobile)
- Notifiche in-app
- WhatsApp (opzionale)

## Tecnologie Utilizzate
- Laravel Notifications
- Notification channels multipli
- Queue per elaborazione asincrona
- Scheduler per timing ottimale
- Throttling per evitare spam
- Logging e analisi recapiti

## Privacy e Conformità
- Opt-in esplicito per ogni canale
- Storico consensi per audit
- Gestione unsubscribe one-click
- Conformità normative anti-spam
- Cancellazione automatica dati

## Documentazione Correlata
- [Dashboard principale](./dashboard-principale.md)
- [Gestione profilo](./gestione-profilo.md)
- [Sistema notifiche](../sistema-notifiche.md)

## Riferimento Principale
→ [Torna a Stato Avanzamento Lavori](../../stato_avanzamento_lavori_2025_06_05.md)
