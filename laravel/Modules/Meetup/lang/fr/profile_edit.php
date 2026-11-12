<?php

declare(strict_types=1);

// Pagina "Modifica il profilo" (/{lingua}/profile/edit): Modules\Meetup\Http\Livewire\ProfileEditForm
return [
    'link' => 'Modifier le profil',
    'sections' => [
        'data' => ['title' => 'Vos informations', 'description' => 'Votre nom et votre bio apparaissent sur votre profil public et dans les listes de participants.'],
        'photo' => ['title' => 'Photo', 'description' => 'Facultative. Sans photo, nous affichons vos initiales.'],
        'password' => ['title' => 'Mot de passe', 'description' => 'Saisissez d\'abord votre mot de passe actuel. Les autres sessions ouvertes seront fermées.'],
    ],
    'fields' => [
        'first_name' => 'Prénom',
        'last_name' => 'Nom',
        'email' => 'E-mail',
        'bio' => 'Bio',
        'locale' => 'Langue préférée',
        'photo' => 'Nouvelle photo',
        'current_password' => 'Mot de passe actuel',
        'password' => 'Nouveau mot de passe',
        'password_confirmation' => 'Répétez le nouveau mot de passe',
    ],
    'help' => [
        'email' => 'L\'e-mail ne se change pas ici : écrivez-nous depuis la page Contact si besoin.',
        'bio' => '500 caractères maximum. Visible par tous.',
        'locale' => 'La langue des e-mails que nous vous envoyons.',
        'photo' => 'JPG, PNG ou WebP, 2 Mo maximum.',
    ],
    'placeholders' => [
        'bio' => 'Quelques lignes sur vous : ce que vous faites, avec quoi vous travaillez, ce que vous aimeriez apprendre.',
    ],
    'actions' => [
        'save_profile' => 'Enregistrer',
        'view_public' => 'Voir le profil public',
        'save_photo' => 'Envoyer la photo',
        'remove_photo' => 'Retirer la photo',
        'change_password' => 'Changer le mot de passe',
    ],
    'saved' => [
        'profile' => 'Informations enregistrées.',
        'photo' => 'Photo mise à jour.',
        'password' => 'Mot de passe changé.',
    ],
    'photo' => [
        'uploading' => 'Envoi en cours…',
        'preview_alt' => 'Aperçu de la nouvelle photo',
        'current_alt' => 'Votre photo actuelle',
    ],
];
