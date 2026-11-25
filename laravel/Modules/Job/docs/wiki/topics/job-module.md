---
title: "Topic job-module"
type: digest
status: active
qmd: "digest ceiling 100 job-module"
---

# Topic job-module

Sintesi automatica di 3 documenti (chiave `job-module`).

## Architecture Job

_Fonte: `bmad/architecture/job-module.md`_

# Architecture Job

SSoT modulo: [../../architecture.md](../../architecture.md)

SSoT Livewire → Filament: [../livewire-widget-architecture.md](../livewire-widget-architecture.md)

## Job Module Philosophy

_Fonte: `job-module-philosophy.md`_

# Job Module Philosophy

**Last updated:** 2026-09-06

---

## RELIGIONE

Why does the Job module have 19 model files (Task, Schedule, Job, JobBatch, Frequency, Parameter, Result, ScheduleHistory, FailedJob, Import, Export, FailedImportRow, TaskComment, JobManager, JobsWaiting, and others)?

### The Religion: Async Task Processing is Sacred

The Job module exists for one sacred reason: **keep the user interface fast by moving heavy work outside the request-response cycle.**

A user clicks "export 100,000 geocoded locations" or "send notifications to 50,000 residents". The request must return immediately. The work happens later, in background processes. The UI shows progress. Failures are tracked. Retries are automatic. Everything is observable.

### Model Rationale

The models exist in layers:

**Domain Layer (Task, Schedule, Frequency, Parameter, TaskComment):**
- Task: The abstract unit of work ("send emails", "generate PDF", "process geocoding")
- Schedule: When and how often Task runs (cron expression)
- Frequency: Temporal patterns (every Monday, every 5 minutes, monthly on 15th)
- Parameter: Arguments passed to tasks
- TaskComment: Collaboration on task configuration

**Execution Layer (Job, JobBatch, FailedJob, JobsWaiting):**
- Job: Single queued job (Laravel queue native)

## ⚠️ Job Module Troubleshooting Guide

_Fonte: `job-module-troubleshooting-guide.md`_

# ⚠️ Job Module Troubleshooting Guide

**Last updated:** 2026-07-28

---

## Overview

This guide covers common errors, root causes, solutions, and prevention strategies for the Job module's async processing system.

---

## Error Category 1: Dispatch Failures

**Symptoms:** Job never appears in queue, immediate error when calling `.dispatch()`

### Error Pattern

```
BadMethodCallException: Call to undefined method dispatch()
Queue driver error: Connection refused
Serialization failed: Object could not be serialized
```

### Root Causes

1. Action doesn't implement `ShouldQueue` interface
2. Queue driver misconfigured (Redis/Database not accessible)
3. Object contains non-serializable properties (closures, streams)
