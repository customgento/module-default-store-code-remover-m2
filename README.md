# CustomGento_DefaultStoreCodeRemover

Magento 2 module for hiding the store code in the default store.

## Description

This extension hides the Default Store Code from the URL. 
The module is in effect only when <code>web/url/use_store</code> is enabled

## Installation

* <code>composer require customgento/module-default-store-code-remover-m2</code>
* <code>bin/magento module:enable CustomGento_DefaultStoreCodeRemover</code>
* <code>bin/magento setup:upgrade</code>
* <code>bin/magento cache:flush</code>
* <code>bin/magento setup:di:compile</code>

## Example
When the store codes in the url are disabled, the URL of the stores looks like this: `https://website.com/`.

When the store codes in the url are enabled, the URL of the stores looks like this: `https://website.com/store_code/`.

When this extension is installed and enabled, and the store codes are enabled to be shown in the url under
Store > Configuration > General > Web >Add Store Code, the module will not show the store code for the default store 
but will show it for any other store.

So, for the default store the url will be `https://website.com/` while for all other store, the URL will be : `https://website.com/store_code`

## Copyright
&copy; 2020 CustomGento GmbH
