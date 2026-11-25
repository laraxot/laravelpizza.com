---
title: "Topic event-schema"
type: digest
status: active
qmd: "digest ceiling 100 event-schema"
---

# Topic event-schema

Sintesi automatica di 3 documenti (chiave `event-schema`).

## Event Model Schema.org Compliance Report

_Fonte: `event-schema-org-compliance-report.md`_

# Event Model Schema.org Compliance Report

**Report Date**: [DATE]  
**Model**: Modules\Meetup\Models\Event  
**Status**: INCOMPLETE - Missing Critical Schema.org Properties

---

## Executive Summary

The current Event model is **NOT fully compliant** with Schema.org Event standard. It is missing several critical properties required for proper structured data implementation.

---

## ✅ **Currently Implemented (Correct)**

| Property | Status | Implementation |
|----------|--------|----------------|
| `@context` | ✅ | 'https://schema.org' |
| `@type` | ✅ | 'Event' |
| `name` | ✅ | `$this->title` |
| `startDate` | ✅ | `$this->start_date->toIso8601String()` |
| `endDate` | ✅ | `$this->end_date->toIso8601String()` |
| `eventStatus` | ✅ | `$this->event_status->toSchemaOrgUri()` |
| `eventAttendanceMode` | ✅ | `$this->event_attendance_mode->toSchemaOrgUri()` |
| `location` | ✅ | Basic Place structure |
| `description` | ✅ | `$this->description` |
| `image` | ✅ | `$this->cover_image` |
| `organizer` | ✅ | Person structure |
| `offers` | ✅ | Array of offers |

## Event Model - Schema.org Implementation

_Fonte: `event-schema-org-implementation.md`_

# Event Model - Schema.org Implementation

**Status**: ✅ COMPLETED
**Priorità**: HIGH (Phase 1)
**Principi**: DRY + KISS + SOLID + Schema.org Best Practices

---

## Obiettivo

Implementare i campi Schema.org Event type sul modello Event esistente per:
1. **SEO Enhancement**: Rich snippets nei risultati di ricerca
2. **AI Compatibility**: Migliore comprensione da parte di AI systems (Google, ChatGPT, Perplexity)
3. **Structured Data**: Dati strutturati per integrazioni terze parti
4. **Future-Proof**: Preparazione per Web 3.0 e Semantic Web

**Reference**: [Schema.org Event Type](https://schema.org/Event)

---

## Analisi Stato Attuale

### Campi Esistenti (✅ Già Presenti)

| Campo DB | Proprietà Model | Schema.org Equivalent | Status |
|----------|----------------|----------------------|--------|
| `title` | `string` | `name` | ✅ OK |
| `description` | `string\|null` | `description` | ✅ OK |
| `start_date` | `Carbon` | `startDate` | ✅ OK |
| `end_date` | `Carbon` | `endDate` | ✅ OK |

## Event Model - Schema.org Implementation

_Fonte: `event-schema-org.md`_

# Event Model - Schema.org Implementation

> Stato reale: implementazione baseline presente, ma non sufficiente da sola per dichiarare copertura completa `schema.org/Event`. Vedi anche `schema-org-model-governance.md`.

## Overview

The Event model in LaravelPizza is designed to be fully compliant with **Schema.org/Event** for SEO optimization. This enables rich snippets in search results and better visibility on Google Events.

## Current Baseline

### Properties Implemented

| Schema.org Property | Model Field | Type |
|---------------------|-------------|------|
| `@type` | - | Event |
| `name` | `title` | Text |
| `description` | `description` | Text |
| `startDate` | `start_date` | DateTime |
| `endDate` | `end_date` | DateTime |
| `eventStatus` | `event_status` | EventStatusType |
| `eventAttendanceMode` | `event_attendance_mode` | EventAttendanceModeEnumeration |
| `location` | `location` | Place |
| `image` | `cover_image` | URL |
| `organizer` | `organizer` | Organization/Person |
| `offers` | `offers` | Offer |
| `url` | `url` | URL |
| `inLanguage` | `in_language` | Language |
| `duration` | `duration` | Duration (ISO 8601) |
| `maximumAttendeeCapacity` | `max_attendees` | Integer |
| `remainingAttendeeCapacity` | - | Computed |
