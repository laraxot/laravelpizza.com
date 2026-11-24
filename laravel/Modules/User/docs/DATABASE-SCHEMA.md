---
title: "User Module Database Schema"
type: reference
tags: [user, database, schema]
created: 2026-07-28
updated: 2026-07-28
---

# User Module — Database Schema

## Core Tables

### users
```sql
id UUID PRIMARY KEY
email VARCHAR(255) UNIQUE NOT NULL
password VARCHAR(255) NOT NULL
name VARCHAR(255)
email_verified_at TIMESTAMP NULL
created_at, updated_at TIMESTAMP
deleted_at TIMESTAMP NULL (soft delete)
```

### teams
```sql
id UUID PRIMARY KEY
user_id UUID NOT NULL (team owner)
name VARCHAR(255)
created_at, updated_at TIMESTAMP
FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
```

### tenants
```sql
id UUID PRIMARY KEY
name VARCHAR(255)
slug VARCHAR(255) UNIQUE
domain VARCHAR(255) UNIQUE
created_at, updated_at TIMESTAMP
```

## Spatie Permission Tables

### roles
```sql
id BIGINT PRIMARY KEY AUTO_INCREMENT
name VARCHAR(125) UNIQUE NOT NULL
guard_name VARCHAR(125) DEFAULT 'web'
created_at, updated_at TIMESTAMP
```

### permissions
```sql
id BIGINT PRIMARY KEY AUTO_INCREMENT
name VARCHAR(125) UNIQUE NOT NULL
guard_name VARCHAR(125) DEFAULT 'web'
created_at, updated_at TIMESTAMP
```

### model_has_role
```sql
role_id BIGINT NOT NULL
model_id UUID NOT NULL
model_type VARCHAR(255) NOT NULL
PRIMARY KEY (role_id, model_id, model_type)
FOREIGN KEY(role_id) REFERENCES roles(id) ON DELETE CASCADE
```

### model_has_permission
```sql
permission_id BIGINT NOT NULL
model_id UUID NOT NULL
model_type VARCHAR(255) NOT NULL
PRIMARY KEY (permission_id, model_id, model_type)
FOREIGN KEY(permission_id) REFERENCES permissions(id) ON DELETE CASCADE
```

## Key Constraints

- **users.id:** UUID (not auto-increment)
- **users.email:** Unique, indexed for login
- **users.deleted_at:** Soft delete (NULL = active)
- **teams.user_id:** Cascade delete (if owner deleted, team deleted)
- **Role/Permission names:** Unique within guard_name

## Indexes

- `users(email)` — login lookups
- `users(deleted_at)` — soft delete filtering
- `teams(user_id)` — user → teams
- `roles(name, guard_name)` — role lookups
- `permissions(name, guard_name)` — permission lookups
