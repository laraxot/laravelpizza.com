# Indice Documentazione Notifiche

## Collegamenti Correlati
- [Indice Documentazione Notify](../INDEX.md)
- [README Modulo Notify](../README.md)
- [Documentazione Generale SaluteOra](../../../../../docs/README.md)
- [Collegamenti Documentazione](../../../../../docs/collegamenti-documentazione.md)

## Guida Implementazione
- [Guida Implementazione Notifiche](./NOTIFICATIONS_IMPLEMENTATION_GUIDE.md) - Guida generale all'implementazione delle notifiche
- [Notifiche Multi-Canale](./MULTI_CHANNEL_NOTIFICATIONS.md) - Implementazione di notifiche su più canali
- [Errori Comuni da Evitare](./ERRORI_COMUNI_DA_EVITARE.md) - Problemi comuni e come evitarli

## Canali di Notifica

### SMS
- [Implementazione SMS Dettagliata](./SMS_IMPLEMENTATION_DETAILS.md) - Dettagli implementativi per il canale SMS
- [Configurazione Provider SMS](./SMS_PROVIDER_CONFIGURATION.md) - Configurazione dei provider SMS
- [Implementazione Netfun SMS](./NETFUN_SMS_IMPLEMENTATION.md) - Implementazione specifica per il provider Netfun

### Telegram
- [Guida Notifiche Telegram](./TELEGRAM_NOTIFICATIONS_GUIDE.md) - Implementazione delle notifiche Telegram

## Architettura e Pattern
- [Factory Pattern per Provider](../FACTORY_PATTERN_ANALYSIS.md) - Analisi del pattern Factory per i provider
- [Provider vs DTO](../CHANNEL_VS_DTO_PROVIDER_SELECTION.md) - Selezione tra provider e DTO
- [Architettura Provider](../PROVIDER_ACTIONS_ARCHITECTURE.md) - Architettura delle azioni provider

## Documentazione Correlata
- [Implementazione SMS](../SMS_IMPLEMENTATION.md) - Panoramica dell'implementazione SMS
- [Canale WhatsApp](../WHATSAPP_CHANNEL.md) - Documentazione del canale WhatsApp
- [Canale Telegram](../TELEGRAM_CHANNEL.md) - Documentazione del canale Telegram

## Note Importanti
- SaluteOra utilizza il pattern Factory per la creazione delle azioni di invio messaggi
- Il sistema si basa su Queueable Actions (spatie/laravel-queueable-action) e non su Service Pattern
- Le azioni specifiche per provider devono implementare l'interfaccia comune corrispondente
- I DTO standardizzati vengono utilizzati come ponte tra il sistema e i provider specifici

## Regole di Implementazione

1. Per ogni provider configurato deve esistere una corrispondente azione
2. Tutte le azioni devono implementare l'interfaccia comune
3. I canali devono utilizzare le factory per la creazione delle azioni
4. Le factory devono gestire la selezione del driver predefinito

Ultimo aggiornamento: 14 Maggio 2025
