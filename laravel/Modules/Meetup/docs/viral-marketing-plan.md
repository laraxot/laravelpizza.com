# LaravelPizza — Viral Marketing Plan

## Objective

Become the reference platform for Laravel meetups in Italy and Europe.

---

## Target audience

- **Primary**: Italian Laravel developers (age 18-45)
- **Secondary**: European PHP communities (Spain, France, Germany)
- **Tertiary**: Companies using Laravel who want to sponsor events

---

## Distribution channels

### GitHub (organic channel #1)
- README badge with live pizzate counter
- GitHub Discussions for approved event announcements
- GitHub Actions that auto-tweets each approved event
- Issue template for proposing a pizzata (lowers the barrier to entry)

### Twitter/X — hashtag #LaravelPizza
- Auto-tweet on each approved event (via GitHub Action)
- Countdown 24h before the event
- Post-event recap with attendee count
- Tag @laravelphp, @taylorotwell for organic reach

### LinkedIn
- Rich preview via Schema.org (already implemented in `Event::toSchemaOrg()`)
- Tag sponsor companies
- Speaker cross-posts

### WhatsApp / Telegram
- Share button on event page (pure URL, no external packages)
- Telegram webhook for new event notifications

### SEO — organic search
- Schema.org Event JSON-LD on every event (already implemented)
- Target keywords: "laravel meetup italia", "pizzata laravel", "eventi php italia"
- Auto XML sitemap of approved events
- Localized canonical URLs: /it/events/{slug}

---

## Virality hooks (implement in Meetup module)

### Social proof mechanics
- "Marco e altre 23 persone partecipano" with avatar stack
- "Evento quasi esaurito!" when >80% capacity reached
- Badges: Speaker, Organizer, Veteran (5+ events), Pioneer (first event)

### Sharing triggers
- "Vado!" → suggests sharing on Twitter/WhatsApp
- At 50% capacity → notify RSVPs "Invita un collega"
- Post-event: "Ho partecipato a #LaravelPizza Milano con X persone"

### Network effects
- More attendees → more sponsors → more speakers → more attendees
- Linkable public speaker profile (SEO + personal brand)
- Organizers earn badges + profile visibility

---

## Strategic partnerships

### Tier 1
- **Laravel Official** (@laravelphp / @taylorotwell)
- **Spatie** (highly influential, already used in project)
- **Filament** (direct sponsor — we use Filament v5)

### Tier 2
- **Laracasts** — Jeffrey Way link-back
- **Laravel News** — post on laravelnews.com
- **PHP.net** — list Italian PHP events

### Tier 3
- Italian web agencies using Laravel
- Italian tech universities and ITS
- JetBrains (PhpStorm users)

---

## Launch phases

### Phase 1 — Soft launch (current)
- Invite 10-20 historical Italian Laravel organizers
- Import historical events from laravelpizza.com
- Collect early adopter feedback

### Phase 2 — Product Hunt
- 60-second demo video
- Tagline: "The open source meetup platform for Laravel developers"
- Targeting: maker, developer, PHP community

### Phase 3 — Community blast
- Post on r/laravel with story "We built..."
- Dev.to article: "How we made LaravelPizza viral"
- Hacker News: "Show HN: LaravelPizza"
- Laracasts forum post

---

## KPIs

| Metric | 3-month target | 12-month target |
|---|---|---|
| Registered users | 500 | 5,000 |
| Pizzate proposed/month | 5 | 30 |
| Total RSVPs | 200 | 3,000 |
| Cities covered | 5 | 20 |
| GitHub stars | 100 | 1,000 |

---

## Implementation in codebase

All implementation uses existing modules — NEVER create new Marketing*, Viral*, Social* modules.

| Feature | Module | File |
|---|---|---|
| Social share | Seo | `SocialShareData` + `Event::getSocialShareData()` |
| Badges | User | Spatie Permission roles |
| Newsletter | Notify | Notification classes |
| Schema.org | Meetup | `Event::toSchemaOrg()` |
| Avatar stack | Meetup + Media | Profile + MediaLibrary |
| Auto-tweet | CI/CD | GitHub Actions workflow |
