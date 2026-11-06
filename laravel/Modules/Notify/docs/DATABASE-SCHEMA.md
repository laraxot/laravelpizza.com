---
updated: 2026-09-26
qmd: "DATABASE SCHEMA"
issues: []
discussions: []
title: "Notify Module Database Schema"
type: reference
tags: [notify, database, schema]
created: 2026-07-28
status: superseded
superseded_by: database-schema.md
---

# Notify Module: Database Schema

## notifications Table

```sql
id UUID PRIMARY KEY
notifiable_id UUID NOT NULL
notifiable_type VARCHAR(255) NOT NULL
type VARCHAR(255) NOT NULL
data LONGTEXT (JSON)
read_at TIMESTAMP NULL
created_at TIMESTAMP
```

**Polymorphic:** notifiable_id + notifiable_type (usually User)
**Channels:** Stored in data JSON (mail, sms, slack)
