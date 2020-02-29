<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Heise Shariff',
    'description' => 'Shariff implementation for TYPO3 CMS including the backend module, a viewhelper and a plugin.',
    'category' => 'plugin',
    'version' => '13.0.3',
    'state' => 'stable',
    'uploadfolder' => false,
    'author' => 'Markus Klein',
    'author_email' => 'support@reelworx.at',
    'author_company' => 'Reelworx GmbH',
    'constraints' => [
        'depends' => [
            'php' => '7.1.0-7.4.99',
            'typo3' => '8.7.0-10.4.99',
        ],
        'conflicts' => [],
        'suggests' => []
    ],
];
