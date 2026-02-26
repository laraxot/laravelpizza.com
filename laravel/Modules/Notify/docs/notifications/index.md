# Indice Documentazione Notifiche

## Collegamenti Correlati
- [Indice Documentazione Notify](../index.md)
- [README Modulo Notify](../readme.md)
<<<<<<< HEAD
- [Documentazione Generale Laraxot](../../../../../docs/readme.md)
=======
- [Documentazione Generale healthcare_app](../../../../../docs/readme.md)
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
- [Collegamenti Documentazione](../../../../../docs/collegamenti-documentazione.md)

## Guida Implementazione
- [Guida Implementazione Notifiche](./notifications_implementation_guide.md) - Guida generale all'implementazione delle notifiche
- [Notifiche Multi-Canale](./multi_channel_notifications.md) - Implementazione di notifiche su più canali
- [Errori Comuni da Evitare](./errori_comuni_da_evitare.md) - Problemi comuni e come evitarli

## Canali di Notifica

### SMS
- [Implementazione SMS Dettagliata](./sms_implementation_details.md) - Dettagli implementativi per il canale SMS
- [Configurazione Provider SMS](./sms_provider_configuration.md) - Configurazione dei provider SMS
- [Implementazione Netfun SMS](./netfun_sms_implementation.md) - Implementazione specifica per il provider Netfun

### Telegram
- [Guida Notifiche Telegram](./telegram_notifications_guide.md) - Implementazione delle notifiche Telegram

## Architettura e Pattern
- [Factory Pattern per Provider](../factory_pattern_analysis.md) - Analisi del pattern Factory per i provider
- [Provider vs DTO](../channel_vs_dto_provider_selection.md) - Selezione tra provider e DTO
- [Architettura Provider](../provider_actions_architecture.md) - Architettura delle azioni provider

## Documentazione Correlata
- [Implementazione SMS](../sms_implementation.md) - Panoramica dell'implementazione SMS
- [Canale WhatsApp](../whatsapp_channel.md) - Documentazione del canale WhatsApp
- [Canale Telegram](../telegram_channel.md) - Documentazione del canale Telegram

## Note Importanti
<<<<<<< HEAD
- Laraxot utilizza il pattern Factory per la creazione delle azioni di invio messaggi
=======
- healthcare_app utilizza il pattern Factory per la creazione delle azioni di invio messaggi
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
- Il sistema si basa su Queueable Actions (spatie/laravel-queueable-action) e non su Service Pattern
- Le azioni specifiche per provider devono implementare l'interfaccia comune corrispondente
- I DTO standardizzati vengono utilizzati come ponte tra il sistema e i provider specifici

## Regole di Implementazione

1. Per ogni provider configurato deve esistere una corrispondente azione
2. Tutte le azioni devono implementare l'interfaccia comune
3. I canali devono utilizzare le factory per la creazione delle azioni
4. Le factory devono gestire la selezione del driver predefinito

