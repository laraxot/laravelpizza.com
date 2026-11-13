---
title: "Activity Module Database Schema"
type: reference
tags: [activity, database, schema]
created: 2026-07-28
updated: 2026-07-28
---

# Activity Module — Database Schema

## activities Table

```sql
id BIGINT PRIMARY KEY AUTO_INCREMENT
log_name VARCHAR(255) DEFAULT 'default'
description TEXT
subject_id UUID NULL
subject_type VARCHAR(255) NULL
causer_id UUID NULL
causer_type VARCHAR(255) NULL
properties LONGTEXT (JSON)
created_at, updated_at TIMESTAMP
```

- **Polymorphic:** subject_id + subject_type (can be any model)
- **Causer:** User performing the action
- **Properties:** JSON metadata (email, old values, etc.)
