<?php

declare(strict_types=1);

return array (
  'login' => 
  array (
    'username_or_email' => 'שם משתמש או כתובת דואר אלקטרוני',
    'forgot_password_link' => 'שכחת סיסמה?',
    'create_an_account' => 'צור חשבון',
  ),
  'password_confirm' => 
  array (
    'heading' => 'אימות סיסמה',
    'description' => 'אנא אמת את הסיסמה שלך כדי להשלים פעולה זו.',
    'current_password' => 'סיסמה נוכחית',
  ),
  'two_factor' => 
  array (
    'heading' => 'אימות דו שלבי',
    'description' => 'אנא אמת גישה לחשבונך על ידי הזנת הקוד שאושר על ידי אפליקציית האימות שלך.',
    'code_placeholder' => 'XXX-XXX',
    'recovery' => 
    array (
      'heading' => 'אימות דו שלבי',
      'description' => 'אנא אמת גישה לחשבונך על ידי הזנת אחת מקודי ההחלפה לחירום שלך.',
    ),
    'recovery_code_placeholder' => 'abcdef-98765',
    'recovery_code_text' => 'אבדת מכשיר?',
    'recovery_code_link' => 'השתמש בקוד ההחלפה',
    'back_to_login_link' => 'חזרה להתחברות',
  ),
  'registration' => 
  array (
    'title' => 'הרשמה',
    'heading' => 'צור חשבון חדש',
    'submit' => 
    array (
      'label' => 'הירשם',
    ),
    'notification_unique' => 'כבר קיים חשבון עם כתובת הדואר האלקטרוני הזו. אנא התחבר.',
  ),
  'reset_password' => 
  array (
    'title' => 'שכחתי סיסמה',
    'heading' => 'איפוס סיסמה',
    'submit' => 
    array (
      'label' => 'שלח',
    ),
    'notification_error' => 'שגיאה באיפוס הסיסמה. אנא בקש שחזור סיסמה חדשה.',
    'notification_error_link_text' => 'נסה שוב',
    'notification_success' => ' להוראות בדוק את תיבת הדואר הנכנס שלך!',
  ),
  'verification' => 
  array (
    'title' => 'אימות דואר אלקטרוני',
    'heading' => 'נדרש אימות דואר אלקטרוני',
    'submit' => 
    array (
      'label' => 'התנתקות',
    ),
    'notification_success' => 'להוראות בדוק את תיבת הדואר הנכנס שלך!',
    'notification_resend' => ' הודעת אימות נשלחה מחדש לדואר האלקטרוני שלך.',
    'before_proceeding' => 'לפני שנמשיך, אנא בדוק את תיבת הדואר האלקטרוני שלך לקבלת קישור לאימות.',
    'not_receive' => 'אם לא קיבלת את האימייל,',
    'request_another' => 'לחץ כאן לבקשת אימות נוסף',
  ),
  'profile' => 
  array (
    'account' => 'חשבון',
    'profile' => 'פרופיל',
    'my_profile' => 'הפרופיל שלי',
    'personal_info' => 
    array (
      'heading' => 'מידע אישי',
      'subheading' => 'ניהול מידע האישי שלך.',
      'submit' => 
      array (
        'label' => 'עדכון',
      ),
      'notify' => 'פרופיל עודכן בהצלחה!',
    ),
    'password' => 
    array (
      'heading' => 'סיסמה',
      'subheading' => 'יש להכיל לפחות 8 תווים.',
      'submit' => 
      array (
        'label' => 'עדכון',
      ),
      'notify' => 'הסיסמה עודכנה בהצלחה!',
    ),
    '2fa' => 
    array (
      'title' => 'אימות דו-שלבי',
      'description' => 'ניהול אימות דו-שלבי עבור החשבון שלך (מומלץ).',
      'actions' => 
      array (
        'enable' => 'הפעלה',
        'regenerate_codes' => 'יצירת קודים חדשים',
        'disable' => 'השבתה',
        'confirm_finish' => 'אישור וסיום',
        'cancel_setup' => 'ביטול הגדרות',
      ),
      'setup_key' => 'מפתח התקנה',
      'not_enabled' => 
      array (
        'title' => 'לא הפעלת אימות דו-שלבי.',
        'description' => 'כאשר אימות דו-שלבי מופעל, תתבקש להכניס קוד מאובטח ואקראי במהלך האימות. תוכל לקבל קוד זה מאפליקציית האימות הדו-שלבית של Google בטלפון הנייד שלך.',
      ),
      'finish_enabling' => 
      array (
        'title' => 'סיום הפעלת אימות דו-שלבי.',
        'description' => 'לסיום הפעלת אימות דו-שלבי, סרוק את קוד ה-QR הבא באמצעות אפליקצית האימות הדו-שלבית של הטלפון הנייד שלך או הכנס את מפתח ההגדרה וספק את קוד ה-OTP שהתקבל.',
      ),
      'enabled' => 
      array (
        'title' => 'הפעלת אימות דו-שלבי בוצעה בהצלחה!',
        'description' => 'אימות דו-שלבי מופעל כעת. זה עוזר להגביר את ביטחון החשבון שלך.',
        'store_codes' => 'שמור על קודי השחזור האלו במנהל ססמאות מאובטח. ניתן להשתמש בהם לשחזור גישה לחשבון במקרה שנתקלת באובדן ההתקנה של אימות הדו-שלבי.',
        'show_codes' => 'הצג קודי שחזור',
        'hide_codes' => 'הסתר קודי שחזור',
      ),
      'confirmation' => 
      array (
        'success_notification' => 'הקוד אומת. אימות דו-שלבי מופעל.',
        'invalid_code' => 'הקוד שהוכנס אינו תקין.',
      ),
    ),
    'sanctum' => 
    array (
      'title' => 'טוקנים לממשק API',
      'description' => 'ניהול של טוקנים לממשק API שמאפשרים לשירותים צד שלישי לגשת ליישום הזה בשם שלך. הערה: הטוקן מוצג רק בפעם הראשונה ביצירתו. אם אתה מאבד את הטוקן, תצטרך למחוק אותו וליצור חדש.',
      'create' => 
      array (
        'notify' => 'טוקן נוצר בהצלחה!',
        'submit' => 
        array (
          'label' => 'יצירה',
        ),
      ),
      'update' => 
      array (
        'notify' => 'טוקן עודכן בהצלחה!',
      ),
    ),
  ),
  'clipboard' => 
  array (
    'link' => 'העתק',
    'tooltip' => 'הועתק!',
  ),
  'fields' => 
  array (
    'email' => 
    array (
      'label' => 'אימייל',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'login' => 
    array (
      'label' => 'כניסה',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'name' => 
    array (
      'label' => 'שם',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password' => 
    array (
      'label' => 'סיסמה',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password_confirm' => 
    array (
      'label' => 'אישור סיסמה',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password' => 
    array (
      'label' => 'סיסמה חדשה',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password_confirmation' => 
    array (
      'label' => 'אישור סיסמה חדשה',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'token_name' => 
    array (
      'label' => 'שם טוקן',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'abilities' => 
    array (
      'label' => 'יכולות',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    '2fa_code' => 
    array (
      'label' => 'קוד 2FA',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    '2fa_recovery_code' => 
    array (
      'label' => 'קוד שחזור 2FA',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created' => 
    array (
      'label' => 'נוצר',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'expires' => 
    array (
      'label' => 'פג תוקף',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'or' => 'או',
  'cancel' => 'ביטול',
  'navigation' => 
  array (
    'label' => 'Missing Navigation Label',
    'plural_label' => 'Missing Navigation Plural Label',
    'group' => 'Missing Group',
    'icon' => 'heroicon-o-puzzle-piece',
    'sort' => 100,
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
  'actions' => 
  array (
  ),
);
