# Default Store Code Remover for Magento 2

Default Store Code Remover for Magento 2 hides the store code in the default store from the URL. The module is in effect only when <code>web/url/use_store</code> is enabled and is meant to be used for multistore setups, where the default shop should not contain any store code, whereas all other stores should.

The module also provides an optional, extended configuration to control store code removal **per store view**:

- Configuration path: **Store > Configuration > CustomGento > Default Store Code Remover**
- Setting: **Configure Store Code Removal Per Store** (Yes/No)
    - Default value: **No** (backwards compatible)
        - Uses the original behavior: the store code is removed from the **default store view** URL, while all other store views keep their store code in the URL.
    - If set to **Yes**
        - An additional setting becomes available with a list of **store views**.
        - Only the **selected store views** will have the store code removed from the URL.
        - All **non-selected store views** will keep the store code in the URL.

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

## License
[OSL - Open Software Licence 3.0](https://opensource.org/licenses/osl--3.0.php)

## Copyright
&copy; 2021 - present CustomGento GmbH
