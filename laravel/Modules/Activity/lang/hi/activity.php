<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'गतिविधि',
    'plural' => 'गतिविधियाँ',
    'group' => 
    array (
      'name' => 'निगरानी',
      'description' => 'सिस्टम गतिविधि निगरानी',
    ),
    'label' => 'गतिविधि',
    'sort' => '60',
    'icon' => 'heroicon-o-activity',
  ),
  'fields' => 
  array (
    'user' => 
    array (
      'label' => 'उपयोगकर्ता',
      'placeholder' => 'एक उपयोगकर्ता चुनें',
      'help' => 'वह उपयोगकर्ता जिसने कार्रवाई की',
      'name' => 
      array (
        'label' => 'नाम',
        'placeholder' => 'नाम दर्ज करें',
        'help' => 'उपयोगकर्ता का पूरा नाम',
        'validation' => 'required|string|max:255',
      ),
      'email' => 
      array (
        'label' => 'ईमेल',
        'placeholder' => 'ईमेल दर्ज करें',
        'help' => 'उपयोगकर्ता ईमेल पता',
        'validation' => 'required|email|max:255',
      ),
      'role' => 
      array (
        'label' => 'भूमिका',
        'placeholder' => 'एक भूमिका चुनें',
        'help' => 'सिस्टम में उपयोगकर्ता की भूमिका',
        'validation' => 'required|string',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'action' => 
    array (
      'label' => 'क्रिया',
      'placeholder' => 'एक क्रिया चुनें',
      'help' => 'की गई क्रिया का प्रकार',
      'validation' => 'required|string',
      'options' => 
      array (
        'created' => 
        array (
          'label' => 'बनाया गया',
          'icon' => 'heroicon-o-plus-circle',
          'color' => 'success',
        ),
        'updated' => 
        array (
          'label' => 'अपडेट किया गया',
          'icon' => 'heroicon-o-pencil',
          'color' => 'warning',
        ),
        'deleted' => 
        array (
          'label' => 'हटाया गया',
          'icon' => 'heroicon-o-trash',
          'color' => 'danger',
        ),
        'viewed' => 
        array (
          'label' => 'देखा गया',
          'icon' => 'heroicon-o-eye',
          'color' => 'info',
        ),
        'downloaded' => 
        array (
          'label' => 'डाउनलोड किया गया',
          'icon' => 'heroicon-o-arrow-down-tray',
          'color' => 'primary',
        ),
        'uploaded' => 
        array (
          'label' => 'अपलोड किया गया',
          'icon' => 'heroicon-o-arrow-up-tray',
          'color' => 'primary',
        ),
        'logged_in' => 
        array (
          'label' => 'लॉगिन किया गया',
          'icon' => 'heroicon-o-arrow-right-on-rectangle',
          'color' => 'success',
        ),
        'logged_out' => 
        array (
          'label' => 'लॉगआउट किया गया',
          'icon' => 'heroicon-o-arrow-left-on-rectangle',
          'color' => 'gray',
        ),
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'subject' => 
    array (
      'label' => 'विषय',
      'placeholder' => 'एक विषय चुनें',
      'help' => 'क्रिया द्वारा प्रभावित ऑब्जेक्ट',
      'type' => 
      array (
        'label' => 'प्रकार',
        'placeholder' => 'ऑब्जेक्ट प्रकार',
        'help' => 'ऑब्जेक्ट का वर्ग या प्रकार',
        'validation' => 'nullable|string|max:255',
      ),
      'id' => 
      array (
        'label' => 'आईडी',
        'placeholder' => 'ऑब्जेक्ट आईडी',
        'help' => 'ऑब्जेक्ट की विशिष्ट पहचानकर्ता',
        'validation' => 'nullable|integer|min:1',
      ),
      'name' => 
      array (
        'label' => 'नाम',
        'placeholder' => 'ऑब्जेक्ट का नाम',
        'help' => 'ऑब्जेक्ट का वर्णनात्मक नाम',
        'validation' => 'nullable|string|max:255',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'description' => 
    array (
      'label' => 'विवरण',
      'placeholder' => 'एक विवरण दर्ज करें',
      'help' => 'गतिविधि का विस्तृत विवरण',
      'validation' => 'nullable|string|max:1000',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'ip_address' => 
    array (
      'label' => 'IP पता',
      'placeholder' => 'उदा. 192.168.1.1',
      'help' => 'IP पता जहां से क्रिया की गई थी',
      'validation' => 'nullable|ip',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'user_agent' => 
    array (
      'label' => 'उपयोगकर्ता एजेंट',
      'placeholder' => 'ब्राउज़र और ऑपरेटिंग सिस्टम',
      'help' => 'उपयोगकर्ता के ब्राउज़र और सिस्टम के बारे में जानकारी',
      'validation' => 'nullable|string|max:500',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'तिथि',
      'placeholder' => 'तिथि और समय चुनें',
      'help' => 'तिथि और समय जब गतिविधि बनाई गई थी',
      'validation' => 'required|date',
      'format' => 'd/m/Y H:i:s',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'properties' => 
    array (
      'label' => 'गुण',
      'placeholder' => 'अतिरिक्त गुण',
      'help' => 'गतिविधि का अतिरिक्त डेटा',
      'old' => 
      array (
        'label' => 'पुराना मान',
        'placeholder' => 'पिछला मान',
        'help' => 'परिवर्तन से पहले का मान',
      ),
      'new' => 
      array (
        'label' => 'नया मान',
        'placeholder' => 'वर्तमान मान',
        'help' => 'परिवर्तन के बाद का मान',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'toggleColumns' => 
    array (
      'label' => 'कॉलम दिखाएं/छिपाएं',
      'help' => 'कॉलम दृश्यता कॉन्फ़िगर करें',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'reorderRecords' => 
    array (
      'label' => 'रिकॉर्ड पुन: क्रमित करें',
      'help' => 'तालिका में रिकॉर्ड पुन: क्रमित करें',
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
  ),
  'filters' => 
  array (
    'user' => 
    array (
      'label' => 'उपयोगकर्ता',
      'placeholder' => 'उपयोगकर्ता द्वारा फ़िल्टर करें',
      'help' => 'उपयोगकर्ता द्वारा गतिविधियाँ फ़िल्टर करें',
      'type' => 'select',
      'searchable' => '1',
    ),
    'action' => 
    array (
      'label' => 'क्रिया',
      'placeholder' => 'क्रिया द्वारा फ़िल्टर करें',
      'help' => 'क्रिया प्रकार द्वारा गतिविधियाँ फ़िल्टर करें',
      'type' => 'select',
      'multiple' => '1',
    ),
    'subject_type' => 
    array (
      'label' => 'विषय प्रकार',
      'placeholder' => 'विषय प्रकार द्वारा फ़िल्टर करें',
      'help' => 'विषय प्रकार द्वारा गतिविधियाँ फ़िल्टर करें',
      'type' => 'select',
      'searchable' => '1',
    ),
    'date_range' => 
    array (
      'label' => 'तिथि सीमा',
      'placeholder' => 'सीमा चुनें',
      'help' => 'तिथि सीमा द्वारा गतिविधियाँ फ़िल्टर करें',
      'type' => 'date_range',
      'presets' => 
      array (
        'today' => 'आज',
        'yesterday' => 'कल',
        'last_7_days' => 'पिछले 7 दिन',
        'last_30_days' => 'पिछले 30 दिन',
        'this_month' => 'इस महीने',
        'last_month' => 'पिछले महीने',
      ),
    ),
    'ip_address' => 
    array (
      'label' => 'IP पता',
      'placeholder' => 'IP द्वारा फ़िल्टर करें',
      'help' => 'IP पता द्वारा गतिविधियाँ फ़िल्टर करें',
      'type' => 'text',
    ),
  ),
  'actions' => 
  array (
    'view_details' => 
    array (
      'label' => 'विवरण देखें',
      'icon' => 'heroicon-o-eye',
      'color' => 'primary',
      'success' => 'विवरण सफलतापूर्वक लोड किए गए',
      'error' => 'विवरण लोड करने में त्रुटि',
      'confirmation' => 'क्या आप इस गतिविधि का विवरण देखना चाहते हैं?',
    ),
    'export' => 
    array (
      'label' => 'निर्यात करें',
      'icon' => 'heroicon-o-arrow-down-tray',
      'color' => 'success',
      'success' => 'निर्यात सफलतापूर्वक पूरा हुआ',
      'error' => 'निर्यात के दौरान त्रुटि',
      'confirmation' => 'क्या आप चयनित गतिविधियों का निर्यात करना चाहते हैं?',
    ),
    'clear_old' => 
    array (
      'label' => 'पुरानी साफ करें',
      'icon' => 'heroicon-o-trash',
      'color' => 'danger',
      'success' => 'पुरानी गतिविधियाँ सफलतापूर्वक हटाई गईं',
      'error' => 'गतिविधियाँ साफ करने में त्रुटि',
      'confirmation' => 'क्या आप वाकई पुरानी गतिविधियों को हटाना चाहते हैं? यह क्रिया पूर्ववत नहीं की जा सकती।',
      'days_threshold' => '90',
    ),
    'bulk_delete' => 
    array (
      'label' => 'चयनित हटाएं',
      'icon' => 'heroicon-o-trash',
      'color' => 'danger',
      'success' => 'चयनित गतिविधियाँ सफलतापूर्वक हटाई गईं',
      'error' => 'गतिविधियाँ हटाने में त्रुटि',
      'confirmation' => 'क्या आप वाकई चयनित गतिविधियों को हटाना चाहते हैं?',
    ),
  ),
  'messages' => 
  array (
    'no_activities' => 'चयनित फ़िल्टर के लिए कोई गतिविधियाँ नहीं मिलीं',
    'cleared' => 'पुरानी गतिविधियाँ सफलतापूर्वक हटाई गईं',
    'exported' => 'गतिविधियाँ सफलतापूर्वक निर्यात की गईं',
    'loading' => 'गतिविधियाँ लोड हो रही हैं...',
    'error_loading' => 'गतिविधियाँ लोड करने में त्रुटि',
    'empty_state' => 
    array (
      'title' => 'कोई गतिविधि दर्ज नहीं की गई',
      'description' => 'अभी तक दिखाने के लिए कोई गतिविधियाँ नहीं हैं। जब उपयोगकर्ता सिस्टम के साथ इंटरैक्ट करना शुरू करेंगे, तो गतिविधियाँ यहां दिखाई देंगी।',
    ),
  ),
  'export' => 
  array (
    'formats' => 
    array (
      'csv' => 
      array (
        'label' => 'CSV',
        'mime_type' => 'text/csv',
        'extension' => 'csv',
        'icon' => 'heroicon-o-document-text',
      ),
      'excel' => 
      array (
        'label' => 'Excel',
        'mime_type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'extension' => 'xlsx',
        'icon' => 'heroicon-o-table-cells',
      ),
      'pdf' => 
      array (
        'label' => 'PDF',
        'mime_type' => 'application/pdf',
        'extension' => 'pdf',
        'icon' => 'heroicon-o-document',
      ),
    ),
    'columns' => 
    array (
      'date' => 
      array (
        'label' => 'तिथि',
        'format' => 'd/m/Y H:i:s',
        'sortable' => '1',
      ),
      'user' => 
      array (
        'label' => 'उपयोगकर्ता',
        'sortable' => '1',
      ),
      'action' => 
      array (
        'label' => 'क्रिया',
        'sortable' => '1',
      ),
      'subject' => 
      array (
        'label' => 'विषय',
        'sortable' => '',
      ),
      'ip' => 
      array (
        'label' => 'IP',
        'sortable' => '1',
      ),
      'description' => 
      array (
        'label' => 'विवरण',
        'sortable' => '',
      ),
    ),
    'filename_pattern' => 'गतिविधि_{date}_{time}',
    'max_records' => '10000',
  ),
  'permissions' => 
  array (
    'view' => 'activities.view',
    'create' => 'activities.create',
    'update' => 'activities.update',
    'delete' => 'activities.delete',
    'export' => 'activities.export',
    'clear_old' => 'activities.clear_old',
  ),
  'pagination' => 
  array (
    'per_page' => '25',
    'options' => 
    array (
      0 => '10',
      1 => '25',
      2 => '50',
      3 => '100',
    ),
  ),
  'cache' => 
  array (
    'ttl' => '300',
    'tags' => 
    array (
      0 => 'activities',
      1 => 'monitoring',
    ),
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
