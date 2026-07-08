<?php

declare(strict_types=1);

return [

        'default' => 'test',

        'test' => [
            'kid' => 'vrfKQdxk39qIif0LRJIZcD2g4pl1cXDaJ2TA4goHv8U',
            'issuer' => '6993a2cb-7cbe-45f0-bb26-1373b891f845',
            'clientId' => '6993a2cb-7cbe-45f0-bb26-1373b891f845',
            'privKeyPath' => storage_path('pdnd/C030/client-test-ricerca_domicilio.rsa.priv'),
            'authUrl' => 'https://auth.interop.pagopa.it/token.oauth2',
            'audience' => 'auth.interop.pagopa.it/client-assertion',
            'apiBaseUrlTest' => 'https://modipa-val.anpr.interno.it/govway/rest/in/MinInternoPortaANPR-PDND/',
        ],

        'prod' => [
            'kid' => 'vrfKQdxk39qIif0LRJIZcD2g4pl1cXDaJ2TA4goHv8U',
            'issuer' => '91301dcd-bb35-4ea1-bf5a-cbb259822851',
            'clientId' => '91301dcd-bb35-4ea1-bf5a-cbb259822851',
            'privKeyPath' => storage_path('pdnd/C030/client-test-ricerca_domicilio.rsa.priv'),
            'authUrl' => 'https://auth.interop.pagopa.it/token.oauth2',
            'audience' => 'auth.interop.pagopa.it/client-assertion',
            'apiBaseUrlTest' => 'https://modipa.anpr.interno.it/govway/rest/in/MinInternoPortaANPR-PDND/',
        ],

];
