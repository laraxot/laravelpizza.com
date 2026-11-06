---
title: "scope"
type: note
status: draft
updated: 2026-10-18
tags: [docs, xot, consolidated]
qmd: "scope xot"
---
# scope

<!-- Contenuto migrato da _docs/scope.txt -->

Calling some fields from a specific table in a more organized way - Laravel

If you want to call some fields from a specific table in a more organized way, you can write this function in Model :-

public function scopeDoctorFields($query)
{
$query->select('name');
}

then call function inside Controller :-

$doctors = User::doctorFields()->paginate(100);

--------------------------------------------------------------------------------------
