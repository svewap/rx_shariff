.. include:: ../Includes.txt


Installation
============

Install the extension via the Extension Manager as usual.


Configuration
-------------

Some settings of the extension have to be configured centrally in the Extension Manager.
Those are most of the options for the backend module as documented here: https://github.com/heiseonline/shariff-backend-php

.. note::

   Technical note: The backend module is implemented as eID script. Therefore it is not possible to define these settings in
   your TypoScript template, as fetching this configuration would mostly kill the benefits of eID scripts.
   Multi-Domain sites, which require different settings per domain are therefore not supported currently.


JavaScript and CSS integration
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

The extension ships the Frontend Javascript and default styles of Shariff.
You have to add one of the five available static templates:

* Shariff: Plugin settings only
* Shariff: Plugin settings, FE styles only
* Shariff: Plugin settings, FE styles and jQuery
* Shariff: Plugin settings, FE styles incl. Font-Awesome and jQuery
* Shariff: Plugin settings, FE styles incl. Font-Awesome but no jQuery

The templates including jQuery are including the jQuery version shipped TYPO3 CMS Core.

.. hint::

   Include the first template if you want to integrate the Javascript and CSS in your asset workflow (e.g. gulp or grunt) directly.


Frontend usage
--------------

The extension provides multiple ways to use Shariff in Frontend.


Content Element plugin
^^^^^^^^^^^^^^^^^^^^^^

This is the easiest way to use Shariff.

Simply add a new content element to a page and select the "Shariff Social Icons" plugin.
All configuration options can be adjusted as needed.

This is especially useful for editors, which should be able to put the Shariff buttons on arbitrary places on the site.


Fluid view helper
^^^^^^^^^^^^^^^^^

For developers a convenient view helper is available to integrate Shariff into your extension's HTML template.

.. code-block:: html

   <html xmlns:rx="http://typo3.org/ns/Reelworx/RxShariff/ViewHelper">
     <rx:shariff data="{url: 'http://example.com/'}" services="whatsapp,facebook,xing" enableBackend="true" />
   </html>


**Optionally you can define all data attributes available for Shariff.**

For your comfort the language for Shariff is automatically determined from your curernt page language.

More example usages can be found here: http://heiseonline.github.io/shariff/

.. hint::

   Did you know that the tx_news extension automatically uses Shariff if present in the system? Nice, isn't it?


Pure TypoScript
^^^^^^^^^^^^^^^

The plugin can also be rendered via TypoScript the usual way. All settings are available in TypoScript as well.

.. code-block:: typoscript

   page.20 < tt_content.list.20.rxshariff_shariff

The various settings are listed below.

If you need maximum flexibility in your integration, there is also a way to retrieve the backend module (eID script) URL via TypoScript.
Simply copy the content of :ts:`plugin.rx_shariff.data-backend-url`:

.. code-block:: typoscript

   lib.shariffBackendUrl < plugin.rx_shariff.data-backend-url


Nice to know
------------

Finding the logs
^^^^^^^^^^^^^^^^

The extension uses the TYPO3 logging facility to log warnings when fetching counts from the various social media platforms.
If you encounter problems, take a look into the logs usually located in the ``typo3temp`` folder.


Predefining plugin options
^^^^^^^^^^^^^^^^^^^^^^^^^^

It may be your requirement to have some of the options the plugin is providing predefined and hidden from the user.
This is easily doable by changing the default value for those options with TypoScript.

The default settings provided by the extension are:

.. code-block:: typoscript

   tt_content.list.20.rxshariff_shariff {
      settings {
         enableBackend = 1
         data {
            lang = en
            mail-body =
            mail-subject =
            mail-url = mailto:
            media-url = null
            orientation = horizontal
            referrer-track = null
            services =
            theme = standard
            twitter-via = null
         }
      }
   }


Override those settings for your needs and hide the fields in the plugin configuration accordingly.
Use default ``TCEFORM`` page TSconfig settings to achieve this. Take a look into the :ref:`TSconfig reference <t3tsconfig:tceform>`.

Examples:

.. code-block:: typoscript

   TCEFORM.tt_content.pi_flexform.rxshariff_shariff.sDEF.settings\.enableBackend.disabled = 1
   TCEFORM.tt_content.pi_flexform.rxshariff_shariff.services.disabled = 1

