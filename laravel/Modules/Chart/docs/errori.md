---
title: Soluzione agli Errori
description: Soluzione agli Errori
extends: _layouts.documentation
section: content
---

# Soluzione agli Errori {#soluzione-agli-errori}

## Errore:

```console
Can't write to file "/var/www/base_example/public_html/chart/uuid-uuid-uuid-uuid-uuid.png". Check that the process running PHP has enough permission.
```

### Soluzione

```console
cd base_example/public_html
mkdir chart
cd ..
sudo chmod 777 -R .