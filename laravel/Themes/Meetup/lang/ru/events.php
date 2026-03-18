<?php

declare(strict_types=1);

return [
    'status' => [
        'all' => [
            'label' => 'Все события',
            'description' => 'Метка фильтра: все события',
        ],
        'upcoming' => [
            'label' => 'Предстоящие',
            'description' => 'Метка: будущие события',
        ],
        'past' => [
            'label' => 'Прошедшие события',
            'description' => 'Метка: прошедшие события',
        ],
    ],

    'fields' => [
        'about_this_event' => [
            'label' => 'Об этом событии',
            'description' => 'Заголовок секции описания события',
        ],
        'event_details' => [
            'label' => 'Детали события',
            'description' => 'Заголовок секции информации',
        ],
        'date' => [
            'label' => 'Дата',
            'description' => 'Метка даты события',
        ],
        'time' => [
            'label' => 'Время',
            'description' => 'Метка времени события',
        ],
        'location' => [
            'label' => 'Место',
            'description' => 'Метка места проведения',
        ],
        'language' => [
            'label' => 'Язык',
            'description' => 'Метка языка',
        ],
        'attendees' => [
            'label' => 'Участники',
            'description' => 'Метка участников',
        ],
        'people_joined' => [
            'label' => ':count человек присоединились',
            'description' => 'Сообщение: число участников',
        ],
        'available_spots' => [
            'label' => ':count мест доступно',
            'description' => 'Сообщение: доступные места',
        ],
        'spots_filled' => [
            'label' => 'мест занято',
            'description' => 'Метка занятых мест',
        ],
    ],

    'actions' => [
        'back_to_events' => [
            'label' => 'Назад к событиям',
            'tooltip' => 'Вернуться к списку событий',
            'helper_text' => '',
            'description' => 'Ссылка для возврата к списку',
            'icon' => 'heroicon-o-arrow-left',
            'color' => 'secondary',
        ],
        'register_now' => [
            'label' => 'Зарегистрироваться',
            'tooltip' => 'Забронировать место',
            'helper_text' => '',
            'description' => 'CTA регистрации',
            'icon' => 'heroicon-o-check-circle',
            'color' => 'primary',
        ],
        'join_event' => [
            'label' => 'Присоединиться к событию',
            'tooltip' => 'Записаться на участие',
            'helper_text' => '',
            'description' => 'CTA участия',
            'icon' => 'heroicon-o-user-plus',
            'color' => 'primary',
        ],
        'book_your_spot' => [
            'label' => 'Забронировать место!',
            'tooltip' => 'Зарезервировать место',
            'helper_text' => '',
            'description' => 'CTA срочности',
            'icon' => 'heroicon-o-ticket',
            'color' => 'primary',
        ],
        'share_event' => [
            'label' => 'Поделиться событием',
            'tooltip' => 'Поделиться с друзьями',
            'helper_text' => '',
            'description' => 'Метка кнопки поделиться',
            'icon' => 'heroicon-o-share',
            'color' => 'secondary',
        ],
    ],

    'messages' => [
        'no_events_found' => [
            'label' => 'События не найдены',
            'description' => 'Сообщение, когда событий нет',
        ],
        'check_back_later' => [
            'label' => 'Загляните позже',
            'description' => 'Предложение зайти позже',
        ],
        'event_fallback_title' => [
            'label' => 'Событие',
            'description' => 'Запасной заголовок, если отсутствует название',
        ],
        'spots_filling_fast' => [
            'label' => 'Места быстро заканчиваются!',
            'description' => 'Сообщение срочности',
        ],
        'event_location' => [
            'label' => 'Место проведения',
            'description' => 'Заголовок секции места',
        ],
        'map_loading' => [
            'label' => 'Загрузка карты...',
            'description' => 'Сообщение при загрузке карты',
        ],
        'click_to_view' => [
            'label' => 'Открыть в Google Maps',
            'description' => 'Инструкция открыть на карте',
        ],
    ],
];
