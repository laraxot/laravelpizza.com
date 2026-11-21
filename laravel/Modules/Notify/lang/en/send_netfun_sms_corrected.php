<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Invio SMS Netfun',
        'plural' => 'Invio SMS Netfun'],
    'navigation' => [
        'name' => 'Invio SMS (Netfun)',
        'plural' => 'Invio SMS (Netfun)',
        'group' => [
            'name' => 'Notifications',
            'description' => 'Manage sending SMS notifications via Netfun'],
        'label' => 'Invio SMS (Netfun)',
        'icon' => 'heroicon-o-chat-bubble-left-right',
        'sort' => '15'],
    'fields' => [
        'to' => [
            'label' => 'Recipient',
            'placeholder' => 'Enter the phone number',
            'helper_text' => 'Recipient phone number',
            'tooltip' => '',
            'description' => ''],
        'message' => [
            'label' => 'Message',
            'placeholder' => 'Write the message text',
            'helper_text' => 'SMS message content',
            'tooltip' => '',
            'description' => '']],
    'actions' => [
        'send' => [
            'label' => 'Send',
            'tooltip' => 'Send an SMS message via Netfun',
            'success_message' => 'SMS message sent successfully',
            'error_message' => 'Error sending the SMS message']],
    'messages' => [
        'success' => 'SMS message sent successfully via Netfun',
        'error' => 'An error occurred while sending the SMS message',
        'confirmation' => 'Are you sure you want to send this SMS message?'],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label'];
