<?php

declare(strict_types=1);

// Validazione de del modulo User: la base e' il set completo di Modules/Xot, qui si aggiungono le regole che Xot non ha e i messaggi propri di User.
// Prima era una copia byte per byte del file italiano e, caricata dopo quella di Xot, la oscurava (DCP-146).
$base = (array) require base_path('Modules/Xot/lang/de/validation.php');

return array_replace_recursive(
    $base,
    [
        'date_equals' => 'Das Feld :attribute muss ein Datum gleich :date sein.',
        'ends_with' => 'Das Feld :attribute muss mit einem der folgenden Werte enden: :values.',
        'gt' => [
            'numeric' => 'Das Feld :attribute muss größer als :value sein.',
            'file' => 'Das Feld :attribute muss größer als :value Kilobyte sein.',
            'string' => 'Das Feld :attribute muss länger als :value Zeichen sein.',
            'array' => 'Das Feld :attribute muss mehr als :value Elemente haben.',
        ],
        'gte' => [
            'numeric' => 'Das Feld :attribute muss größer oder gleich :value sein.',
            'file' => 'Das Feld :attribute muss mindestens :value Kilobyte groß sein.',
            'string' => 'Das Feld :attribute muss mindestens :value Zeichen lang sein.',
            'array' => 'Das Feld :attribute muss mindestens :value Elemente haben.',
        ],
        'ipv4' => 'Das Feld :attribute muss eine gültige IPv4-Adresse sein.',
        'ipv6' => 'Das Feld :attribute muss eine gültige IPv6-Adresse sein.',
        'lt' => [
            'numeric' => 'Das Feld :attribute muss kleiner als :value sein.',
            'file' => 'Das Feld :attribute muss kleiner als :value Kilobyte sein.',
            'string' => 'Das Feld :attribute muss kürzer als :value Zeichen sein.',
            'array' => 'Das Feld :attribute muss weniger als :value Elemente haben.',
        ],
        'lte' => [
            'numeric' => 'Das Feld :attribute muss kleiner oder gleich :value sein.',
            'file' => 'Das Feld :attribute darf höchstens :value Kilobyte groß sein.',
            'string' => 'Das Feld :attribute darf höchstens :value Zeichen lang sein.',
            'array' => 'Das Feld :attribute darf nicht mehr als :value Elemente haben.',
        ],
        'mimetypes' => 'Das Feld :attribute muss eine Datei des Typs :values sein.',
        'multiple_of' => 'Das Feld :attribute muss ein Vielfaches von :value sein.',
        'not_regex' => 'Das Format des Feldes :attribute ist ungültig.',
        'password' => [
            'letters' => 'Das Feld :attribute muss mindestens einen Buchstaben enthalten.',
            'mixed' => 'Das Feld :attribute muss mindestens einen Groß- und einen Kleinbuchstaben enthalten.',
            'numbers' => 'Das Feld :attribute muss mindestens eine Zahl enthalten.',
            'symbols' => 'Das Feld :attribute muss mindestens ein Sonderzeichen enthalten.',
            'uncompromised' => 'Das angegebene :attribute ist in einem Datenleck aufgetaucht. Bitte wählen Sie ein anderes :attribute.',
        ],
        'starts_with' => 'Das Feld :attribute muss mit einem der folgenden Werte beginnen: :values.',
        'uploaded' => 'Das Hochladen von :attribute ist fehlgeschlagen.',
        'uuid' => 'Das Feld :attribute muss eine gültige UUID sein.',
        'email_already_taken' => 'Diese E-Mail-Adresse wird bereits von einem anderen Konto verwendet.',
        'password_confirmation' => 'Die Passwortbestätigung stimmt nicht überein.',
        'password_current_required' => 'Das aktuelle Passwort ist erforderlich.',
        'password_current_incorrect' => 'Das aktuelle Passwort ist nicht korrekt.',
        'name_required' => 'Der Name ist erforderlich.',
        'email_required' => 'Die E-Mail-Adresse ist erforderlich.',
        'email_format' => 'Die E-Mail-Adresse muss ein gültiges Format haben.',
        'phone_format' => 'Die Telefonnummer muss ein gültiges Format haben.',
        'birth_date_before' => 'Das Geburtsdatum muss vor dem heutigen Tag liegen.',
    ],
);
