<?php

declare(strict_types=1);

/*
 * "Forgot password" and "new password" pages of the front office (DCP-290).
 * The `sent` message is the same for a registered and an unknown address: accounts cannot be enumerated.
 */
return [
    'title' => 'Forgot your password?',
    'intro' => 'Enter the email address you signed up with. We will send you a link to choose a new password.',
    'submit' => 'Send the link',
    'sent' => 'If the address is registered, you will soon get an email with a link to choose a new password. Check your spam folder too.',
    'back_to_login' => 'Back to sign in',
    'reset_title' => 'Choose a new password',
    'reset_intro' => 'Type the new password twice. Then you can sign in with it.',
    'reset_submit' => 'Save the new password',
    'reset_done' => 'Your password has been changed. Sign in with the new password.',
    'invalid_link' => 'The link is not valid or has expired. Ask for a new one.',
    'request_new' => 'Ask for a new link',
    'sending' => 'Sending…',
    'saving' => 'Saving…',
];
