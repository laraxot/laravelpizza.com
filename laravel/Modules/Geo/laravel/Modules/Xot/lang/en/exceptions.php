<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Exception Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used in Exceptions thrown throughout the system.
    | Regardless where it is placed, a button can be listed here so it is easily
    | found in a intuitive way.
    |
    */

    'backend' => [
        'takeaway' => [
            'newsletterSubscribe' => [
                'messages' => [
                ],
            ],
            'category' => [
                'create_error' => 'Create Error',
                'update_error' => 'Update Error',
                'cant_delete_self' => 'Can not Delete Self',
                'delete_error' => 'Delete Error',
                'delete_first' => 'Delete First',
                'cant_restore' => 'Can nott Restore',
                'restore_error' => 'Restore Error',
            ],
            'addOnCategory' => [
                'create_error' => 'Create Error',
                'update_error' => 'Update Error',
                'cant_delete_self' => 'Can not Delete Self',
                'delete_error' => 'Delete Error',
                'delete_first' => 'Delete First',
                'cant_restore' => 'Can nott Restore',
                'restore_error' => 'Restore Error',
            ],
            'currency' => [
                'create_error' => 'Create Error',
                'update_error' => 'Update Error',
                'cant_delete_self' => 'Can not Delete Self',
                'delete_error' => 'Delete Error',
                'delete_first' => 'Delete First',
                'cant_restore' => 'Can nott Restore',
                'restore_error' => 'Restore Error',
            ],
            'ingredient' => [
                'create_error' => 'Create Error',
                'update_error' => 'Update Error',
                'cant_delete_self' => 'Can not Delete Self',
                'delete_error' => 'Delete Error',
                'delete_first' => 'Delete First',
                'cant_restore' => 'Can nott Restore',
                'restore_error' => 'Restore Error',
            ],
            'item' => [
                'create_error' => 'Create Error',
                'update_error' => 'Update Error',
                'cant_delete_self' => 'Can not Delete Self',
                'delete_error' => 'Delete Error',
                'delete_first' => 'Delete First',
                'cant_restore' => 'Can nott Restore',
                'restore_error' => 'Restore Error',
            ],
            'package' => [
                'create_error' => 'Create Error',
                'update_error' => 'Update Error',
                'cant_delete_self' => 'Can not Delete Self',
                'delete_error' => 'Delete Error',
                'delete_first' => 'Delete First',
                'cant_restore' => 'Can nott Restore',
                'restore_error' => 'Restore Error',
            ],
            'productSize' => [
                'create_error' => 'Create Error',
                'update_error' => 'Update Error',
                'cant_delete_self' => 'Can not Delete Self',
                'delete_error' => 'Delete Error',
                'delete_first' => 'Delete First',
                'cant_restore' => 'Can nott Restore',
                'restore_error' => 'Restore Error',
            ],
        ],
        'access' => [
            'roles' => [
                'already_exists' => 'That role already exists. Please choose a different name.',
                'cant_delete_admin' => 'You can not delete the Administrator role.',
                'create_error' => 'There was a problem creating this role. Please try again.',
                'delete_error' => 'There was a problem deleting this role. Please try again.',
                'has_users' => 'You can not delete a role with associated users.',
                'needs_permission' => 'You must select at least one permission for this role.',
                'not_found' => 'That role does not exist.',
                'update_error' => 'There was a problem updating this role. Please try again.',
            ],

            'users' => [
                'cant_deactivate_self' => 'You can not do that to yourself.',
                'cant_delete_self' => 'You can not delete yourself.',
                'cant_restore' => 'This user is not deleted so it can not be restored.',
                'create_error' => 'There was a problem creating this user. Please try again.',
                'delete_error' => 'There was a problem deleting this user. Please try again.',
                'delete_first' => 'This user must be deleted first before it can be destroyed permanently.',
                'email_error' => 'That email address belongs to a different user.',
                'mark_error' => 'There was a problem updating this user. Please try again.',
                'not_found' => 'That user does not exist.',
                'restore_error' => 'There was a problem restoring this user. Please try again.',
                'role_needed_create' => 'You must choose at lease one role.',
                'role_needed' => 'You must choose at least one role.',
                'update_error' => 'There was a problem updating this user. Please try again.',
                'update_password_error' => 'There was a problem changing this users password. Please try again.',
            ],
        ],
    ],

    'general' => [
        'messages' => [
            'merchant' => [
                'resturant_slug' => 'Resturant Slug field is required.',
                'resturant_name' => 'Resturant Name field is required.',
                'resturant_phone' => 'Resturant Phone field is required.',
            ],
            'email' => [
                'required' => 'Email is required',
                'unique' => 'Email already exist',
                'valid' => 'Enter a valid email',
            ],
            'status' => 'Status is required',
        ],
    ],
    'frontend' => [
        'auth' => [
            'confirmation' => [
                'already_confirmed' => 'Your account is already confirmed.',
                'confirm' => 'Confirm your account!',
                'created_confirm' => 'Your account was successfully created. We have sent you an e-mail to confirm your account.',
                'mismatch' => 'Your confirmation code does not match.',
                'not_found' => 'That confirmation code does not exist.',
                'resend' => 'Your account is not confirmed. Please click the confirmation link in your e-mail, or <a href="'.route('frontend.auth.account.confirm.resend', ':user_id').'">click here</a> to resend the confirmation e-mail.',
                'success' => 'Your account has been successfully confirmed!',
                'resent' => 'A new confirmation e-mail has been sent to the address on file.',
            ],

            'deactivated' => 'Your account has been deactivated.',
            'email_taken' => 'That e-mail address is already taken.',

            'password' => [
                'change_mismatch' => 'That is not your old password.',
            ],
        ],
    ],
];
