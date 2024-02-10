<?php

declare(strict_types=1);

namespace CustomGento\DefaultStoreCodeRemover\Helper;

use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\Store;
use MageWorx\SeoBase\Helper\StoreUrl as MageworxStoreUrl;

// Check if MageWorx\SeoBase\Helper\StoreUrl class exists
$mageWorxClassExists = class_exists(MageworxStoreUrl::class);

// Define the StoreUrl class based on whether MageWorx class exists
if ($mageWorxClassExists) {
    class StoreUrl extends MageworxStoreUrl
    {
        protected function isUseStoreCodeInUrl(StoreInterface $store): bool
        {
            if (!method_exists($store, 'isDefault')) {
                return false;
            }

            if ($store->getCode() !== Store::ADMIN_CODE && $store->isDefault()) {
                return false;
            }

            $storeId = (int)$store->getId();
            if (!method_exists($store, 'hasDisableStoreInUrl') || !method_exists($store, 'getDisableStoreInUrl')) {
                return false;
            }

            if (empty($this->configDataLoader)) {
                return false;
            }

            return !($store->hasDisableStoreInUrl() && $store->getDisableStoreInUrl())
                && $this->configDataLoader->getConfigValue(
                    Store::XML_PATH_STORE_IN_URL,
                    $storeId
                );
        }
    }
} else {
    // Handle the case when MageWorx\SeoBase\Helper\StoreUrl class is not found
    class StoreUrl
    {
        // Provide an alternative implementation or leave it empty based on your needs
        protected function isUseStoreCodeInUrl(StoreInterface $store): bool
        {
            // Your alternative logic here
            return false;
        }
    }
}
