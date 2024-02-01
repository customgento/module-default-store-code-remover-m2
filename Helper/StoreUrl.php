<?php

declare(strict_types=1);

namespace CustomGento\DefaultStoreCodeRemover\Helper;

use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\Store;
use MageWorx\SeoBase\Helper\StoreUrl as MageworxStoreUrl;

class StoreUrl extends MageworxStoreUrl
{
    protected function isUseStoreCodeInUrl(StoreInterface $store): bool
    {
        /** @phpstan-ignore-next-line */
        if ($store->getCode() !== Store::ADMIN_CODE && $store->isDefault()) {
            return false;
        }

        $storeId = (int)$store->getId();
        /** @phpstan-ignore-next-line */
        return !($store->hasDisableStoreInUrl() && $store->getDisableStoreInUrl())
            && $this->configDataLoader->getConfigValue(Store::XML_PATH_STORE_IN_URL, $storeId);
    }
}
