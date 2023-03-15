<?php

declare(strict_types=1);

/*
 *
 * This file is part of the rx_shariff Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * Copyright (c) Reelworx GmbH
 *
 */

namespace Reelworx\RxShariff;

use GuzzleHttp\HandlerStack;
use Heise\Shariff\Backend;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Http\Response;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Shariff Backend implementation
 *
 * @author Markus Klein
 */
class Shariff
{
    /**
     * Process request
     *
     * @param ServerRequestInterface $request
     * @return null|Response
     */
    public function processRequest(ServerRequestInterface $request): ?Response
    {
        $url = $request->getQueryParams()['url'] ?? (string)$_SERVER['HTTP_REFERER'];
        return GeneralUtility::makeInstance(JsonResponse::class, $this->render($url));
    }

    /**
     * Retrieve the stats from the services
     *
     * @param string $url URL for which stats should be queried
     * @return array Array of results
     */
    protected function render(string $url): array
    {
        $extensionConfiguration = $this->getExtensionConfiguration();

        $serviceArray = GeneralUtility::trimExplode(',', $extensionConfiguration['services']);
        // filter Twitter, which has been removed
        $serviceArray = array_filter($serviceArray, function ($value) {
            return strtolower($value) !== 'twitter';
        });

        $allowedDomains = [];
        if (!isset($extensionConfiguration['allowedDomains']) || $extensionConfiguration['allowedDomains'] === 'SERVER_NAME') {
            $defaultPort = GeneralUtility::getIndpEnv('TYPO3_SSL') ? '443' : '80';
            if (strtolower($_SERVER['HTTP_HOST']) === strtolower($_SERVER['SERVER_NAME']) && $defaultPort === $_SERVER['SERVER_PORT']) {
                $allowedDomains[] = strtolower($_SERVER['SERVER_NAME']);
            }
        } else {
            $allowedDomains = GeneralUtility::trimExplode(',', $extensionConfiguration['allowedDomains'], true);
        }

        $shariffConfiguration = [
            'services' => $serviceArray,
            'domains' => $allowedDomains,
            'cacheClass' => Cache::class,
            'cache' => [
                'ttl' => (int)$extensionConfiguration['ttl'],
            ],
        ];

        $httpOptions = $GLOBALS['TYPO3_CONF_VARS']['HTTP'];
        $httpOptions['verify'] = filter_var($httpOptions['verify'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? $httpOptions['verify'];

        if (isset($GLOBALS['TYPO3_CONF_VARS']['HTTP']['handler']) && is_array($GLOBALS['TYPO3_CONF_VARS']['HTTP']['handler'])) {
            $stack = HandlerStack::create();
            foreach ($GLOBALS['TYPO3_CONF_VARS']['HTTP']['handler'] ?? [] as $handler) {
                $stack->push($handler);
            }
            $httpOptions['handler'] = $stack;
        }
        $shariffConfiguration['client'] = $httpOptions;

        $facebookKey = array_search('Facebook', $shariffConfiguration['services'], true);
        if ($facebookKey !== false) {
            if (empty($extensionConfiguration['facebook_app_id']) || empty($extensionConfiguration['facebook_secret'])) {
                unset($shariffConfiguration['services'][$facebookKey]);
            } else {
                $shariffConfiguration['Facebook'] = [
                    'app_id' => $extensionConfiguration['facebook_app_id'],
                    'secret' => $extensionConfiguration['facebook_secret'],
                ];
            }
        }

        $shariff = new Backend($shariffConfiguration);
        $shariff->setLogger(GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__));
        return $shariff->get($url);
    }

    private function getExtensionConfiguration(): array
    {
        $extensionConfiguration = [
            'services' => 'Facebook, LinkedIn, Reddit, StumbleUpon, Flattr, Pinterest, Xing, AddThis, Vk',
            'facebook_app_id' => '',
            'facebook_secret' => '',
        ];

        $userExtensionConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('rx_shariff');
        if (is_array($userExtensionConfiguration)) {
            $extensionConfiguration = array_replace($extensionConfiguration, $userExtensionConfiguration);
        }
        return $extensionConfiguration;
    }
}
