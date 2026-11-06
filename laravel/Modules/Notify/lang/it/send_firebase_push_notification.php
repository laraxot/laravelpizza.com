<?php

declare(strict_types=1);

return [
    'navigation' => ['label' => 'Invio Push Notification', 'group' => 'Notifiche'],
    'label' => 'Send Firebase Push Notification',
    'plural_label' => 'Send Firebase Push Notification (Plurale)',
    'fields' => [
        'id' => ['label' => 'Identificativo', 'tooltip' => 'Identificativo univoco del record', 'helper_text' => '', 'description' => ''],
        'created_at' => ['label' => 'Data Creazione', 'tooltip' => '', 'helper_text' => '', 'description' => ''],
        'updated_at' => ['label' => 'Ultima Modifica', 'tooltip' => '', 'helper_text' => '', 'description' => ''],
        'token' => ['label' => 'token', 'placeholder' => 'token', 'helper_text' => 'token', 'description' => 'token'],
        'title' => ['label' => 'title', 'placeholder' => 'title', 'helper_text' => 'title', 'description' => 'title'],
        'body' => ['label' => 'body', 'placeholder' => 'body', 'helper_text' => 'body', 'description' => 'body'],
        'image_url' => ['label' => 'image_url', 'placeholder' => 'image_url', 'helper_text' => 'image_url', 'description' => 'image_url'],
        'notification_type' => ['label' => 'notification_type', 'placeholder' => 'notification_type', 'helper_text' => 'notification_type', 'description' => 'notification_type'],
        'high_priority' => ['label' => 'high_priority', 'placeholder' => 'high_priority', 'helper_text' => 'high_priority', 'description' => 'high_priority'],
        'custom_data' => ['label' => 'custom_data', 'placeholder' => 'custom_data', 'helper_text' => 'custom_data', 'description' => 'custom_data']],
    'actions' => [
        'create' => ['label' => 'Crea Send Firebase Push Notification'],
        'edit' => ['label' => 'Modifica Send Firebase Push Notification'],
        'delete' => ['label' => 'Elimina Send Firebase Push Notification'],
        'sendPushNotification' => ['label' => 'sendPushNotification', 'icon' => 'sendPushNotification', 'tooltip' => 'sendPushNotification'],
        'save' => ['label' => 'save', 'icon' => 'save', 'tooltip' => 'save']]];
