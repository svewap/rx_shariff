.. include:: ../Includes.txt


Installation
============

Install the extension via Extension Manager as usual.

The provided Javascript requires jQuery to be loaded. You have to take care of this on your own. The example below shows that too.


Configuration
-------------

You can configure the extension in the Extension Manager.
It allows to set most of the options for the backend module as documented here: https://github.com/heiseonline/shariff-backend-php


JavaScript and CSS integration
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

The extension also ships the Frontend Javascript and default styles of Shariff.
You can simple add one of the four available static templates:

* Shariff: Include Shariff and jQuery
* Shariff: Include Shariff, font-awesome and jQuery
* Shariff: Include Shariff without jQuery
* Shariff: Include Shariff, font-awesome without jQuery

jQuery is included by using the local jQuery version shipped with the TYPO3 CMS Core.

.. note::

   In case you want to integrate the Javascript and CSS in your asset workflow (e.g. gulp or grunt) you don't need
   to include any static template or TypoScript


If you want, you can also simply integrate them manually in your own page template:

.. code-block:: typoscript

   page = PAGE

   page.javascriptLibs.jQuery = 1
   page.javascriptLibs.jQuery.version = latest
   page.javascriptLibs.jQuery.source = local

   page.includeJSFooter.shariff = EXT:rx_shariff/Resources/Public/Css/shariff.min.js
   page.includeCSS.shariff = EXT:rx_shariff/Resources/Public/Css/shariff.min.css
   //# or you may use the following for include font-awesome too
   //# page.includeCSS.shariff = EXT:rx_shariff/Resources/Public/Css/shariff.complete.css


.. important::

   The Javascript has to be included in your frontend page in either way, otherwise the usages described below will not work.


Frontend usage
--------------

The extension provides multiple ways to use Shariff in frontend.


Pure TypoScript
^^^^^^^^^^^^^^^

For TypoScript usage, the extension provides a default typolink setup to generate the necessary backend-url.
The setup can be used like this:

.. code-block:: typoscript

   lib.shariffBackendUrl < plugin.rx_shariff.data-backend-url


Fluid viewhelper
^^^^^^^^^^^^^^^^

Additionally the extension provides a Fluid viewhelper to easily integrate Shariff into your HTML template.

.. code-block:: html

   <html xmlns:rx="http://typo3.org/ns/Reelworx/RxShariff/ViewHelper">
     <rx:shariff data="{url: 'http://example.com/'}" services="whatsapp,facebook" enableBackend="true" />
   </html>


**Optionally you can define all data attributes available for Shariff.**

Example usages can be found here: http://heiseonline.github.io/shariff/


Frontend plugin
^^^^^^^^^^^^^^^

Simply add a new content element to a page and select the "Shariff Social Icons" plugin.
Adjust the configuration as needed.


Nice to know
------------


News integration
^^^^^^^^^^^^^^^^

You can also easily use this extension within your News extension template.
Simply paste the viewhelper into your ``Detail.html`` template, include one of the static templates and you are ready to go.


Finding the logs
^^^^^^^^^^^^^^^^

The extension uses the TYPO3 logging facility to log warnings when fetching counts from the various social media platforms.
If you encounter problems, take a look into the logs.


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


.. code-block:: typoscript

   TCEFORM.tt_content.pi_flexform.rxshariff_shariff.sDEF.settings\.enableBackend.disabled = 1
   TCEFORM.tt_content.pi_flexform.rxshariff_shariff.services.disabled = 1

