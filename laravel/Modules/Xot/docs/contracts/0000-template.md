---
title: "Behavioral contract template"
type: template
status: proposed
---

# `<operation>`

One sentence describing the public operation or boundary. Name the owner and link this file from its docblock with `@contract docs/contracts/<file>.md`.

## Owner

Class, method, interface, middleware, component, or view boundary that owns the behavior.

## Input

Types, required fields, units, ranges, authorization context, and trust-boundary validation.

## Output

Return value, response status, persisted state, and observable result.

## Invariants

Use stable IDs. Each implemented invariant must have a focused test, normally a Pest group with the same ID.

| ID | Rule | Test group |
|---|---|---|
| `MODULE-INV-1` | | `MODULE-INV-1` |

## Side effects

List database writes, transactions, external calls, events, notifications, queues, files, and their order.

## Errors

Exception or response, when it occurs, and the invariant or boundary it protects.

## Non-goals

Explicitly exclude tempting adjacent behavior, especially behavior that belongs to another module or a future task.
