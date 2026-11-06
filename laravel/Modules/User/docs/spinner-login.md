---
title: "spinner login"
type: note
status: draft
updated: 2026-10-19
tags: [docs, user]
qmd: "spinner login user"
---
<button x-data="{loading:false}" @click="loading=true" :disabled="loading" class="btn"><span x-show="loading" class="loading loading-spinner"></span> Accedi</button>
