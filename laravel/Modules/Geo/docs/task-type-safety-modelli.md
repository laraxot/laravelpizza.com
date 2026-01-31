# Task: Type Safety Modelli Address/Comune - Geo

**Modulo**: Geo
**Priorita'**: Alta
**Completamento**: 40%
**Data**: 2026-01-30

---

## Descrizione

I modelli Address, Comune e ComuneJson hanno attributi tipizzati come `mixed` che causano suppressioni a catena. Migliorare la definizione dei tipi.

## Azioni

- [ ] Aggiungere PHPDoc `@property` per tutti gli attributi Address
- [ ] Definire casts espliciti per coordinate (float)
- [ ] Tipizzare return values di getRows() nei modelli Sushi
- [ ] Creare AddressData DTO per type-safe data flow

## Criteri di Completamento

- [ ] Address model: 0 suppressioni
- [ ] Comune/ComuneJson: 0 suppressioni
- [ ] DTO AddressData creato e utilizzato
