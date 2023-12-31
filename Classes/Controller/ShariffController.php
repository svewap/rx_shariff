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

namespace Reelworx\RxShariff\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Class ShariffController
 *
 * @author Frank Nägler <typo3@naegler.net>
 */
class ShariffController extends ActionController
{
    public const SERVICE_LIST = [
        'twitter',
        'facebook',
        'linkedin',
        'xing',
        'pinterest',
        'whatsapp',
        'mail',
        'addthis',
        'tumblr',
        'flattr',
        'diaspora',
        'reddit',
        'stumbleupon',
        'threema',
        'vk',
        'telegram',
        'qzone',
        'tencent-weibo',
        'weibo',
        'print',
        'info',
    ];

    /**
     * Render content element
     *
     * This action renders the content element in Frontend
     * based on the TypoScript settings and overwritten by
     * the settings from FlexForms.
     *
     * @return ResponseInterface
     */
    public function indexAction(): ResponseInterface
    {
        $data = $this->settings['data'];
        unset($data['services']);
        if (isset($data['lang']) && $data['lang'] === 'auto') {
            unset($data['lang']);
        }
        foreach ($data as $key => $value) {
            if (trim($value) === '') {
                unset($data[$key]);
            }
        }

        $this->view->assign('data', $data);
        $this->view->assign('enableBackend', $this->settings['enableBackend']);
        $this->view->assign('services', $this->settings['data']['services']);
        return $this->htmlResponse();
    }
}
