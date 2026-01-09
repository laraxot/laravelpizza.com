<?php

declare(strict_types=1);

return [
    'actions' => [
        'attach_user' => 'उपयोगकर्ता जोड़ें',
        'associate_user' => 'उपयोगकर्ता संबद्ध करें',
        'user_actions' => 'उपयोगकर्ता क्रियाएं',
        'view' => 'देखें',
        'edit' => 'संपादित करें',
        'detach' => 'अलग करें',
        'row_actions' => 'क्रियाएं',
        'delete_selected' => 'चयनित हटाएं',
        'confirm_detach' => 'क्या आप वाकई इस उपयोगकर्ता को अलग करना चाहते हैं?',
        'confirm_delete' => 'क्या आप वाकई चयनित उपयोगकर्ताओं को हटाना चाहते हैं?',
        'success_attached' => 'उपयोगकर्ता सफलतापूर्वक जोड़ा गया',
        'success_detached' => 'उपयोगकर्ता सफलतापूर्वक अलग किया गया',
        'success_deleted' => 'उपयोगकर्ता सफलतापूर्वक हटाए गए',
        'toggle_layout' => 'लेआउट टॉगल करें',
        'create' => 'उपयोगकर्ता बनाएं',
        'delete' => 'उपयोगकर्ता हटाएं',
        'associate' => 'उपयोगकर्ता संबद्ध करें',
        'bulk_delete' => 'चयनित हटाएं',
        'bulk_detach' => 'चयनित अलग करें',
        'impersonate' => 'उपयोगकर्ता की नकल करें',
        'stop_impersonating' => 'नकल बंद करें',
        'block' => 'ब्लॉक करें',
        'unblock' => 'अनब्लॉक करें',
        'send_reset_link' => 'रीसेट लिंक भेजें',
        'verify_email' => 'ईमेल सत्यापित करें',
    ],
    'fields' => [
        'name' => [
            'label' => 'नाम',
            'placeholder' => 'नाम दर्ज करें',
            'description' => 'नाम',
            'helper_text' => '',
        ],
        'email' => [
            'label' => 'ईमेल',
            'placeholder' => 'ईमेल दर्ज करें',
            'description' => 'ईमेल',
            'helper_text' => '',
        ],
        'created_at' => [
            'label' => 'निर्माण तिथि',
        ],
        'updated_at' => [
            'label' => 'अंतिम संशोधन',
        ],
        'role' => [
            'label' => 'भूमिका',
        ],
        'active' => 'सक्रिय',
        'id' => [
            'label' => 'आईडी',
        ],
        'password' => [
            'label' => 'पासवर्ड',
            'placeholder' => 'पासवर्ड दर्ज करें',
            'description' => 'पासवर्ड',
            'helper_text' => '',
        ],
        'password_confirmation' => [
            'label' => 'पासवर्ड की पुष्टि करें',
            'placeholder' => 'पासवर्ड की पुष्टि करें',
        ],
        'email_verified_at' => [
            'label' => 'ईमेल सत्यापित तिथि',
        ],
        'current_password' => [
            'label' => 'वर्तमान पासवर्ड',
            'placeholder' => 'वर्तमान पासवर्ड दर्ज करें',
        ],
        'roles' => [
            'label' => 'भूमिकाएं',
        ],
        'permissions' => [
            'label' => 'अनुमतियां',
        ],
        'status' => [
            'label' => 'स्थिति',
            'options' => [
                'active' => 'सक्रिय',
                'inactive' => 'निष्क्रिय',
                'blocked' => 'ब्लॉक किया गया',
            ],
        ],
        'last_login' => [
            'label' => 'अंतिम लॉगिन',
        ],
        'avatar' => [
            'label' => 'अवतार',
        ],
        'language' => [
            'label' => 'भाषा',
        ],
        'timezone' => [
            'label' => 'समय क्षेत्र',
        ],
        'password_expires_at' => [
            'label' => 'पासवर्ड समाप्ति',
        ],
        'verified' => [
            'label' => 'सत्यापित',
        ],
        'unverified' => [
            'label' => 'असत्यापित',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'isActive' => [
            'label' => 'isActive',
        ],
        'deactivate' => [
            'label' => 'deactivate',
        ],
        'delete' => [
            'label' => 'delete',
        ],
        'edit' => [
            'label' => 'edit',
        ],
        'view' => [
            'label' => 'view',
        ],
        'create' => [
            'label' => 'create',
        ],
        'detach' => [
            'label' => 'detach',
        ],
        'attach' => [
            'label' => 'attach',
        ],
        'changePassword' => [
            'label' => 'changePassword',
        ],
    ],
    'filters' => [
        'active_users' => 'सक्रिय उपयोगकर्ता',
        'creation_date' => 'निर्माण तिथि',
        'date_from' => 'से',
        'date_to' => 'तक',
        'verified' => 'सत्यापित उपयोगकर्ता',
        'unverified' => 'असत्यापित उपयोगकर्ता',
    ],
    'messages' => [
        'no_records' => 'कोई उपयोगकर्ता नहीं मिला',
        'loading' => 'उपयोगकर्ता लोड हो रहे हैं...',
        'search' => 'उपयोगकर्ता खोजें...',
        'credentials_incorrect' => 'प्रदान किए गए क्रेडेंशियल गलत हैं।',
        'created' => 'उपयोगकर्ता सफलतापूर्वक बनाया गया',
        'updated' => 'उपयोगकर्ता सफलतापूर्वक अपडेट किया गया',
        'deleted' => 'उपयोगकर्ता सफलतापूर्वक हटाया गया',
        'blocked' => 'उपयोगकर्ता सफलतापूर्वक ब्लॉक किया गया',
        'unblocked' => 'उपयोगकर्ता सफलतापूर्वक अनब्लॉक किया गया',
        'reset_link_sent' => 'रीसेट लिंक भेजा गया',
        'email_verified' => 'ईमेल सफलतापूर्वक सत्यापित किया गया',
        'impersonating' => 'आप उपयोगकर्ता :name की नकल कर रहे हैं',
        'login_success' => 'लॉगिन सफल',
        'validation_error' => 'सत्यापन त्रुटि',
        'login_error' => 'लॉगिन के दौरान एक त्रुटि हुई। कृपया बाद में पुनः प्रयास करें।',
    ],
    'modals' => [
        'create' => [
            'heading' => 'उपयोगकर्ता बनाएं',
            'description' => 'नया उपयोगकर्ता रिकॉर्ड बनाएं',
            'actions' => [
                'submit' => 'बनाएं',
                'cancel' => 'रद्द करें',
            ],
        ],
        'edit' => [
            'heading' => 'उपयोगकर्ता संपादित करें',
            'description' => 'उपयोगकर्ता जानकारी संशोधित करें',
            'actions' => [
                'submit' => 'परिवर्तन सहेजें',
                'cancel' => 'रद्द करें',
            ],
        ],
        'delete' => [
            'heading' => 'उपयोगकर्ता हटाएं',
            'description' => 'क्या आप वाकई इस उपयोगकर्ता को हटाना चाहते हैं?',
            'actions' => [
                'submit' => 'हटाएं',
                'cancel' => 'रद्द करें',
            ],
        ],
        'associate' => [
            'heading' => 'उपयोगकर्ता संबद्ध करें',
            'description' => 'संबद्ध करने के लिए उपयोगकर्ता चुनें',
            'actions' => [
                'submit' => 'संबद्ध करें',
                'cancel' => 'रद्द करें',
            ],
        ],
        'detach' => [
            'heading' => 'उपयोगकर्ता अलग करें',
            'description' => 'क्या आप वाकई इस उपयोगकर्ता को अलग करना चाहते हैं?',
            'actions' => [
                'submit' => 'अलग करें',
                'cancel' => 'रद्द करें',
            ],
        ],
        'bulk_delete' => [
            'heading' => 'चयनित उपयोगकर्ता हटाएं',
            'description' => 'क्या आप वाकई चयनित उपयोगकर्ताओं को हटाना चाहते हैं?',
            'actions' => [
                'submit' => 'चयनित हटाएं',
                'cancel' => 'रद्द करें',
            ],
        ],
        'bulk_detach' => [
            'heading' => 'चयनित उपयोगकर्ता अलग करें',
            'description' => 'क्या आप वाकई चयनित उपयोगकर्ताओं को अलग करना चाहते हैं?',
            'actions' => [
                'submit' => 'चयनित अलग करें',
                'cancel' => 'रद्द करें',
            ],
        ],
    ],
    'navigation' => [
        'name' => 'उपयोगकर्ता',
        'plural' => 'उपयोगकर्ता',
        'group' => [
            'name' => 'उपयोगकर्ता प्रबंधन',
            'description' => 'उपयोगकर्ताओं और उनकी अनुमतियों का प्रबंधन',
        ],
        'label' => 'उपयोगकर्ता',
        'sort' => '26',
        'icon' => 'user-main',
    ],
    'validation' => [
        'email_unique' => 'यह ईमेल पहले से उपयोग में है',
        'password_min' => 'पासवर्ड कम से कम :min वर्णों का होना चाहिए',
        'password_confirmed' => 'पासवर्ड मेल नहीं खाते',
        'current_password' => 'वर्तमान पासवर्ड गलत है',
    ],
    'permissions' => [
        'view_users' => 'उपयोगकर्ता देखें',
        'create_users' => 'उपयोगकर्ता बनाएं',
        'edit_users' => 'उपयोगकर्ता संपादित करें',
        'delete_users' => 'उपयोगकर्ता हटाएं',
        'impersonate_users' => 'उपयोगकर्ता की नकल करें',
        'manage_roles' => 'भूमिकाएं प्रबंधित करें',
    ],
    'model' => [
        'label' => 'उपयोगकर्ता',
    ],
];
