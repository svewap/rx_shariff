<?php
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

namespace Reelworx\RxShariff\ViewHelper;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContext;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Class ShariffViewHelper
 *
 * @author Markus Klein <markus.klein@reelworx.at>
 */
class ShariffViewHelper extends AbstractTagBasedViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerUniversalTagAttributes();
        $this->registerArgument('services', 'string', 'Comma separated list of services', false);
        $this->registerArgument('enableBackend', 'boolean', 'Enable the Shariff Backend module and show stats', false, false);
    }

    public function render()
    {
        if ($this->arguments['enableBackend']) {
            $controllerContext = null;
            if (isset($this->controllerContext)) {
                $controllerContext = $this->controllerContext;
            } elseif ($this->renderingContext instanceof RenderingContext) {
                $controllerContext = $this->renderingContext->getControllerContext();
            }
            if ($controllerContext) {
                $url = $controllerContext->getUriBuilder()->reset()->setArguments(['eID' => 'shariff'])->buildFrontendUri();
                $this->tag->addAttribute('data-backend-url', $url);
            }
        }

        $services = $this->arguments['services'];
        if ($services !== null) {
            $this->tag->addAttribute(
                'data-services',
                '["' . implode('","', GeneralUtility::trimExplode(',', $services)) . '"]'
            );
        }

        $sys_language_isocode = 0;
        if (class_exists(\TYPO3\CMS\Core\Site\Entity\SiteLanguage::class)) {
            /** @var \TYPO3\CMS\Core\Site\Entity\SiteLanguage $language */
            $language = $GLOBALS['TYPO3_REQUEST']->getAttribute('language');
            if ($language instanceof \TYPO3\CMS\Core\Site\Entity\SiteLanguage) {
                $sys_language_isocode = $language->getTwoLetterIsoCode();
            }
        }
        if (!$sys_language_isocode) {
            /** @var TypoScriptFrontendController $tsfe */
            $tsfe = $GLOBALS['TSFE'];
            $sys_language_isocode = $tsfe->sys_language_isocode;
        }

        if (!$this->tag->hasAttribute('data-lang') && !empty($sys_language_isocode)) {
            $this->tag->addAttribute('data-lang', $sys_language_isocode);
        }

        $this->tag->addAttribute('class', 'shariff');
        $this->tag->forceClosingTag(true);
        return $this->tag->render();
    }
}
