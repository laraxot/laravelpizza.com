<?php

use Spatie\QueueableAction\ActionJob;

return [
    /*
     * The job class that will be dispatched.
     * If you would like to change it and use your own job class,
     * it must extend the \Spatie\QueueableAction\ActionJob class.
     */
    'job_class' => ActionJob::class,
];
