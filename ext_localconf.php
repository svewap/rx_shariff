<?php

$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['shariff'] = \Reelworx\RxShariff\Shariff::class . '::processRequest';

if (!isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['rx_shariff'])) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['rx_shariff'] = [
        'frontend' => \TYPO3\CMS\Core\Cache\Frontend\VariableFrontend::class,
        'backend' => \TYPO3\CMS\Core\Cache\Backend\SimpleFileBackend::class,
        'options' => [
            'defaultLifetime' => 3600,
        ],
        'groups' => ['pages', 'all'],
    ];
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'RxShariff',
    'Shariff',
    [\Reelworx\RxShariff\Controller\ShariffController::class => 'index']
);

if (!isset($GLOBALS['TYPO3_CONF_VARS']['LOG']['Reelworx']['RxShariff'])) {
    $GLOBALS['TYPO3_CONF_VARS']['LOG']['Reelworx']['RxShariff']['writerConfiguration'] = [
        \Psr\Log\LogLevel::WARNING => [
            \TYPO3\CMS\Core\Log\Writer\FileWriter::class => [
                'logFileInfix' => 'shariff',
            ],
        ],
    ];
}
