# Sprint 1 KPI Dashboard Spec

## Scope
Dashboard baseline per eventi community (pizzate/meetup) per misurare loop UGC e conversione evento.

## KPI obbligatori

1. `event_views`
2. `rsvp_total`
3. `attendees_total`
4. `show_up_rate` = attendees_total / rsvp_total
5. `ugc_posts_72h`
6. `ugc_rate_72h` = ugc_posts_72h / attendees_total
7. `referral_invites_sent`
8. `referral_rsvp_conversions`

## Segmentazioni minime

- per evento
- per citta'
- per format evento (beginner/builder/founder)
- per settimana

## Data contract

- Event ID
- Event date/time
- City
- Format
- RSVP count
- Checked-in attendees
- UGC count entro 72h
- Referral invites
- Referral RSVP

## Threshold iniziali

- show_up_rate target: >= 0.60
- ugc_rate_72h target: >= 0.20
- referral conversion target: >= 0.10

## Reporting cadence

- aggiornamento settimanale su issue #509
- retro sprint ogni 2 settimane
