---
title: "Topic activitylog"
type: digest
status: active
qmd: "digest ceiling 100 activitylog"
---

# Topic activitylog

Sintesi automatica di 3 documenti (chiave `activitylog`).

## activitylog

_Fonte: `activitylog.md`_



## activitylog

_Fonte: `bmad/activitylog.md`_



## activitylog

_Fonte: `it/config/activitylog.md`_

<?php

return [

    /*
     * If set to false, no activities will be saved to the database.
     */
    'enabled' => env('ACTIVITY_LOGGER_ENABLED', true),

    /*
     * When the clean-command is executed, all recording activities older than
     * the number of days specified here will be deleted.
     */
    'delete_records_older_than_days' => 365,

    /*
     * If no log name is passed to the activity() helper
     * we use this default log name.
     */
    'default_log_name' => 'default',

    /*
     * You can specify an auth driver here that gets user models.
     * If this is null we'll use the current Laravel auth driver.
     */
    'default_auth_driver' => null,

    /*
     * If set to true, the subject returns soft deleted models.
     */
