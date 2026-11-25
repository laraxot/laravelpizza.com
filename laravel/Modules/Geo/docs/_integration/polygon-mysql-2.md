---
title: "polygon mysql"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "polygon mysql"
issues: []
discussions: []
---

# polygon_mysql

<!-- Contenuto migrato da _docs/polygon_mysql.txt -->

SET @g = ST_GEOMFROMTEXT('POLYGON((11.0000000 46.0000000,11.0000000 45.0000000,13.0000000 45.0000000,13.0000000 46.0000000, 11.0000000 46.0000000))');
set @p = ST_GEOMFROMTEXT('POINT(12.2442554 45.5653223)');
SELECT ST_CONTAINS(@g,@p);