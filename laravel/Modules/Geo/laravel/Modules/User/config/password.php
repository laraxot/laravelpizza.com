<?php

declare(strict_types=1);

return [
    'otp_expiration_minutes' => 15, // Durata in minuti della validità della password temporanea
    'otp_length' => 6, // Lunghezza del codice OTP
    'expires_in' => 30, // The number of days before the password expires.
    'min' => 6, // The minimum size of the password.
    'mixedCase' => false, // If the password requires at least one uppercase and one lowercase letter.
    'letters' => false, // If the password requires at least one letter.
    'numbers' => false, // If the password requires at least one number.
    'symbols' => false, // If the password requires at least one symbol.
    // uppercase
    'uncompromised' => false, // If the password should not have been compromised in data leaks.
    'compromisedThreshold' => 1, // The number of times a password can appear in data leaks before being considered compromised.
    // requireSpecialCharacter(); // at least one special character required
];

/*
 * $inputs = [
 * 'email'    => 'foo',
 * 'password' => 'bar',
 * ];
 *
 * $rules = [
 * 'email'    => 'required|email',
 * 'password' => [
 * 'required',
 * 'string',
 * 'min:10',             // must be at least 10 characters in length
 * 'regex:/[a-z]/',      // must contain at least one lowercase letter
 * 'regex:/[A-Z]/',      // must contain at least one uppercase letter
 * 'regex:/[0-9]/',      // must contain at least one digit
 * 'regex:/[@$!%*#?&]/', // must contain a special character
 * ],
 * ];
 *
 * $validation = \Validator::make( $inputs, $rules );
 *
 * if ( $validation->fails() ) {
 * print_r( $validation->errors()->all() );
 * }
 */
