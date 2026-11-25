---
title: "Topic schema-org"
type: digest
status: active
qmd: "digest ceiling 100 schema-org"
---

# Topic schema-org

Sintesi automatica di 16 documenti (chiave `schema-org`).

## Schema.org Actions and RSVP Implementation

_Fonte: `schema-org-actions-rsvp-implementation.md`_

# Schema.org Actions and RSVP Implementation

## Overview

This document provides comprehensive implementation guidance for Schema.org Action types (JoinAction, LeaveAction) and EventReservation for building a complete RSVP and event participation system in LaravelPizza.

## Core Action Types

### 1. JoinAction

Used when an agent (user) joins an event, group, or organization.

#### Key Properties
- `agent` (Person/Organization) - Who is joining
- `object` (Thing) - What they're joining (Event, Organization, etc.)
- `event` (Event) - Specific event being joined (alternative to object)
- `startTime` (DateTime) - When the join action occurred
- `actionStatus` (ActionStatusType) - Status of the action

#### Use Cases for LaravelPizza
- User RSVPs "Yes" to an event
- User joins a community/group
- User subscribes to event series
- User becomes a member of organization

### 2. LeaveAction

The inverse of JoinAction - when an agent leaves an event or group.

#### Key Properties

## Schema.org EducationEvent and Attendee Management

_Fonte: `schema-org-education-event-attendee-management.md`_

# Schema.org EducationEvent and Attendee Management

## Overview

This document provides comprehensive implementation guidance for Schema.org EducationEvent type and attendee management for LaravelPizza's educational workshops, tutorials, and training events.

## EducationEvent Type

### Core EducationEvent Properties

#### Education-Specific Properties
- `teaches` (DefinedTerm/Text) - Learning outcomes or competencies taught
- `educationalLevel` (DefinedTerm/Text/URL) - Target skill level (beginner, intermediate, advanced)
- `assesses` (DefinedTerm/Text) - Competencies or outcomes that are assessed

#### Standard Event Properties (Inherited)
- All properties from base Event type
- Additional emphasis on `audience`, `typicalAgeRange`, `inLanguage`

### Educational Level Standardization

**Recommended Values**:
- `Beginner` - New to the topic
- `Intermediate` - Some prior knowledge required
- `Advanced` - Experienced practitioners
- `Expert` - Professional level expertise

**Custom Levels for Laravel Pizza**:
- `Laravel Beginner` - New to Laravel
- `Laravel Intermediate` - Basic Laravel knowledge

## Schema.org Enhancement Proposal - Meetup Module

_Fonte: `schema-org-enhancement-proposal.md`_

# Schema.org Enhancement Proposal - Meetup Module

**Filosofia**: DRY + KISS + SEO + Structured Data
**Obiettivo**: Migliorare SEO e structured data seguendo schema.org

---

## 🎯 Analisi Schema.org per Modelli Esistenti

### 1. Event Model - Campi Aggiuntivi Proposti

#### Schema.org Event Properties
Basato su [schema.org/Event](https://schema.org/Event), propongo i seguenti campi aggiuntivi:

```php
// Campi da aggiungere al modello Event
protected $fillable = [
    // ... campi esistenti ...

    // Schema.org Event properties
    'event_status',              // EventStatusType: Scheduled, Postponed, Cancelled, MovedOnline
    'event_attendance_mode',     // EventAttendanceMode: OfflineEventAttendanceMode, OnlineEventAttendanceMode, MixedEventAttendanceMode
    'organizer_name',            // Text - Nome organizzatore
    'organizer_email',           // Email - Email organizzatore
    'organizer_url',             // URL - Sito organizzatore
    'event_schedule',            // JSON - Schedule con startDate, endDate, repeatFrequency
    'maximum_attendee_capacity', // Integer - già presente come max_attendees
    'remaining_attendee_capacity', // Integer - calcolato
    'previous_start_date',       // DateTime - per eventi spostati
    'super_event',               // Event ID - per eventi parte di serie

## Schema.org Enhancement Recommendations for LaravelPizza

_Fonte: `schema-org-enhancement-recommendations.md`_

# Schema.org Enhancement Recommendations for LaravelPizza

**Analysis Date:** [DATE]
**Agent:** Schema.org Research Agent
**Priority:** HIGH - Critical for 2026 SEO & AI Discovery

---

## Executive Summary

Comprehensive Schema.org analysis across 6 model categories with implementation priorities for enhanced SEO, rich snippets, and AI system compatibility (Google AI Overviews, ChatGPT, Perplexity).

**Key Insight for 2026:** AI systems cannot rank or cite content they can't understand. Schema.org structured data is now essential for visibility in AI-powered search.

---

## Priority Summary

### Phase 1 (HIGH PRIORITY - SEO CRITICAL)

1. **Event Model** → [Event](https://schema.org/Event)
   - Add: `event_status`, `attendance_mode`, `price`, `place_id`, `performers`
   - Impact: Rich event snippets, event carousels, Google Calendar integration

2. **Page Model** (Cms) → [WebPage](https://schema.org/WebPage)/[Article](https://schema.org/Article)
   - Add: `language`, `keywords`, `page_type`, `featured_image`
   - Impact: AI understanding, rich snippets, voice search optimization

3. **User/Profile Model** → [Person](https://schema.org/Person)
   - Add: `job_title`, `expertise`, `social_links`, `website_url`

## Schema.org Event Implementation Guide

_Fonte: `schema-org-event-implementation.md`_

# Schema.org Event Implementation Guide

## Overview

This document provides comprehensive implementation guidance for Schema.org Event types in the LaravelPizza project, based on the official Schema.org specifications. It covers Event, EventSeries, scheduling, actions, and related entities for building a robust meetup and event management system.

## Core Schema.org Event Types

### 1. Event (Base Type)

The foundational Event type with essential properties:

#### Required Properties
- `name` (Text) - Event title/name
- `startDate` (DateTime/Date) - Event start time in ISO 8601 format
- `location` (Place/VirtualLocation/Text) - Where the event occurs

#### Highly Recommended Properties
- `endDate` (DateTime/Date) - Event end time
- `description` (Text) - Event description
- `url` (URL) - Event page URL
- `eventStatus` (EventStatusType) - Current status (scheduled, cancelled, etc.)
- `eventAttendanceMode` (EventAttendanceModeEnumeration) - Online/offline/mixed

#### Optional but Important Properties
- `organizer` (Organization/Person) - Who organizes the event
- `performer` (Organization/Person) - Speakers/presenters
- `offers` (Offer) - Ticket/pricing information
- `maximumAttendeeCapacity` (Integer) - Venue capacity limits
- `remainingAttendeeCapacity` (Integer) - Available spots

## Schema.org EventSeries and Scheduling Implementation

_Fonte: `schema-org-event-series-scheduling.md`_

# Schema.org EventSeries and Scheduling Implementation

## Overview

This document provides comprehensive guidance for implementing EventSeries and scheduling functionality based on Schema.org specifications. EventSeries allows for efficient management of recurring events while maintaining structured data compliance.

## EventSeries Architecture

### Core Concepts

An EventSeries represents:
1. **Recurring Events** - Weekly meetups, monthly workshops
2. **Event Collections** - Conferences with multiple sessions
3. **Thematic Series** - Events sharing common topics or themes
4. **Multi-day Events** - Festivals spanning multiple days

### EventSeries vs Individual Events

| Use Case | EventSeries | Individual Event |
|-----------|-------------|-----------------|
| Weekly Laravel Meetup | ✅ | ❌ |
| One-time Conference | ❌ | ✅ |
| Multi-day Festival | ✅ (as series) | ✅ (as sub-events) |
| Monthly Workshop Series | ✅ | ❌ |

## Implementation Tasks

### Task 1: EventSeries Model Design

**File**: `Modules/Meetup/app/Models/EventSeries.php`

## Schema.org Compliance — Full Gap Analysis & Implementation Plan

_Fonte: `schema-org-full-compliance-plan.md`_

# Schema.org Compliance — Full Gap Analysis & Implementation Plan

> **Goal**: Every page and model in the Meetup module must emit complete `application/ld+json` structured data following Schema.org specifications, making the project **rich snippets ready**.

---

## Page-to-Schema.org Type Mapping

| Project Page | Schema.org `@type` | `mainEntity` |
|---|---|---|
| Homepage (`/it`) | `WebPage` | — |
| Events list (`/it/events`) | `CollectionPage` | `ItemList` of `Event` |
| Event detail (`/it/events/{slug}`) | `WebPage` | `Event` |
| Profile page (`/it/profile/{id}`) | `ProfilePage` | `Person` |
| Terms (`/it/terms`) | `WebPage` | — |
| Privacy (`/it/privacy`) | `WebPage` | — |
| About (`/it/about`) | `AboutPage` | `Organization` |
| Contact (`/it/contact`) | `ContactPage` | `Organization` |
| Login / Register | `WebPage` | — |

---

## Model-to-Schema.org Type Mapping & Gap Analysis

### 1. `Event` → `schema.org/Event`

**Currently Has**: name, startDate, endDate, eventStatus, eventAttendanceMode, location (text), url, description, image, organizer (Person), offers, inLanguage, duration, maximumAttendeeCapacity.

**Missing (MUST ADD)**:

## Schema.org gap analysis — Meetup module

_Fonte: `schema-org-gap-analysis.md`_

# Schema.org gap analysis — Meetup module

## Executive summary

The Meetup module models have partial schema.org coverage. The `Event` model is the most complete: it
implements `toSchemaOrg()` and covers all required base properties. However, every model has gaps
ranging from missing DB columns to entirely absent `toSchemaOrg()` methods.

Critical gaps across all models:

- `Venue` has no `toSchemaOrg()` method. The DB schema is missing `postal_code`, `street_address`,
  `region`, `image`, `url`, `opening_hours`, `public_access`, and `amenity_feature`.
- `Performer` has no `toSchemaOrg()` method. Missing `job_title`, `given_name`, `family_name`,
  `knows_about`, `knows_language`, `same_as` (social profiles are split into individual columns
  instead), and `image` is stored as `photo` (different name).
- `Sponsor` has no `toSchemaOrg()` method. Missing `founding_date`, `legal_name`, `number_of_employees`,
  `tax_id`, `slogan`, `area_served`, `location`, and `same_as`.
- `Feedback` has no `toSchemaOrg()` method. Missing `review_body` (stored as `comment`), `review_aspect`,
  `positive_notes`, `negative_notes`, and no `@type` mapping.
- `Profile` has no `toSchemaOrg()` method. Missing `job_title`, `given_name`/`family_name` (exist but
  named differently), `knows_about`, `knows_language`, `same_as`, `honorific_prefix`, `works_for`,
  `affiliation`, `nationality`, `gender`, and `birth_date`.
- `Event.toSchemaOrg()` is missing: `attendee`, `performer`, `sponsor`, `review`, `aggre

## Schema.org Implementation Summary

_Fonte: `schema-org-implementation-sumy.md`_

# Schema.org Implementation Summary

**Project**: LaravelPizza Event Management System  
**Date**: [DATE]  
**Status**: ✅ COMPLETED

---

## 🎉 Mission Accomplished

I have successfully completed a comprehensive analysis of Schema.org specifications and created a complete implementation roadmap for LaravelPizza's event management system. All core components are now documented with detailed technical specifications, implementation guides, and practical tasks.

## 📋 Documentation Package Created

### ✅ Core Implementation Documents

1. **Event & EventSeries Management**
   - `schema-org-event-implementation.md` - Complete Event type with scheduling
   - `schema-org-event-series-scheduling.md` - EventSeries and recurring patterns

2. **User Interaction System**
   - `schema-org-actions-rsvp-implementation.md` - JoinAction/LeaveAction for RSVP
   - `schema-org-education-event-attendee-management.md` - EducationEvent and attendee management

3. **Location & Venue Management**
   - `schema-org-offers-pricing-ticketing.md` - Comprehensive offers and ticketing

4. **Research & Strategy**
   - `schema-org-research-complete.md` - Complete analysis of specifications
   - `schema-org-implementation-tasks.md` - Implementation roadmap

## Schema.org Implementation Tasks - Complete Roadmap

_Fonte: `schema-org-implementation-tasks.md`_

# Schema.org Implementation Tasks - Complete Roadmap

**Updated**: [DATE]  
**Status**: 🚀 Implementation Ready

---

## Overview

This document consolidates all implementation tasks for Schema.org features in LaravelPizza, providing a prioritized roadmap with detailed implementation guidance, code examples, and quality assurance procedures.

## Task Prioritization Matrix

### 🔥 HIGH Priority Tasks (Weeks 1-2)

| Task | Documentation | Status | Impact |
|------|-------------|--------|---------|
| 1. Event Scheduling System | [task-event-scheduling.md](./task-event-scheduling.md) | ✅ Complete | Core recurring events |
| 2. Event Series Management | [task-event-series.md](./task-event-series.md) | ✅ Complete | Event grouping |
| 3. RSVP Action System | [task-rsvp-actions.md](./task-rsvp-actions.md) | ✅ Complete | User engagement |
| 4. Enhanced Event Model | [task-event-enhancement.md](./task-event-enhancement.md) | ✅ Complete | Schema.org compliance |

### 🔶 MEDIUM Priority Tasks (Weeks 3-4)

| Task | Documentation | Status | Impact |
|------|-------------|--------|---------|
| 5. Event Reservation System | [task-event-reservations.md](./task-event-reservations.md) | ✅ Complete | Ticketing |
| 6. Food Establishment Integration | [task-food-establishments.md](./task-food-establishments.md) | ✅ Complete | Venue partners |
| 7. Education Event Support | [task-education-events.md](./task-education-events.md) | ✅ Complete | Workshops |
| 8. Location Management | [task-location-manag

## Meetup Schema.org Model Governance

_Fonte: `schema-org-model-governance.md`_

# Meetup Schema.org Model Governance

## Obiettivo

Il modulo `Meetup` deve essere `rich snippets ready`.

Questo obiettivo va interpretato correttamente:
- ogni model di dominio rilevante deve poter produrre structured data completo e accurato;
- il model non deve trasformarsi in una copia meccanica della pagina `schema.org`;
- il mapping puo' usare attributi persistiti, relazioni, enum, oggetti derivati e `meta_data`.

## Perche' mettere in dubbio "tutti gli elementi di schema.org nel model"

Su `schema.org`, tipi come `Event`, `Person`, `Organization` e `Place` ereditano un numero molto alto di proprieta'.

Applicare la regola in modo letterale porterebbe a:
- model gonfiati con campi mai usati;
- duplicazione tra database, accessor e structured data;
- perdita di DRY e di chiarezza;
- documentazione che dichiara compliance senza implementazione reale.

La regola corretta e' quindi:

> ogni model `Meetup` deve avere un contratto di serializzazione `schema.org` completo per i dati che il dominio possiede o puo' derivare in modo affidabile.

## Canonical type map

| Model | Canonical type | Note |
|------|------|------|
| `Event` | `Event` | modello principale rich result |

## Schema.org Offers, Pricing, and Ticketing Implementation

_Fonte: `schema-org-offers-pricing-ticketing.md`_

# Schema.org Offers, Pricing, and Ticketing Implementation

## Overview

This document provides comprehensive implementation guidance for Schema.org Offer types, PriceSpecification, and related entities for building a complete ticketing and monetization system in LaravelPizza.

## Core Offer Types

### 1. Offer (Base Type)

The fundamental offer type representing any proposal to transfer rights, goods, or services.

#### Key Properties
- `@type` - Always "Offer"
- `name` - Offer title/name
- `description` - Detailed offer description
- `price` - Numeric price value
- `priceCurrency` - ISO 4217 currency code
- `availability` - Stock status (InStock, OutOfStock, etc.)
- `businessFunction` - Transaction type (sell, lease, etc.)
- `itemOffered` - What's being offered (Event, Product, Service)
- `offeredBy` - Who's making the offer
- `validFrom`/`validThrough` - Validity period
- `url` - Offer landing page

### 2. PriceSpecification

Detailed pricing information for complex pricing models.

#### Key Properties

## Schema.org Page Type Governance

_Fonte: `schema-org-page-type-governance.md`_

# Schema.org Page Type Governance

## Regola

Nel progetto `Meetup` bisogna distinguere sempre:

- il nodo entita' di dominio;
- il nodo pagina pubblica che la presenta.

`schema.org` non descrive solo oggetti come `Event` o `Person`, ma anche il tipo della pagina che li espone.

## Mappa minima

| Route/Page | Page type | Main entity |
|---|---|---|
| `/events` | `CollectionPage` | lista di `Event` |
| `/events/{slug}` | `ItemPage` o `WebPage` | `Event` |
| `/profile/{user}` | `ProfilePage` | `Person` |
| `/privacy` | `WebPage` | testo legale / `WebPageElement` |
| `/terms` | `WebPage` | testo legale / `WebPageElement` |
| `/contact` | `ContactPage` | `Organization` / `ContactPoint` |
| homepage | `WebPage` | `Organization` e contenuti principali |

## Regola pratica

- il model pubblico esporta l'entita' (`Event`, `Person`, `Organization`, `Place`);
- il tema esporta il nodo pagina (`WebPage`, `ProfilePage`, `ItemPage`, `CollectionPage`);
- i due nodi vanno collegati con `mainEntity` o `mainEntityOfPage`;
- il markup pagina non deve contraddire il contenuto realmente visibile.

## Meetup Schema.org Public Model Contract

_Fonte: `schema-org-public-model-contract.md`_

# Meetup Schema.org Public Model Contract

## Obiettivo

Rendere `Modules/Meetup` rich-snippets ready senza deformare il dominio.

## Chiarimento necessario

`schema.org` non implica che ogni modello debba avere tutte le proprieta' del tipo referenziato.

La lettura corretta e':

- usare il tipo piu' specifico possibile;
- coprire i campi richiesti dal rich result supportato;
- aggiungere le proprieta' raccomandate solo quando esiste un dato reale e pubblico;
- non introdurre campi fittizi solo per "riempire" il tipo.

## Mappa attuale del modulo

### `Event`

- tipo: `Event`
- stato attuale: ha gia' `toSchemaOrg()`
- gap principale: il `location` emesso oggi ha solo `name`, ma per la baseline Google evento servono anche dettagli di indirizzo sul nodo `Place`
- altri gap: `organizer` troppo minimale, `performer` assente, `offers` non normalizzato, `image` e `description` non garantiti come baseline operativa

### `Venue`

- tipo: `Place` oppure `LocalBusiness` se il venue e' anche business pubblico
- stato attuale: dati utili gia' presenti (`name`, `address`, `city`, `country`, `latitude`, `longitude`, `website`, `phone`)

## Schema.org Research - Complete Analysis

_Fonte: `schema-org-research-complete.md`_

# Schema.org Research - Complete Analysis

**Status**: Complete – all specifications studied and documented

---

## Executive Summary

I have conducted a comprehensive analysis of Schema.org specifications for event management, RSVP systems, and venue management. This research provides the foundation for implementing world-class event functionality in LaravelPizza with full compliance to structured data standards.

## Research URLs Analyzed

### Event Management Core Types
1. **Event** - [https://schema.org/Event](https://schema.org/Event)
2. **EventSeries** - [https://schema.org/EventSeries](https://schema.org/EventSeries)  
3. **eventSchedule** - [https://schema.org/eventSchedule](https://schema.org/eventSchedule)
4. **EventReservation** - [https://schema.org/EventReservation](https://schema.org/EventReservation)
5. **EducationEvent** - [https://schema.org/EducationEvent](https://schema.org/EducationEvent)

### Action and Participation Types
1. **JoinAction** - [https://schema.org/JoinAction](https://schema.org/JoinAction)
2. **LeaveAction** - [https://schema.org/LeaveAction](https://schema.org/LeaveAction)
3. **attendee** - [https://schema.org/attendee](https://schema.org/attendee)
4. **participant** - [https://schema.org/participant](https://schema.org/participant)
5. **attendees** - [https://schema.org/attendees](https://schema.org/attendees) *(deprecated)*

### Commercial and Offer Types
1. **Offer** - [https://schema.org/Offer](https://schema.org/Offer)
2. **PriceSpec

## Schema.org Comprehensive Research Guide

_Fonte: `schema-org-research-comprehensive.md`_

# Schema.org Comprehensive Research Guide

**Status**: Reference document  
**Purpose**: Deep research on Schema.org types for Meetup module enhancement

---

## Table of Contents

1. [Event Scheduling & Recurrence](#event-scheduling--recurrence)
2. [Event Series & Super Events](#event-series--super-events)
3. [Participant Actions](#participant-actions)
4. [Event Reservations](#event-reservations)
5. [Education Events](#education-events)
6. [Food Establishments](#food-establishments)
7. [Pricing & Offers](#pricing--offers)
8. [Geographic Areas](#geographic-areas)
9. [Person & Address](#person--address)
10. [Hotel Accommodations](#hotel-accommodations)
11. [Implementation Tasks](#implementation-tasks)

---

## Event Scheduling & Recurrence

### Schema.org URL: [eventSchedule](https://schema.org/eventSchedule)

The `eventSchedule` property allows specifying when an event occurs, particularly for recurring events.

### Key Concepts
