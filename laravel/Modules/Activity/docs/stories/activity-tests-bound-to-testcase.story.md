---
title: "Activity: ogni file di test legato al TestCase del modulo"
type: story
status: done
created: 2026-10-26
updated: 2026-10-26
module: Activity
related:
  - ./3.10.activity-pest-extend-bootstrap.story.md
  - ../wiki/concepts/pest-bootstrap-extend-ignore.md
tags: [activity, pest, testcase, mockery, bootstrap]
---

# Activity: ogni file di test legato al TestCase del modulo

Fase BMAD: Dev, poi Verify.

## Problema

Il commit `63a67a3054` ha tolto `pest()->extend(TestCase::class)->in('Feature', 'Unit')` da `tests/Pest.php`. Da allora vale la convenzione "ogni file dichiara `uses()`", ma 23 file su 98 non lo facevano. Quei test giravano senza app Laravel. Un `new Activity` lanciava `Target class [config]` a metà del boot. Il flag di boot di Eloquent restava attivo, e tutti i test successivi fallivano con `bootIfNotBooted ... while it is being booted` (48 casi). Isolati, passavano.

In più `mockeryExpect()` dichiarava come ritorno `Expectation`, mentre Mockery 1.6 restituisce sempre `CompositeExpectation` da `shouldReceive()`.

## Correzioni

- Aggiunto `uses(TestCase::class)` ai 23 file senza binding. L'`extend` globale non torna: collide (`TestCaseAlreadyInUse`) con i 75 file che hanno già il proprio `uses()`.
- `mockeryExpect()` (anche in `Modules/User/tests/Helpers.php`): se riceve un composite con un solo metodo, restituisce la sua `Expectation`. Il tipo resta preciso, senza `mixed` e senza `@var`.

## Verifica

Dalla root: `PEST_OUT=<file> bash bashscripts/tools/pest-scratch-db.sh --test-directory=Modules/Activity/tests Modules/Activity/tests`.
Prima: 114 falliti, 406 superati. Dopo: 23 falliti, 497 superati. PHPStan su `Modules/Activity/tests`: 0 errori.

## Aperto

I 23 rimasti: permessi e ruoli non creati nel DB scratch (`activity.viewAny`, `super-admin`), tabella di fixture `activity_subject_harness` mancante, `Model::newQuery()` chiamato staticamente, asserzioni su array vuoti.
