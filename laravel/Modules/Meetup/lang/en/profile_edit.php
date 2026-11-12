<?php

declare(strict_types=1);

// Pagina "Modifica il profilo" (/{lingua}/profile/edit): Modules\Meetup\Http\Livewire\ProfileEditForm
return [
    'link' => 'Edit profile',
    'sections' => [
        'data' => ['title' => 'Your details', 'description' => 'Your name and bio appear on your public profile and in attendee lists.'],
        'photo' => ['title' => 'Photo', 'description' => 'Optional. Without a photo we show your initials.'],
        'password' => ['title' => 'Password', 'description' => 'Enter your current password first. Other open sessions will be signed out.'],
    ],
    'fields' => [
        'first_name' => 'First name',
        'last_name' => 'Last name',
        'email' => 'Email',
        'bio' => 'Bio',
        'locale' => 'Preferred language',
        'photo' => 'New photo',
        'current_password' => 'Current password',
        'password' => 'New password',
        'password_confirmation' => 'Repeat the new password',
    ],
    'help' => [
        'email' => 'You can\'t change your email here: write to us from the Contact page if you need to.',
        'bio' => 'Up to 500 characters. Visible to everyone.',
        'locale' => 'The language of the emails we send you.',
        'photo' => 'JPG, PNG or WebP, up to 2 MB.',
    ],
    'placeholders' => [
        'bio' => 'A couple of lines about you: what you do, what you work with, what you\'d like to learn.',
    ],
    'actions' => [
        'save_profile' => 'Save details',
        'view_public' => 'View public profile',
        'save_photo' => 'Upload photo',
        'remove_photo' => 'Remove photo',
        'change_password' => 'Change password',
    ],
    'saved' => [
        'profile' => 'Details saved.',
        'photo' => 'Photo updated.',
        'password' => 'Password changed.',
    ],
    'photo' => [
        'uploading' => 'Uploading…',
        'preview_alt' => 'Preview of the new photo',
        'current_alt' => 'Your current photo',
    ],
];
