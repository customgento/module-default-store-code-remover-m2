<?php

declare(strict_types=1);

namespace CustomGento\DefaultStoreCodeRemover\Helper;

use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\Store;
/** @phpstan-ignore-next-line */
use MageWorx\SeoBase\Helper\StoreUrl as MageworxStoreUrl;

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

if (class_exists(MageworxStoreUrl::class)) {
    class StoreUrl extends MageworxStoreUrl
    {
        protected function isUseStoreCodeInUrl(StoreInterface $store): bool
        {
            if ($store->getCode() !== Store::ADMIN_CODE && $store->isDefault()) {
                return false;
            }

            $storeId = (int)$store->getId();

            return !($store->hasDisableStoreInUrl() && $store->getDisableStoreInUrl())
                // @phpstan-ignore-next-line
                && $this->configDataLoader->getConfigValue(Store::XML_PATH_STORE_IN_URL, $storeId);
        }
    }
} else {
    class StoreUrl
    {

    }
}
