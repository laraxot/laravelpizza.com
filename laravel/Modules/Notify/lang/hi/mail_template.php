<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'group' => 
    array (
      'name' => 'सूचनाएं',
      'description' => 'ईमेल अधिसूचनाओं और उनके टेम्पलेट्स का प्रबंधन',
    ),
    'label' => 'ईमेल टेम्पलेट्स',
    'plural' => 'ईमेल टेम्पलेट्स',
    'singular' => 'ईमेल टेम्पलेट',
    'icon' => 'heroicon-o-envelope',
    'sort' => '1',
    'name' => 'ईमेल टेम्पलेट',
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'आईडी',
      'helper_text' => 'टेम्पलेट की विशिष्ट पहचान',
      'tooltip' => '',
      'description' => '',
    ),
    'mailable' => 
    array (
      'label' => 'मेलेबल क्लास',
      'placeholder' => 'मेलेबल क्लास का नाम दर्ज करें',
      'help' => 'ईमेल भेजने वाला PHP क्लास',
      'helper_text' => 'ईमेल भेजने का PHP क्लास',
      'description' => 'मेलेबल',
      'tooltip' => '',
    ),
    'subject' => 
    array (
      'label' => 'विषय',
      'placeholder' => 'ईमेल विषय दर्ज करें',
      'help' => 'ईमेल में दिखाई देने वाला विषय',
      'helper_text' => 'ईमेल विषय',
      'description' => 'विषय',
      'tooltip' => '',
    ),
    'html_template' => 
    array (
      'label' => 'HTML सामग्री',
      'placeholder' => 'ईमेल HTML सामग्री दर्ज करें',
      'help' => 'HTML प्रारूप में ईमेल सामग्री',
      'helper_text' => 'ईमेल टेम्पलेट की HTML सामग्री',
      'description' => 'HTML टेम्पलेट',
      'tooltip' => '',
    ),
    'text_template' => 
    array (
      'label' => 'पाठ सामग्री',
      'placeholder' => 'ईमेल पाठ सामग्री दर्ज करें',
      'help' => 'HTML का समर्थन नहीं करने वाले क्लाइंट्स के लिए पाठ संस्करण',
      'helper_text' => 'ईमेल टेम्पलेट का पाठ संस्करण',
      'description' => 'पाठ टेम्पलेट',
      'tooltip' => '',
    ),
    'version' => 
    array (
      'label' => 'संस्करण',
      'help' => 'टेम्पलेट संस्करण संख्या',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'बनाया गया',
      'helper_text' => 'टेम्पलेट बनाने की तारीख',
      'tooltip' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'अंतिम संशोधन',
      'helper_text' => 'टेम्पलेट अंतिम संशोधन की तारीख',
      'tooltip' => '',
      'description' => '',
    ),
    'from_email' => 
    array (
      'label' => 'प्रेषक ईमेल',
      'helper_text' => 'प्रेषक का ईमेल पता',
      'placeholder' => 'noreply@example.com',
      'tooltip' => '',
      'description' => '',
    ),
    'from_name' => 
    array (
      'label' => 'प्रेषक का नाम',
      'helper_text' => 'प्रदर्शित प्रेषक का नाम',
      'placeholder' => 'कंपनी का नाम',
      'tooltip' => '',
      'description' => '',
    ),
    'variables' => 
    array (
      'label' => 'उपलब्ध चर',
      'helper_text' => 'टेम्पलेट में उपयोग किए जा सकने वाले चरों की सूची',
      'placeholder' => 'उदा: {{name}}, {{email}}',
      'tooltip' => '',
      'description' => '',
    ),
    'is_markdown' => 
    array (
      'label' => 'मार्कडाउन उपयोग करें',
      'helper_text' => 'बताता है कि क्या टेम्पलेट मार्कडाउन वाक्य रचना का उपयोग करता है',
      'tooltip' => '',
      'description' => '',
    ),
    'status' => 
    array (
      'label' => 'स्थिति',
      'helper_text' => 'टेम्पलेट की वर्तमान स्थिति',
      'tooltip' => '',
      'description' => '',
    ),
    'toggleColumns' => 
    array (
      'label' => 'कॉलम टॉगल करें',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'reorderRecords' => 
    array (
      'label' => 'रिकॉर्ड पुनः क्रमित करें',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'resetFilters' => 
    array (
      'label' => 'फ़िल्टर रीसेट करें',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'applyFilters' => 
    array (
      'label' => 'फ़िल्टर लागू करें',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'openFilters' => 
    array (
      'label' => 'फ़िल्टर खोलें',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'layout' => 
    array (
      'label' => 'लेआउट',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'slug' => 
    array (
      'label' => 'स्लग',
      'description' => 'स्लग',
      'helper_text' => 'स्लग',
      'placeholder' => 'स्लग',
      'tooltip' => '',
    ),
    'name' => 
    array (
      'description' => 'टेम्पलेट का नाम',
      'helper_text' => 'टेम्पलेट को पहचानने के लिए वर्णनात्मक नाम',
      'placeholder' => 'उदा: स्वागत, आदेश पुष्टि, पासवर्ड रीसेट',
      'label' => 'टेम्पलेट का नाम',
      'tooltip' => '',
    ),
    'params' => 
    array (
      'label' => 'पैरामीटर्स',
      'helper_text' => 'टेम्पलेट में उपयोग किए जा सकने वाले पैरामीटर अल्पविराम से अलग करके दर्ज करें',
      'placeholder' => 'name, email, date, company',
      'description' => 'ईमेल टेम्पलेट के लिए उपलब्ध पैरामीटर्स',
      'tooltip' => '',
    ),
  ),
  'filters' => 
  array (
    'search_placeholder' => 'टेम्पलेट्स खोजें...',
    'version' => 
    array (
      'label' => 'संस्करण',
      'placeholder' => 'संस्करण चुनें',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'नया टेम्पलेट',
      'modal' => 
      array (
        'heading' => 'ईमेल टेम्पलेट बनाएं',
        'description' => 'नए ईमेल टेम्पलेट के लिए विवरण दर्ज करें',
        'submit' => 'बनाएं',
      ),
    ),
    'edit' => 
    array (
      'label' => 'संपादित करें',
      'modal' => 
      array (
        'heading' => 'ईमेल टेम्पलेट संपादित करें',
        'description' => 'ईमेल टेम्पलेट विवरण संशोधित करें',
        'submit' => 'सहेजें',
      ),
    ),
    'delete' => 
    array (
      'label' => 'हटाएं',
      'modal' => 
      array (
        'heading' => 'ईमेल टेम्पलेट हटाएं',
        'description' => 'क्या आप वाकई इस टेम्पलेट को हटाना चाहते हैं? यह क्रिया पूर्ववत नहीं की जा सकती।',
        'submit' => 'हटाएं',
      ),
    ),
    'restore' => 
    array (
      'label' => 'पुनर्स्थापित करें',
    ),
    'force_delete' => 
    array (
      'label' => 'स्थायी रूप से हटाएं',
      'modal' => 
      array (
        'heading' => 'ईमेल टेम्पलेट स्थायी रूप से हटाएं',
        'description' => 'क्या आप वाकई इस टेम्पलेट को स्थायी रूप से हटाना चाहते हैं? यह क्रिया पूर्ववत नहीं की जा सकती।',
        'submit' => 'स्थायी रूप से हटाएं',
      ),
    ),
    'new_version' => 
    array (
      'label' => 'नया संस्करण',
      'modal' => 
      array (
        'heading' => 'नया संस्करण बनाएं',
        'description' => 'ईमेल टेम्पलेट का नया संस्करण बनाएं',
        'submit' => 'संस्करण बनाएं',
      ),
    ),
    'preview' => 
    array (
      'label' => 'पूर्वावलोकन',
      'tooltip' => 'ईमेल पूर्वावलोकन देखें',
      'success_message' => 'पूर्वावलोकन सफलतापूर्वक बनाया गया',
      'error_message' => 'पूर्वावलोकन बनाने में त्रुटि',
    ),
    'test' => 
    array (
      'label' => 'परीक्षण भेजें',
      'tooltip' => 'परीक्षण ईमेल भेजें',
      'success_message' => 'परीक्षण ईमेल सफलतापूर्वक भेजा गया',
      'error_message' => 'परीक्षण ईमेल भेजने में त्रुटि',
    ),
    'duplicate' => 
    array (
      'label' => 'प्रतिलिपि बनाएं',
      'tooltip' => 'टेम्पलेट की प्रतिलिपि बनाएं',
      'success_message' => 'टेम्पलेट की प्रतिलिपि सफलतापूर्वक बनाई गई',
      'error_message' => 'टेम्पलेट की प्रतिलिपि बनाने में त्रुटि',
    ),
    'export' => 
    array (
      'label' => 'निर्यात करें',
      'tooltip' => 'JSON प्रारूप में टेम्पलेट निर्यात करें',
      'success_message' => 'टेम्पलेट सफलतापूर्वक निर्यात किया गया',
      'error_message' => 'टेम्पलेट निर्यात करने में त्रुटि',
    ),
    'import' => 
    array (
      'label' => 'आयात करें',
      'tooltip' => 'JSON फ़ाइल से टेम्पलेट आयात करें',
      'success_message' => 'टेम्पलेट सफलतापूर्वक आयात किया गया',
      'error_message' => 'टेम्पलेट आयात करने में त्रुटि',
    ),
  ),
  'messages' => 
  array (
    'created' => 'ईमेल टेम्पलेट सफलतापूर्वक बनाया गया।',
    'updated' => 'ईमेल टेम्पलेट सफलतापूर्वक अपडेट किया गया।',
    'deleted' => 'ईमेल टेम्पलेट सफलतापूर्वक हटाया गया।',
    'restored' => 'ईमेल टेम्पलेट सफलतापूर्वक पुनर्स्थापित किया गया।',
    'force_deleted' => 'ईमेल टेम्पलेट स्थायी रूप से हटाया गया।',
    'version_created' => 'नया टेम्पलेट संस्करण सफलतापूर्वक बनाया गया।',
    'success' => 'ऑपरेशन सफलतापूर्वक पूरा हुआ',
    'error' => 'ऑपरेशन के दौरान त्रुटि हुई',
    'confirmation' => 'क्या आप वाकई इस ऑपरेशन को जारी रखना चाहते हैं?',
    'template_created' => 'ईमेल टेम्पलेट सफलतापूर्वक बनाया गया है',
    'template_updated' => 'ईमेल टेम्पलेट सफलतापूर्वक अपडेट किया गया है',
    'template_deleted' => 'ईमेल टेम्पलेट सफलतापूर्वक हटाया गया है',
  ),
  'sections' => 
  array (
    'template' => 
    array (
      'label' => 'टेम्पलेट',
      'description' => 'टेम्पलेट की मुख्य जानकारी',
    ),
    'versions' => 
    array (
      'label' => 'संस्करण',
      'description' => 'टेम्पलेट संस्करण इतिहास',
    ),
    'logs' => 
    array (
      'label' => 'लॉग्स',
      'description' => 'टेम्पलेट भेजने का इतिहास',
    ),
    'main' => 'मुख्य जानकारी',
    'content' => 'सामग्री',
    'styling' => 'स्टाइलिंग',
    'settings' => 'सेटिंग्स',
    'variables' => 'चर',
  ),
  'status' => 
  array (
    'sent' => 'भेजा गया',
    'delivered' => 'पहुंचा दिया गया',
    'failed' => 'विफल',
    'opened' => 'खोला गया',
    'clicked' => 'क्लिक किया गया',
    'bounced' => 'वापस आया',
    'spam' => 'स्पैम के रूप में चिह्नित',
  ),
  'model' => 
  array (
    'label' => 'ईमेल टेम्पलेट',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
