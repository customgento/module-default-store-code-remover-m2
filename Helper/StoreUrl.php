<?php

declare(strict_types=1);

namespace CustomGento\DefaultStoreCodeRemover\Helper;

use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\Store;
use MageWorx\SeoBase\Helper\StoreUrl as MageworxStoreUrl; /** @phpstan-ignore-line */

/** @phpstan-ignore-next-line */
class StoreUrl extends MageworxStoreUrl /** @phpstan-ignore-line */
{
    protected function isUseStoreCodeInUrl(StoreInterface $store): bool
    {
        if ($store->getCode() !== Store::ADMIN_CODE && $store->isDefault()) {
            return false;
        }

        $storeId = (int)$store->getId();

        return !($store->hasDisableStoreInUrl() && $store->getDisableStoreInUrl())
            && $this->configDataLoader->getConfigValue(Store::XML_PATH_STORE_IN_URL, $storeId);
    }
}
