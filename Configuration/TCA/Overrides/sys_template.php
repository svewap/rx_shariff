<?php

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'rx_shariff',
    'Configuration/TypoScript/PluginOnly',
    'Shariff: Plugin settings only'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'rx_shariff',
    'Configuration/TypoScript/WithoutJQuery',
    'Shariff: Plugin settings, FE styles only'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'rx_shariff',
    'Configuration/TypoScript/WithJQuery',
    'Shariff: Plugin settings, FE styles and jQuery'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'rx_shariff',
    'Configuration/TypoScript/WithJQueryAndFontawesome',
    'Shariff: Plugin settings, FE styles incl. Font-Awesome and jQuery'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'rx_shariff',
    'Configuration/TypoScript/WithoutJQueryAndFontawesome',
    'Shariff: Plugin settings, FE styles incl. Font-Awesome but no jQuery'
);
