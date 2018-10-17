<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Heise Shariff',
    'description' => 'Shariff implementation for TYPO3 CMS including the backend module, a viewhelper and a plugin.',
    'category' => 'plugin',
    'version' => '11.0.2',
    'state' => 'stable',
    'uploadfolder' => false,
    'author' => 'Markus Klein',
    'author_email' => 'support@reelworx.at',
    'author_company' => 'Reelworx GmbH',
    'constraints' => [
        'depends' => [
            'php' => '7.0.0-7.2.99',
            'typo3' => '7.6.0-9.5.99',
        ],
        'conflicts' => [],
        'suggests' => []
    ],
];
