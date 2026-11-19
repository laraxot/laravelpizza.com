# Laravel Pizza Meetups user guide

Welcome! This guide explains, step by step and without assuming anything, how to use **Laravel Pizza Meetups**: the place where Laravel developers find meetups, sign up and meet over a pizza.

You don't need to be a computer expert. Every chapter has **pictures taken from the real site**: the yellow boxes with a number show exactly where to click, and the steps in the text use the same numbers.

*Italian edition: [Manuale d'uso](../readme.md).*

## PDF version to print or send

- [Complete guide (PDF)](pdf/user-guide.pdf)
- Just the chapter you need: [Visitor](pdf/01-visitor.pdf) · [Participant](pdf/02-participant.pdf) · [Organiser](pdf/03-organiser.pdf) · [Administrator](pdf/04-administrator.pdf)

## Who are you? Pick your chapter

The site has four kinds of user. Each one sees different things and can do different things.

| Kind of user | Who they are | What they can do | Chapter |
|---|---|---|---|
| **Visitor** | Anyone who opens the site without an account | Browse and search events, see past ones, add them to a calendar, change language, write to the organisers | [1. Visitor](01-visitor.md) |
| **Participant** | Anyone with an account (also one created while registering for an event, with just email and password) | Everything a visitor can do, plus: register for events (with a confirmation email and a reminder), cancel a registration, see "My events", manage their profile, ask the assistant | [2. Participant](02-participant.md) |
| **Organiser** | Someone an administrator has allowed to manage events | Open the admin panel; create, publish, edit and delete events; manage venues, speakers and sponsors; see and download attendees | [3. Organiser](03-organiser.md) |
| **Administrator** | Whoever runs the site (super-admin role) | Everything an organiser can do, plus: give and remove the organiser role, check accounts, settings and the technical panels | [4. Administrator](04-administrator.md) |

Not sure which one you are? If you have never created an account you are a **Visitor**. If you have an account you are a **Participant**. You become an **Organiser** only if an administrator gave you permission; **Administrators** are one or two people, and they already know.

> The admin panel (chapters 3 and 4) is currently in Italian. Those chapters show the Italian screens and give every label in Italian, followed by its meaning in English.

## Words you will meet

- **Event** (or *meetup*): a get-together with a date, time, place and a maximum number of seats.
- **Register**: book your seat at an event. It's free.
- **Seats available** (or *capacity*): how many people can attend. When they run out, the event shows "Sold out".
- **Account**: your profile on the site, protected by your email and password.
- **Admin panel**: the reserved area for organisers, at a different address from the public site.

## Frequently asked questions

**How much does it cost?** Nothing. Signing up to the site and registering for events is free.

**I forgot my password.** On the "Sign in" page click "Reset it" and follow the instructions you receive by email (see [chapter 2](02-participant.md#forgot-your-password)).

**I opened a link and I see "Page not found".** The address is wrong or the page no longer exists (for example a deleted event). Use the buttons on the page to go back to the events or to the home page.

**How do I register for an event without an account?** Open the event: in the **Join now** box type your email and a password, tick the privacy box and click **Register for this event**. Your account is created at the same time (see [chapter 2](02-participant.md#21-register-for-an-event-in-one-step)).

**I can't see the "Register" button.** If the event is full, already started or over, registration is closed; if you are already registered you see "Cancel registration" (see [chapter 2](02-participant.md#28-when-you-cannot-register)).

**My password is rejected.** It must have at least 12 characters, with upper and lower case letters, a number and a symbol, and it must not be one that appeared in known data breaches.

**Can I find events near me?** Yes: on the Events page choose your city in the search (see [chapter 1](01-visitor.md#13-search-by-city-or-date)).

**How do I put the event in my calendar?** On the event page click "Add to calendar", or open the attachment of the confirmation email.

**I clicked "Register" but no email arrived.** Check your spam folder. Your registration counts anyway: you'll find it in "My events".

**Can I just ask for what I need?** Yes: once you have signed in, click **Ask the assistant** at the bottom right (see [chapter 2](02-participant.md#29-ask-the-assistant)).

## Notes for maintainers

- The pictures are in [`img/`](img/) (public site, in English); chapters 3 and 4 use the Italian ones in [`../img/`](../img/) because the admin panel is in Italian. They were captured on a local installation with demo data (made-up people and events), not from the live site. Event titles and descriptions are in Italian because that is how the demo events are written.
- To redo the screenshots, from `laravel/`: `sh Themes/Meetup/docs/manuale-utente/tools/reset-demo.sh`, then `php Themes/Meetup/docs/manuale-utente/tools/render-mail.php $PWD /tmp/mail-en.html en`; from `laravel/Themes/Meetup`: `MANUAL_LANG=en PHP_BIN=php node docs/manuale-utente/tools/capture.cjs docs/manuale-utente/en/img /tmp/mail-en.html`. It must end with "Tutti i riquadri trovati" (all boxes found).
- The PDFs in [`pdf/`](pdf/) are generated from the `.md` files with `node ../build-pdf.mjs en` (needs pandoc and Playwright). After changing text or pictures, regenerate the PDFs and commit `.md` and `.pdf` together.
- When the Italian chapters change, update these too: same sections, same picture names.
