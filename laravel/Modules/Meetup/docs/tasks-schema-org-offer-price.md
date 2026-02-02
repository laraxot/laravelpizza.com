# Task: Schema.org Offer, PriceSpecification e contesto food

**Obiettivo:** utilizzare Offer, PriceSpecification e DeliveryChargeSpecification (e opzionalmente FoodEstablishment) per prezzo, biglietti e contesto "pizza/venue" negli eventi Meetup.

**Riferimento:** [schema-org-enhancement-recommendations](schema-org-enhancement-recommendations.md) (sezione "Reference: Schema.org types studiati")

---

## Task 1: Offer in Event.offers

- [ ] In `Event::toSchemaOrg()`: popolare `offers` con almeno un oggetto **Offer**: `@type: Offer`, `price`, `priceCurrency`, `availability` (es. InStock / SoldOut), `url` (pagina registrazione/dettaglio), `validFrom`/`validUntil` se applicabile.
- [ ] Per eventi gratuiti: `price: "0"` o `isAccessibleForFree: true` e comunque includere un Offer con `price: "0"` per chiarezza.
- [ ] Collegare i campi DB esistenti (es. `price`, `price_currency`, `registration_url`, `registration_opens_at`) al JSON-LD Offer.
- [ ] Validare con [validator.schema.org](https://validator.schema.org/) e Google Rich Results (evento).

---

## Task 2: PriceSpecification per prezzi articolati

- [ ] Se sono previste più tariffe (es. early bird, standard, supporter): modellare come array di **PriceSpecification** o Offer distinti, con `price`, `priceCurrency`, `valueAddedTaxIncluded` se rilevante.
- [ ] Documentare in docs Meetup la convenzione: un solo prezzo → un solo Offer; più tariffe → più Offer o PriceSpecification nell’offerta principale.
- [ ] Evitare DeliveryChargeSpecification a meno che non si modellino costi di consegna (es. merchandise/pizza delivery); in quel caso creare task dedicato.

---

## Task 3: DeliveryChargeSpecification (opzionale)

- [ ] Valutare se il progetto prevede "delivery" (consegna pizza, merchandise): se sì, definire dove si applica (evento, ordine, altro).
- [ ] Se applicabile: usare **DeliveryChargeSpecification** come sottotipo di PriceSpecification per costi di consegna; collegare a Offer o a un modello Order/Delivery.
- [ ] Se non applicabile: ignorare e non emettere DeliveryChargeSpecification; lasciare nota in questo file.

---

## Task 4: FoodEstablishment per venue (opzionale)

- [ ] Se il luogo dell’evento è esplicitamente un locale food (pizzeria, ristorante): valutare di tipizzare la **Place** come **FoodEstablishment** in JSON-LD quando `place.type` o flag lo indicano.
- [ ] Aggiungere in Place/Geo eventuale campo o enum per "food establishment" e documentare il mapping verso Schema.org.
- [ ] Collegare a [tasks-schema-org-place-geocircle](../../Geo/docs/tasks-schema-org-place-geocircle.md) nel modulo Geo per coerenza Place/address.

---

## Verifica finale

- [ ] Controllare che ogni evento con prezzo/registrazione abbia almeno un Offer valido in JSON-LD.
- [ ] Aggiornare [schema-org-enhancement-recommendations](schema-org-enhancement-recommendations.md) e [event-schema-org-implementation](event-schema-org-implementation.md) con le convenzioni adottate.
- [ ] Collegare questo file da [rules-index](rules-index.md) o indice docs Meetup.

---

## Collegamenti

- [schema-org-enhancement-recommendations](schema-org-enhancement-recommendations.md)
- [event-schema-org-implementation](event-schema-org-implementation.md)
- [tasks-schema-org-place-geocircle](../../Geo/docs/tasks-schema-org-place-geocircle.md) (Geo)
- [database-schema](database-schema.md)
