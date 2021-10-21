<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Heise Shariff',
    'description' => 'Shariff implementation for TYPO3 CMS including the backend module, a viewhelper and a plugin.',
    'category' => 'plugin',
    'version' => '14.0.1',
    'state' => 'stable',
    'uploadfolder' => false,
    'author' => 'Markus Klein',
    'author_email' => 'support@reelworx.at',
    'author_company' => 'Reelworx GmbH',
    'constraints' => [
        'depends' => [
            'typo3' => '10.4.21-11.5.99',
        ],
        'conflicts' => [],
        'suggests' => []
    ],
];
